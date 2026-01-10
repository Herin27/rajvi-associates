<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // સુરક્ષા માટે તપાસો કે આ કેટેગરીમાં કોઈ પ્રોડક્ટ્સ તો નથી ને?
    $check = $conn->query("SELECT id FROM products WHERE category_id = $id");
    
    if ($check->num_rows > 0) {
        echo "<script>alert('આ કેટેગરી ડિલીટ ના થઈ શકે કારણ કે તેમાં પ્રોડક્ટ્સ છે!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        // ઇમેજ ફાઇલ પણ સર્વરમાંથી ડિલીટ કરવી હોય તો:
        $res = $conn->query("SELECT image_path FROM categories WHERE id = $id");
        $cat = $res->fetch_assoc();
        if (!empty($cat['image_path']) && file_exists($cat['image_path'])) {
            unlink($cat['image_path']);
        }

        $conn->query("DELETE FROM categories WHERE id = $id");
        header("Location: admin_dashboard.php?success=Category Deleted");
    }
}
?>