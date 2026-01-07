<?php
include('db.php');
$all_inquiries = []; // બધી ઇન્ક્વાયરી સ્ટોર કરવા માટે એરે
$error = "";

if (isset($_POST['track'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    // LIMIT 1 કાઢી નાખ્યું જેથી બધી જ ઇન્ક્વાયરી મળે
    $query = "SELECT * FROM inquiries WHERE phone = '$phone' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $all_inquiries[] = $row; // એરેમાં બધી રો સેવ કરો
        }
    } else {
        $error = "No inquiries found for this mobile number.";
    }
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Track All Inquiries | Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="max-w-3xl mx-auto px-6 py-12">
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Check Your inquiry status</h1>

            <form action="" method="POST" class="flex gap-4">
                <input type="tel" name="phone" placeholder="Enter your mobile number" required
                    value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>"
                    class="flex-1 p-4 border rounded-2xl bg-gray-50 outline-none focus:ring-2 focus:ring-yellow-500 transition">
                <button type="submit" name="track"
                    class="bg-black text-white px-8 py-4 rounded-2xl font-bold hover:bg-yellow-600 transition">
                    Track Inquiry
                </button>
            </form>
        </div>

        <?php if ($error): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-center font-medium">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <div class="space-y-8">
            <?php foreach ($all_inquiries as $status_data): ?>
            <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-sm text-gray-400 font-bold">Inquiry ID: #<?php echo $status_data['id']; ?></p>
                        <p class="text-[10px] text-gray-400 italic">
                            <?php echo date('d M, Y', strtotime($status_data['created_at'])); ?></p>
                    </div>
                    <div class="mt-10 border-t pt-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">પસંદ કરેલી પ્રોડક્ટ્સ
                        </h4>
                        <div class="grid grid-cols-1 gap-3">
                            <?php 
        $inq_id = $status_data['id'];
        // ઇન્ક્વાયરી આઈટમ્સ અને પ્રોડક્ટ્સને જોડતી ક્વેરી
        $items_res = mysqli_query($conn, "SELECT ii.quantity, p.product_name, p.image, p.sku 
                                          FROM inquiry_items ii 
                                          JOIN products p ON ii.product_id = p.id 
                                          WHERE ii.inquiry_id = '$inq_id'");
        
        while($item = mysqli_fetch_assoc($items_res)): 
        ?>
                            <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                                <img src="uploads/<?php echo $item['image']; ?>"
                                    class="w-12 h-12 object-cover rounded-xl bg-white">
                                <div class="flex-1">
                                    <h5 class="text-sm font-bold text-gray-800"><?php echo $item['product_name']; ?>
                                    </h5>
                                    <p class="text-[10px] text-gray-400">SKU: <?php echo $item['sku']; ?></p>
                                </div>
                                <div class="text-right px-4 border-l">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Qty</p>
                                    <p class="font-bold text-gray-800"><?php echo $item['quantity']; ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-4 py-1 rounded-full text-xs font-bold 
                                <?php 
                                    if($status_data['status'] == 'New') echo 'bg-blue-100 text-blue-600';
                                    elseif($status_data['status'] == 'Contacted') echo 'bg-yellow-100 text-yellow-600';
                                    else echo 'bg-green-100 text-green-600';
                                ?>">
                            <?php echo $status_data['status']; ?>
                        </span>
                    </div>
                </div>

                <div class="mt-8 mb-4">
                    <div class="relative flex justify-between px-2">
                        <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
                        <div class="absolute top-1/2 left-0 h-1 bg-yellow-500 -translate-y-1/2 transition-all" style="width: <?php 
                                    if($status_data['status'] == 'New') echo '0%';
                                    elseif($status_data['status'] == 'Contacted') echo '50%';
                                    else echo '100%';
                                 ?>;"></div>

                        <div class="relative z-10 flex flex-col items-center">
                            <div
                                class="w-6 h-6 rounded-full flex items-center justify-center border-4 border-white <?php echo ($status_data['status'] == 'New' || $status_data['status'] == 'Contacted' || $status_data['status'] == 'Completed') ? 'bg-yellow-500 text-white' : 'bg-gray-300'; ?>">
                                <i class="fa fa-check text-[8px]"></i>
                            </div>
                            <span class="text-[8px] font-bold mt-1 uppercase">New</span>
                        </div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div
                                class="w-6 h-6 rounded-full flex items-center justify-center border-4 border-white <?php echo ($status_data['status'] == 'Contacted' || $status_data['status'] == 'Completed') ? 'bg-yellow-500 text-white' : 'bg-gray-300'; ?>">
                                <i class="fa fa-phone text-[8px]"></i>
                            </div>
                            <span class="text-[8px] font-bold mt-1 uppercase">Contacted</span>
                        </div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div
                                class="w-6 h-6 rounded-full flex items-center justify-center border-4 border-white <?php echo ($status_data['status'] == 'Completed') ? 'bg-yellow-500 text-white' : 'bg-gray-300'; ?>">
                                <i class="fa fa-thumbs-up text-[8px]"></i>
                            </div>
                            <span class="text-[8px] font-bold mt-1 uppercase">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>