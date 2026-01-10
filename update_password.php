<?php
session_start();
include 'db.php'; // તમારા ડેટાબેઝ કનેક્શનની ફાઇલ

// ચેક કરો કે યુઝર લોગિન છે કે નહીં
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_SESSION['admin_id'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // ૧. પાસવર્ડ ખાલી નથી ને તે ચેક કરો
    if (empty($new_pass) || empty($confirm_pass)) {
        header("Location: admin_dashboard.php?error=Password cannot be empty");
        exit();
    }

    // ૨. બંને પાસવર્ડ મેચ થાય છે કે નહીં તે ચેક કરો
    if ($new_pass !== $confirm_pass) {
        header("Location: admin_dashboard.php?error=Passwords do not match");
        exit();
    }

    // ૩. પાસવર્ડ અપડેટ કરો (અહીં mysqli_real_escape_string નો ઉપયોગ સુરક્ષા માટે જરૂરી છે)
    $secure_pass = mysqli_real_escape_string($conn, $new_pass);
    $update_sql = "UPDATE users SET password = '$secure_pass' WHERE id = '$admin_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Password Updated Successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>