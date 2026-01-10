<?php
$conn = new mysqli("localhost", "root", "", "rajvi-associates");

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = $conn->real_escape_string($_GET['status']);
    
    // Status અપડેટ કરવાની ક્વેરી
    $sql = "UPDATE inquiries SET status = '$status' WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: admin_dashboard.php?success=Status Updated");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>