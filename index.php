<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Rajvi Associates - home</title>
</head>

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
                    <h2 class="text-4xl font-serif font-bold text-gray-900 mt-3">Sports Categories</h2>
                </div>
                <a href="#" class="text-gray-500 hover:text-black font-semibold flex items-center gap-2 transition">
                    View All Sports <i class="fa fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="flex gap-6 overflow-x-auto pb-8 no-scrollbar">
                <?php
                $cat_query = mysqli_query($conn, "SELECT * FROM categories");
                while($cat = mysqli_fetch_assoc($cat_query)) {
                ?>
                <div class="flex flex-col items-center min-w-[120px] group cursor-pointer">
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100 group-hover:border-yellow-500 group-hover:shadow-xl transition-all duration-300">
                        <img src="<?php echo $cat['image_path']; ?>"
                            class="w-12 h-12 object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <span
                        class="mt-4 text-xs font-bold uppercase tracking-tighter text-gray-600 group-hover:text-black"><?php echo $cat['name']; ?></span>
                </div>
                <?php } ?>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-10">
                <?php for($i=1; $i<=4; $i++) { ?>
                <div
                    class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500">
                    <div class="relative h-72 bg-gray-50 overflow-hidden">
                        <span
                            class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10">-20%</span>
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500"
                            class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
                        <button
                            class="absolute bottom-4 right-4 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all">
                            <i class="fa fa-heart text-gray-400 hover:text-red-500"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Premium Running Shoes</h4>
                        <div class="flex text-yellow-400 text-[10px] mb-3">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i><i class="fa fa-star"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-black">$120.00</span>
                            <button class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-black transition">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>

        <section class="py-16 bg-[#FFFDF5]">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-[#FFB549] rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-gem text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">Premium Quality</h5>
                    <p class="text-xs text-gray-500 mt-2">Handpicked luxury products with guaranteed authenticity</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-[#FFB549] rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-user-tie text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">Personal Service</h5>
                    <p class="text-xs text-gray-500 mt-2">Expert consultation and personalized recommendations</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-[#FFB549] rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa fa-truck-fast text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 uppercase text-sm tracking-widest">White Glove Service</h5>
                    <p class="text-xs text-gray-500 mt-2">Premium delivery and installation services</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div
                        class="w-16 h-16 bg-[#FFB549] rounded-full flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
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

        <section class="py-20 bg-[#FFB549]">
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
                        class="inline-flex items-center gap-2 bg-[#FFB549] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md hover:shadow-xl transition">
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

        <footer class="bg-[#FFFDF5] pt-20 pb-10 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 pb-16">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <img src="./assets/image/logo.png" class="w-10">
                        <span class="text-lg font-bold text-yellow-600 uppercase">Luxury Store</span>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed mb-6">Premium luxury products with personalized
                        service. Experience excellence in every purchase.</p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-[#FFB549] text-white flex items-center justify-center hover:scale-110 transition"><i
                                class="fa-brands fa-facebook-f text-xs"></i></a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-[#FFB549] text-white flex items-center justify-center hover:scale-110 transition"><i
                                class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-[#FFB549] text-white flex items-center justify-center hover:scale-110 transition"><i
                                class="fa-brands fa-whatsapp text-xs"></i></a>
                    </div>
                </div>
                <div>
                    <h5 class="font-bold text-gray-800 text-sm mb-6 uppercase tracking-wider">Quick Links</h5>
                    <ul class="space-y-3 text-xs text-gray-500">
                        <li><a href="#" class="hover:text-yellow-600">Home</a></li>
                        <li><a href="#" class="hover:text-yellow-600">About Us</a></li>
                        <li><a href="#" class="hover:text-yellow-600">Categories</a></li>
                        <li><a href="#" class="hover:text-yellow-600">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-gray-800 text-sm mb-6 uppercase tracking-wider">Categories</h5>
                    <ul class="space-y-3 text-xs text-gray-500">
                        <li><a href="#" class="hover:text-yellow-600">Fashion</a></li>
                        <li><a href="#" class="hover:text-yellow-600">Accessories</a></li>
                        <li><a href="#" class="hover:text-yellow-600">Home Decor</a></li>
                        <li><a href="#" class="hover:text-yellow-600">Electronics</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-gray-800 text-sm mb-6 uppercase tracking-wider">Stay Updated</h5>
                    <p class="text-gray-500 text-xs mb-4">Subscribe to get special offers and updates</p>
                    <div class="bg-white border border-gray-100 rounded-full p-1 flex">
                        <input type="email" placeholder="Enter your email"
                            class="bg-transparent px-4 py-2 text-xs w-full outline-none">
                        <button
                            class="bg-[#FFB549] text-white px-6 py-2 rounded-full font-bold text-xs hover:bg-black transition">Subscribe</button>
                    </div>
                </div>
            </div>
            <div
                class="max-w-7xl mx-auto px-6 pt-8 border-t border-gray-100 flex flex-wrap justify-between items-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                <p>© 2026 Luxury Store. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Powered by Readdy</a>
                </div>
            </div>
        </footer>

    </main>
    </main>






</body>

</html>