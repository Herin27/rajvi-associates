<?php
// Maani lo ke tamari pase products table chhe
// SELECT * FROM products WHERE category_id = ...
// Ahiya dummy loop chhe attractive design mate:

for($i=1; $i<=5; $i++) {
?>
<div
    class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
    <div class="relative h-64 bg-gray-50 overflow-hidden">
        <span
            class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10">-33%</span>
        <button
            class="absolute top-4 right-4 w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition z-10 shadow-sm">
            <i class="fa-regular fa-heart"></i>
        </button>

        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=500"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

        <div
            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
            <button
                class="bg-white text-black px-4 py-2 rounded-full text-xs font-bold shadow-xl translate-y-4 group-hover:translate-y-0 transition-transform">Quick
                View</button>
        </div>
    </div>

    <div class="p-5">
        <h4 class="font-bold text-gray-800 mb-1 truncate">Pro Runner Elite Shoes</h4>
        <div class="flex items-center gap-2 mb-3">
            <div class="flex text-yellow-400 text-[10px]">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                    class="fa fa-star"></i><i class="fa fa-star-half"></i>
            </div>
            <span class="text-[10px] text-gray-400 font-bold">4.8 (2,341 reviews)</span>
        </div>

        <div class="flex items-baseline gap-2 mb-5">
            <span class="text-xl font-bold text-black">$129.99</span>
            <span class="text-sm text-gray-400 line-through">$179.99</span>
        </div>

        <button
            class="w-full bg-yellow-500 hover:bg-black text-white py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 group/btn">
            <i class="fa-regular fa-paper-plane group-hover/btn:translate-x-1 transition-transform"></i>
            Add to Inquiry
        </button>
    </div>
</div>
<?php } ?>