<?php
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rajvi-associates";
$conn = new mysqli($host, $user, $pass, $dbname);

if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $parent_id = $_POST['parent_id'] ?? 0;

    // Image Upload Handling
    $image_path = "";
    if (!empty($_FILES['cat_image']['name'])) {
        $file_name = time() . "_" . $_FILES['cat_image']['name'];
        $target = "uploads/categories/" . $file_name;
        if (move_uploaded_file($_FILES['cat_image']['tmp_name'], $target)) {
            $image_path = $target;
        }
    }

    $sql = "INSERT INTO categories (name, image_path, parent_id) VALUES ('$name', '$image_path', '$parent_id')";
    
    if ($conn->query($sql)) {
        header("Location: admin_dashboard.php?success=Category Added");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Add Category | InquiryHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    </style>
</head>

<body class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-8 border-b pb-6">
            <a href="admin_dashboard.php"
                class="bg-white p-2.5 rounded-xl border border-gray-200 text-gray-400 hover:text-blue-600 transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">ADD NEW CATEGORY</h2>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Organize your product hierarchy</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Category Name</label>
                    <input type="text" name="cat_name" required
                        class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                        placeholder="e.g. Machinery, Electronics">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Parent Category
                        (Optional)</label>
                    <select name="parent_id"
                        class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50 cursor-pointer">
                        <option value="0">None (Main Category)</option>
                        <?php
                        $res = $conn->query("SELECT * FROM categories WHERE parent_id = 0");
                        while($row = $res->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Category Icon/Image</label>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-20 h-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-100 flex items-center justify-center text-gray-300">
                            <i class="far fa-image text-2xl"></i>
                        </div>
                        <input type="file" name="cat_image"
                            class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="submit" name="add_category"
                        class="flex-1 bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                        Create Category
                    </button>
                    <a href="admin_dashboard.php"
                        class="px-8 bg-gray-50 text-gray-400 font-bold py-4 rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>