<?php
include 'db.php';
session_start();
$ip = $_SERVER['REMOTE_ADDR']; // યુઝરની ઓળખ માટે

// વિશલિસ્ટમાંથી પ્રોડક્ટ્સની વિગતો મેળવવી
$query = "SELECT p.* FROM products p 
          JOIN wishlist w ON p.id = w.product_id 
          WHERE w.ip_address = '$ip' 
          ORDER BY w.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-[#F9F9F9]">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-16">
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-black italic uppercase tracking-tighter text-gray-900">My Wishlist</h1>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.3em] mt-2">Your Saved Luxury Pieces</p>
        </div>

        <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div
                class="product-card group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
                <div class="relative h-72 overflow-hidden bg-gray-50">
                    <button onclick="toggleWishlist(<?php echo $row['id']; ?>, this)"
                        class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 shadow-md z-10">
                        <i class="fa-solid fa-heart"></i>
                    </button>

                    <a href="product-details.php?id=<?php echo $row['id']; ?>">
                        <img src="uploads/<?php echo $row['image']; ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </a>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-800 text-sm mb-2"><?php echo $row['product_name']; ?></h3>
                    <p class="text-xl font-black text-black mb-4">
                        ₹<?php echo number_format($row['discounted_price']); ?></p>
                    <button onclick="addToInquiry(<?php echo $row['id']; ?>, <?php echo $row['min_qty']; ?>)"
                        class="w-full bg-black text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-yellow-500 hover:text-black transition-all">
                        Add to Inquiry
                    </button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
            <i class="fa-regular fa-heart text-5xl text-gray-200 mb-6 block"></i>
            <h3 class="text-xl font-bold text-gray-400">Your wishlist is empty.</h3>
            <a href="index.php"
                class="inline-block mt-6 text-xs font-black uppercase tracking-widest text-blue-600 hover:underline">Start
                Shopping <i class="fa fa-arrow-right ml-2"></i></a>
        </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <script>
    // Wishlist માંથી દૂર કરવા માટેનું ફંક્શન
    function toggleWishlist(productId, element) {
        const formData = new FormData();
        formData.append('product_id', productId);

        fetch('toggle_wishlist.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'removed') {
                    // પેજ રીફ્રેશ કરો અથવા કાર્ડ દૂર કરો
                    element.closest('.product-card').style.opacity = '0';
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            });
    }
    </script>
</body>

</html>