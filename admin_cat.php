<?php
include('db.php');

// Delete Category Logic
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $find = mysqli_query($conn, "SELECT image_path FROM categories WHERE id=$id");
    $data = mysqli_fetch_assoc($find);
    if(file_exists($data['image_path'])) { unlink($data['image_path']); }

    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    header("Location: admin_cat.php");
    exit();
}

// Add Category Logic
if(isset($_POST['add_cat'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $target_dir = "uploads/categories/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        mysqli_query($conn, "INSERT INTO categories (name, image_path) VALUES ('$name', '$target_file')");
        echo "<script>alert('Category Added Successfully!'); window.location='admin_cat.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Manage Categories | Luxury Store</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .admin-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .gradient-btn {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        transition: all 0.3s ease;
    }

    .gradient-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.3);
    }
    </style>
</head>

<body class="py-12 px-4">

    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Manage Categories</h1>
                <p class="text-slate-500 text-sm">Organize your store collections and sports</p>
            </div>
            <a href="index.php"
                class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 text-slate-600 hover:text-yellow-600 transition flex items-center gap-2">
                <i class="fa fa-eye"></i> View Site
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-4">
                <div class="admin-card p-8 rounded-3xl shadow-xl">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="fa fa-folder-plus text-yellow-500"></i> New Collection
                    </h2>

                    <form method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div>
                            <label
                                class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block">Category
                                Name</label>
                            <input type="text" name="name" placeholder="e.g. Running, Rolex"
                                class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block">Icon /
                                Image</label>
                            <div class="relative group">
                                <div
                                    class="w-full h-40 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center bg-slate-50 group-hover:border-yellow-500 transition cursor-pointer overflow-hidden">
                                    <div id="upload-placeholder" class="text-center">
                                        <i class="fa fa-cloud-arrow-up text-slate-300 text-3xl mb-2"></i>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">Click to Upload</p>
                                    </div>
                                    <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                    <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer"
                                        onchange="previewFile(this)" required>
                                </div>
                            </div>
                        </div>

                        <button name="add_cat"
                            class="w-full gradient-btn text-white py-4 rounded-xl font-bold text-sm tracking-widest uppercase">
                            Add Category
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="admin-card rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white/50">
                        <h3 class="font-bold text-slate-800">Existing Collections</h3>
                        <span
                            class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase">
                            <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM categories")); ?> Total
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        Preview</th>
                                    <th
                                        class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        Name</th>
                                    <th
                                        class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
                                while($cat = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-white border border-slate-100 p-2 shadow-sm">
                                            <img src="<?php echo $cat['image_path']; ?>"
                                                class="w-full h-full object-contain">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="font-bold text-slate-700 text-sm"><?php echo $cat['name']; ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="?delete=<?php echo $cat['id']; ?>"
                                            onclick="return confirm('Are you sure? Products in this category might be affected.')"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition shadow-sm">
                                            <i class="fa fa-trash-can text-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
    function previewFile(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                document.getElementById("preview").src = reader.result;
                document.getElementById("preview").classList.remove("hidden");
                document.getElementById("upload-placeholder").classList.add("hidden");
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>

</html>