<?php
include 'db.php'; 

$limit = 4; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; 

$prod_query = mysqli_query($conn, "SELECT * FROM products LIMIT $limit OFFSET $offset"); 

if(mysqli_num_rows($prod_query) > 0) {
    while($row = mysqli_fetch_assoc($prod_query)) {
        // ડિસ્કાઉન્ટની ગણતરી અહીં કરો
        $discount = 0;
        if($row['original_price'] > $row['discounted_price'] && $row['original_price'] > 0) {
            $discount = round((($row['original_price'] - $row['discounted_price']) / $row['original_price']) * 100);
        }
?>
<div
    class="product-card-home group bg-white overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 rounded-2xl flex flex-col">
    <div class="relative h-72 bg-[#F7F8F9] overflow-hidden">
        <?php if($discount > 0): ?>
        <span
            class="absolute top-4 left-4 bg-red-600 text-white text-[10px] font-black px-2 py-1 rounded-sm z-10 shadow-sm">-<?php echo $discount; ?>%
            OFF</span>
        <?php endif; ?>

        <button
            class="absolute top-4 right-4 w-9 h-9 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition-all z-10 shadow-sm border border-gray-100">
            <i class="fa-regular fa-heart"></i>
        </button>

        <a href="product-details.php?id=<?php echo $row['id']; ?>" class="block h-full">
            <img src="uploads/<?php echo $row['image']; ?>"
                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                alt="<?php echo $row['product_name']; ?>">
        </a>

        <div
            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <a href="product-details.php?id=<?php echo $row['id']; ?>"
                class="bg-white text-black px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-2xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                View Details
            </a>
        </div>
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <div class="flex justify-between items-start mb-2">
            <h4 class="font-bold text-[#111827] text-sm truncate max-w-[150px]"><?php echo $row['product_name']; ?></h4>
            <div class="flex text-yellow-400 text-[8px] gap-0.5 mt-1">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                    class="fa fa-star"></i><i class="fa fa-star"></i>
            </div>
        </div>

        <div class="flex items-baseline gap-2 mb-4">
            <span
                class="text-xl font-black text-[#111827]">₹<?php echo number_format($row['discounted_price']); ?></span>
            <?php if($row['original_price'] > $row['discounted_price']): ?>
            <span
                class="text-xs text-gray-400 line-through font-medium">₹<?php echo number_format($row['original_price']); ?></span>
            <?php endif; ?>
        </div>

        <div class="mt-auto space-y-2">
            <button onclick="addToInquiry(<?php echo $row['id']; ?>, <?php echo $row['min_qty']; ?>)"
                class="w-full bg-black text-white py-3 rounded-lg font-bold text-[11px] uppercase tracking-widest transition-all hover:bg-gray-800 flex items-center justify-center gap-2">
                <i class="fa fa-list-check"></i> Add to Inquiry
            </button>
            <div class="text-center">
                <span class="text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded uppercase">MOQ:
                    <?php echo $row['min_qty']; ?> Units</span>
            </div>
        </div>
    </div>
</div>
<?php 
    }
} else {
    echo "<div class='col-span-4 text-center py-20 font-bold text-gray-400'>No more products found.</div>";
}
?>