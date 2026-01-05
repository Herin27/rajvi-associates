<?php
include 'db.php';

if(isset($_POST['add_product'])) {
    $cat_id = $_POST['category_id'];
    $name = $_POST['pname'];
    $sku = $_POST['sku'];
    $o_price = $_POST['o_price'];
    $d_price = $_POST['d_price'];
    $units = $_POST['units'];
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $long_desc = mysqli_real_escape_string($conn, $_POST['long_desc']);
    $features = mysqli_real_escape_string($conn, $_POST['features']);
    
    // ડિસ્કાઉન્ટ ગણતરી
    $discount_percent = round((($o_price - $d_price) / $o_price) * 100);

    $image = $_FILES['pimage']['name'];
    move_uploaded_file($_FILES['pimage']['tmp_name'], "uploads/" . $image);

    $query = "INSERT INTO products (category_id, product_name, sku, original_price, discounted_price, discount_percent, available_units, short_description, long_description, key_features, image) 
              VALUES ('$cat_id', '$name', '$sku', '$o_price', '$d_price', '$discount_percent', '$units', '$short_desc', '$long_desc', '$features', '$image')";
    
    mysqli_query($conn, $query);
    echo "<script>alert('Product added with all details!');</script>";
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2">Add Luxury Product</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-6">

            <div class="col-span-2 md:col-span-1">
                <label class="block text-sm font-bold mb-1">Product Name</label>
                <input type="text" name="pname" class="w-full border p-2 rounded-lg"
                    placeholder="e.g. Premium Silk Scarf" required>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label class="block text-sm font-bold mb-1">SKU Code</label>
                <input type="text" name="sku" class="w-full border p-2 rounded-lg" placeholder="PSS-001">
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">Original Price ($)</label>
                <input type="number" name="o_price" class="w-full border p-2 rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Discounted Price ($)</label>
                <input type="number" name="d_price" class="w-full border p-2 rounded-lg" required>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">Category</label>
                <select name="category_id" class="w-full border p-2 rounded-lg">
                    <?php
                    $cats = mysqli_query($conn, "SELECT * FROM categories");
                    while($c = mysqli_fetch_assoc($cats)) echo "<option value='".$c['id']."'>".$c['name']."</option>";
                    ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Available Units</label>
                <input type="number" name="units" class="w-full border p-2 rounded-lg" placeholder="e.g. 50">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-bold mb-1">Short Description (Intro)</label>
                <textarea name="short_desc" class="w-full border p-2 rounded-lg" rows="2"></textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-bold mb-1">Key Features (Use comma to separate)</label>
                <input type="text" name="features" class="w-full border p-2 rounded-lg"
                    placeholder="100% Silk, Hand-finished, 90cm x 90cm">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-bold mb-1">Full Detailed Description</label>
                <textarea name="long_desc" class="w-full border p-2 rounded-lg" rows="4"></textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-bold mb-1">Main Image</label>
                <input type="file" name="pimage" class="w-full border p-2 rounded-lg">
            </div>

            <button type="submit" name="add_product"
                class="col-span-2 bg-yellow-500 text-black font-bold py-3 rounded-xl hover:bg-black hover:text-white transition">
                Publish Product
            </button>
        </form>
    </div>
</body>

</html>