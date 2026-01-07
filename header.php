<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Luxury Store</title>
    <style>
    /* Smooth transition for dropdown */
    .mega-menu {
        visibility: hidden;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease-in-out;
    }

    .group:hover .mega-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    /* Sticky effect */
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 50;
    }
    </style>
</head>

<body class="bg-black text-white font-sans">
    <div class="sticky-header">
        <header style="width: 100%; max-width: 1500px;"
            class="flex items-center justify-between px-10 py-4 bg-white/95 backdrop-blur-md text-black max-w-7xl mx-auto rounded-b-2xl shadow-2xl mt-0 border-b border-gray-100">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 transition-transform group-hover:rotate-12">
                    <img src="./assets/image/logo.png" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-extrabold text-yellow-600 leading-none tracking-tight">RAJVI</span>
                    <span class="text-[10px] font-bold text-gray-400 tracking-[3px] uppercase">Associates</span>
                </div>
            </div>

            <nav class="hidden md:flex gap-10 font-semibold items-center">
                <a href="index.php"
                    class="relative hover:text-yellow-600 transition-colors after:content-[''] after:absolute after:w-0 after:h-[2px] after:bg-yellow-600 after:bottom-[-4px] after:left-0 hover:after:w-full after:transition-all">Home</a>

                <div class="group static md:relative">
                    <button class="flex items-center gap-1 hover:text-yellow-600 transition-colors py-4">
                        Categories <i
                            class="fa fa-chevron-down text-[10px] group-hover:rotate-180 transition-transform"></i>
                    </button>

                    <div
                        class="mega-menu absolute left-1/2 -translate-x-1/2 mt-0 w-[550px] bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 p-8 z-[100]">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-sm font-bold text-gray-400 tracking-widest uppercase">Explore Collections
                            </h3>
                            <span class="h-[1px] flex-1 bg-gray-100 ml-4"></span>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <?php
            include('db.php');
            $cat_query = mysqli_query($conn, "SELECT * FROM categories LIMIT 6");
            if(mysqli_num_rows($cat_query) > 0) {
                while($cat = mysqli_fetch_assoc($cat_query)) {
            ?>
                            <a href="<?php echo $cat['link']; ?>"
                                class="group/item flex items-center gap-4 p-2 rounded-xl hover:bg-yellow-50 transition-all">
                                <div
                                    class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200 group-hover/item:border-yellow-300">
                                    <img src="<?php echo $cat['image_path']; ?>"
                                        class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500"
                                        alt="">
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-gray-800 group-hover/item:text-yellow-600 transition-colors">
                                        <?php echo $cat['name']; ?></h4>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">View Collection</p>
                                </div>
                            </a>
                            <?php 
                }
            } else {
                echo "<p class='text-gray-400 text-sm italic col-span-2'>No categories found. Add from Admin.</p>";
            }
            ?>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                            <p class="text-xs text-gray-500 italic">Limited Edition Pieces Available</p>
                            <a href="category.php" class="text-xs font-bold text-yellow-600 hover:underline">See All
                                Categories <i class="fa fa-arrow-right ml-1 text-[8px]"></i></a>
                        </div>
                    </div>
                </div>

                <a href="about.php" class="relative hover:text-yellow-600 transition-colors py-4">About</a>
                <a href="inquiry.php" class="relative hover:text-yellow-600 transition-colors py-4">Inquiry</a>
                <a href="contact.php" class="relative hover:text-yellow-600 transition-colors py-4">Contact</a>
                <a href="track-inquiry.php" class="relative hover:text-yellow-600 transition-colors py-4">Track
                    Inquiry</a>
            </nav>

            <div class="flex items-center gap-6">
                <div class="relative">
                    <input type="text" id="searchInput" onkeyup="searchProducts()"
                        placeholder="Search luxury products..."
                        class="pl-10 pr-4 py-2 border rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <i class="fa fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>





                <div class="relative group/cart flex items-center">
                    <div onclick="window.location.href='cart.php'"
                        class="relative flex items-center gap-3 px-5 py-2.5 bg-gray-50 rounded-full border border-gray-100 hover:border-yellow-500 hover:bg-yellow-50 transition-all duration-300 cursor-pointer shadow-sm active:scale-95">

                        <div class="relative">
                            <i
                                class="fa-solid fa-basket-shopping text-gray-800 text-xl group-hover/cart:text-yellow-600 transition-colors"></i>
                            <span id="cart-count-badge"
                                class="absolute -top-2 -right-2 bg-black text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center border-2 border-white shadow-md">
                                <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : '0'; ?>
                            </span>
                        </div>

                        <div class="hidden lg:flex flex-col items-start leading-none">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-[2px]">My Inquiry</span>
                            <span id="cart-subtotal-nav"
                                class="text-sm font-black text-gray-800 tracking-tight">₹0.00</span>
                        </div>
                    </div>

                    <div
                        class="absolute right-0 top-full mt-4 w-[450px] bg-white rounded-[2rem] shadow-[0_35px_120px_rgba(0,0,0,0.2)] border border-gray-50 p-8 z-[150] invisible opacity-0 group-hover/cart:visible group-hover/cart:opacity-100 transition-all duration-500 transform origin-top-right group-hover/cart:translate-y-0 translate-y-6">

                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                            <div>
                                <h3 class="text-lg font-black text-black uppercase tracking-tighter">Inquiry Basket</h3>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Review your
                                    selected items</p>
                            </div>
                            <span
                                class="text-[11px] font-bold bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full uppercase">Wholesale
                                List</span>
                        </div>

                        <div id="cart-items-container"
                            class="max-h-[380px] overflow-y-auto mb-8 pr-4 custom-scrollbar space-y-5">
                            <div class="flex flex-col items-center justify-center py-12 opacity-30">
                                <i class="fa-solid fa-spinner fa-spin text-3xl mb-4"></i>
                                <p class="text-xs font-bold tracking-widest uppercase">Fetching Details...</p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <!-- <div
                                class="flex justify-between items-center p-5 bg-gray-50 rounded-2xl border border-gray-100">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-[2px]">Total Est.
                                    Value</span>
                                <span id="cart-subtotal"
                                    class="text-2xl font-black text-black tracking-tighter">₹0.00</span>
                            </div> -->

                            <div class="width-full flex flex-col gap-3">
                                <!-- <a href="cart.php"
                                    class="w-full text-center py-4 text-[11px] font-black uppercase tracking-widest bg-black text-white rounded-2xl hover:bg-yellow-600 transition-all duration-300 shadow-xl shadow-black/10 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-layer-group"></i> Full List
                                </a> -->
                                <a href="inquiry.php"
                                    class="w-full text-center py-4 text-[11px] font-black uppercase tracking-widest border-2 border-gray-900 text-black rounded-2xl hover:bg-black hover:text-white transition-all duration-300">
                                    Send Inquiry
                                </a>
                            </div>
                            <p class="text-[9px] text-gray-400 text-center uppercase font-medium tracking-widest">Prices
                                are subject to wholesale quantities</p>
                        </div>
                    </div>
                </div>


                <div id="search-overlay"
                    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[200] hidden flex-col items-center pt-10 px-4 transition-all duration-300">

                    <div
                        class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden animate__animated animate__fadeInDown">

                        <div class="flex items-center p-4 border-b">
                            <i class="fa fa-search text-gray-400"></i>
                            <input type="text" id="search-input" onkeyup="liveSearch(this.value)"
                                placeholder="Search products or categories..." class="...">
                            <button onclick="toggleSearch()"><i class="fa fa-times text-gray-500"></i></button>
                        </div>

                        <div class="p-6 max-h-[70vh] overflow-y-auto">
                            <div id="live-results" class="hidden mb-6 pb-6 border-b border-gray-100"></div>

                            <div id="default-suggestions">
                            </div>
                        </div>

                        <div class="p-6 max-h-[70vh] overflow-y-auto">

                            <div class="mb-8">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Recent
                                        Searches</h3>
                                    <button class="text-xs text-blue-500 hover:underline">Edit</button>
                                </div>
                                <div class="flex gap-4">
                                    <div class="text-center group cursor-pointer">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center border border-gray-200 group-hover:border-yellow-500 transition">
                                            <img src="uploads/recent-watch.png" class="w-10 object-contain" alt="">
                                        </div>
                                        <p class="text-[10px] mt-2 text-gray-600">Rolex S1</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Trending
                                    Searches</h3>
                                <div class="flex flex-wrap gap-2">
                                    <a href="#"
                                        class="px-4 py-1.5 border border-gray-200 rounded-md text-sm text-gray-700 hover:border-yellow-600 hover:bg-yellow-50 transition">Premium
                                        Watches</a>
                                    <a href="#"
                                        class="px-4 py-1.5 border border-gray-200 rounded-md text-sm text-gray-700 hover:border-yellow-600 hover:bg-yellow-50 transition">Leather
                                        Straps</a>
                                    <a href="#"
                                        class="px-4 py-1.5 border border-gray-200 rounded-md text-sm text-gray-700 hover:border-yellow-600 hover:bg-yellow-50 transition">Chronograph</a>
                                    <a href="#"
                                        class="px-4 py-1.5 border border-gray-200 rounded-md text-sm text-gray-700 hover:border-yellow-600 hover:bg-yellow-50 transition">Gift
                                        Sets</a>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Most Popular
                                </h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <div
                                        class="bg-gray-50 rounded-xl p-3 hover:shadow-md transition cursor-pointer border border-transparent hover:border-yellow-200">
                                        <img src="uploads/popular-1.jpg"
                                            class="w-full h-24 object-cover rounded-lg mb-2" alt="">
                                        <p class="text-xs font-bold text-black text-center">Executive Gold</p>
                                    </div>
                                    <div
                                        class="bg-gray-50 rounded-xl p-3 hover:shadow-md transition cursor-pointer border border-transparent hover:border-yellow-200">
                                        <img src="uploads/popular-2.jpg"
                                            class="w-full h-24 object-cover rounded-lg mb-2" alt="">
                                        <p class="text-xs font-bold text-black text-center">Black Stealth</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <script>
    // Esc key dabavva thi search band thay
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            const overlay = document.getElementById('search-overlay');
            if (!overlay.classList.contains('hidden')) {
                toggleSearch();
            }
        }
    });
    </script>

    <script>
    function searchProducts() {
        const query = document.getElementById('searchInput').value;
        const container = document.getElementById('product-container');

        // જો સર્ચ બોક્સ ખાલી હોય તો બધી પ્રોડક્ટ્સ બતાવો
        if (query.length < 1) {
            // તમે ઈચ્છો તો અહીં default loadProducts(0) કોલ કરી શકો
        }

        fetch('get_products_by_cat.php?search=' + encodeURIComponent(query))
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }

    // કાર્ટની પ્રોડક્ટ્સ લાઈવ મેળવવા માટે
    function fetchCartDetails() {
        const container = document.getElementById('cart-items-container');
        const totalDisplay = document.getElementById('cart-subtotal');
        const countBadge = document.getElementById('cart-count-badge');

        fetch('fetch_cart_dropdown.php', {
                cache: 'no-cache'
            })
            .then(response => response.text()) // પહેલા text તરીકે લો જેથી ભૂલ પકડાય
            .then(text => {
                try {
                    const data = JSON.parse(text); // હવે તેને JSON માં ફેરવો
                    container.innerHTML = data.html;
                    if (totalDisplay) totalDisplay.innerText = "₹" + data.total;
                    if (countBadge) countBadge.innerText = data.count;
                } catch (err) {
                    console.error("Server sent invalid JSON:", text);
                    container.innerHTML = '<p class="text-[10px] text-red-500 text-center">Server Data Error</p>';
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    // હોવર ઇવેન્ટ લિસ્ટનર
    document.addEventListener('DOMContentLoaded', () => {
        const cartIcon = document.querySelector('.group\\/cart');
        if (cartIcon) {
            cartIcon.addEventListener('mouseenter', fetchCartDetails);
        }
    });

    // કાર્ટ કાઉન્ટ અપડેટ કરવા માટે (તમારા જૂના કોડમાં સુધારો)
    function updateCartCount(count) {
        const cartBadge = document.getElementById('cart-count-badge');
        if (cartBadge) {
            cartBadge.innerText = count;
        }
    }

    // જ્યારે યુઝર કાર્ટ આઈકન પર હોવર કરે ત્યારે ડેટા લોડ કરો
    document.querySelector('.group\\/cart').addEventListener('mouseenter', fetchCartDetails);

    // Search Toggle function ma thodo badlav
    function toggleSearch() {
        const overlay = document.getElementById('search-overlay');
        const input = document.getElementById('search-input');
        const resultsDiv = document.getElementById('live-results');
        const defaultDiv = document.getElementById('default-suggestions');

        if (overlay.classList.contains('hidden')) {
            overlay.classList.remove('hidden', 'animate__fadeOutUp');
            overlay.classList.add('flex', 'animate__fadeInDown');
            setTimeout(() => {
                input.focus();
            }, 200);
            document.body.style.overflow = 'hidden';
        } else {
            overlay.classList.add('hidden');
            input.value = ''; // Reset input
            resultsDiv.classList.add('hidden');
            defaultDiv.classList.remove('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function addToInquiry(productId) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', 1); // બલ્ક માટે ડિફોલ્ટ ૧, યુઝર લિસ્ટ પેજ પર બદલી શકશે

        fetch('add_to_cart_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.new_count);
                    if (typeof fetchCartDetails === "function") fetchCartDetails(); // ડ્રોપડાઉન અપડેટ કરવા
                    alert('Item added to your inquiry list!');
                }
            })
            .catch(error => console.error('Error:', error));
    }
    // ... existing fetch logic ...
    const totalNav = document.getElementById('cart-subtotal-nav'); // નવો વેરિએબલ
    // Inside your then(data => { ... })
    if (totalNav) totalNav.innerText = "₹" + data.total;
    </script>