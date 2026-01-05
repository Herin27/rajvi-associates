<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    
    // ૧. Inquiry મેઈન ટેબલમાં સેવ કરો
    $query = "INSERT INTO inquiries (name, email, phone, message, date) VALUES ('$name', '$email', '$phone', '$msg', NOW())";
    mysqli_query($conn, $query);
    $inquiry_id = mysqli_insert_id($conn);

    // ૨. પ્રોડક્ટ્સની લિસ્ટ લૂપ દ્વારા સેવ કરો
    foreach ($_SESSION['cart'] as $id => $qty) {
        mysqli_query($conn, "INSERT INTO inquiry_items (inquiry_id, product_id, quantity) VALUES ('$inquiry_id', '$id', '$qty')");
    }

    // ૩. સેશન ખાલી કરો
    unset($_SESSION['cart']);

    echo "<script>alert('તમારી ઇન્ક્વાયરી સફળતાપૂર્વક મોકલવામાં આવી છે. અમે ટૂંક સમયમાં સંપર્ક કરીશું.'); window.location='index.php';</script>";
}
?>