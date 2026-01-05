<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry List - Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-serif font-bold text-gray-900">Inquiry List</h1>
            <p class="text-gray-500 mt-2">Submit an inquiry for your selected products to get pricing information.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-4">
                <?php
                $has_items = false;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $has_items = true;
                    foreach ($_SESSION['cart'] as $id => $qty) {
                        $res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
                        if ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="flex items-center gap-6 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <img src="uploads/<?php echo $row['image']; ?>"
                        class="w-24 h-24 object-cover rounded-2xl bg-gray-50">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800"><?php echo $row['product_name']; ?></h3>
                        <p class="text-gray-400 text-sm">Product ID: #<?php echo $id; ?></p>
                    </div>

                    <div class="flex items-center border rounded-xl overflow-hidden bg-gray-50">
                        <button onclick="updateQty(<?php echo $id; ?>, 'minus')"
                            class="px-3 py-1 hover:bg-gray-200">-</button>
                        <span class="px-4 py-1 font-bold text-sm"><?php echo $qty; ?></span>
                        <button onclick="updateQty(<?php echo $id; ?>, 'plus')"
                            class="px-3 py-1 hover:bg-gray-200">+</button>
                    </div>

                    <div class="text-right">
                        <button onclick="removeFromCart(<?php echo $id; ?>)"
                            class="text-red-400 hover:text-red-600 transition">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </div>
                </div>
                <?php 
                        }
                    }
                } else {
                    echo "<div class='text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200'>
                            <p class='text-gray-400 mb-4 font-medium'>Your inquiry list is empty!</p>
                            <a href='index.php' class='inline-block bg-yellow-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-black transition'>View Products</a>
                          </div>";
                }
                ?>
            </div>

            <?php if ($has_items): ?>
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 h-fit sticky top-24">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <i class="fa-regular fa-paper-plane text-yellow-600"></i> Send Inquiry
                </h3>

                <form action="submit_bulk_inquiry.php" method="POST" class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Full Name</label>
                        <input type="text" name="name" required placeholder="Enter your full name"
                            class="w-full mt-1 p-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none transition text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Mobile Number</label>
                        <input type="tel" name="phone" required placeholder="Enter your mobile number"
                            class="w-full mt-1 p-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none transition text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Message
                            (Optional)</label>
                        <textarea name="message" rows="3"
                            placeholder="Any special instructions or questions you have..."
                            class="w-full mt-1 p-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none transition text-sm"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-black text-white py-4 rounded-2xl font-bold hover:bg-yellow-600 transition shadow-xl flex items-center justify-center gap-2">
                            Request Quotation
                        </button>
                        <p class="text-[10px] text-gray-400 text-center mt-3 uppercase tracking-tighter">
                            We will get back to you within 24-48 hours.
                        </p>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
    function updateQty(id, action) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('action', action);
        fetch('update_cart_quantity.php', {
                method: 'POST',
                body: formData
            })
            .then(() => location.reload());
    }

    function removeFromCart(id) {
        if (confirm('Are you sure you want to remove this item?')) {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('action', 'remove');
            fetch('update_cart_quantity.php', {
                    method: 'POST',
                    body: formData
                })
                .then(() => location.reload());
        }
    }
    </script>
</body>

</html>