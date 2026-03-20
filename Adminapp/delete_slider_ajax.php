<?php
include '../database.php';
$upload_dir = "slider_images/";

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $res = mysqli_query($con, "SELECT image FROM slider_images WHERE id='$id'");
    $img = mysqli_fetch_assoc($res);
    if($img){
        $file_path = $upload_dir . $img['image'];
        if(file_exists($file_path)){
            unlink($file_path);
        }
        mysqli_query($con, "DELETE FROM slider_images WHERE id='$id'");
        echo "success";
    } else {
        echo "notfound";
    }
} else {
    echo "invalid";
}
?>