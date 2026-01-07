<?php
session_start();

if(isset($_POST['add_to_list'])) {
    $id = $_POST['product_id'];
    $qty = $_POST['qty'];

    // જો કાર્ટ પહેલેથી ન હોય તો એરે બનાવો
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // પ્રોડક્ટને સેસનમાં સ્ટોર કરો (જો પહેલેથી હોય તો ક્વોન્ટિટી અપડેટ થશે)
    $_SESSION['cart'][$id] = $qty;

    // ઇન્ક્વાયરી લિસ્ટ પેજ પર રીડાયરેક્ટ કરો
    header('Location: inquiry-list.php');
    exit();
}
?>