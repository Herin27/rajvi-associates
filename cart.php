<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart - Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-serif font-bold mb-8">Shopping Cart</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-4">
                <?php
                $total = 0;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $id => $qty) {
                        $res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
                        if ($row = mysqli_fetch_assoc($res)) {
                            $subtotal = $row['discounted_price'] * $qty;
                            $total += $subtotal;
                ?>
                <div class="flex items-center gap-6 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <img src="uploads/<?php echo $row['image']; ?>" class="w-24 h-24 object-cover rounded-2xl">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg"><?php echo $row['product_name']; ?></h3>
                        <p class="text-yellow-600 font-bold">₹<?php echo number_format($row['discounted_price'], 2); ?>
                        </p>
                    </div>

                    <div class="flex items-center border rounded-xl overflow-hidden bg-gray-50">
                        <button onclick="updateQty(<?php echo $id; ?>, 'minus')"
                            class="px-3 py-1 hover:bg-gray-200">-</button>
                        <span class="px-4 py-1 font-bold text-sm"><?php echo $qty; ?></span>
                        <button onclick="updateQty(<?php echo $id; ?>, 'plus')"
                            class="px-3 py-1 hover:bg-gray-200">+</button>
                    </div>

                    <div class="text-right min-w-[100px]">
                        <p class="font-bold text-gray-800">₹<?php echo number_format($subtotal, 2); ?></p>
                        <button onclick="removeFromCart(<?php echo $id; ?>)"
                            class="text-red-400 text-xs hover:text-red-600 mt-2">Remove</button>
                    </div>
                </div>
                <?php 
                        }
                    }
                } else {
                    echo "<div class='text-center py-20 bg-white rounded-3xl'>Your cart is empty! <a href='index.php' class='text-yellow-600 font-bold'>Shop Now</a></div>";
                }
                ?>
            </div>

            <?php if ($total > 0): ?>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-fit sticky top-24">
                <h3 class="text-xl font-bold mb-6">Order Summary</h3>
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span>₹<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Shipping</span>
                        <span class="text-green-600">Free</span>
                    </div>
                    <div class="border-t pt-4 flex justify-between font-bold text-xl">
                        <span>Total</span>
                        <span>₹<?php echo number_format($total, 2); ?></span>
                    </div>
                </div>
                <a href="checkout.php"
                    class="block text-center w-full bg-black text-white py-4 rounded-2xl font-bold hover:bg-yellow-600 transition shadow-xl">Proceed
                    to Checkout</a>
            </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>

    <script>
    // Quantity Update Logic
    function updateQty(id, action) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('action', action);

        fetch('update_cart_quantity.php', {
                method: 'POST',
                body: formData
            })
            .then(() => location.reload()); // સરળતા માટે પેજ રિફ્રેશ કરો
    }

    // Remove Product Logic
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