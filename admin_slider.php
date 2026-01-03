<?php
include('db.php');

// Delete Logic (Always put this at top before HTML starts)
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Optional: Database mathi file path laine folder mathi image delete karva mate
    $find = mysqli_query($conn, "SELECT image_path FROM sliders WHERE id=$id");
    $data = mysqli_fetch_assoc($find);
    if(file_exists($data['image_path'])) { unlink($data['image_path']); }

    mysqli_query($conn, "DELETE FROM sliders WHERE id=$id");
    header("Location: admin_slider.php");
    exit();
}

if(isset($_POST['upload'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

    $file_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO sliders (title, subtitle, image_path) VALUES ('$title', '$subtitle', '$target_file')";
        mysqli_query($conn, $sql);
        echo "<script>alert('Slider Added Successfully!'); window.location='admin_slider.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Admin Dashboard | Luxury Store</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
    }

    .glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #ca8a04 0%, #a16207 100%);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(202, 138, 4, 0.4);
    }

    .table-row-hover:hover {
        background-color: #f9fafb;
        transition: 0.2s;
    }
    </style>
</head>

<body class="py-10 px-5">

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Slider Management</h1>
                <p class="text-gray-500">Add or remove homepage banner sliders</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fa fa-images text-yellow-600 text-2xl"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1">
                <div class="glass p-6 rounded-2xl shadow-xl border border-white">
                    <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="fa fa-plus-circle text-yellow-600"></i> New Slider
                    </h2>
                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600 block mb-1">Main Title</label>
                            <input type="text" name="title" placeholder="e.g. Exclusive Watch"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 outline-none"
                                required>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 block mb-1">Subtitle</label>
                            <input type="text" name="subtitle" placeholder="e.g. 20% Off Today"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 outline-none">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 block mb-1">Slider Image</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-yellow-500 transition cursor-pointer bg-gray-50">
                                <div class="space-y-1 text-center">
                                    <i class="fa fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-yellow-600 hover:text-yellow-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="image" type="file" class="sr-only" required
                                                onchange="previewImage(event)">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                                </div>
                            </div>
                            <img id="output-image"
                                class="mt-4 rounded-lg hidden shadow-md w-full h-32 object-cover border" />
                        </div>
                        <button type="submit" name="upload"
                            class="w-full btn-gradient text-white py-3 rounded-xl font-bold uppercase tracking-wide">
                            Add to Slider
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="glass rounded-2xl shadow-xl border border-white overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-xl font-semibold">Active Sliders</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase">Preview</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase">Details</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase text-center">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM sliders ORDER BY id DESC");
                                if(mysqli_num_rows($res) > 0) {
                                    while($item = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4">
                                        <div class="relative group">
                                            <img src="<?php echo $item['image_path']; ?>"
                                                class="w-24 h-14 rounded-lg object-cover shadow-sm ring-2 ring-gray-100">
                                            <div
                                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded-lg flex items-center justify-center">
                                                <i class="fa fa-search-plus text-white text-xs"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800"><?php echo $item['title']; ?></div>
                                        <div class="text-xs text-gray-400"><?php echo $item['subtitle']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="?delete=<?php echo $item['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete this slider?')"
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition shadow-sm">
                                            <i class="fa fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='3' class='p-10 text-center text-gray-400'>No sliders found. Start by adding one!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
    // Image Preview Script
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output-image');
            output.src = reader.result;
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>
</body>

</html>