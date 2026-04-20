<?php
session_start();
include '../database.php';

$user_id = $_SESSION['user_id'] ?? 0;

$club_id = intval($_POST['club_id'] ?? 0);
$payment_id = $_POST['payment_id'] ?? '';

if($user_id && $club_id && $payment_id){

    $check = mysqli_query($con, "SELECT * FROM club_join_requests 
                                 WHERE user_id='$user_id' AND club_id='$club_id'");

    if(mysqli_num_rows($check) > 0){

        mysqli_query($con, "UPDATE club_join_requests 
                            SET status='approved', payment_id='$payment_id'
                            WHERE user_id='$user_id' AND club_id='$club_id'");

    } else {

        mysqli_query($con, "INSERT INTO club_join_requests 
        (user_id, club_id, status, payment_id)
        VALUES 
        ('$user_id','$club_id','approved','$payment_id')");
    }
}
?>