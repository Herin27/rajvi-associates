<?php
session_start();
include('db.php');
header('Content-Type: application/json');

// બધી અગાઉની આઉટપુટ ભૂંસી નાખો જેથી માત્ર JSON જ જાય
ob_clean();

$response = [
    'html' => '',
    'total' => '0.00',
    'count' => 0
];

$total_price = 0;
$cart_html = "";

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $p_id => $qty) {
        $p_id = mysqli_real_escape_string($conn, $p_id);
        $res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$p_id'");
        
        if ($row = mysqli_fetch_assoc($res)) {
            $price = (float)$row['discounted_price'];
            $subtotal = $price * $qty;
            $total_price += $subtotal;

            $cart_html .= '
            <div class="flex items-center gap-3 border-b border-gray-50 pb-2">
                <div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded overflow-hidden">
                    <img src="uploads/'.$row['image'].'" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-[11px] font-bold text-gray-800 truncate">'.$row['product_name'].'</h4>
                    <p class="text-[10px] text-gray-400">'.$qty.' x ₹'.number_format($price, 2).'</p>
                </div>
            </div>';
        }
    }
    
    // મહત્વનો ફેરફાર અહીં છે:
    $response['html'] = $cart_html;
    $response['total'] = number_format($total_price, 2);
    $response['count'] = count($_SESSION['cart']); // ફક્ત યુનિક પ્રોડક્ટ્સની સંખ્યા
    
} else {
    $response['html'] = '<p class="text-xs text-gray-400 text-center py-4 italic">Your bag is empty.</p>';
    $response['count'] = 0;
}

echo json_encode($response);
exit;