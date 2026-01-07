<?php
include 'db.php';

if(isset($_POST['add_product'])) {
    $cat_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']); // New Field
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $o_price = $_POST['o_price'];
    $d_price = $_POST['d_price'];
    $units = $_POST['units'];
    $rating = $_POST['rating']; // New Field
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $long_desc = mysqli_real_escape_string($conn, $_POST['long_desc']);
    $features = mysqli_real_escape_string($conn, $_POST['features']);
    $min_qty = $_POST['min_qty'];

    // Additional Images Handling
    $additional_images = [];
    if(isset($_FILES['extra_images'])) {
        foreach($_FILES['extra_images']['tmp_name'] as $key => $tmp_name) {
            if(!empty($tmp_name)) {
                $file_name = time() . "_" . $_FILES['extra_images']['name'][$key];
                move_uploaded_file($tmp_name, "uploads/" . $file_name);
                $additional_images[] = $file_name;
            }
        }
    }
    $extra_images_str = implode(',', $additional_images);
    
    // Discount Calculation
    $discount_percent = ($o_price > 0) ? round((($o_price - $d_price) / $o_price) * 100) : 0;

    // Main Image Upload
    $image = time() . "_" . $_FILES['pimage']['name'];
    move_uploaded_file($_FILES['pimage']['tmp_name'], "uploads/" . $image);

    // SQL Query updated with brand and rating
    $query = "INSERT INTO products (category_id, product_name, brand, sku, original_price, discounted_price, discount_percent, min_qty, rating, additional_images, available_units, short_description, long_description, key_features, image) 
              VALUES ('$cat_id', '$name', '$brand', '$sku', '$o_price', '$d_price', '$discount_percent', '$min_qty', '$rating', '$extra_images_str', '$units', '$short_desc', '$long_desc', '$features', '$image')";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Product added successfully with Brand and Rating!'); window.location.href='admin_add_product.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Inter', sans-serif !important;
        /* Applying Inter font to whole page */
        font-size: 14px;
        /* Based on requested image spec */
        line-height: 20px;
        /* Based on requested image spec */
        color: #111827;
        /* Dark text color */
    }
    </style>
</head>

<body class="bg-gray-50 p-6 md:p-12">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
        <div class="flex items-center gap-4 mb-8 border-b pb-6">
            <div class="bg-black text-white p-3 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black tracking-tight italic uppercase">Add New Product</h2>
                <p class="text-gray-400 text-xs font-medium uppercase tracking-widest">Inventory Management System</p>
            </div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-8">

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Product Name</label>
                <input type="text" name="pname"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    placeholder="e.g. Forclaz Trekking Jacket" required>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand Name</label>
                <input type="text" name="brand"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    placeholder="e.g. FORCLAZ, QUECHUA" required>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">SKU Code</label>
                <input type="text" name="sku"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    placeholder="PSS-001">
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Category</label>
                <select name="category_id"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition cursor-pointer">
                    <?php
                    $cats = mysqli_query($conn, "SELECT * FROM categories");
                    while($c = mysqli_fetch_assoc($cats)) echo "<option value='".$c['id']."'>".$c['name']."</option>";
                    ?>
                </select>
            </div>

            <div class="col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Original Price (₹)</label>
                <input type="number" name="o_price"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    required>
            </div>
            <div class="col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Discounted Price (₹)</label>
                <input type="number" name="d_price"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    required>
            </div>

            <div class="col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Min Inquiry Qty (MOQ)</label>
                <input type="number" name="min_qty" value="1"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    required>
            </div>

            <div class="col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Initial Rating (1-5)</label>
                <input type="number" step="0.1" name="rating" value="4.5" min="1" max="5"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    required>
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Stock Available (Units)</label>
                <input type="number" name="units"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    placeholder="e.g. 500">
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Short Intro Description</label>
                <textarea name="short_desc"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    rows="2"></textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Key Features (Separate with
                    commas)</label>
                <input type="text" name="features"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    placeholder="Waterproof, Lightweight, 2-Year Warranty">
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Full Long Description</label>
                <textarea name="long_desc"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-black outline-none transition"
                    rows="5"></textarea>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Main Product Image</label>
                <input type="file" name="pimage"
                    class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-yellow-500 cursor-pointer"
                    required>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Extra Gallery Images</label>
                <input type="file" name="extra_images[]"
                    class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer"
                    multiple>
            </div>

            <div class="col-span-2 pt-6">
                <button type="submit" name="add_product"
                    class="w-full bg-black text-white font-bold py-4 rounded-2xl shadow-xl hover:bg-yellow-500 hover:text-black transition-all duration-300 uppercase tracking-widest">
                    Publish to Website
                </button>
            </div>
        </form>
    </div>
</body>

</html>