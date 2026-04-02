<?php
include '../database.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $stmt = mysqli_prepare($con, "DELETE FROM events WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "Deleted";
}
?>