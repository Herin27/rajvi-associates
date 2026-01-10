<?php
$conn = new mysqli("localhost", "root", "", "rajvi-associates");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // પહેલા ચેક કરો કે આ પ્રોડક્ટ કોઈ ઇન્ક્વાયરીમાં જોડાયેલી છે કે નહીં (Foreign Key Constraint માટે)
    $sql = "DELETE FROM products WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: admin_dashboard.php?success=Product Deleted");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>