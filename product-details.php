<?php
include 'db.php';

// URL માંથી પ્રોડક્ટ ID લેવી (દા.ત. product-details.php?id=1)
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <nav class="text-sm text-gray-500 mb-8">
            Home > Category > <?php echo $product['product_name']; ?>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-3xl shadow-sm">

            <div>
                <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4">
                    <img src="uploads/<?php echo $product['image']; ?>" class="w-full h-full object-cover"
                        id="mainImage">
                </div>
                <div class="grid grid-cols-4 gap-4 mt-4">
                    <div class="border rounded-lg p-1 cursor-pointer"
                        onclick="changeImage('uploads/<?php echo $product['image']; ?>')">
                        <img src="uploads/<?php echo $product['image']; ?>" class="rounded-md">
                    </div>

                    <?php 
    if(!empty($product['additional_images'])) {
        $extras = explode(',', $product['additional_images']);
        foreach($extras as $img) {
            echo '<div class="border rounded-lg p-1 cursor-pointer" onclick="changeImage(\'uploads/'.trim($img).'\')">
                    <img src="uploads/'.trim($img).'" class="rounded-md">
                  </div>';
        }
    }
    ?>
                </div>
            </div>

            <div>
                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded uppercase">
                    <?php echo $product['stock_status']; ?>
                </span>
                <span class="text-gray-400 text-xs ml-3">SKU: <?php echo $product['sku']; ?></span>

                <h1 class="text-4xl font-serif font-bold text-gray-900 mt-4"><?php echo $product['product_name']; ?>
                </h1>

                <div class="flex items-center gap-2 mt-2">
                    <div class="text-yellow-400 text-sm">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                            class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <span class="text-gray-400 text-xs">4.8 (124 reviews)</span>
                </div>

                <div class="flex items-baseline gap-4 mt-6">
                    <span class="text-4xl font-bold text-yellow-600"><?php echo $product['discounted_price']; ?></span>
                    <span class="text-xl text-gray-400 line-through"><?php echo $product['original_price']; ?></span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">Save
                        <?php echo $product['discount_percent']; ?>%</span>
                </div>

                <p class="text-gray-500 mt-6 leading-relaxed">
                    <?php echo $product['short_description']; ?>
                </p>
                <!-- <div class="flex items-center gap-4">
                    <div class="flex border rounded-xl overflow-hidden">
                        <input type="number" id="qty" value="<?php echo $product['min_qty']; ?>"
                            min="<?php echo $product['min_qty']; ?>" class="w-20 text-center p-2 outline-none">
                    </div>
                    <span class="text-red-500 text-sm">Min order: <?php echo $product['min_qty']; ?> units</span>
                </div> -->
                <div class="mt-8 flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <!-- <div class="flex border rounded-xl overflow-hidden">
                            <button class="px-4 py-2 bg-gray-50 hover:bg-gray-200">-</button>
                            <input type="text" value="1" class="w-12 text-center border-x outline-none">
                            <button class="px-4 py-2 bg-gray-50 hover:bg-gray-200">+</button>
                        </div> -->
                        <span class="text-gray-400 text-sm">Available: <?php echo $product['available_units']; ?>+
                            units</span>
                    </div>



                    <form action="add_to_inquiry.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <div class="flex items-center gap-4 mb-6">
                            <label class="font-bold">Quantity:</label>
                            <input type="number" name="qty" value="<?php echo $product['min_qty']; ?>"
                                min="<?php echo $product['min_qty']; ?>"
                                class="border p-2 w-20 rounded-lg focus:ring-2 focus:ring-yellow-500 outline-none">
                            <span class="text-red-500 text-sm">Min order: <?php echo $product['min_qty']; ?>
                                units</span>
                        </div>




                        <div class="lg:col-span-7">
                            <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] mb-8">Technical
                                    Details
                                </h3>

                                <div class="space-y-0 border-t border-gray-200">
                                    <div class="grid grid-cols-2 py-4 border-b border-gray-200">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Brand</span>
                                        <span
                                            class="text-sm font-black text-gray-900"><?php echo $product['brand']; ?></span>
                                    </div>

                                    <div class="grid grid-cols-2 py-4 border-b border-gray-200">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Model Number
                                            (SKU)</span>
                                        <span
                                            class="text-sm font-mono text-gray-900"><?php echo $product['sku']; ?></span>
                                    </div>

                                    <?php if(!empty($product['category_details'])): 
                        $details = json_decode($product['category_details'], true);
                        foreach($details as $key => $value):
                    ?>
                                    <div
                                        class="grid grid-cols-2 py-4 border-b border-gray-200 group hover:bg-white transition-colors px-2 rounded-lg">
                                        <span
                                            class="text-xs font-bold text-gray-500 uppercase"><?php echo str_replace('_', ' ', $key); ?></span>
                                        <span class="text-sm font-black text-black italic"><?php echo $value; ?></span>
                                    </div>
                                    <?php endforeach; endif; ?>

                                    <div class="grid grid-cols-2 py-4 border-b border-gray-200">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Availability</span>
                                        <span
                                            class="text-sm font-bold <?php echo ($product['available_units'] > 0) ? 'text-green-600' : 'text-red-600'; ?>">
                                            <?php echo ($product['available_units'] > 0) ? 'In Stock ('.$product['available_units'].' units)' : 'Out of Stock'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <button type="submit" name="add_to_list"
                            class="bg-black text-white px-8 py-3 rounded-xl font-bold hover:bg-yellow-600 transition"
                            style="width: 100%; max-width: 600px;">
                            Add to Inquiry List
                        </button>
                    </form>

                    <!-- <div class="flex gap-4">
                        <button
                            class="flex-1 border border-gray-200 py-3 rounded-full font-semibold hover:bg-gray-50 transition">
                            <i class="fa-regular fa-heart"></i> Add to Wishlist
                        </button>
                        <button
                            class="flex-1 border border-gray-200 py-3 rounded-full font-semibold hover:bg-gray-50 transition">
                            <i class="fa fa-share-nodes"></i> Share
                        </button>
                    </div> -->
                </div>
                <!-- <div class="mt-10"> -->
                <!-- <div class="flex items-center gap-3 mb-6">
                        <span class="h-[2px] w-8 bg-yellow-500"></span>
                        <h3 class="font-black text-[#111827] uppercase text-xs tracking-[0.2em]">Product Specifications
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <?php 
        $features = explode(',', $product['key_features']);
        // આઈકોન્સની એક એરે (રેન્ડમ આઈકોન્સ બતાવવા માટે અથવા તમે ફિક્સ કરી શકો)
        $icons = ['fa-shield-halved', 'fa-feather', 'fa-award', 'fa-leaf', 'fa-bolt', 'fa-gem'];
        
        foreach($features as $index => $f): 
            $icon = $icons[$index % count($icons)]; // લૂપ મુજબ આઈકોન બદલાશે
        ?> -->
                <!-- <div
                    class="group flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-transparent hover:border-yellow-200 hover:bg-white hover:shadow-xl hover:shadow-yellow-500/5 transition-all duration-300">
                    <div
                        class="w-10 h-10 flex-shrink-0 bg-white rounded-xl shadow-sm flex items-center justify-center group-hover:bg-yellow-500 transition-colors duration-300">
                        <i class="fa-solid <?php echo $icon; ?> text-yellow-600 group-hover:text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-gray-800 leading-tight transition-colors">
                            <?php echo trim($f); ?>
                        </p>
                    </div>
                </div> -->
                <?php endforeach; ?>
            </div>
        </div>
        <!-- <div class="mt-10 p-6 bg-gray-50 rounded-2xl">
                    <h3 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-widest">Key Features</h3>
                    <ul class="space-y-3">
                        <?php 
                        $features = explode(',', $product['key_features']);
                        foreach($features as $f) {
                            echo "<li class='flex items-center gap-3 text-sm text-gray-600'>
                                    <i class='fa fa-circle-check text-yellow-600'></i> ".trim($f)."
                                  </li>";
                        }
                        ?>
                    </ul>
                </div> -->
        </div>
        </div>

        <div class="mt-16 border-t border-gray-100 pt-12">
            <div class="flex gap-12 border-b border-gray-100 mb-10 overflow-x-auto pb-1">
                <button
                    class="pb-4 border-b-2 border-black text-sm font-black uppercase tracking-widest text-black">Specifications</button>
                <!-- <button 
                    class="pb-4 border-b-2 border-transparent text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-black transition">Description</button>
                 -->
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <div class="lg:col-span-5">
                    <h3 class="text-lg font-black text-gray-900 mb-6 italic">Why choose this product?</h3>
                    <ul class="space-y-4">
                        <?php 
                $features = explode(',', $product['key_features']);
                foreach($features as $f): 
                ?>
                        <li class="flex items-center gap-4 group">
                            <div
                                class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center group-hover:bg-green-500 transition-all">
                                <i class="fa-solid fa-check text-[10px] text-green-600 group-hover:text-white"></i>
                            </div>
                            <span
                                class="text-sm font-medium text-gray-600 group-hover:text-black transition-colors"><?php echo trim($f); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>


            </div>
        </div>


        <section class="mt-20">
            <h2 class="text-2xl font-bold mb-8">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php
        $cat_id = $product['category_id'];
        $current_id = $product['id'];
        $related = mysqli_query($conn, "SELECT * FROM products WHERE category_id = '$cat_id' AND id != '$current_id' LIMIT 4");
        while($r = mysqli_fetch_assoc($related)) {
        ?>
                <a href="product-details.php?id=<?php echo $r['id']; ?>" class="group">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-3">
                        <img src="uploads/<?php echo $r['image']; ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <h3 class="font-bold text-gray-800"><?php echo $r['product_name']; ?></h3>
                    <p class="text-yellow-600 font-bold">$<?php echo $r['discounted_price']; ?></p>
                </a>
                <?php } ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }
    </script>

</body>

</html>