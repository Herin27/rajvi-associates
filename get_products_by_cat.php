<?php
include 'db.php';

// AJAX દ્વારા મોકલેલી Category ID મેળવો
$cat_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// ૧. બેઝ ક્વેરી તૈયાર કરો (ફક્ત In Stock પ્રોડક્ટ્સ જ બતાવવા માટે)
$query = "SELECT * FROM products WHERE stock_status = 'In Stock'";

// ૨. જો ચોક્કસ કેટેગરી ફિલ્ટર હોય
if($cat_id > 0) {
    $query .= " AND category_id = $cat_id";
}

// ૩. છેલ્લે એક જ વાર ORDER BY ઉમેરો
$query .= " ORDER BY id DESC";

$res = mysqli_query($conn, $query);

if(mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        // ડિસ્કાઉન્ટ ગણતરી
        $discount = 0;
        if(isset($row['original_price']) && $row['original_price'] > 0) {
            $discount = round((($row['original_price'] - $row['discounted_price']) / $row['original_price']) * 100);
        }
        ?>
<div
    class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
    <div class="relative h-64 bg-gray-50 overflow-hidden">
        <?php if($discount > 0): ?>
        <span
            class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10">-<?php echo $discount; ?>%</span>
        <?php endif; ?>

        <button onclick="toggleWishlist(<?php echo $row['id']; ?>, this)"
            class="absolute top-4 right-4 w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition z-10 shadow-sm">
            <i class="fa-regular fa-heart"></i>
        </button>

        <img src="uploads/<?php echo $row['image']; ?>"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            alt="<?php echo $row['product_name']; ?>">

        <div
            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
            <a href="product-details.php?id=<?php echo $row['id']; ?>"
                class="bg-white text-black px-4 py-2 rounded-full text-xs font-bold shadow-xl translate-y-4 group-hover:translate-y-0 transition-transform">
                View Details
            </a>
        </div>
    </div>

    <div class="p-5">
        <h4 class="font-bold text-gray-800 mb-1 truncate"><?php echo $row['product_name']; ?></h4>
        <div class="flex items-center gap-2 mb-3">
            <div class="flex text-yellow-400 text-[10px]">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                    class="fa fa-star"></i><i class="fa fa-star"></i>
            </div>
            <span class="text-[10px] text-gray-400 font-bold">New Arrival</span>
        </div>
        <div class="flex items-baseline gap-2 mb-5">
            <span class="text-xl font-bold text-black">₹<?php echo $row['discounted_price']; ?></span>
            <?php if(isset($row['original_price']) && $row['original_price'] > $row['discounted_price']): ?>
            <span class="text-sm text-gray-400 line-through">₹<?php echo $row['original_price']; ?></span>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-2 mb-5">
            <button onclick="addToCart(<?php echo $row['id']; ?>)"
                class="w-full bg-black hover:bg-yellow-600 text-white py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 group/btn">
                <i class="fa fa-shopping-cart"></i> Add to Cart
            </button>
            <button onclick="addToInquiry(<?php echo $row['id']; ?>)"
                class="w-full bg-black hover:bg-yellow-600 text-white py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 group/btn">
                <i class="fa fa-list-plus"></i> Add to Inquiry
            </button>
        </div>
    </div>
</div>
<?php
    }
} else {
    // જો કોઈ પ્રોડક્ટ ન મળે અથવા બધી Out of Stock હોય તો આ મેસેજ દેખાશે
    echo "<div class='col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100'>
            <i class='fa fa-box-open text-gray-300 text-5xl mb-4'></i>
            <p class='text-gray-500 font-medium'>No products available in this category.</p>
          </div>";
}
?>