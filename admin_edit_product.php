<?php
include 'db.php'; // ડેટાબેઝ કનેક્શન ફાઈલ

// URL માંથી પ્રોડક્ટ ID મેળવવી
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $edit_res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $data = mysqli_fetch_assoc($edit_res);
}

// અપડેટ લોજિક
if(isset($_POST['update_product'])) {
    $cat_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $o_price = $_POST['o_price'];
    $d_price = $_POST['d_price'];
    $rating = $_POST['rating'];
    $min_qty = $_POST['min_qty'];
    $units = $_POST['units'];
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $long_desc = mysqli_real_escape_string($conn, $_POST['long_desc']);
    $features = mysqli_real_escape_string($conn, $_POST['features']);
    
    // ડિસ્કાઉન્ટ ગણતરી
    $discount_percent = ($o_price > 0) ? round((($o_price - $d_price) / $o_price) * 100) : 0;

    // ઈમેજ અપડેટ લોજિક
    if(!empty($_FILES['pimage']['name'])) {
        $image = time() . "_" . $_FILES['pimage']['name'];
        move_uploaded_file($_FILES['pimage']['tmp_name'], "uploads/" . $image);
    } else {
        $image = $data['image'];
    }

   // --- નવો PDF અપડેટ લોજિક ઉમેરો ---
$brochure_pdf = $data['brochure_pdf']; // જૂની ફાઇલનું નામ ડિફોલ્ટ રાખો
if(!empty($_FILES['brochure']['name'])) {
    $brochure_pdf = "brochure_" . time() . "_" . $_FILES['brochure']['name'];
    move_uploaded_file($_FILES['brochure']['tmp_name'], "uploads/pdf/" . $brochure_pdf);
}

// ક્વેરીમાં brochure_pdf = '$brochure_pdf' ઉમેરો
$update_query = "UPDATE products SET 
    category_id='$cat_id', product_name='$name', brand='$brand', sku='$sku', 
    original_price='$o_price', discounted_price='$d_price', 
    discount_percent='$discount_percent', min_qty='$min_qty', rating='$rating', 
    available_units='$units', short_description='$short_desc', 
    long_description='$long_desc', key_features='$features', 
    image='$image', brochure_pdf='$brochure_pdf' WHERE id='$id'";

    if(mysqli_query($conn, $update_query)) {
        header("Location: admin_dashboard.php?success=1"); // ડેશબોર્ડ પર પાછા જાઓ
    }
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Edit Product | InquiryHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        color: #111827;
    }
    </style>
</head>

<body class="p-6 md:p-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-4 mb-8 border-b pb-6">
            <a href="admin_dashboard.php"
                class="bg-white p-2.5 rounded-xl border border-gray-200 text-gray-400 hover:text-blue-600 transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-800 uppercase">Edit Product</h2>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Update Information for ID:
                    #<?php echo $id; ?></p>
            </div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-3 gap-8">

            <div class="col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Product Information</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Product Name</label>
                            <input type="text" name="pname" value="<?php echo $data['product_name']; ?>"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand Name</label>
                            <input type="text" name="brand" value="<?php echo $data['brand']; ?>"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">SKU Code</label>
                            <input type="text" name="sku" value="<?php echo $data['sku']; ?>"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Key Features (Commas
                                separated)</label>
                            <input type="text" name="features" value="<?php echo $data['key_features']; ?>"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                placeholder="Feature 1, Feature 2...">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Short
                                Description</label>
                            <textarea name="short_desc"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                rows="2"><?php echo $data['short_description']; ?></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Long Description</label>
                            <textarea name="long_desc"
                                class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-white"
                                rows="5"><?php echo $data['long_description']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Pricing & Inventory</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Original (₹)</label>
                            <input type="number" name="o_price" value="<?php echo $data['original_price']; ?>"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Discount (₹)</label>
                            <input type="number" name="d_price" value="<?php echo $data['discounted_price']; ?>"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Rating</label>
                            <input type="number" step="0.1" name="rating" value="<?php echo $data['rating']; ?>"
                                class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Units</label>
                            <input type="number" name="units" value="<?php echo $data['available_units']; ?>"
                                class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-white">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-4 tracking-widest">Select
                        Category</label>
                    <select name="category_id"
                        class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50 cursor-pointer">
                        <?php
                        $cats = mysqli_query($conn, "SELECT * FROM categories"); //
                        while($c = mysqli_fetch_assoc($cats)) {
                            $selected = ($c['id'] == $data['category_id']) ? "selected" : "";
                            echo "<option value='".$c['id']."' $selected>".$c['name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-4 tracking-widest">Product
                        Image</label>
                    <div class="flex flex-col items-center gap-4">
                        <div
                            class="w-full h-48 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="uploads/<?php echo $data['image']; ?>" class="w-full h-full object-cover">
                        </div>
                        <input type="file" name="pimage"
                            class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <input type="hidden" name="min_qty" value="<?php echo $data['min_qty']; ?>">
                    </div>
                    <div class="mt-4 w-full">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Update Brochure
                            (PDF)</label>
                        <input type="file" name="brochure" accept=".pdf"
                            class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                        <?php if(!empty($data['brochure_pdf'])): ?>
                        <p class="text-[10px] text-green-600 mt-1">Current PDF: <?php echo $data['brochure_pdf']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" name="update_product"
                    class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                    Update Changes
                </button>
            </div>
        </form>
    </div>
</body>

</html>