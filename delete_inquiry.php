<?php
$conn = new mysqli("localhost", "root", "", "rajvi-associates");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // 1. પહેલા inquiry_items માંથી આ ID ના રેકોર્ડ કાઢો
    $conn->query("DELETE FROM inquiry_items WHERE inquiry_id = $id");
    
    // 2. હવે મુખ્ય inquiry ડિલીટ કરો
    if ($conn->query("DELETE FROM inquiries WHERE id = $id")) {
        header("Location: admin_dashboard.php?deleted=1");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>