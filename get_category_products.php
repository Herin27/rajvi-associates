<?php
include 'db.php';

if(isset($_GET['cat_id'])) {
    $cat_id = (int)$_GET['cat_id'];
    
    // કેટેગરી મુજબ પ્રોડક્ટ્સ મેળવવાની ક્વેરી
    $sql = "SELECT * FROM products WHERE category_id = $cat_id ORDER BY id DESC";
    $res = $conn->query($sql);
    

    if($res->num_rows > 0) {
        while($p = $res->fetch_assoc()) {
            // ઈમેજ પાથ સેટિંગ્સ
            $img = !empty($p['image']) ? "uploads/".$p['image'] : "https://via.placeholder.com/150";
            
            // સ્ટોક સ્ટેટસ કલર લોજિક
            $status_color = ($p['stock_status'] == 'In Stock') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
            
            echo '
            <div class="bg-white group rounded-[2.5rem] border border-gray-100 p-5 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-100/40 hover:-translate-y-2">
                
                <div class="relative h-52 w-full bg-gray-50 rounded-[2rem] overflow-hidden mb-6">
                    <img src="'.$img.'" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span class="'.$status_color.' text-[9px] font-black uppercase tracking-widest px-4 py-2 rounded-full shadow-sm backdrop-blur-sm">
                            '.$p['stock_status'].'
                        </span>
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">SKU: '.$p['sku'].'</span>
                        <div class="flex items-center gap-1 text-yellow-400 text-[10px]">
                            <i class="fas fa-star"></i>
                            <span class="font-bold text-gray-600">'.$p['rating'].'</span>
                        </div>
                    </div>

                    <h4 class="text-xl font-black text-gray-800 leading-tight mb-4 group-hover:text-blue-600 transition-colors line-clamp-1">
                        '.$p['product_name'].'
                    </h4>
                    
                    <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter line-through decoration-red-400">₹'.$p['original_price'].'</span>
                            <span class="text-2xl font-black text-gray-900 tracking-tighter">₹'.$p['discounted_price'].'</span>
                        </div>
                        
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                            <a href="admin_edit_product.php?id='.$p['id'].'" class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit Product">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            
                            <a href="delete_product.php?id='.$p['id'].'" onclick="return confirm(\'શું તમે ખરેખર આ પ્રોડક્ટ ડિલીટ કરવા માંગો છો?\')" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Delete Product">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        // Empty state remains same as before
        echo '
        <div class="col-span-full py-24 flex items-center justify-center">
            <div class="text-center space-y-4">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-2 border-2 border-dashed border-blue-100 animate-pulse">
                    <i class="fas fa-box-open text-blue-200 text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-gray-800 tracking-tight">આ કેટેગરી ખાલી છે</h3>
                <p class="text-gray-400 text-sm max-w-xs mx-auto">અહીં કોઈ પ્રોડક્ટ્સ મળ્યા નથી. નવી પ્રોડક્ટ ઉમેરવા માટે બટનનો ઉપયોગ કરો.</p>
            </div>
        </div>';
    }
}
?>