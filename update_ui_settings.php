<?php
include 'db.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $key = mysqli_real_escape_string($conn, $_POST['key']);
    $status = (int)$_POST['status'];

    $query = "UPDATE site_settings SET is_enabled = $status WHERE feature_key = '$key'";
    if(mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>