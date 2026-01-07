<?php
include 'db.php';

// પ્રોડક્ટ ડિલીટ કરવાની લોજિક
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = '$id'");
    echo "<script>alert('Product Deleted!'); window.location.href='admin_manage_products.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Manage Products | Admin</title>
    <style>
    body {
        font-family: 'Inter', sans-serif !important;
        font-size: 14px;
        color: #111827;
    }
    </style>
</head>

<body class="bg-gray-50 p-8">

    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-black p-6 flex justify-between items-center">
            <h2 class="text-white text-xl font-bold uppercase italic">Product Inventory</h2>
            <a href="admin_add_product.php"
                class="bg-yellow-500 text-black px-6 py-2 rounded-xl font-bold text-xs uppercase hover:bg-white transition">
                + Add New Product
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest">Product</th>
                        <th class="p-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest">Brand & Category
                        </th>
                        <th class="p-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest">Price</th>
                        <th class="p-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest">Rating</th>
                        <th class="p-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest text-center">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $res = mysqli_query($conn, "SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
                while($row = mysqli_fetch_assoc($res)): 
                ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 flex items-center gap-4">
                            <img src="uploads/<?php echo $row['image']; ?>"
                                class="w-12 h-16 object-cover rounded-lg bg-gray-100">
                            <div>
                                <div class="font-bold text-gray-900"><?php echo $row['product_name']; ?></div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">SKU:
                                    <?php echo $row['sku']; ?></div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-xs font-black text-blue-600 uppercase mb-1"><?php echo $row['brand']; ?>
                            </div>
                            <div class="text-xs text-gray-500"><?php echo $row['cat_name']; ?></div>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-gray-900">₹<?php echo number_format($row['discounted_price']); ?>
                            </div>
                            <div class="text-[10px] text-gray-400 line-through">
                                ₹<?php echo number_format($row['original_price']); ?></div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-1 font-bold text-xs text-yellow-600">
                                <?php echo $row['rating']; ?> <i class="fa fa-star text-[10px]"></i>
                            </div>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>"
                                class="inline-flex items-center justify-center w-9 h-9 bg-gray-100 text-gray-600 rounded-xl hover:bg-black hover:text-white transition">
                                <i class="fa fa-pen-to-square text-xs"></i>
                            </a>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')"
                                class="inline-flex items-center justify-center w-9 h-9 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition">
                                <i class="fa fa-trash-can text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>