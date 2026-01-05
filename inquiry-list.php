<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bulk Inquiry List | Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">તમારી ઇન્ક્વાયરી લિસ્ટ</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-4">
                <?php
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $id => $qty) {
                        $res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
                        if ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="flex items-center gap-6 bg-white p-5 rounded-2xl border shadow-sm">
                    <img src="uploads/<?php echo $row['image']; ?>" class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg"><?php echo $row['product_name']; ?></h3>
                        <p class="text-gray-400 text-sm">Product Code: #<?php echo $row['id']; ?></p>
                    </div>

                    <div class="flex items-center border rounded-lg bg-gray-50">
                        <input type="number" value="<?php echo $qty; ?>"
                            onchange="updateBulkQty(<?php echo $id; ?>, this.value)"
                            class="w-20 text-center p-2 bg-transparent font-bold outline-none" min="1">
                    </div>

                    <button onclick="removeFromInquiry(<?php echo $id; ?>)" class="text-red-400 hover:text-red-600">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <?php 
                        }
                    }
                } else {
                    echo "<div class='text-center py-20 bg-white rounded-3xl border-2 border-dashed font-bold text-gray-400'>તમારી લિસ્ટ અત્યારે ખાલી છે.</div>";
                }
                ?>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg border h-fit sticky top-24">
                <h3 class="text-xl font-bold mb-6">Request Wholesale Quote</h3>
                <form action="submit_inquiry.php" method="POST" class="space-y-4">
                    <input type="text" name="name" placeholder="તમારું નામ / કંપનીનું નામ" required
                        class="w-full p-3 border rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-yellow-500">
                    <input type="tel" name="phone" placeholder="મોબાઈલ નંબર (WhatsApp)" required
                        class="w-full p-3 border rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-yellow-500">
                    <textarea name="message" placeholder="તમારી કોઈ ખાસ જરૂરિયાત જણાવો..."
                        class="w-full p-3 border rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-yellow-500"
                        rows="4"></textarea>

                    <button type="submit"
                        class="w-full bg-yellow-600 text-white font-bold py-4 rounded-xl hover:bg-black transition-all">
                        બધી પ્રોડક્ટ્સ માટે ઇન્ક્વાયરી મોકલો
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
    function updateBulkQty(id, val) {
        const fd = new FormData();
        fd.append('id', id);
        fd.append('action', 'update');
        fd.append('qty', val);
        fetch('update_cart_quantity.php', {
            method: 'POST',
            body: fd
        }).then(() => location.reload());
    }

    function removeFromInquiry(id) {
        const fd = new FormData();
        fd.append('id', id);
        fd.append('action', 'remove');
        fetch('update_cart_quantity.php', {
            method: 'POST',
            body: fd
        }).then(() => location.reload());
    }
    </script>
</body>

</html>