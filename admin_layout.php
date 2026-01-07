<div class="flex min-h-screen bg-gray-50">
    <aside class="w-64 bg-black text-white flex-shrink-0 hidden md:flex flex-col sticky top-0 h-screen">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-xl font-black italic tracking-tighter uppercase text-yellow-500">Rajvi Admin</h1>
            <p class="text-[10px] text-gray-500 font-bold tracking-widest mt-1 uppercase">Control Panel</p>
        </div>

        <nav class="flex-1 p-4 space-y-2 mt-4">
            <a href="admin_dashboard.php"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-900 transition group">
                <i class="fa fa-chart-line text-gray-500 group-hover:text-yellow-500"></i>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>

            <div class="pt-4 pb-2">
                <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest px-3">Inventory</span>
            </div>

            <a href="admin_add_product.php"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-900 transition group">
                <i class="fa fa-plus-circle text-gray-500 group-hover:text-yellow-500"></i>
                <span class="font-semibold text-sm">Add New Product</span>
            </a>

            <a href="admin_manage_products.php"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-900 transition group bg-gray-900 text-yellow-500">
                <i class="fa fa-boxes-stacked"></i>
                <span class="font-semibold text-sm">Manage Products</span>
            </a>

            <div class="pt-4 pb-2">
                <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest px-3">Customers</span>
            </div>

            <a href="admin_inquiries.php"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-900 transition group">
                <i class="fa fa-envelope-open-text text-gray-500 group-hover:text-yellow-500"></i>
                <span class="font-semibold text-sm">Inquiry List</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <a href="logout.php"
                class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-950/30 rounded-xl transition">
                <i class="fa fa-right-from-bracket"></i>
                <span class="font-bold text-xs uppercase">Logout</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 h-screen overflow-y-auto">
    </div>
</div>