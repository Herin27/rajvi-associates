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
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span
                        class="bg-black text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em]">Curated
                        Collections</span>
                    <h2 class="text-4xl font-black italic tracking-tighter text-gray-900 mt-4 uppercase">All Categories
                    </h2>
                </div>
                <a href="category.php"
                    class="text-gray-400 hover:text-black font-bold text-xs uppercase tracking-widest flex items-center gap-2 transition-all group">
                    View All <i
                        class="fa fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="flex gap-10 overflow-x-auto pb-10 no-scrollbar justify-start md:justify-center">
                <?php
        $cat_query = mysqli_query($conn, "SELECT * FROM categories");
        while($cat = mysqli_fetch_assoc($cat_query)) {
        ?>
                <div class="flex flex-col items-center min-w-[110px] group cursor-pointer"
                    onclick="loadProducts(<?php echo $cat['id']; ?>)">

                    <div
                        class="relative w-24 h-24 mb-4 rounded-full p-1 border-2 border-transparent group-hover:border-yellow-500 transition-all duration-500">
                        <div
                            class="w-full h-full rounded-full overflow-hidden shadow-md group-hover:shadow-2xl group-hover:scale-105 transition-all duration-500 bg-gray-100">
                            <img src="<?php echo $cat['image_path']; ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="<?php echo $cat['name']; ?>">
                        </div>

                        <!-- <div
                            class="absolute -top-1 -right-1 bg-black text-white w-6 h-6 rounded-full flex items-center justify-center scale-0 group-hover:scale-100 transition-transform duration-300 shadow-lg">
                             <i class="fa fa-plus text-[8px]"></i> 
                        </div> -->
                    </div>

                    <span
                        class="text-[11px] font-black uppercase tracking-widest text-gray-500 group-hover:text-black transition-colors duration-300">
                        <?php echo $cat['name']; ?>
                    </span>
                </div>
                <?php } ?>
            </div>
            <section class="max-w-7xl mx-auto px-6 py-16">
                <div class="relative px-0 lg:px-4">
                    <button onclick="slideProducts('prev')" id="prevBtn"
                        class="absolute -left-4 lg:-left-16 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white text-black shadow-xl rounded-full flex items-center justify-center border border-gray-100 hover:bg-black hover:text-white transition-all disabled:opacity-0">
                        <i class="fa fa-chevron-left text-[10px]"></i>
                    </button>

                    <div id="product-container"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 transition-all duration-500">
                        <?php include('fetch_products.php'); ?>
                    </div>

                    <button onclick="slideProducts('next')" id="nextBtn"
                        class="absolute -right-4 lg:-right-16 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white text-black shadow-xl rounded-full flex items-center justify-center border border-gray-100 hover:bg-black hover:text-white transition-all">
                        <i class="fa fa-chevron-right text-[10px]"></i>
                    </button>
                </div>

                <div class="flex flex-col items-center gap-8 mt-12">

                    <a href="category.php" class="view-all-premium group">
                        Explore Full Collection
                        <span
                            class="bg-black text-white w-6 h-6 rounded-full flex items-center justify-center ml-3 group-hover:bg-yellow-500 group-hover:text-black transition-colors">
                            <i class="fa fa-arrow-right text-[8px]"></i>
                        </span>
                    </a>
                </div>
            </section>

            <style>
            /* Clean Minimal Dots */
            .dot {
                width: 6px;
                height: 6px;
                background: #d1d5db;
                border-radius: 50%;
                transition: all 0.3s ease;
            }

            .dot.active {
                background: #000;
                width: 20px;
                border-radius: 10px;
            }

            /* Premium View All Button Styling */
            .view-all-premium {
                display: inline-flex;
                align-items: center;
                background: #ffffff;
                color: #111827;
                /* */
                padding: 12px 28px;
                border-radius: 100px;
                font-family: 'Inter', sans-serif !important;
                /* */
                font-size: 13px;
                /* */
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 1px;
                border: 1px solid #e5e7eb;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
            }

            .view-all-premium:hover {
                border-color: #000;
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Mobile compatibility for buttons */
            @media (max-width: 1024px) {
                .absolute {
                    display: none;
                }
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
    const maxPages = 3; // ૧૨ પ્રોડક્ટ્સ માટે ૩ પેજ (૪ પ્રતિ પેજ)

    function slideProducts(direction) {
        let nextBtn = document.getElementById('nextBtn');
        let prevBtn = document.getElementById('prevBtn');

        // પેજ લિમિટ ચેક
        if (direction === 'next') {
            if (currentPage < maxPages) {
                currentPage++;
            } else {
                return;
            }
        } else if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else {
            return;
        }

        const container = document.getElementById('product-container');

        // ૧. એનિમેશન આઉટ
        container.style.opacity = '0';
        container.style.transform = 'translateY(10px)';
        container.style.transition = 'all 0.4s ease';

        // ૨. AJAX દ્વારા નવી પ્રોડક્ટ્સ મેળવવી
        fetch(`fetch_products.php?page=${currentPage}`)
            .then(response => response.text())
            .then(data => {
                setTimeout(() => {
                    if (data.trim() === "") {
                        // જો ડેટા ખાલી હોય (૧૨ પૂરી થઈ ગઈ હોય)
                        currentPage--;
                        updatePaginationUI();
                    } else {
                        container.innerHTML = data;
                        // ૩. એનિમેશન ઇન
                        container.style.opacity = '1';
                        container.style.transform = 'translateY(0)';
                        updatePaginationUI();
                    }
                }, 300);
            })
            .catch(error => console.error('Error:', error));
    }

    function updatePaginationUI() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // Previous બટન ડિસેબલ લોજિક
        prevBtn.disabled = (currentPage === 1);
        prevBtn.style.opacity = (currentPage === 1) ? '0' : '1'; // પહેલા પેજ પર Prev છુપાઈ જશે

        // Next બટન ડિસેબલ લોજિક
        if (currentPage >= maxPages) {
            nextBtn.disabled = true;
            nextBtn.classList.add('opacity-30', 'cursor-not-allowed');
        } else {
            nextBtn.disabled = false;
            nextBtn.classList.remove('opacity-30', 'cursor-not-allowed');
        }

        // ડોટ્સ અપડેટ લોજિક
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', (index + 1) === currentPage);
        });
    }

    // કેટેગરી મુજબ લોડ કરવા માટેનું ફંક્શન
    function loadProducts(catId) {
        const container = document.getElementById('product-container');
        container.innerHTML = '<div class="col-span-4 text-center py-10 opacity-50">Loading Products...</div>';

        fetch('get_products_by_cat.php?category_id=' + catId)
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }

    // કાર્ટ ફંક્શનલિટી
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
                    if (typeof fetchCartDetails === "function") fetchCartDetails();
                    alert('Product added to cart!');
                } else {
                    alert('Error adding to cart');
                }
            });
    }

    // પેજ લોડ વખતે બટન સ્ટેટ ચેક કરો
    window.onload = updatePaginationUI;

    function toggleWishlist(productId, element) {
        const icon = element.querySelector('i');
        const badge = document.getElementById('wishlist-count-badge');

        // ૧. તરત જ (Instant) આઈકોનનો કલર બદલી નાખો
        const isAdding = icon.classList.contains('fa-regular');

        if (isAdding) {
            // હાર્ટ લાલ કરો
            icon.classList.replace('fa-regular', 'fa-solid');
            icon.classList.add('text-red-500');
            icon.classList.replace('text-gray-400', 'text-red-500');
            // હળવું એનિમેશન આપો
            element.classList.add('scale-125');
        } else {
            // હાર્ટ નોર્મલ કરો
            icon.classList.replace('fa-solid', 'fa-regular');
            icon.classList.remove('text-red-500');
            icon.classList.add('text-gray-400');
            element.classList.add('scale-90');
        }

        // ૨. બેકએન્ડમાં ડેટા સેવ કરવા માટે મોકલો
        const formData = new FormData();
        formData.append('product_id', productId);

        fetch('toggle_wishlist.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // ૩. સર્વર પરથી નવો કાઉન્ટ અપડેટ કરો
                if (badge && data.count !== undefined) {
                    badge.innerText = data.count;
                    badge.classList.add('scale-150');
                    setTimeout(() => {
                        badge.classList.remove('scale-150');
                        element.classList.remove('scale-125', 'scale-90');
                    }, 200);
                }
            });
    }
    </script>




</body>

</html>