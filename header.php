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
        <header
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
                <a href="#"
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
                            <a href="#" class="text-xs font-bold text-yellow-600 hover:underline">See All Categories <i
                                    class="fa fa-arrow-right ml-1 text-[8px]"></i></a>
                        </div>
                    </div>
                </div>

                <a href="#" class="relative hover:text-yellow-600 transition-colors py-4">About</a>
                <a href="#" class="relative hover:text-yellow-600 transition-colors py-4">Inquiry</a>
                <a href="#" class="relative hover:text-yellow-600 transition-colors py-4">Contact</a>
            </nav>

            <div class="flex items-center gap-6">
                <div class="p-2 hover:bg-gray-100 rounded-full cursor-pointer transition-colors"
                    onclick="toggleSearch()">
                    <i class="fa fa-search text-gray-700"></i>
                </div>
                <div class="relative p-2 hover:bg-gray-100 rounded-full cursor-pointer transition-colors">
                    <i class="fa fa-shopping-bag text-gray-700"></i>
                    <span
                        class="absolute top-0 right-0 bg-yellow-600 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center border-2 border-white">0</span>
                </div>
                <div class="p-2 hover:bg-gray-100 rounded-full cursor-pointer transition-colors">
                    <i class="fa fa-moon text-gray-700"></i>
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
    function liveSearch(query) {
        let resultsDiv = document.getElementById('live-results');
        let defaultDiv = document.getElementById('default-suggestions');

        if (query.length > 1) {
            // AJAX Request
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "search_api.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                if (this.status == 200) {
                    resultsDiv.innerHTML = this.responseText;
                    resultsDiv.classList.remove('hidden');
                    defaultDiv.classList.add('hidden'); // Type karo tyare trendy suggestions chhupavi do
                }
            };
            xhr.send("query=" + query);
        } else {
            resultsDiv.classList.add('hidden');
            defaultDiv.classList.remove('hidden'); // Khali hoy tyare default batavo
        }
    }

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
    </script>