<?php
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rajvi-associates";
$conn = new mysqli($host, $user, $pass, $dbname);

if(isset($_POST['add_product'])) {
    $cat_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $o_price = $_POST['o_price'];
    $d_price = $_POST['d_price'];
    $units = $_POST['units'];
    $rating = $_POST['rating'];
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $long_desc = mysqli_real_escape_string($conn, $_POST['long_desc']);
    $features = mysqli_real_escape_string($conn, $_POST['features']);
    $min_qty = $_POST['min_qty'];
    $brochure_name = NULL;

    // મહત્વનો સુધારો: ખાલી વેલ્યુને બદલે '{}' મોકલો અને તેને Escape કરો
    $extra_json = (isset($_POST['extra']) && !empty($_POST['extra'])) ? json_encode($_POST['extra']) : '{}';
    $extra_details = mysqli_real_escape_string($conn, $extra_json);

    // Additional Images Handling
    $additional_images = [];
    if(isset($_FILES['extra_images'])) {
        foreach($_FILES['extra_images']['tmp_name'] as $key => $tmp_name) {
            if(!empty($tmp_name)) {
                $file_name = time() . "_" . $_FILES['extra_images']['name'][$key];
                // આ લાઇન ચેક કરો, તેમાં છેલ્લે '/' હોવો જોઈએ
move_uploaded_file($_FILES['brochure']['tmp_name'], "uploads/pdf/" . $brochure_name);
                $additional_images[] = $file_name;
            }
        }
    }
    if(isset($_FILES['brochure']['name']) && !empty($_FILES['brochure']['name'])) {
    $brochure_name = "brochure_" . time() . "_" . $_FILES['brochure']['name'];
    move_uploaded_file($_FILES['brochure']['tmp_name'], "uploads/pdf/" . $brochure_name);
    }
    $extra_images_str = implode(',', $additional_images);
    
    // Discount Calculation
    $discount_percent = ($o_price > 0) ? round((($o_price - $d_price) / $o_price) * 100) : 0;

    // Main Image Upload
    $image = time() . "_" . $_FILES['pimage']['name'];
    move_uploaded_file($_FILES['pimage']['tmp_name'], "uploads/" . $image);

    // ક્વેરીમાં $extra_details વાપર્યું છે જે હવે ક્યારેય ખાલી નહીં હોય
    $query = "INSERT INTO products (category_id, product_name, brand, sku, original_price, discounted_price, discount_percent, min_qty, rating, additional_images, available_units, short_description, long_description, key_features, category_details, image,brochure_pdf) 
              VALUES ('$cat_id', '$name', '$brand', '$sku', '$o_price', '$d_price', '$discount_percent', '$min_qty', '$rating', '$extra_images_str', '$units', '$short_desc', '$long_desc', '$features', '$extra_details', '$image','$brochure_name')";

    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Product added successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        // જો હજી પણ Error આવે તો તેને જોવા માટે:
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Add Product | Admin Panel</title>
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
                <h2 class="text-2xl font-bold tracking-tight text-gray-800">ADD NEW PRODUCT</h2>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Inventory Management System</p>
            </div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-3 gap-8">
            <div class="col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Product Details</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Product Name</label>
                            <input type="text" name="pname"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                placeholder="e.g. Luxury Perfume" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand Name</label>
                            <input type="text" name="brand"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                placeholder="e.g. Rajvi" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">SKU Code</label>
                            <input type="text" name="sku"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                placeholder="PSS-001">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Short Intro
                                Description</label>
                            <textarea name="short_desc"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                rows="2"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Full Long
                                Description</label>
                            <textarea name="long_desc"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Pricing & Inventory</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Original (₹)</label>
                            <input type="number" name="o_price"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Discounted (₹)</label>
                            <input type="number" name="d_price"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Rating (1-5)</label>
                            <input type="number" step="0.1" name="rating" value="4.5"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">MOQ</label>
                            <input type="number" name="min_qty" value="1"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50">
                        </div>
                        <div class="col-span-2 md:col-span-4">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Stock Available
                                (Units)</label>
                            <input type="number" name="units"
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                                placeholder="e.g. 100">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-4 tracking-widest">Select
                        Category</label>
                    <select name="category_id" onchange="showDynamicFields(this.value)"
                        class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50 cursor-pointer"
                        required>
                        <option value="">Choose Category</option>
                        <?php
                        $cats = mysqli_query($conn, "SELECT * FROM categories");
                        while($c = mysqli_fetch_assoc($cats)) {
                            echo "<option value='".$c['id']."'>".$c['name']."</option>";
                        }
                        ?>
                    </select>
                    <div id="dynamic-fields"
                        class="mt-6 p-4 bg-blue-50 rounded-2xl border border-dashed border-blue-200 hidden"></div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Main Product Image</label>
                        <input type="file" name="pimage"
                            class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Extra Gallery Images</label>
                        <input type="file" name="extra_images[]"
                            class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer"
                            multiple>
                    </div>
                    <div class="mt-6 border-t pt-6">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Product Brochure
                            (PDF)</label>
                        <input type="file" name="brochure" accept=".pdf"
                            class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
                        <p class="text-[9px] text-gray-400 mt-2 italic">*Only PDF files are allowed</p>
                    </div>
                </div>

                <button type="submit" name="add_product"
                    class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                    Publish to Website
                </button>
            </div>
        </form>
    </div>

    <script>
    function showDynamicFields(catId) {
        const container = document.getElementById('dynamic-fields');
        if (catId == "3") { // Perfume ID
            container.classList.remove('hidden');
            container.innerHTML = `
                <h3 class="text-[10px] font-black uppercase text-blue-600 mb-3 tracking-tighter italic">Perfume Details</h3>
                <div class="space-y-4">
                    <input type="text" name="extra[scent]" class="w-full border border-blue-100 p-2 text-sm rounded-lg outline-none" placeholder="Fragrance Type" required>
                    <input type="text" name="extra[volume]" class="w-full border border-blue-100 p-2 text-sm rounded-lg outline-none" placeholder="Volume (ml)" required>
                    <input type="text" name="extra[scent_features]" class="w-full border border-blue-100 p-2 text-sm rounded-lg outline-none" placeholder="Features (e.g. Long-lasting)">
                </div>
            `;
        } else if (catId == "4") { // Health Care ID (તમારી સાચી ID અહીં લખો)
            container.classList.remove('hidden');
            container.innerHTML = `
            <h3 class="text-[10px] font-black uppercase text-green-600 mb-3 tracking-tighter italic">Health Care Details</h3>
            <div class="space-y-4">
                <select name="extra[item_form]" class="w-full border border-green-100 p-2 text-sm rounded-lg outline-none" required>
                    <option value="">Select Item Form</option>
                    <option value="Tablet">Paste</option>
                    <option value="Capsule">Capsule</option>
                    <option value="Syrup">Syrup</option>
                    <option value="Powder">Powder</option>
                    <option value="Gel">Gel</option>
                </select>
                <input type="text" name="extra[flavour]" class="w-full border border-green-100 p-2 text-sm rounded-lg outline-none" placeholder="Flavour (e.g. Orange, Mint, Unflavoured)" required>
                
            </div>
        `;
        } else {
            container.classList.add('hidden');
            container.innerHTML = "";
        }
    }
    </script>
</body>

</html>