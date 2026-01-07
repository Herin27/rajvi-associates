<?php
include 'db.php';

// સ્ટેટસ અપડેટ કરવાની લોજિક
if(isset($_POST['update_status'])) {
    $id = $_POST['inquiry_id'];
    $new_status = $_POST['status'];
    mysqli_query($conn, "UPDATE inquiries SET status = '$new_status' WHERE id = '$id'");
    echo "<script>alert('Status Updated!'); window.location.href='admin_inquiries.php';</script>";
}

$query = mysqli_query($conn, "SELECT * FROM inquiries ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Inquiry Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="bg-black p-6 flex justify-between items-center">
            <h2 class="text-white text-xl font-bold flex items-center gap-3">
                <i class="fa fa-shopping-basket text-yellow-500"></i> Inquiry Orders
            </h2>
            <span class="text-gray-400 text-sm">Total Inquiries: <?php echo mysqli_num_rows($query); ?></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-4 font-bold text-gray-600 uppercase text-xs">Customer & Message</th>
                        <th class="p-4 font-bold text-gray-600 uppercase text-xs">Products Requested</th>
                        <th class="p-4 font-bold text-gray-600 uppercase text-xs text-center">Status</th>
                        <th class="p-4 font-bold text-gray-600 uppercase text-xs text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)) { 
                    $inquiry_id = $row['id'];
                    $phone = $row['phone'];
                    $name = $row['customer_name'];
                    $status = $row['status'];
                    $cust_msg = $row['message'];
                    
                    // Status Style logic
                    $badge = "bg-blue-100 text-blue-700";
                    if($status == 'Contacted') $badge = "bg-yellow-100 text-yellow-700";
                    if($status == 'Completed') $badge = "bg-green-100 text-green-700";
                ?>
                    <tr class="border-b hover:bg-gray-50 transition align-top">
                        <td class="p-4 w-64">
                            <div class="font-bold text-gray-800 text-lg"><?php echo $name; ?></div>
                            <div class="text-blue-600 font-medium text-sm mb-2"><i
                                    class="fa fa-whatsapp mr-1"></i><?php echo $phone; ?></div>
                            <?php if($cust_msg): ?>
                            <div class="bg-gray-100 p-2 rounded-lg text-xs text-gray-600 italic">
                                "<?php echo $cust_msg; ?>"
                            </div>
                            <?php endif; ?>
                            <div class="text-[10px] text-gray-400 mt-2">
                                <?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></div>
                        </td>

                        <td class="p-4">
                            <div class="space-y-2">
                                <?php 
                            // આ ઇન્ક્વાયરી માટેની પ્રોડક્ટ્સ શોધો
                            $items_query = mysqli_query($conn, "SELECT ii.*, p.product_name, p.image, p.sku FROM inquiry_items ii JOIN products p ON ii.product_id = p.id WHERE ii.inquiry_id = '$inquiry_id'");
                            while($item = mysqli_fetch_assoc($items_query)) {
                            ?>
                                <div class="flex items-center gap-3 bg-white border rounded-xl p-2 shadow-sm">
                                    <img src="uploads/<?php echo $item['image']; ?>"
                                        class="w-10 h-10 object-cover rounded-lg">
                                    <div>
                                        <div class="text-sm font-bold text-gray-800">
                                            <?php echo $item['product_name']; ?></div>
                                        <div class="text-[10px] text-gray-500">SKU: <?php echo $item['sku']; ?> | <span
                                                class="text-black font-bold text-xs">Qty:
                                                <?php echo $item['quantity']; ?></span></div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </td>

                        <td class="p-4 text-center">
                            <form method="POST" class="inline-block">
                                <input type="hidden" name="inquiry_id" value="<?php echo $inquiry_id; ?>">
                                <span
                                    class="block mb-2 px-2 py-1 rounded-full text-[10px] font-bold uppercase <?php echo $badge; ?>">
                                    <?php echo $status; ?>
                                </span>
                                <select name="status" onchange="this.form.submit()" name="update_status"
                                    class="border p-1 rounded-lg text-xs bg-white shadow-sm outline-none">
                                    <option value="New" <?php if($status == 'New') echo 'selected'; ?>>New</option>
                                    <option value="Contacted" <?php if($status == 'Contacted') echo 'selected'; ?>>
                                        Contacted</option>
                                    <option value="Completed" <?php if($status == 'Completed') echo 'selected'; ?>>
                                        Completed</option>
                                </select>
                                <input type="hidden" name="update_status">
                            </form>
                        </td>

                        <td class="p-4 text-center">
                            <?php 
                        $wa_msg = "Hello $name, Regarding your inquiry #$inquiry_id, we have updated the status to: $status. We will contact you soon.";
                        $wa_link = "https://wa.me/91$phone?text=" . urlencode($wa_msg);
                        ?>
                            <a href="<?php echo $wa_link; ?>" target="_blank"
                                class="inline-flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full hover:bg-green-600 transition shadow-lg">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>