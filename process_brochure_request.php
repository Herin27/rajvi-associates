<?php
// ફાઇલની શરૂઆતમાં જ આ લાઇન મૂકો જેથી અગાઉનું કોઈ આઉટપુટ ક્લિયર થઈ જાય
ob_start();
include 'db.php';
ob_end_clean(); // db.php માં રહેલું કોઈપણ HTML લખાણ સાફ કરી નાખશે

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ડેટા મેળવો
    $name = mysqli_real_escape_string($conn, $_POST['u_name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['u_email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['u_phone'] ?? '');
    $product = mysqli_real_escape_string($conn, $_POST['product_name'] ?? '');

    // રિસ્પોન્સ મોકલો
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
exit;
?>