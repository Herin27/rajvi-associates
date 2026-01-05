<?php
session_start();
if (isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    if ($action == 'plus') {
        $_SESSION['cart'][$id]++;
    } elseif ($action == 'minus') {
        if ($_SESSION['cart'][$id] > 1) $_SESSION['cart'][$id]--;
    } elseif ($action == 'update') {
        $_SESSION['cart'][$id] = ($qty > 0) ? $qty : 1;
    } elseif ($action == 'remove') {
        unset($_SESSION['cart'][$id]);
    }
}
?>