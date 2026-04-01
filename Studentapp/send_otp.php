<?php
session_start();
include '../database.php';

$email = $_POST['email'];

// Check email exists
$check = mysqli_query($con, "SELECT * FROM Faculty_register WHERE email='$email'");

if(mysqli_num_rows($check) > 0){

    $otp = rand(100000,999999);

    mysqli_query($con, "INSERT INTO password_resets (email, otp) VALUES ('$email','$otp')");

    $_SESSION['email'] = $email;

    // EMAIL SEND
    $subject = "OTP Verification";
    $message = "Your OTP is: $otp";
    $headers = "From: no-reply@test.com";

    mail($email,$subject,$message,$headers);

    header("Location: verify_otp.php");
}else{
    echo "<script>alert('Email not found');window.location='forgot_password.php';</script>";
}
?>