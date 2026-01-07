<?php
include 'db.php';

$min_p = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_p = isset($_GET['max_price']) ? $_GET['max_price'] : 100000;
$cat_id = isset($_GET['id']) ? $_GET['id'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';

// નવા ફિલ્ટર્સના ડેટા
$selected_brands = isset($_GET['brands']) ? $_GET['brands'] : [];
$rating = isset($_GET['rating']) ? $_GET['rating'] : 0;

// બેઝ ક્વેરી
$sql = "SELECT * FROM products WHERE discounted_price BETWEEN $min_p AND $max_p";

if($cat_id > 0) {
    $sql .= " AND category_id = '$cat_id'";
}

// બ્રાન્ડ ફિલ્ટર લોજિક
if(!empty($selected_brands)) {
    $brand_list = "'" . implode("','", array_map(fn($b) => mysqli_real_escape_string($conn, $b), $selected_brands)) . "'";
    $sql .= " AND brand IN ($brand_list)";
}

// રેટિંગ ફિલ્ટર લોજિક (તમારા ડેટાબેઝમાં rating કોલમ હોવી જોઈએ, અત્યારે 4.5 સ્ટેટિક છે)
if($rating > 0) {
    $sql .= " AND rating >= $rating";
}

// સોર્ટિંગ લોજિક
if($sort == 'low') $sql .= " ORDER BY discounted_price ASC";
elseif($sort == 'high') $sql .= " ORDER BY discounted_price DESC";
else $sql .= " ORDER BY id DESC";

$products = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Explore Products | Rajvi Associates</title>
    <style>
    body {
        font-family: 'Inter', sans-serif !important;
        /* Inter ફોન્ટ ફેમિલી લાગુ કરો */
        font-size: 14px;
        /* ડિફોલ્ટ સાઈઝ 14px */
        line-height: 20px;
        /* લાઈન હાઈટ 20px */
        color: #111827;
        /* ફોન્ટ કલર */
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* હેડિંગ્સ માટે પણ તમે તેને સ્પષ્ટ કરી શકો છો */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        /* હેડિંગ્સ માટે થોડું બોલ્ડ રાખવું સારું લાગશે */
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .filter-drawer {
        transition: transform 0.3s ease-in-out;
    }

    .product-card:hover .btn-overlay {
        opacity: 1;
        transform: translateY(0);
    }
    </style>
    <style>
    /* Slider Thumb Styling */
    .range-thumb::-webkit-slider-thumb {
        appearance: none;
        pointer-events: auto;
        width: 18px;
        height: 18px;
        background: #ffffff;
        border: 3px solid #2563eb;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .range-thumb::-moz-range-thumb {
        width: 18px;
        height: 18px;
        background: #ffffff;
        border: 3px solid #2563eb;
        border-radius: 50%;
        cursor: pointer;
    }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-white">

    <?php include 'header.php'; ?>

    <div class="relative w-full h-[300px] md:h-[400px] overflow-hidden bg-gray-900">
        <img src="./assets/image/product_banner.jpg" alt="Category Banner"
            class="absolute inset-0 w-full h-full object-cover opacity-60 transition-transform duration-1000 hover:scale-105">

        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent"></div>

        <div class="relative max-w-[1440px] mx-auto h-full flex flex-col justify-center px-6 md:px-12 text-white">
            <nav class="flex mb-4 text-xs font-bold uppercase tracking-widest text-gray-300">
                <a href="index.php" class="hover:text-yellow-400">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white"><?php echo ($cat_id > 0) ? "Category Collection" : "All Products"; ?></span>
            </nav>

            <h1 class="text-4xl md:text-6xl font-black italic tracking-tighter uppercase leading-none">
                <?php 
                if($cat_id > 0) {
                    $c_res = mysqli_query($conn, "SELECT name FROM categories WHERE id = $cat_id");
                    $c_row = mysqli_fetch_assoc($c_res);
                    echo $c_row['name'];
                } else {
                    echo "Premium Collection";
                }
            ?>
            </h1>
            <p class="mt-4 max-w-md text-gray-300 text-sm md:text-base font-medium leading-relaxed">
                Discover our exclusive range of products tailored to meet your needs. Browse through our collection
                and find the perfect fit for you.
            </p>

            <div class="mt-8 flex gap-4">
                <div
                    class="flex items-center gap-2 bg-yellow-400 text-black px-4 py-2 rounded-sm font-black text-xs uppercase shadow-lg">
                    <i class="fa fa-award"></i> Best Price Guaranteed
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="mt-6">
        <h3 class="font-bold text-[10px] uppercase tracking-widest text-gray-400 mb-3 text-center">Popular Price Range
        </h3>
        <div class="grid grid-cols-1 gap-2">
            <button type="button" onclick="setPriceBracket(0, 1000)"
                class="text-xs font-bold border border-gray-200 py-2 px-3 rounded-lg hover:bg-black hover:text-white hover:border-black transition-all text-left flex justify-between items-center group">
                ₹1,000 ની નીચે
                <i class="fa fa-chevron-right text-[8px] opacity-0 group-hover:opacity-100 transition-all"></i>
            </button>

            <button type="button" onclick="setPriceBracket(1000, 5000)"
                class="text-xs font-bold border border-gray-200 py-2 px-3 rounded-lg hover:bg-black hover:text-white hover:border-black transition-all text-left flex justify-between items-center group">
                ₹1,000 - ₹5,000
                <i class="fa fa-chevron-right text-[8px] opacity-0 group-hover:opacity-100 transition-all"></i>
            </button>

            <button type="button" onclick="setPriceBracket(5000, 15000)"
                class="text-xs font-bold border border-gray-200 py-2 px-3 rounded-lg hover:bg-black hover:text-white hover:border-black transition-all text-left flex justify-between items-center group">
                ₹5,000 - ₹15,000
                <i class="fa fa-chevron-right text-[8px] opacity-0 group-hover:opacity-100 transition-all"></i>
            </button>

            <button type="button" onclick="setPriceBracket(15000, 100000)"
                class="text-xs font-bold border border-gray-200 py-2 px-3 rounded-lg hover:bg-black hover:text-white hover:border-black transition-all text-left flex justify-between items-center group">
                ₹15,000 થી ઉપર
                <i class="fa fa-chevron-right text-[8px] opacity-0 group-hover:opacity-100 transition-all"></i>
            </button>
        </div>
    </div> -->

    <div class="lg:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50">
        <button onclick="toggleFilter()"
            class="bg-black text-white px-8 py-3 rounded-full shadow-2xl font-bold flex items-center gap-2">
            <i class="fa fa-sliders"></i> FILTERS
        </button>
    </div>

    <main class="max-w-[1440px] mx-auto px-4 flex gap-10 py-8">






        <aside
            class="w-72 hidden lg:block sticky top-24 h-[calc(100vh-100px)] overflow-y-auto no-scrollbar border-r pr-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-black italic tracking-tighter">FILTERS</h2>
                <a href="category.php"
                    class="text-[10px] font-bold text-blue-600 underline uppercase tracking-widest hover:text-black transition">
                    Clear All
                </a>
            </div>

            <form action="" method="GET" id="filterForm">
                <div class="mb-8">
                    <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-gray-400">Sort By</h3>
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full border-b-2 border-black py-2 text-sm outline-none font-semibold">
                        <option value="latest" <?php if($sort == 'latest') echo 'selected'; ?>>Newest First</option>
                        <option value="low" <?php if($sort == 'low') echo 'selected'; ?>>Price: Low to High</option>
                        <option value="high" <?php if($sort == 'high') echo 'selected'; ?>>Price: High to Low</option>
                    </select>
                </div>

                <div class="mb-8 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-[10px] uppercase tracking-widest mb-6 flex justify-between text-gray-500">
                        Price Range
                        <span class="text-blue-600 font-black" id="priceLabel">₹<?php echo $min_p; ?> -
                            ₹<?php echo $max_p; ?></span>
                    </h3>
                    <div class="relative h-1.5 w-full bg-gray-200 rounded-full mb-8">
                        <div id="sliderTrack" class="absolute h-full bg-blue-600 rounded-full"></div>
                        <input type="range" name="min_price" id="minRange" min="0" max="50000"
                            value="<?php echo $min_p; ?>"
                            class="absolute w-full h-1.5 appearance-none bg-transparent pointer-events-none cursor-pointer range-thumb">
                        <input type="range" name="max_price" id="maxRange" min="0" max="100000"
                            value="<?php echo $max_p; ?>"
                            class="absolute w-full h-1.5 appearance-none bg-transparent pointer-events-none cursor-pointer range-thumb">
                    </div>
                    <button type="submit"
                        class="w-full bg-black text-white py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-blue-700 transition-all">
                        Apply Price
                    </button>
                </div>

                <div class="mb-8 space-y-2">
                    <h3 class="font-bold text-[10px] uppercase tracking-widest mb-4 text-gray-400">Quick Selection</h3>
                    <button type="button" onclick="setPriceBracket(0, 1000)" class="price-bracket-btn group">
                        <span>Below ₹1,000</span> <i class="fa fa-chevron-right"></i>
                    </button>
                    <button type="button" onclick="setPriceBracket(1000, 5000)" class="price-bracket-btn group">
                        <span>₹1,000 - ₹5,000</span> <i class="fa fa-chevron-right"></i>
                    </button>
                </div>

                <div class="mb-8 border-t pt-6">
                    <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-gray-400">Categories</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="id" value="0" onclick="this.form.submit()"
                                <?php if($cat_id == 0) echo 'checked'; ?> class="w-4 h-4 accent-black">
                            <span class="text-sm font-medium text-gray-600 group-hover:text-black">All Categories</span>
                        </label>
                        <?php 
                $cats = mysqli_query($conn, "SELECT * FROM categories");
                while($c = mysqli_fetch_assoc($cats)): 
                ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="id" value="<?php echo $c['id']; ?>" onclick="this.form.submit()"
                                <?php if($cat_id == $c['id']) echo 'checked'; ?> class="w-4 h-4 accent-black">
                            <span
                                class="text-sm font-medium text-gray-600 group-hover:text-black"><?php echo $c['name']; ?></span>
                        </label>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="mb-8 border-t pt-6">
                    <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-gray-400">Brands</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto no-scrollbar">
                        <?php 
                $brands_query = mysqli_query($conn, "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != ''");
                while($b = mysqli_fetch_assoc($brands_query)): 
                    $b_val = $b['brand'];
                    $b_checked = (isset($_GET['brands']) && in_array($b_val, $_GET['brands'])) ? 'checked' : '';
                ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="brands[]" value="<?php echo $b_val; ?>"
                                onchange="this.form.submit()" <?php echo $b_checked; ?>
                                class="w-4 h-4 accent-black rounded">
                            <span
                                class="text-sm font-medium text-gray-600 group-hover:text-black capitalize"><?php echo $b_val; ?></span>
                        </label>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="mb-8 border-t pt-6">
                    <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-gray-400">Ratings</h3>
                    <div class="space-y-2">
                        <?php for($i=4; $i>=1; $i--): 
                    $r_checked = (isset($_GET['rating']) && $_GET['rating'] == $i) ? 'checked' : '';
                ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="rating" value="<?php echo $i; ?>" onchange="this.form.submit()"
                                <?php echo $r_checked; ?> class="w-4 h-4 accent-black">
                            <div class="flex items-center gap-1 text-sm font-medium text-gray-600">
                                <?php echo $i; ?> <i class="fa fa-star text-yellow-400 text-[10px]"></i> & Up
                            </div>
                        </label>
                        <?php endfor; ?>
                    </div>
                </div>
            </form>
        </aside>























        <div class="flex-1">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-3 gap-y-10">
                <?php while($row = mysqli_fetch_assoc($products)): ?>
                <div
                    class="product-card group relative flex flex-col bg-white overflow-hidden transition-all duration-500 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] rounded-md border border-gray-100 hover:border-gray-200">
                    <div class="relative aspect-[3/4] bg-[#F7F8F9] overflow-hidden">
                        <a href="product-details.php?id=<?php echo $row['id']; ?>" class="block h-full">
                            <img src="uploads/<?php echo $row['image']; ?>"
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                alt="<?php echo $row['product_name']; ?>">
                        </a>

                        <div
                            class="absolute bottom-0 left-0 right-0 bg-black/90 text-white text-center py-3 text-[10px] font-bold uppercase tracking-[0.2em] opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                            View Details
                        </div>

                        <button onclick="addToInquiry(<?php echo $row['id']; ?>, <?php echo $row['min_qty']; ?>)"
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white text-black px-4 py-2 rounded-full text-[10px] font-black uppercase shadow-2xl opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 z-10 hover:bg-yellow-400">
                            <i class="fa fa-cart-plus mr-1"></i> Quick Inquiry
                        </button>

                        <div
                            class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm px-2 py-1 rounded-sm text-[9px] font-black shadow-sm flex items-center gap-1 border border-gray-100">
                            <i class="fa fa-star text-black"></i> 4.5
                        </div>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h4 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1.5">
                            Rajvi Selection
                        </h4>

                        <h3
                            class="text-[14px] leading-[20px] text-[#111827] font-semibold mb-3 h-10 overflow-hidden line-clamp-2 group-hover:text-blue-600 transition-colors">
                            <?php echo $row['product_name']; ?>
                        </h3>

                        <div class="mt-auto pt-4 border-t border-gray-50">
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="text-lg font-bold text-[#111827]">
                                    ₹<?php echo number_format($row['discounted_price']); ?>
                                </span>
                                <?php if($row['original_price'] > $row['discounted_price']): ?>
                                <span class="text-[11px] text-gray-400 line-through font-medium">
                                    ₹<?php echo number_format($row['original_price']); ?>
                                </span>
                                <?php endif; ?>
                            </div>

                            <div class="flex items-center justify-between">
                                <div
                                    class="bg-blue-50 text-blue-700 text-[9px] font-black px-2 py-1 uppercase rounded-sm tracking-tighter">
                                    MOQ: <?php echo $row['min_qty']; ?> Units
                                </div>
                                <div class="flex gap-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <div id="filterOverlay" onclick="toggleFilter()"
        class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300"></div>
    <div id="filterDrawer"
        class="fixed bottom-0 left-0 right-0 bg-white z-[70] rounded-t-[2.5rem] p-8 filter-drawer translate-y-full lg:hidden">
        <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-8"></div>
        <h2 class="text-2xl font-black mb-6 italic">FILTERS</h2>
        <form action="" method="GET">
            <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-bold mt-4 uppercase">Apply
                Filters</button>
        </form>
    </div>

    <script>
    function setPriceBracket(min, max) {
        // સ્લાઈડરના ઇનપુટ્સ મેળવો
        const minInput = document.getElementById('minRange');
        const maxInput = document.getElementById('maxRange');

        // વેલ્યુ સેટ કરો
        minInput.value = min;
        maxInput.value = max;

        // સ્લાઈડરને વિઝ્યુઅલી અપડેટ કરો (પહેલા બનાવેલા updateSlider ફંક્શનનો ઉપયોગ કરીને)
        updateSlider();

        // ફોર્મ સબમિટ કરો
        document.getElementById('filterForm').submit();
    }

    function toggleFilter() {
        const drawer = document.getElementById('filterDrawer');
        const overlay = document.getElementById('filterOverlay');
        if (drawer.classList.contains('translate-y-full')) {
            drawer.classList.remove('translate-y-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        } else {
            drawer.classList.add('translate-y-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    }
    </script>
    <script>
    const minRange = document.getElementById('minRange');
    const maxRange = document.getElementById('maxRange');
    const priceLabel = document.getElementById('priceLabel');
    const sliderTrack = document.getElementById('sliderTrack');

    function updateSlider() {
        let minVal = parseInt(minRange.value);
        let maxVal = parseInt(maxRange.value);

        // જો min કિંમત max થી વધી જાય તો અટકાવો
        if (minVal > maxVal) {
            let temp = minVal;
            minVal = maxVal;
            maxVal = temp;
        }

        // લેબલ અપડેટ કરો
        priceLabel.innerHTML = `₹${minVal.toLocaleString()} - ₹${maxVal.toLocaleString()}`;

        // સ્લાઈડર ટ્રેક (કલર પટ્ટી) અપડેટ કરો
        const percent1 = (minVal / minRange.max) * 100;
        const percent2 = (maxVal / maxRange.max) * 100;
        sliderTrack.style.left = percent1 + "%";
        sliderTrack.style.width = (percent2 - percent1) + "%";
    }

    minRange.addEventListener('input', updateSlider);
    maxRange.addEventListener('input', updateSlider);

    // પેજ લોડ થાય ત્યારે ફંક્શન એકવાર રન કરો
    updateSlider();
    </script>
    <script>
    function addToInquiry(productId, minQty) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('qty', minQty); // એડમિન દ્વારા સેટ કરેલી મિનિમમ ક્વોન્ટિટી ઓટોમેટિક જશે
        formData.append('add_to_list', true);

        fetch('add_to_inquiry.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // પ્રોડક્ટ એડ થયા પછી સુંદર મેસેજ બતાવો
                showToast("Product added to your inquiry list!");

                // જો તમે ઈચ્છો તો અહીં હેડરમાં રહેલા કાર્ટ કાઉન્ટને પણ અપડેટ કરી શકો
            })
            .catch(error => console.error('Error:', error));
    }

    // સુંદર નોટિફિકેશન (Toast) માટેનું ફંક્શન
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className =
            "fixed bottom-10 right-10 bg-black text-white px-6 py-3 rounded-xl shadow-2xl z-[100] animate-bounce";
        toast.innerHTML = `<i class="fa fa-check-circle text-green-400 mr-2"></i> ${message}`;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>