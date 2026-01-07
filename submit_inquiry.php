<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // ૧. ગ્રાહકની વિગત inquiries ટેબલમાં ઉમેરો
    $query = "INSERT INTO inquiries (customer_name, phone, message, status) VALUES ('$name', '$phone', '$message', 'New')";
    
    if (mysqli_query($conn, $query)) {
        $inquiry_id = mysqli_insert_id($conn); // છેલ્લે ઉમેરાયેલી ID મેળવો

        // ૨. કાર્ટમાં રહેલી દરેક પ્રોડક્ટને inquiry_items માં ઉમેરો
        foreach ($_SESSION['cart'] as $product_id => $qty) {
            $product_id = mysqli_real_escape_string($conn, $product_id);
            $qty = mysqli_real_escape_string($conn, $qty);
            
            $item_query = "INSERT INTO inquiry_items (inquiry_id, product_id, quantity) VALUES ('$inquiry_id', '$product_id', '$qty')";
            mysqli_query($conn, $item_query);
        }

        // ૩. ઇન્ક્વાયરી સફળતાપૂર્વક સબમિટ થયા પછી કાર્ટ ખાલી કરો
        unset($_SESSION['cart']);

        echo "<script>
                alert('તમારી ઇન્ક્વાયરી સફળતાપૂર્વક મોકલવામાં આવી છે!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: inquiry-list.php");
}
?>