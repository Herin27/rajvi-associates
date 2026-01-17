<?php
include 'db.php';

// URL માંથી પ્રોડક્ટ ID લેવી
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($query);
// ૧. સાઇટ સેટિંગ્સ મેળવો (On/Off Control માટે)
$settings_query = mysqli_query($conn, "SELECT * FROM site_settings");
$ui = [];
while($s = mysqli_fetch_assoc($settings_query)) {
    $ui[$s['feature_key']] = $s['is_enabled'];
}

if (!$product) {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Rajvi Associates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>


<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <nav class="text-sm text-gray-500 mb-8">
            Home > Category > <?php echo $product['product_name']; ?>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-3xl shadow-sm items-start">
            <div class="sticky top-24">
                <div
                    class="relative group bg-white rounded-[2.5rem] overflow-hidden mb-8 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center justify-center h-[550px] transition-all duration-500 hover:shadow-[0_30px_60px_rgba(0,0,0,0.1)]">

                    <div
                        class="absolute -top-24 -left-24 w-64 h-64 bg-yellow-100/30 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div
                        class="absolute -bottom-24 -right-24 w-64 h-64 bg-blue-100/30 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>

                    <img src="uploads/<?php echo $product['image']; ?>"
                        class="max-w-[85%] max-h-[85%] object-contain transition-all duration-700 ease-out group-hover:scale-110 drop-shadow-2xl"
                        id="mainImage" alt="<?php echo $product['product_name']; ?>">

                    <div class="absolute top-6 left-6">
                        <span
                            class="bg-black/5 backdrop-blur-md border border-white/20 text-black text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest shadow-sm">
                            Premium Quality
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-5 px-2">
                    <div class="aspect-square border-2 border-yellow-500 rounded-2xl p-2 cursor-pointer bg-white shadow-md transition-all hover:-translate-y-1 overflow-hidden"
                        onclick="changeImage('uploads/<?php echo $product['image']; ?>', this)">
                        <img src="uploads/<?php echo $product['image']; ?>"
                            class="w-full h-full object-contain rounded-lg">
                    </div>

                    <?php 
                if(!empty($product['additional_images'])) {
    // અલ્પવિરામથી ઇમેજ અલગ કરો
    $extras = explode(',', $product['additional_images']);
    foreach($extras as $img) {
        $img_name = trim($img); // વધારાની સ્પેસ દૂર કરો
        if(!empty($img_name)) { // જો નામ ખાલી ન હોય તો જ બતાવો
            echo '<div class="aspect-square border-2 border-transparent hover:border-yellow-500 rounded-2xl p-2 cursor-pointer bg-white shadow-sm transition-all hover:-translate-y-1 overflow-hidden" onclick="changeImage(\'uploads/'.$img_name.'\', this)">
                    <img src="uploads/'.$img_name.'" class="w-full h-full object-contain rounded-lg" onerror="this.parentElement.style.display=\'none\'">
                </div>';
        }
    }
}
                ?>
                </div>
            </div>

            <div>
                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded uppercase">
                    <?php echo $product['stock_status']; ?>
                </span>
                <span class="text-gray-400 text-xs ml-3">SKU: <?php echo $product['sku']; ?></span>

                <h1 class="text-4xl font-serif font-bold text-gray-900 mt-4"><?php echo $product['product_name']; ?>
                </h1>

                <?php if($ui['show_rating']): // Rating Toggle Check ?>
                <div class="flex items-center gap-3 mt-2">
                    <div class="flex text-yellow-400 text-sm">
                        <?php 
        $current_rating = (float)$product['rating']; // ડેટાબેઝમાંથી રેટિંગ લેવું
        for($i = 1; $i <= 5; $i++) {
            if($i <= $current_rating) {
                echo '<i class="fa-solid fa-star"></i>'; // આખો ભરેલો સ્ટાર
            } elseif($i - 0.5 <= $current_rating) {
                echo '<i class="fa-solid fa-star-half-stroke"></i>'; // અડધો સ્ટાર
            } else {
                echo '<i class="fa-regular fa-star text-gray-300"></i>'; // ખાલી સ્ટાર
            }
        }
        ?>
                    </div>
                    <span class="text-gray-500 text-xs font-bold"><?php echo number_format($product['rating'], 1); ?>
                        Rating</span>
                </div>
                <?php endif; ?>

                <?php if($ui['show_price']): // જો પ્રાઈસ ઓન હોય તો જ બતાવો ?>
                <div class="flex items-baseline gap-4 mt-6">
                    <span
                        class="text-4xl font-bold text-yellow-600">₹<?php echo number_format($product['discounted_price']); ?></span>
                    <span
                        class="text-xl text-gray-400 line-through">₹<?php echo number_format($product['original_price']); ?></span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">Save
                        <?php echo $product['discount_percent']; ?>%</span>
                </div>
                <?php endif; ?>

                <p class="text-gray-500 mt-6 leading-relaxed"><?php echo $product['short_description']; ?></p>

                <div class="mt-8">
                    <span class="text-gray-400 text-sm">Available: <?php echo $product['available_units']; ?>+
                        units</span>

                    <form action="add_to_inquiry.php" method="POST" class="mt-8">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <div class="flex items-center gap-4 mb-6">
                            <label class="font-bold text-gray-700">Quantity:</label>
                            <input type="number" name="qty" value="<?php echo $product['min_qty']; ?>"
                                min="<?php echo $product['min_qty']; ?>"
                                class="border-2 border-gray-100 p-2 w-24 rounded-xl focus:ring-2 focus:ring-yellow-500 outline-none font-bold">
                            <span class="text-red-500 text-xs font-bold uppercase tracking-tight">Min order:
                                <?php echo $product['min_qty']; ?> units</span>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mb-8">
                            <button type="submit" name="add_to_list"
                                class="flex-[2] bg-black text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-yellow-600 transition-all shadow-xl shadow-black/10 flex items-center justify-center gap-2">
                                <i class="fa fa-list-check"></i> Add to Inquiry List
                            </button>

                            <?php if(!empty($product['brochure_pdf'])): ?>
                            <button type="button" onclick="toggleBrochureModal()"
                                class="flex-1 flex items-center justify-center bg-red-50 text-red-700 px-6 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-red-100 transition-all border border-red-100 group shadow-lg">
                                <i class="fas fa-file-pdf mr-2 text-red-600"></i>
                                Brochure
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>
                    <div id="brochureModal"
                        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                        <div
                            class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                            <div
                                class="bg-gradient-to-r from-red-600 to-red-800 p-6 text-white flex justify-between items-center">
                                <h3 class="text-sm font-black uppercase tracking-widest">Get Brochure</h3>
                                <button type="button" onclick="toggleBrochureModal()"
                                    class="text-white/80 hover:text-white transition-colors">
                                    <i class="fa fa-times text-xl"></i>
                                </button>
                            </div>

                            <form id="brochureForm" class="p-8 space-y-5 text-left">
                                <input type="hidden" name="brochure_file"
                                    value="<?php echo $product['brochure_pdf']; ?>">
                                <input type="hidden" name="product_name"
                                    value="<?php echo $product['product_name']; ?>">

                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase text-gray-400 mb-2">Name</label>
                                    <input type="text" name="u_name" required minlength="3"
                                        class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-red-500 outline-none transition"
                                        placeholder="Your Full Name">
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase text-gray-400 mb-2">Email</label>
                                    <input type="email" name="u_email" required
                                        class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-red-500 outline-none transition"
                                        placeholder="yourname@email.com">
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase text-gray-400 mb-2">Phone</label>
                                    <input type="tel" name="u_phone" required pattern="[0-9]{10}" maxlength="10"
                                        class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-red-500 outline-none transition"
                                        placeholder="10 Digit Mobile Number">
                                    <p class="text-[8px] text-gray-400 mt-1 italic">*Enter 10 digit number without +91
                                    </p>
                                </div>

                                <button type="submit" id="submitBrochureBtn"
                                    class="w-full bg-red-600 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-red-700 transition-all uppercase tracking-widest text-xs">
                                    Download Now
                                </button>
                            </form>
                        </div>
                    </div>

                    <style>
                    /* સાધારણ બાઉન્સ એનિમેશન જ્યારે યુઝર હોવર કરે */
                    @keyframes bounce-subtle {

                        0%,
                        100% {
                            transform: translateY(0);
                        }

                        50% {
                            transform: translateY(-3px);
                        }
                    }

                    .group:hover .fa-file-pdf {
                        animation: bounce-subtle 0.8s infinite;
                    }
                    </style>


                </div>

                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] mb-8">Technical Details</h3>
                    <div class="space-y-0 border-t border-gray-200">
                        <div class="grid grid-cols-2 py-4 border-b border-gray-200">
                            <span class="text-xs font-bold text-gray-500 uppercase">Brand</span>
                            <span class="text-sm font-black text-gray-900"><?php echo $product['brand']; ?></span>
                        </div>
                        <div class="grid grid-cols-2 py-4 border-b border-gray-200">
                            <span class="text-xs font-bold text-gray-500 uppercase">Model Number (SKU)</span>
                            <span class="text-sm font-mono text-gray-900"><?php echo $product['sku']; ?></span>
                        </div>
                        <?php if(!empty($product['category_details'])): 
                            $details = json_decode($product['category_details'], true);
                            if(is_array($details)):
                                foreach($details as $key => $value): ?>
                        <div
                            class="grid grid-cols-2 py-4 border-b border-gray-200 group hover:bg-white transition-colors px-2 rounded-lg">
                            <span
                                class="text-xs font-bold text-gray-500 uppercase"><?php echo str_replace('_', ' ', $key); ?></span>
                            <span class="text-sm font-black text-black italic"><?php echo $value; ?></span>
                        </div>
                        <?php endforeach; endif; endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-20">
            <h2 class="text-2xl font-bold mb-8">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php
                $cat_id = $product['category_id'];
                $current_id = $product['id'];
                $related = mysqli_query($conn, "SELECT * FROM products WHERE category_id = '$cat_id' AND id != '$current_id' LIMIT 4");
                while($r = mysqli_fetch_assoc($related)) {
                ?>
                <a href="product-details.php?id=<?php echo $r['id']; ?>" class="group">
                    <div
                        class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-3 flex items-center justify-center">
                        <img src="uploads/<?php echo $r['image']; ?>"
                            class="max-w-full max-h-full object-contain transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <h3 class="font-bold text-gray-800"><?php echo $r['product_name']; ?></h3>
                    <!-- <p class="text-yellow-600 font-bold">₹<?php echo number_format($r['discounted_price']); ?></p> -->

                    <?php if($ui['show_price']): ?>
                    <p class="text-yellow-600 font-bold">₹<?php echo number_format($r['discounted_price']); ?></p>
                    <?php endif; ?>
                </a>
                <?php } ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script>
    function changeImage(src, element) {
        const mainImg = document.getElementById('mainImage');

        // Smooth transition effect
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';

            // Active border update
            document.querySelectorAll('.thumb-node').forEach(el => {
                el.classList.remove('border-yellow-500');
                el.classList.add('border-transparent');
            });
            element.classList.remove('border-transparent');
            element.classList.add('border-yellow-500');
        }, 200);
    }

    // મોડલ ખોલવા/બંધ કરવા માટે
    function toggleBrochureModal() {
        const modal = document.getElementById('brochureModal');
        if (modal) {
            modal.classList.toggle('hidden');
        }
    }

    // ફોર્મ સબમિટ અને ફાઈલ ડાઉનલોડ લોજિક
    document.getElementById('brochureForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // ૧. બેઝિક વેલિડેશન ચેક
        const name = this.u_name.value.trim();
        const phone = this.u_phone.value.trim();

        if (name.length < 3) {
            alert("Please enter a valid full name.");
            return;
        }

        if (phone.length !== 10 || isNaN(phone)) {
            alert("Please enter a valid 10-digit phone number.");
            return;
        }

        // ૨. સબમિટ પ્રોસેસ શરૂ કરો
        const btn = document.getElementById('submitBrochureBtn');
        const originalText = btn.innerText;
        btn.innerText = "Processing...";
        btn.disabled = true;

        const formData = new FormData(this);

        fetch('./process_brochure_request.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // ફાઈલ ડાઉનલોડ લોજિક
                    const fileName = formData.get('brochure_file');
                    const downloadLink = document.createElement('a');
                    downloadLink.href = 'uploads/pdf/' + fileName;
                    downloadLink.download = fileName;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);

                    // alert('Thank you! Your brochure download has started.');

                    toggleBrochureModal();
                    this.reset();
                } else {
                    alert('Server Error: ' + (data.error || 'Request failed'));
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                alert('Could not connect to server. Please try again.');
            })
            .finally(() => {
                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
    </script>
</body>

</html>