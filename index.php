<!-- <?php 
$features_array = explode(',', $row['key_features']); 
foreach($features_array as $feature) {
    echo "<li><i class='fa fa-check text-orange-500'></i> ".trim($feature)."</li>";
}
?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Rajvi Associates - home</title>
</head>
<style>
.load-more-premium {
    background: #000000;
    color: #ffffff;
    padding: 16px 45px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif !important;
    /* */
    font-weight: 800;
    font-size: 14px;
    /* */
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    border: 2px solid #000000;
}

.load-more-premium:hover {
    background: #FFB549;
    /* */
    color: #000000;
    border-color: #FFB549;
    transform: translateY(-4px);
    box-shadow: 0 15px 30px rgba(255, 181, 73, 0.4);
}

/* મોબાઈલ માટે એડજસ્ટમેન્ટ */
@media (max-width: 640px) {
    .load-more-premium {
        width: 100%;
        justify-content: center;
        padding: 14px 20px;
        font-size: 12px;
    }
}
</style>

<body>
    <!-- <h1>Welcome to Rajvi Associates</h1>
    <p>Your trusted partner in business solutions.</p> -->
    <?php
    include 'header.php';
    ?>
    <main class="bg-[#F2F2F2]">



        <?php include('slider.php'); ?>

        <section class="max-w-7xl mx-auto px-6 py-16">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span
                        class="bg-black text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Shop
                        By Sport</span>
                    <h2 class="text-4xl font-serif font-bold text-gray-900 mt-3">All Categories</h2>
                </div>
                <a href="#" class="text-gray-500 hover:text-black font-semibold flex items-center gap-2 transition">
                    View All <i class="fa fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="flex gap-6 overflow-x-auto pb-8 no-scrollbar">
                <?php
    $cat_query = mysqli_query($conn, "SELECT * FROM categories");
    while($cat = mysqli_fetch_assoc($cat_query)) {
    ?>
                <div class="flex flex-col items-center min-w-[120px] group cursor-pointer"
                    onclick="loadProducts(<?php echo $cat['id']; ?>)">
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100 group-hover:border-yellow-500 group-hover:shadow-xl transition-all duration-300">
                        <img src="<?php echo $cat['image_path']; ?>"
                            class="w-12 h-12 object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <span
                        class="mt-4 text-xs font-bold uppercase tracking-tighter text-gray-600 group-hover:text-black">
                        <?php echo $cat['name']; ?>
                    </span>
                </div>
                <?php } ?>
            </div>

            <div id="product-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-10">
                <?php include('fetch_products.php'); ?>
            </div>
            <div class="flex flex-col items-center justify-center mt-12 mb-10 gap-6">
                <div class="flex items-center gap-8">
                    <button onclick="slideProducts('prev')" id="prevBtn"
                        class="nav-btn-circle group disabled:opacity-30" disabled>
                        <i class="fa fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
                    </button>

                    <div id="paginationDots" class="flex gap-2">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>

                    <button onclick="slideProducts('next')" id="nextBtn" class="nav-btn-circle group">
                        <i class="fa fa-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>

                <a href="category.php" class="load-more-premium shadow-lg shadow-black/5">
                    View All Collection
                    <i class="fa fa-arrow-right ml-3 text-xs"></i>
                </a>
            </div>

            <style>
            /* Slider Specific Styles */
            .nav-btn-circle {
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 50%;
                color: #111827;
                transition: all 0.3s ease;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            }

            .nav-btn-circle:hover:not(:disabled) {
                background: #000;
                color: #fff;
                border-color: #000;
            }

            .dot {
                width: 8px;
                height: 8px;
                background: #d1d5db;
                border-radius: 50%;
                transition: all 0.3s ease;
            }

            .dot.active {
                background: #000;
                width: 24px;
                border-radius: 10px;
            }
            </style>
        </section>

        <section class="py-16 bg-[#FFFDF5]">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-gem text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">Premium Quality</h5>
                    <p class="text-xs text-gray-500 mt-2">Handpicked luxury products with guaranteed authenticity</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-user-tie text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">Personal Service</h5>
                    <p class="text-xs text-gray-500 mt-2">Expert consultation and personalized recommendations</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-truck-fast text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">White Glove Service</h5>
                    <p class="text-xs text-gray-500 mt-2">Premium delivery and installation services</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-award text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">Exclusive Access</h5>
                    <p class="text-xs text-gray-500 mt-2">First access to limited editions and new collections</p>
                </div>
            </div>
        </section>

        <section class="py-24 bg-[#0F1621] text-white overflow-hidden relative">
            <div class="max-w-6xl mx-auto px-6 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold">What Our <span class="text-[#FFB549]">Clients</span> Say
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Hear from our satisfied customers about their luxury
                        shopping experience</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-[#1A2332] p-8 rounded-2xl border border-gray-800 shadow-2xl">
                        <div class="flex text-[#FFB549] gap-1 mb-4 text-xs">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i><i class="fa fa-star"></i>
                        </div>
                        <p class="text-gray-300 italic mb-8 text-sm leading-relaxed">"Exceptional quality and service.
                            The personal consultation helped me find exactly what I was looking for."</p>
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?u=1"
                                class="w-12 h-12 rounded-full border-2 border-[#FFB549]">
                            <div>
                                <h6 class="font-bold text-sm">Sarah Johnson</h6>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Fashion
                                    Enthusiast</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#1A2332] p-8 rounded-2xl border border-gray-800 shadow-2xl">
                        <div class="flex text-[#FFB549] gap-1 mb-4 text-xs">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i><i class="fa fa-star"></i>
                        </div>
                        <p class="text-gray-300 italic mb-8 text-sm leading-relaxed">"The home decor collection is
                            outstanding. Every piece is carefully curated and of the highest quality."</p>
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?u=2"
                                class="w-12 h-12 rounded-full border-2 border-[#FFB549]">
                            <div>
                                <h6 class="font-bold text-sm">Michael Chen</h6>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Interior
                                    Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#1A2332] p-8 rounded-2xl border border-gray-800 shadow-2xl">
                        <div class="flex text-[#FFB549] gap-1 mb-4 text-xs">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i><i class="fa fa-star"></i>
                        </div>
                        <p class="text-gray-300 italic mb-8 text-sm leading-relaxed">"I love the exclusive access to
                            limited editions. The WhatsApp service makes inquiries so convenient."</p>
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?u=3"
                                class="w-12 h-12 rounded-full border-2 border-[#FFB549]">
                            <div>
                                <h6 class="font-bold text-sm">Emma Williams</h6>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Luxury
                                    Collector</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-yellow-500">
            <div class="max-w-4xl mx-auto text-center px-6">
                <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Ready to Experience Luxury?</h2>
                <p class="text-gray-800 mb-10 font-medium">Get personalized recommendations from our luxury specialists
                    or visit our showroom</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#"
                        class="bg-white text-black px-8 py-4 rounded-full font-bold shadow-xl hover:bg-gray-100 transition flex items-center gap-2">
                        <i class="fa-regular fa-envelope"></i> Send Inquiry
                    </a>
                    <a href="#"
                        class="bg-transparent border-2 border-black/20 text-black px-8 py-4 rounded-full font-bold hover:bg-black hover:text-white transition flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp Us
                    </a>
                    <a href="#"
                        class="bg-transparent border-2 border-black/20 text-black px-8 py-4 rounded-full font-bold hover:bg-black hover:text-white transition flex items-center gap-2">
                        <i class="fa fa-location-dot"></i> Visit Store
                    </a>
                </div>
            </div>
        </section>

        <section class="py-20 bg-[#FFFDF5]">
            <div
                class="max-w-6xl mx-auto px-6 bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-2xl flex flex-wrap md:flex-nowrap">
                <div class="w-full md:w-1/2 p-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Visit Our Store</h3>
                    <p class="text-gray-500 text-sm mb-6">123 Luxury Avenue, Premium District<br>City Center, State
                        12345</p>
                    <p class="text-gray-400 text-[11px] mb-8 font-bold uppercase tracking-wider">
                        Mon - Sat: 9:00 AM - 9:00 PM<br>
                        Sunday: 11:00 AM - 6:00 PM
                    </p>
                    <a href="#"
                        class="inline-flex items-center gap-2 bg-yellow-500 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md hover:shadow-xl transition">
                        <i class="fa fa-map"></i> Get Directions
                    </a>
                </div>
                <div class="w-full md:w-1/2 h-[400px]">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14686.067984852033!2d72.54044391782226!3d23.041530906236312!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fccd70d1000f1e2!2sAhmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1704285000000!5m2!1sen!2sin"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </section>

        <?php include('footer.php'); ?>

    </main>
    </main>

    <script>
    let currentPage = 1;

    function slideProducts(direction) {
        if (direction === 'next') currentPage++;
        else if (direction === 'prev' && currentPage > 1) currentPage--;
        else return;

        const container = document.getElementById('product-container');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        // ૧. એનિમેશન આઉટ (Fade out)
        container.style.opacity = '0';
        container.style.transform = 'translateX(' + (direction === 'next' ? '-20px' : '20px') + ')';
        container.style.transition = 'all 0.4s ease';

        setTimeout(() => {
            // ૨. AJAX દ્વારા ડેટા ખેંચવો
            fetch(`fetch_products.php?page=${currentPage}`)
                .then(response => response.text())
                .then(data => {
                    if (data.includes('No products found') || data.trim() === "") {
                        currentPage--; // પાછા જૂના પેજ પર
                        alert("તમે છેલ્લી પ્રોડક્ટ પર પહોંચી ગયા છો.");
                    } else {
                        container.innerHTML = data;
                        updatePaginationUI();
                    }

                    // ૩. એનિમેશન ઇન (Fade in)
                    container.style.opacity = '1';
                    container.style.transform = 'translateX(0)';
                });
        }, 400);
    }

    function updatePaginationUI() {
        const prevBtn = document.getElementById('prevBtn');
        prevBtn.disabled = (currentPage === 1);

        // ડોટ્સ અપડેટ લોજિક
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', (index + 1) === currentPage);
        });
    }

    function loadProducts(catId) {
        const container = document.getElementById('product-container');
        container.innerHTML = '<div class="col-span-4 text-center py-10">Loading Products...</div>';

        fetch('get_products_by_cat.php?category_id=' + catId)
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = 'Products could not be loaded.';
            });
    }

    function addToCart(productId) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', 1);

        fetch('add_to_cart_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // ૧. તરત જ કાર્ટની વિગતો ફરીથી ખેંચો
                    fetchCartDetails();
                    // ૨. એલર્ટ બતાવો (Optional: તમે Toast પણ વાપરી શકો)
                    alert('Product added to cart!');
                } else {
                    alert('Error adding to cart');
                }
            })
            .catch(error => console.error('Error:', error));
    }
    </script>




</body>

</html>