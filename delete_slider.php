<?php
include 'db.php';
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $find = mysqli_query($conn, "SELECT image_path FROM sliders WHERE id=$id");
    $data = mysqli_fetch_assoc($find);
    if($data && file_exists($data['image_path'])) { unlink($data['image_path']); }

    mysqli_query($conn, "DELETE FROM sliders WHERE id=$id");
    header("Location: admin_dashboard.php?success=Slider Deleted");
}
?>