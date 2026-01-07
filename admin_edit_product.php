<?php
include 'db.php';

// URL માંથી પ્રોડક્ટ ID મેળવવી
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $edit_res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $data = mysqli_fetch_assoc($edit_res);
}

// અપડેટ લોજિક
if(isset($_POST['update_product'])) {
    $cat_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']); //
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $o_price = $_POST['o_price'];
    $d_price = $_POST['d_price'];
    $rating = $_POST['rating']; //
    $min_qty = $_POST['min_qty'];
    
    // ડિસ્કાઉન્ટ ગણતરી
    $discount_percent = ($o_price > 0) ? round((($o_price - $d_price) / $o_price) * 100) : 0;

    // ઈમેજ અપડેટ લોજિક
    if(!empty($_FILES['pimage']['name'])) {
        $image = time() . "_" . $_FILES['pimage']['name'];
        move_uploaded_file($_FILES['pimage']['tmp_name'], "uploads/" . $image);
    } else {
        $image = $data['image']; // જૂની ઈમેજ રાખવી
    }

    $update_query = "UPDATE products SET 
        category_id='$cat_id', product_name='$name', brand='$brand', sku='$sku', 
        original_price='$o_price', discounted_price='$d_price', 
        discount_percent='$discount_percent', min_qty='$min_qty', rating='$rating', 
        image='$image' WHERE id='$id'";

    if(mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product Updated Successfully!'); window.location.href='admin_manage_products.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Edit Product | Admin</title>
    <style>
    body {
        font-family: 'Inter', sans-serif !important;
        font-size: 14px;
        color: #111827;
    }

    /* */
    </style>
</head>

<body class="bg-gray-50 p-6 md:p-12">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
        <h2 class="text-2xl font-black tracking-tight italic uppercase mb-8 border-b pb-4">Edit Product Details</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-8">
            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Product Name</label>
                <input type="text" name="pname" value="<?php echo $data['product_name']; ?>"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-black" required>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand Name</label>
                <input type="text" name="brand" value="<?php echo $data['brand']; ?>"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-black" required>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Original Price (₹)</label>
                <input type="number" name="o_price" value="<?php echo $data['original_price']; ?>"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-black" required>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Discounted Price (₹)</label>
                <input type="number" name="d_price" value="<?php echo $data['discounted_price']; ?>"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-black" required>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Rating (1-5)</label>
                <input type="number" step="0.1" name="rating" value="<?php echo $data['rating']; ?>"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-black" required>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Category</label>
                <select name="category_id"
                    class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-black">
                    <?php
                    $cats = mysqli_query($conn, "SELECT * FROM categories");
                    while($c = mysqli_fetch_assoc($cats)) {
                        $sel = ($c['id'] == $data['category_id']) ? "selected" : "";
                        echo "<option value='".$c['id']."' $sel>".$c['name']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Product Image (નવી ન નાખવી હોય તો
                    ખાલી છોડો)</label>
                <div class="flex items-center gap-4">
                    <img src="uploads/<?php echo $data['image']; ?>" class="w-20 h-20 object-cover rounded-xl border">
                    <input type="file" name="pimage" class="text-xs">
                </div>
            </div>

            <button type="submit" name="update_product"
                class="col-span-2 bg-black text-white font-bold py-4 rounded-2xl hover:bg-yellow-500 hover:text-black transition uppercase tracking-widest">
                Update Changes
            </button>
        </form>
    </div>
</body>

</html>