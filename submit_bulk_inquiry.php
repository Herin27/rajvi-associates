<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // ૧. ઇન્ક્વાયરીને ડેટાબેઝમાં સેવ કરો
    $query = "INSERT INTO inquiries (customer_name, phone, message, status, created_at) 
              VALUES ('$name', '$phone', '$message', 'New', NOW())";
    
    if (mysqli_query($conn, $query)) {
        $inquiry_id = mysqli_insert_id($conn);
        
        // ૨. કાર્ટમાં રહેલી બધી પ્રોડક્ટ્સને આ ઇન્ક્વાયરી સાથે જોડો
        foreach ($_SESSION['cart'] as $product_id => $qty) {
            mysqli_query($conn, "INSERT INTO inquiry_items (inquiry_id, product_id, quantity) 
                                 VALUES ('$inquiry_id', '$product_id', '$qty')");
        }
        
        // ૩. ઇન્ક્વાયરી સફળ થયા પછી કાર્ટ ખાલી કરો
        unset($_SESSION['cart']);
        
        echo "<script>alert('Your inquiry has been submitted successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
}
?>