<?php
include('db.php');
if(isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $target_dir = "uploads/categories/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . $_FILES["image"]["name"];
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        mysqli_query($conn, "INSERT INTO categories (name, image_path) VALUES ('$name', '$target_file')");
        header("Location: admin_cat.php");
    }
}
?>

<body class="bg-gray-50 p-10 font-sans">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-xl font-bold mb-6">Add Category with Image</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="name" placeholder="Category Name (e.g. Rolex)"
                class="w-full p-3 border rounded-xl outline-none focus:ring-2 focus:ring-yellow-500" required>
            <input type="file" name="image" class="w-full p-2" required>
            <button name="add_cat"
                class="w-full bg-black text-white py-3 rounded-xl font-bold hover:bg-yellow-600 transition">Add
                Category</button>
        </form>
    </div>
</body>