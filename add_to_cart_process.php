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

    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id] += $qty;
    } else {
        $_SESSION['cart'][$p_id] = $qty;
    }

    echo json_encode([
        'success' => true,
        'new_count' => array_sum($_SESSION['cart'])
    ]);
} else {
    echo json_encode(['success' => false]);
}
exit;