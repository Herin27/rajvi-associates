<?php
include('db.php');

if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    
    // Khali Categories search karva mate
    $cat_res = mysqli_query($conn, "SELECT * FROM categories WHERE name LIKE '%$search%' LIMIT 6");

    if (mysqli_num_rows($cat_res) > 0) {
        echo '<div class="animate__animated animate__fadeIn">';
        echo '<h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Matching Collections</h3>';
        echo '<div class="grid grid-cols-2 gap-4">';
        
        while ($cat = mysqli_fetch_assoc($cat_res)) {
            echo '
            <a href="category_page.php?id='.$cat['id'].'" class="flex items-center gap-4 p-3 rounded-xl border border-gray-100 hover:border-yellow-500 hover:bg-yellow-50 transition-all group">
                <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                    <img src="'.$cat['image_path'].'" class="w-full h-full object-cover group-hover:scale-110 transition-transform shadow-sm">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-sm group-hover:text-yellow-600">'.$cat['name'].'</h4>
                    <p class="text-[10px] text-gray-400">Explore Items</p>
                </div>
            </a>';
        }
        
        echo '</div></div>';
    } else {
        echo '<div class="py-10 text-center">
                <i class="fa fa-search-minus text-gray-200 text-4xl mb-3"></i>
                <p class="text-gray-400 text-sm italic">Haji koi matching category nathi mali...</p>
              </div>';
    }
}
?>