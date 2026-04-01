<?php
session_start();
include '../database.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

// Check if email exists in session
if(!isset($_SESSION['email'])){
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['email'];
$otp = rand(100000,999999);

// Insert OTP into database
mysqli_query($con, "INSERT INTO password_resets (email, otp) VALUES ('$email','$otp')");

// Send OTP via PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'soeyashgiri@gmail.com'; // your Gmail
    $mail->Password   = 'xvauxmhhjslhqhdt';      // app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
    $mail->Port       = 587;

    // ✅ Fix SSL certificate verification
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom('soeyashgiri@gmail.com', 'OTP Verification');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Resend OTP';
    $mail->Body    = "<h2>Your new OTP is: $otp</h2>";

    $mail->send();
    header("Location: verify_otp.php");
    exit();

} catch (Exception $e) {
    echo "Error sending OTP: " . $mail->ErrorInfo;
}
?>