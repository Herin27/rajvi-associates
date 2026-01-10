<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM categories WHERE id = $id");
    $cat = $res->fetch_assoc();
}

if (isset($_POST['update_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $parent_id = $_POST['parent_id'];
    $image_path = $cat['image_path'];

    if (!empty($_FILES['cat_image']['name'])) {
        $file_name = time() . "_" . $_FILES['cat_image']['name'];
        $target = "uploads/categories/" . $file_name;
        if (move_uploaded_file($_FILES['cat_image']['tmp_name'], $target)) {
            $image_path = $target;
        }
    }

    $sql = "UPDATE categories SET name='$name', image_path='$image_path', parent_id='$parent_id' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: admin_dashboard.php?success=Category Updated");
    }
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Edit Category | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    </style>
</head>

<body class="p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
        <h2 class="text-xl font-bold text-gray-800 mb-6 uppercase">Edit Category</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Category Name</label>
                <input type="text" name="cat_name" value="<?php echo $cat['name']; ?>"
                    class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50"
                    required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Current Icon</label>
                <div class="flex items-center gap-4">
                    <img src="<?php echo $cat['image_path']; ?>" class="w-16 h-16 rounded-xl border object-cover">
                    <input type="file" name="cat_image" class="text-xs">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" name="update_category"
                    class="flex-1 bg-blue-600 text-white font-bold py-4 rounded-2xl uppercase text-xs tracking-widest">Update
                    Category</button>
                <a href="admin_dashboard.php"
                    class="px-8 bg-gray-50 text-gray-400 font-bold py-4 rounded-2xl text-xs uppercase text-center">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>