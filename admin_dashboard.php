<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rajvi-associates";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Total Counts mate Queries
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_categories = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$total_inquiries = $conn->query("SELECT COUNT(*) as count FROM inquiries")->fetch_assoc()['count'];
$new_today = $conn->query("SELECT COUNT(*) as count FROM inquiries WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];
$resolved_inquiries = $conn->query("SELECT COUNT(*) as count FROM inquiries WHERE status = 'Completed'")->fetch_assoc()['count'];

// 2. Inquiry Status Overview (Chart mate)
$status_new = $conn->query("SELECT COUNT(*) as count FROM inquiries WHERE status = 'New'")->fetch_assoc()['count'];
$status_progress = $conn->query("SELECT COUNT(*) as count FROM inquiries WHERE status = 'Contacted'")->fetch_assoc()['count'];
$status_completed = $conn->query("SELECT COUNT(*) as count FROM inquiries WHERE status = 'Completed'")->fetch_assoc()['count'];

// 3. Most Inquired Products (Join query with inquiry_items)
$most_inquired_query = "
    SELECT p.product_name, c.name as category_name, COUNT(ii.id) as inquiry_count 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    JOIN inquiry_items ii ON p.id = ii.product_id 
    GROUP BY p.id 
    ORDER BY inquiry_count DESC LIMIT 5";
$most_inquired_res = $conn->query($most_inquired_query);

// 4. Recent Inquiries (Join inquiries, inquiry_items and products)
// 4. Recent Inquiries (GROUP BY વાપરીને એક જ વાર બતાવવા માટે)
$recent_inquiries_query = "
    SELECT 
        i.*, 
        GROUP_CONCAT(p.product_name SEPARATOR ', ') as product_names, 
        SUM(ii.quantity) as total_quantity 
    FROM inquiries i
    LEFT JOIN inquiry_items ii ON i.id = ii.inquiry_id
    LEFT JOIN products p ON ii.product_id = p.id
    GROUP BY i.id
    ORDER BY i.created_at DESC 
    LIMIT 5";
$recent_inquiries_res = $conn->query($recent_inquiries_query);


// 3. Most Inquired Products (p.image સાથે)
$most_inquired_query = "
    SELECT p.product_name, p.image, c.name as category_name, COUNT(ii.id) as inquiry_count 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    JOIN inquiry_items ii ON p.id = ii.product_id 
    GROUP BY p.id 
    ORDER BY inquiry_count DESC LIMIT 5";
$most_inquired_res = $conn->query($most_inquired_query);
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InquiryHub - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    </style>
</head>

<body class="flex">
    <aside class="w-64 min-h-screen bg-white border-r border-gray-200 flex flex-col justify-between">
        <div>
            <div class="p-6 flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg"><i class="fas fa-cube text-white"></i></div>
                <h1 class="text-xl font-bold text-gray-800">InquiryHub</h1>
            </div>
            <nav class="mt-4 px-4 space-y-1">
                <a href="javascript:void(0)" onclick="showSection('dashboard-section')" id="link-dashboard"
                    class="nav-link flex items-center gap-3 bg-blue-600 text-white px-4 py-3 rounded-lg">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="javascript:void(0)" onclick="showSection('products-section')" id="link-products"
                    class="nav-link flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg">
                    <i class="fas fa-box"></i> Products
                </a>
                <a href="javascript:void(0)" onclick="showSection('categories-section')" id="link-categories"
                    class="nav-link flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg">
                    <i class="fas fa-box"></i> Categories
                </a>
                <a href="javascript:void(0)" onclick="showSection('inquiries-section')"
                    class="nav-link flex items-center justify-between text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg group transition-all">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-comment-dots"></i> Inquiries
                    </div>
                    <?php if($status_new > 0): ?>
                    <span
                        class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm shadow-red-200">
                        <?php echo $status_new; ?>
                    </span>
                    <?php endif; ?>
                </a>
                <a href="javascript:void(0)" onclick="showSection('reports-section')" id="link-reports"
                    class="nav-link flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg">
                    <i class="fas fa-box"></i> Reports
                </a>
                <a href="javascript:void(0)" onclick="showSection('sliders-section')" id="link-sliders"
                    class="nav-link flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg">
                    <i class="fas fa-box"></i> Sliders
                </a>
                <!-- <a href="javascript:void(0)" onclick="showSection('users-section')"
                    class="nav-link flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg transition-all">
                    <i class="fas fa-users"></i> Users
                </a> -->

                <a href="javascript:void(0)" onclick="showSection('settings-section')"
                    class="nav-link flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-lg transition-all">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-100">
            <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')"
                class="flex items-center justify-center gap-3 text-red-500 hover:bg-red-50 w-full px-4 py-3 rounded-2xl font-bold transition-all">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-8">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                        class="fas fa-search"></i></span>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-white"
                    placeholder="Search...">
            </div>
            <div class="flex items-center gap-4">
                <div class="relative"><i class="far fa-bell text-gray-500 text-xl"></i><span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full px-1"><?php echo $new_today; ?></span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold">Admin User</p>
                        <p class="text-xs text-gray-500">admin@rajvi.com</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff"
                        class="w-10 h-10 rounded-full border">
                </div>
            </div>
        </header>
        <div id="dashboard-section" class="content-section">
            <h2 class="text-2xl font-bold mb-1">Dashboard</h2>
            <p class="text-gray-500 mb-8">Welcome back! Here's an overview of Rajvi Associates.</p>

            <div class="grid grid-cols-5 gap-4 mb-8">
                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 relative">
                    <p class="text-sm text-gray-600 font-medium">Total Products</p>
                    <h3 class="text-3xl font-bold mt-1"><?php echo $total_products; ?></h3>
                    <div class="absolute top-6 right-6 bg-blue-500 text-white p-2 rounded-lg"><i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 relative">
                    <p class="text-sm text-gray-600 font-medium">Total Categories</p>
                    <h3 class="text-3xl font-bold mt-1"><?php echo $total_categories; ?></h3>
                    <div class="absolute top-6 right-6 bg-gray-100 text-gray-500 p-2 rounded-lg"><i
                            class="fas fa-layer-group"></i></div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 relative">
                    <p class="text-sm text-gray-600 font-medium">Total Inquiries</p>
                    <h3 class="text-3xl font-bold mt-1"><?php echo $total_inquiries; ?></h3>
                    <div class="absolute top-6 right-6 bg-gray-100 text-gray-500 p-2 rounded-lg"><i
                            class="fas fa-comment-alt"></i></div>
                </div>
                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 relative">
                    <p class="text-sm text-gray-600 font-medium">New Today</p>
                    <h3 class="text-3xl font-bold mt-1"><?php echo $new_today; ?></h3>
                    <div class="absolute top-6 right-6 bg-orange-500 text-white p-2 rounded-lg"><i
                            class="far fa-clock"></i>
                    </div>
                </div>
                <div class="bg-green-50 p-6 rounded-2xl border border-green-100 relative">
                    <p class="text-sm text-gray-600 font-medium">Completed</p>
                    <h3 class="text-3xl font-bold mt-1"><?php echo $resolved_inquiries; ?></h3>
                    <div class="absolute top-6 right-6 bg-green-500 text-white p-2 rounded-lg"><i
                            class="fas fa-check-circle"></i></div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8 mb-8">
                <div class="col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-gray-800">Inquiry Status Overview</h3>
                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded">Live Data</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="h-90 mt-10">
                            <canvas id="statusChart"></canvas>
                        </div>

                        <div class="flex flex-col justify-center space-y-4">
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-medium text-gray-700">New</span>
                                </div>
                                <span class="font-bold text-blue-700"><?php echo $status_new; ?></span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                                    <span class="text-sm font-medium text-gray-700">Contacted</span>
                                </div>
                                <span class="font-bold text-orange-700"><?php echo $status_progress; ?></span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-sm font-medium text-gray-700">Completed</span>
                                </div>
                                <span class="font-bold text-green-700"><?php echo $status_completed; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100">
                    <h3 class="font-bold mb-6 text-lg">Most Inquired Products</h3>
                    <div class="space-y-6">
                        <?php 
                    $rank = 1;
                    while($row = $most_inquired_res->fetch_assoc()): ?>
                        <div class="flex items-center gap-4">
                            <span
                                class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 text-[10px] flex items-center justify-center font-bold"><?php echo $rank++; ?></span>
                            <div class="flex-1">
                                <div class="flex justify-between text-sm mb-1">
                                    <div><span
                                            class="font-semibold block"><?php echo $row['product_name']; ?></span><span
                                            class="text-[10px] text-gray-400"><?php echo $row['category_name']; ?></span>
                                    </div>
                                    <span class="font-bold text-blue-600"><?php echo $row['inquiry_count']; ?></span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full"
                                        style="width: <?php echo ($row['inquiry_count'] * 20); ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Recent Inquiries</h3>
                    <a href="inquiries.php" class="text-blue-600 text-sm font-semibold">View All</a>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-400 text-xs uppercase font-medium">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Quantity</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php while($inq = $recent_inquiries_res->fetch_assoc()): 
        $statusColor = ($inq['status'] == 'New') ? 'bg-blue-50 text-blue-600' : (($inq['status'] == 'Contacted') ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600');
    ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">#INQ-<?php echo $inq['id']; ?></td>
                            <td class="px-6 py-4">
                                <span class="font-bold block"><?php echo $inq['customer_name']; ?></span>
                                <span class="text-xs text-gray-400"><?php echo $inq['phone']; ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="truncate w-48" title="<?php echo $inq['product_names']; ?>">
                                    <?php echo $inq['product_names'] ?? 'N/A'; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold"><?php echo $inq['total_quantity'] ?? '0'; ?> units</td>
                            <td class="px-6 py-4">
                                <span
                                    class="<?php echo $statusColor; ?> px-3 py-1 rounded-full text-xs font-bold"><?php echo $inq['status']; ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                <?php echo date('Y-m-d', strtotime($inq['created_at'])); ?>
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                <div class="flex items-center gap-3">
                                    <a href="view_inquiry.php?id=<?php echo $inq['id']; ?>" class="hover:text-blue-600">
                                        <i class="far fa-eye cursor-pointer"></i>
                                    </a>
                                    <div class="relative group">
                                        <div class="py-2 cursor-pointer hover:text-gray-700">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </div>
                                        <div
                                            class="hidden group-hover:block absolute right-0 top-full w-40 bg-white border border-gray-100 shadow-xl rounded-lg z-50 py-2">
                                            <a href="update_status.php?id=<?php echo $inq['id']; ?>&status=Contacted"
                                                class="block px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">Mark
                                                Contacted</a>
                                            <a href="update_status.php?id=<?php echo $inq['id']; ?>&status=Completed"
                                                class="block px-4 py-2 text-xs text-gray-700 hover:bg-green-50">Mark
                                                Completed</a>
                                            <hr class="my-1">
                                            <a href="delete_inquiry.php?id=<?php echo $inq['id']; ?>"
                                                onclick="return confirm('Are you sure?')"
                                                class="block px-4 py-2 text-xs text-red-500 hover:bg-red-50">Delete
                                                Inquiry</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>







        <div id="products-section" class="content-section hidden">
            <div class="flex justify-between items-center mb-1">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Products</h2>
                    <p class="text-sm text-gray-500">Manage your product catalog</p>
                </div>
                <a href="admin_add_product.php"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all shadow-sm shadow-blue-200">
                    <i class="fas fa-plus"></i> Add Product
                </a>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mt-6 mb-6 flex gap-4">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-100 rounded-lg bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all text-sm"
                        placeholder="Search products...">
                </div>
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer">
                        <option>All Categories</option>
                        <?php 
                $cat_res = $conn->query("SELECT name FROM categories");
                while($c = $cat_res->fetch_assoc()) echo "<option>".$c['name']."</option>";
                ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
                <button
                    class="bg-gray-50 text-gray-600 p-2 rounded-lg border border-gray-100 hover:bg-gray-100 transition-all">
                    <i class="fas fa-filter text-sm"></i>
                </button>
            </div>




            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Description</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <?php 
                // Database માંથી પ્રોડક્ટ્સ અને તેની કેટેગરી લાવવા માટે
                $prod_sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
                $prod_res = $conn->query($prod_sql);
                
                while($p = $prod_res->fetch_assoc()): 
                    // Status Badge Color
                    $statusClass = ($p['stock_status'] == 'In Stock') ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600';
                ?>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        <?php if(!empty($p['image'])): ?>
                                        <img src="uploads/<?php echo $p['image']; ?>"
                                            class="w-full h-full object-cover">
                                        <?php else: ?>
                                        <i class="fas fa-image text-gray-300"></i>
                                        <?php endif; ?>
                                    </div>
                                    <span class="font-bold text-gray-800"><?php echo $p['product_name']; ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <?php echo $p['category_name'] ?? 'General'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-gray-500 truncate w-64 italic">
                                    <?php echo $p['short_description'] ?: 'No description available'; ?></p>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="<?php echo $statusClass; ?> px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <?php echo $p['stock_status'] ?: 'Active'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <?php 
        // જો સ્ટેટસ 'In Stock' હોય તો આગળ 'Out of Stock' કરવાનો ઓપ્શન આપવો
        $next_status = ($p['stock_status'] == 'In Stock') ? 'Out of Stock' : 'In Stock';
    ?>
                                    <a href="update_stock_status.php?id=<?php echo $p['id']; ?>&status=<?php echo $next_status; ?>"
                                        class="<?php echo $statusClass; ?> px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide hover:opacity-75 transition-all cursor-pointer shadow-sm"
                                        title="Click to mark as <?php echo $next_status; ?>">
                                        <?php echo $p['stock_status'] ?: 'In Stock'; ?>
                                    </a>
                                    <a href="admin_edit_product.php?id=<?php echo $p['id']; ?>"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="delete_product.php?id=<?php echo $p['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                        class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                        title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>


                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>














        <div id="categories-section" class="content-section hidden">
            <div class="flex justify-between items-center mb-1">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
                    <p class="text-sm text-gray-500">Organize your products into categories</p>
                </div>
                <a href="admin_cat.php"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all shadow-sm shadow-blue-200">
                    <i class="fas fa-plus text-xs"></i> Add Category
                </a>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mt-6 mb-8">
                <div class="relative max-w-sm">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-100 rounded-lg bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all text-sm"
                        placeholder="Search categories...">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
        $cat_query = "SELECT c.*, COUNT(p.id) as product_count 
                      FROM categories c 
                      LEFT JOIN products p ON c.id = p.category_id 
                      GROUP BY c.id ORDER BY c.name ASC";
        $cat_res = $conn->query($cat_query);

        while($cat = $cat_res->fetch_assoc()): 
        ?>
                <div onclick="viewCategoryProducts(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>')"
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group relative cursor-pointer">

                    <div class="flex items-start justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center overflow-hidden">
                            <?php if(!empty($cat['image_path'])): ?>
                            <img src="<?php echo $cat['image_path']; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                            <i class="far fa-image text-gray-300 text-xl"></i>
                            <?php endif; ?>
                        </div>

                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-all"
                            onclick="event.stopPropagation();">
                            <a href="admin_edit_category.php?id=<?php echo $cat['id']; ?>"
                                class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors" title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <a href="admin_delete_category.php?id=<?php echo $cat['id']; ?>"
                                onclick="return confirm('Are you sure?')"
                                class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo $cat['name']; ?></h3>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1.5 text-gray-400">
                            <i class="fas fa-box text-[10px]"></i>
                            <span class="text-xs font-semibold"><?php echo $cat['product_count']; ?> products</span>
                        </div>
                        <span
                            class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-green-50 text-green-600">
                            Active
                        </span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div id="category-detail-section" class="content-section hidden">
            <div class="flex items-center gap-4 mb-8">
                <button onclick="showSection('categories-section')"
                    class="bg-white p-2.5 rounded-xl border border-gray-200 text-gray-400 hover:text-blue-600 transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h2 id="selected-category-name" class="text-2xl font-bold text-gray-800 uppercase tracking-tight">
                        Category Products</h2>
                    <p class="text-sm text-gray-500">Products belonging to this category</p>
                </div>
            </div>

            <div id="category-products-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            </div>
        </div>

















        <div id="inquiries-section" class="content-section hidden">
            <div class="flex justify-between items-center mb-1">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Inquiries</h2>
                    <p class="text-sm text-gray-500">Manage and respond to customer requests</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-all">
                        <i class="fas fa-download mr-2 text-xs"></i> Export
                    </button>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mt-6 mb-6 flex gap-4">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" id="inquirySearch" onkeyup="applyInquiryFilters()"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-100 rounded-lg bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all text-sm"
                        placeholder="Search by customer name or phone...">
                </div>

                <div class="relative">
                    <select id="statusFilter" onchange="applyInquiryFilters()"
                        class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer text-gray-600 font-semibold">
                        <option value="All">All Status</option>
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Completed">Completed</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-center">ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Products</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <?php 
                // બધી ઇન્ક્વાયરી મેળવવા માટેની ક્વેરી
                $inq_list_sql = "SELECT i.*, GROUP_CONCAT(p.product_name SEPARATOR ', ') as product_names 
                                 FROM inquiries i 
                                 LEFT JOIN inquiry_items ii ON i.id = ii.inquiry_id 
                                 LEFT JOIN products p ON ii.product_id = p.id 
                                 GROUP BY i.id ORDER BY i.created_at DESC";
                $inq_list_res = $conn->query($inq_list_sql);

                while($inq = $inq_list_res->fetch_assoc()): 
                    // સ્ટેટસ મુજબ કલર સેટ કરવા
                    $status_badge = ($inq['status'] == 'New') ? 'bg-blue-50 text-blue-600' : (($inq['status'] == 'Contacted') ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600');
                ?>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-400">#<?php echo $inq['id']; ?></td>
                            <td class="px-6 py-5">
                                <span class="font-bold text-gray-800 block"><?php echo $inq['customer_name']; ?></span>
                                <span class="text-xs text-blue-500 font-medium"><?php echo $inq['phone']; ?></span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-gray-500 truncate w-48 text-xs italic"
                                    title="<?php echo $inq['product_names']; ?>">
                                    <?php echo $inq['product_names'] ?: 'General Inquiry'; ?>
                                </p>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="<?php echo $status_badge; ?> px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <?php echo $inq['status']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-gray-400 text-xs">
                                <?php echo date('d M, Y', strtotime($inq['created_at'])); ?>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="view_inquiry.php?id=<?php echo $inq['id']; ?>"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        title="View Details">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="delete_inquiry.php?id=<?php echo $inq['id']; ?>"
                                        onclick="return confirm('આ ઇન્ક્વાયરી ડિલીટ કરવી છે?')"
                                        class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>











        <div id="reports-section" class="content-section hidden">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Inquiry Reports</h2>
                    <p class="text-sm text-gray-500">Analyze business growth and trends</p>
                </div>
                <button onclick="window.print()"
                    class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg hover:bg-black transition-all">
                    <i class="fas fa-print mr-2"></i> Print Report
                </button>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Start Date</label>
                        <input type="date" id="startDate" onchange="applyReportFilters()"
                            class="w-full border border-gray-100 p-2.5 rounded-xl bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">End Date</label>
                        <input type="date" id="endDate" onchange="applyReportFilters()"
                            class="w-full border border-gray-100 p-2.5 rounded-xl bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Search Customer</label>
                        <input type="text" id="reportSearch" onkeyup="applyReportFilters()" placeholder="Search..."
                            class="w-full border border-gray-100 p-2.5 rounded-xl bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Status</label>
                        <select id="reportStatus" onchange="applyReportFilters()"
                            class="w-full border border-gray-100 p-2.5 rounded-xl bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer font-bold text-gray-600">
                            <option value="All">All Inquiries</option>
                            <option value="New">New</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left" id="reportsTable">
                    <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase font-bold tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Customer Details</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Inquiry ID</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <?php 
                $rep_query = "SELECT * FROM inquiries ORDER BY created_at DESC";
                $rep_res = $conn->query($rep_query);
                while($row = $rep_res->fetch_assoc()): 
                    $badge = ($row['status'] == 'New') ? 'bg-blue-50 text-blue-600' : (($row['status'] == 'Contacted') ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600');
                ?>
                        <tr class="report-row" data-date="<?php echo date('Y-m-d', strtotime($row['created_at'])); ?>"
                            data-status="<?php echo $row['status']; ?>">
                            <td class="px-8 py-5 font-medium text-gray-500">
                                <?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td class="px-8 py-5">
                                <span class="font-bold text-gray-800 block"><?php echo $row['customer_name']; ?></span>
                                <span class="text-xs text-blue-400"><?php echo $row['phone']; ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="<?php echo $badge; ?> px-3 py-1 rounded-full text-[10px] font-bold uppercase"><?php echo $row['status']; ?></span>
                            </td>
                            <td class="px-8 py-5 text-right font-bold text-gray-300">#<?php echo $row['id']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>



















        <div id="sliders-section" class="content-section hidden">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Slider Management</h2>
                    <p class="text-gray-500 text-sm">Add or remove homepage banner sliders</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fa fa-images text-blue-600 text-xl"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-lg font-bold mb-6 flex items-center gap-2 text-gray-800">
                            <i class="fa fa-plus-circle text-blue-600"></i> New Slider
                        </h2>
                        <form action="save_slider.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                            <div>
                                <label class="text-xs font-bold uppercase text-gray-500 block mb-1">Main Title</label>
                                <input type="text" name="title" placeholder="e.g. Exclusive Watch"
                                    class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm"
                                    required>
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-gray-500 block mb-1">Subtitle</label>
                                <input type="text" name="subtitle" placeholder="e.g. 20% Off Today"
                                    class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-gray-500 block mb-1">Slider Image</label>
                                <div
                                    class="mt-1 flex justify-center px-4 pt-4 pb-4 border-2 border-gray-100 border-dashed rounded-xl hover:border-blue-500 transition cursor-pointer bg-gray-50/50">
                                    <div class="space-y-1 text-center">
                                        <i class="fa fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                        <div class="flex text-xs text-gray-600">
                                            <label for="file-upload-slider"
                                                class="relative cursor-pointer font-bold text-blue-600 hover:text-blue-500">
                                                <span>Upload a file</span>
                                                <input id="file-upload-slider" name="image" type="file" class="sr-only"
                                                    required onchange="previewSliderImage(event)">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <img id="output-slider-image"
                                    class="mt-4 rounded-xl hidden shadow-sm w-full h-32 object-cover border border-gray-100" />
                            </div>
                            <button type="submit" name="upload"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold uppercase tracking-widest text-xs transition-all shadow-lg shadow-blue-100">
                                Add to Slider
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-bold text-gray-800">Active Sliders</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            Preview</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            Details</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <?php
                            $res = mysqli_query($conn, "SELECT * FROM sliders ORDER BY id DESC");
                            if(mysqli_num_rows($res) > 0) {
                                while($item = mysqli_fetch_assoc($res)) {
                            ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="relative group w-24">
                                                <img src="<?php echo $item['image_path']; ?>"
                                                    class="w-24 h-14 rounded-lg object-cover shadow-sm ring-2 ring-gray-50">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-800 text-sm"><?php echo $item['title']; ?>
                                            </div>
                                            <div class="text-[10px] text-gray-400 font-medium italic">
                                                <?php echo $item['subtitle']; ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="delete_slider.php?id=<?php echo $item['id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this slider?')"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                <i class="fa fa-trash-can text-sm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='3' class='p-10 text-center text-xs font-bold text-gray-300 uppercase tracking-widest'>No sliders found</td></tr>";
                            }
                            ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>














        <div id="users-section" class="content-section hidden">
            <div class="flex justify-between items-center mb-1">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
                    <p class="text-sm text-gray-500">Manage administrator and staff accounts</p>
                </div>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all shadow-sm shadow-blue-200">
                    <i class="fas fa-user-plus text-xs"></i> Add New User
                </button>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mt-6 mb-8 flex gap-4">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" id="userSearch" onkeyup="filterUsers()"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-100 rounded-lg bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all text-sm"
                        placeholder="Search users by name or email...">
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left" id="usersTable">
                    <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase font-bold tracking-widest">
                        <tr>
                            <th class="px-8 py-5">User</th>
                            <th class="px-8 py-5">Role</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff"
                                        class="w-10 h-10 rounded-xl border border-gray-100">
                                    <div>
                                        <p class="font-bold text-gray-800">Admin User</p>
                                        <p class="text-xs text-gray-400">admin@rajvi.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Super
                                    Admin</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <span class="text-xs font-medium text-gray-600">Active</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <button class="p-2 text-gray-400 hover:text-blue-600 transition-colors"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="p-2 text-gray-400 hover:text-red-500 transition-colors"><i
                                            class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


















        <div id="settings-section" class="content-section hidden">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Settings</h2>
                <p class="text-sm text-gray-500">Update your website configuration and security settings</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Security</h3>
                    <form action="update_password.php" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">New Password</label>
                            <input type="password" name="new_pass" required
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Confirm Password</label>
                            <input type="password" name="confirm_pass" required
                                class="w-full border-2 border-gray-50 p-3 rounded-xl focus:border-blue-500 outline-none transition bg-gray-50/50">
                        </div>
                        <button type="submit"
                            class="w-full bg-gray-800 text-white font-bold py-3 rounded-xl hover:bg-black transition-all uppercase tracking-widest text-xs">
                            Update Password
                        </button>
                    </form>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mt-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Display Controls (On/Off)
                    </h3>
                    <div class="space-y-6">
                        <?php
        $settings_res = $conn->query("SELECT * FROM site_settings");
        while($setting = $settings_res->fetch_assoc()):
        ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                            <div>
                                <p class="font-bold text-gray-800 capitalize">
                                    <?php echo str_replace('_', ' ', $setting['feature_key']); ?></p>
                                <p class="text-xs text-gray-400">Toggle to show/hide this element for users.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer"
                                    <?php echo $setting['is_enabled'] ? 'checked' : ''; ?>
                                    onchange="updateUIFeature('<?php echo $setting['feature_key']; ?>', this.checked)">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <script>
                function updateUIFeature(key, status) {
                    const isEnabled = status ? 1 : 0;
                    fetch('update_ui_settings.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `key=${key}&status=${isEnabled}`
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                console.log(key + " updated to " + isEnabled);
                            }
                        });
                }
                </script>


            </div>
        </div>
        </div>


    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    function showSection(sectionId) {
        const targetSection = document.getElementById(sectionId);

        // જો સેક્શન ન મળે તો Error રોકવા માટે
        if (!targetSection) {
            console.error("Section not found: " + sectionId);
            return;
        }

        // 1. બધા સેક્શન્સને છુપાવો
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.add('hidden');
        });

        // 2. ટાર્ગેટ સેક્શન બતાવો
        targetSection.classList.remove('hidden');

        // 3. સાઇડબાર હાઇલાઇટ અપડેટ કરો
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('bg-blue-600', 'text-white');
            link.classList.add('text-gray-600', 'hover:bg-gray-50');
        });

        // જો સાઇડબારમાં લિંક હોય તો જ હાઇલાઇટ કરો
        const activeLink = document.querySelector(`[onclick="showSection('${sectionId}')"]`);
        if (activeLink) {
            activeLink.classList.remove('text-gray-600', 'hover:bg-gray-50');
            activeLink.classList.add('bg-blue-600', 'text-white');
        }
    }

    // HTML ઇનપુટમાં આ ઉમેરો: onkeyup="filterInquiries(this.value)"
    function filterInquiries(val) {
        let value = val.toLowerCase();
        let rows = document.querySelectorAll("#inquiries-section tbody tr");

        rows.forEach(row => {
            // Customer name અને Phone સેલના આધારે ફિલ્ટર
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    }

    function applyInquiryFilters() {
        // ઇનપુટ્સ મેળવો
        const searchValue = document.getElementById('inquirySearch').value.toLowerCase();
        const statusValue = document.getElementById('statusFilter').value;
        const tableRows = document.querySelectorAll("#inquiries-section tbody tr");

        tableRows.forEach(row => {
            // ડેટા મેળવો (Customer Info અને Status Badge)
            const customerName = row.cells[1].innerText.toLowerCase();
            const inquiryStatus = row.cells[3].innerText.trim(); // Status badge text

            // ફિલ્ટર શરતો
            const matchesSearch = customerName.includes(searchValue);
            const matchesStatus = (statusValue === "All" || inquiryStatus === statusValue);

            // જો બંને શરતો સંતોષાય તો જ રો બતાવવી
            if (matchesSearch && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function applyReportFilters() {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        const status = document.getElementById('reportStatus').value;
        const search = document.getElementById('reportSearch').value.toLowerCase();

        const rows = document.querySelectorAll(".report-row");

        rows.forEach(row => {
            const rowDate = row.getAttribute('data-date');
            const rowStatus = row.getAttribute('data-status');
            const rowText = row.innerText.toLowerCase();

            // Check Date Range
            let dateMatch = true;
            if (start && end) {
                dateMatch = (rowDate >= start && rowDate <= end);
            } else if (start) {
                dateMatch = (rowDate >= start);
            } else if (end) {
                dateMatch = (rowDate <= end);
            }

            // Check Status & Search
            const statusMatch = (status === "All" || rowStatus === status);
            const searchMatch = rowText.includes(search);

            // Final Visibility
            if (dateMatch && statusMatch && searchMatch) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }



    function previewSliderImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output-slider-image');
            output.src = reader.result;
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function filterUsers() {
        const input = document.getElementById("userSearch");
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll("#usersTable tbody tr");

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    }
    </script>
    <script>
    function viewCategoryProducts(catId, catName) {
        // પહેલા સેક્શન સ્વિચ કરો
        showSection('category-detail-section');
        document.getElementById('selected-category-name').innerText = catName;

        // કન્ટેનર મેળવો જ્યાં પ્રોડક્ટ્સ દેખાશે
        const listContainer = document.getElementById('category-products-list');
        listContainer.innerHTML =
            '<div class="col-span-full text-center p-10 text-gray-400 italic">લોડ થઈ રહ્યું છે...</div>';

        // AJAX વિનંતી
        fetch('get_category_products.php?cat_id=' + catId)
            .then(response => response.text())
            .then(data => {
                // જો ડેટા મળે તો તેને કન્ટેનરમાં મૂકો
                listContainer.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                listContainer.innerHTML =
                    '<p class="p-10 text-red-500 text-center">ડેટા લોડ કરવામાં ભૂલ આવી છે.</p>';
            });
    }

    function updateStatus(id, status) {
        if (confirm('શું તમે સ્ટેટસ બદલવા માંગો છો?')) {
            // અહીં તમે AJAX વાપરી શકો અથવા સાદું ફોર્મ સબમિટ કરી શકો
            window.location.href = 'update_status.php?id=' + id + '&status=' + status;
        }
    }

    function viewInquiry(id) {
        // આ ફંક્શનમાં તમે AJAX થી ડેટા લાવીને Modal માં બતાવી શકો
        // અત્યારે સરળતા માટે આપણે સીધા ઈન્કવાયરી પેજ પર મોકલીએ છીએ
        window.location.href = 'inquiries.php?view_id=' + id;
    }
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut', // તમે અહીં 'pie' પણ રાખી શકો છો
        data: {
            labels: ['New', 'Contacted', 'Completed'],
            datasets: [{
                data: [
                    <?php echo $status_new; ?>,
                    <?php echo $status_progress; ?>,
                    <?php echo $status_completed; ?>
                ],
                backgroundColor: ['#3b82f6', '#fb923c', '#22c55e'],
                hoverOffset: 10,
                borderWidth: 0,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // આપણે કસ્ટમ લેજન્ડ બનાવી છે એટલે અહીં ફોલ્સ રાખ્યું છે
                }
            },
            cutout: '70%', // ડોનટ ચાર્ટની વચ્ચેની જગ્યા
        }
    });
    </script>
</body>

</html>