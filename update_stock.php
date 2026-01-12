<?php
session_start();
include 'db.php'; // ડેટાબેઝ કનેક્શન

// જો લોગિન ન હોય તો રીડાયરેક્ટ કરો
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // ડેટાબેઝ અપડેટ ક્વેરી
    $update_query = "UPDATE products SET stock_status = '$status' WHERE id = '$id'";

    if (mysqli_query($conn, $update_query)) {
        // સફળતાપૂર્વક અપડેટ થયા પછી પાછા ડેશબોર્ડ પર
        header("Location: admin_dashboard.php?success=Status Updated");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>