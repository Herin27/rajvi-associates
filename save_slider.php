<?php
include 'db.php';
if(isset($_POST['upload'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $target_dir = "uploads/";
    
    $file_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO sliders (title, subtitle, image_path) VALUES ('$title', '$subtitle', '$target_file')";
        mysqli_query($conn, $sql);
        header("Location: admin_dashboard.php?success=Slider Added");
    }
}
?>