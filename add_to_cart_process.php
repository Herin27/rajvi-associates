<?php
session_start();
header('Content-Type: application/json');
ob_clean();

if (isset($_POST['product_id'])) {
    $p_id = $_POST['product_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // પ્રોડક્ટ એડ અથવા અપડેટ કરો
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id] += $qty;
    } else {
        $_SESSION['cart'][$p_id] = $qty;
    }

    // યુનિક પ્રોડક્ટ્સની સંખ્યા ગણવા માટે count() વાપરો (array_sum નહીં)
    $new_count = count($_SESSION['cart']); 

    echo json_encode([
        'success' => true,
        'new_count' => $new_count
    ]);
} else {
    echo json_encode(['success' => false]);
}
exit;