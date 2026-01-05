<?php
include 'db.php'; // તમારું ડેટાબેઝ કનેક્શન

// બધી પ્રોડક્ટ્સ અથવા લેટેસ્ટ 8 પ્રોડક્ટ્સ મેળવો
$prod_query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 8");

if(mysqli_num_rows($prod_query) > 0) {
    while($row = mysqli_fetch_assoc($prod_query)) {
        // જો ડિસ્કાઉન્ટ ગણવું હોય તો (Optional)
        $discount = 0;
        if($row['original_price'] > 0) {
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

        <button
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
            <span class="text-xl font-bold text-black"><?php echo $row['discounted_price']; ?></span>
            <?php if($row['original_price'] > $row['discounted_price']): ?>
            <span class="text-sm text-gray-400 line-through"><?php echo $row['original_price']; ?></span>
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
    echo "<p class='col-span-4 text-center text-gray-500'>No products found.</p>";
}
?>

<script>
function addToCart(productId) {
    // બટન એનિમેશન અથવા લોડિંગ બતાવવા માટે (Optional)
    console.log("Adding product " + productId + " to cart...");

    // FormData તૈયાર કરો
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', 1);

    // Fetch API નો ઉપયોગ કરીને PHP ફાઇલ પર ડેટા મોકલો
    fetch('add_to_cart_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart successfully!');
                // અહીં તમે હેડરમાં રહેલા કાર્ટ કાઉન્ટને પણ અપડેટ કરી શકો છો
                updateCartCount(data.new_count);
            } else {
                alert('There was an issue adding the product to the cart.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong.');
        });
}

// કાર્ટ કાઉન્ટ અપડેટ કરવા માટેનું ફંક્શન
function updateCartCount(count) {
    const cartBadge = document.getElementById('cart-count-badge');
    if (cartBadge) {
        cartBadge.innerText = count;
    }
}
</script>