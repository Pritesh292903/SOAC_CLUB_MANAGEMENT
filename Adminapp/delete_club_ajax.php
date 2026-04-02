<?php
include '../database.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    // delete image
    $img_query = mysqli_query($con, "SELECT clubimage FROM clubs WHERE id='$id'");
    $img_row = mysqli_fetch_assoc($img_query);
    if($img_row && file_exists("uploads/".$img_row['clubimage'])){
        unlink("uploads/".$img_row['clubimage']);
    }

    // delete record
    mysqli_query($con, "DELETE FROM clubs WHERE id='$id'");
    echo "success";
}
?>