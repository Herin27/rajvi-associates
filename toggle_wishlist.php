<?php
include 'db.php';
$p_id = $_POST['product_id'];
$ip = $_SERVER['REMOTE_ADDR'];

// ચેક કરો કે પ્રોડક્ટ છે કે નહીં
$check = mysqli_query($conn, "SELECT * FROM wishlist WHERE product_id = '$p_id' AND ip_address = '$ip'");

if(mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "DELETE FROM wishlist WHERE product_id = '$p_id' AND ip_address = '$ip'");
    $status = 'removed';
} else {
    mysqli_query($conn, "INSERT INTO wishlist (product_id, ip_address) VALUES ('$p_id', '$ip')");
    $status = 'added';
}

// નવો ટોટલ કાઉન્ટ મેળવો
$count_res = mysqli_query($conn, "SELECT id FROM wishlist WHERE ip_address = '$ip'");
$total_count = mysqli_num_rows($count_res);

echo json_encode(['status' => $status, 'count' => $total_count]);
?>