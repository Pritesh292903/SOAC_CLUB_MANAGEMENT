<?php
$conn = mysqli_connect("localhost", "root", "", "your_db");

$email = $_POST['email'];

// Check user exists
$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if(mysqli_num_rows($result) > 0){

    $otp = rand(100000, 999999);
    $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    mysqli_query($conn, "UPDATE users SET otp='$otp', otp_expiry='$expiry' WHERE email='$email'");

    // Send Email (Use mail() or PHPMailer)
    mail($email, "Your OTP Code", "Your OTP is: $otp");

    header("Location: verify_otp.php?email=$email");
} else {
    echo "Email not found!";
}
?>  