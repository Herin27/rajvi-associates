<?php
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rajvi-associates";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// URL માંથી Inquiry ID મેળવો
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}
$id = (int)$_GET['id'];

// 1. મુખ્ય ઇન્ક્વાયરીની વિગત મેળવો
$inq_sql = "SELECT * FROM inquiries WHERE id = $id";
$inq_res = $conn->query($inq_sql);
$inquiry = $inq_res->fetch_assoc();

if (!$inquiry) {
    echo "Inquiry not found!";
    exit;
}

// 2. આ ઇન્ક્વાયરીમાં કઈ પ્રોડક્ટ્સ છે તે મેળવો (inquiry_items અને products નો Join)
$items_sql = "SELECT ii.quantity, p.product_name, p.image, p.discounted_price 
              FROM inquiry_items ii 
              JOIN products p ON ii.product_id = p.id 
              WHERE ii.inquiry_id = $id";
$items_res = $conn->query($items_sql);
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Inquiry Details #<?php echo $id; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 p-4 md:p-10">

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Inquiry #<?php echo $id; ?></h1>
                <p class="text-sm text-gray-500">Received on:
                    <?php echo date('d M Y, h:i A', strtotime($inquiry['created_at'])); ?></p>
            </div>
            <a href="admin_dashboard.php" class="text-gray-500 hover:text-gray-800"><i
                    class="fas fa-times text-xl"></i></a>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-2 gap-8 mb-10">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Customer Info</h3>
                    <p class="text-lg font-bold text-gray-800"><?php echo $inquiry['customer_name']; ?></p>
                    <p class="text-blue-600 font-medium"><i
                            class="fas fa-phone-alt mr-2"></i><?php echo $inquiry['phone']; ?></p>
                </div>
                <div class="text-right">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Current Status</h3>
                    <?php 
                        $statusColor = ($inquiry['status'] == 'New') ? 'bg-blue-100 text-blue-700' : (($inquiry['status'] == 'Contacted') ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700');
                    ?>
                    <span class="<?php echo $statusColor; ?> px-4 py-1.5 rounded-full text-xs font-bold">
                        <?php echo $inquiry['status']; ?>
                    </span>
                </div>
            </div>

            <div class="mb-10">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Inquired Products</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-sm">
                            <th class="py-3 font-medium">Product</th>
                            <th class="py-3 font-medium">Quantity</th>
                            <th class="py-3 font-medium text-right">Price (Each)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php while($item = $items_res->fetch_assoc()): ?>
                        <tr>
                            <td class="py-4 flex items-center gap-4">
                                <img src="uploads/<?php echo $item['image']; ?>"
                                    class="w-12 h-12 rounded-lg border object-cover"
                                    onerror="this.src='https://via.placeholder.com/50';">
                                <span class="font-semibold text-gray-700"><?php echo $item['product_name']; ?></span>
                            </td>
                            <td class="py-4 text-gray-600"><?php echo $item['quantity']; ?> units</td>
                            <td class="py-4 text-right font-bold text-gray-800">
                                ₹<?php echo number_format($item['discounted_price'], 2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 mb-10">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Message from Customer</h3>
                <p class="text-gray-700 leading-relaxed">
                    <?php echo !empty($inquiry['message']) ? $inquiry['message'] : "No message provided."; ?></p>
            </div>

            <div class="flex gap-4">
                <a href="update_status.php?id=<?php echo $id; ?>&status=Contacted"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition">Mark as
                    Contacted</a>
                <a href="update_status.php?id=<?php echo $id; ?>&status=Completed"
                    class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-green-700 transition">Mark
                    as Completed</a>
                <a href="delete_inquiry.php?id=<?php echo $id; ?>"
                    onclick="return confirm('Are you sure you want to delete this inquiry?')"
                    class="ml-auto text-red-500 font-bold px-6 py-2.5 hover:bg-red-50 rounded-xl transition">Delete</a>
            </div>
        </div>
    </div>

</body>

</html>