<?php
session_start();
include '../database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ Correct Path (tamara structure pramane)
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if(isset($_POST['email'])){

    $email = mysqli_real_escape_string($con, $_POST['email']);

    // CHECK EMAIL EXISTS
    $check = mysqli_query($con, "SELECT * FROM Faculty_register WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        // GENERATE OTP
        $otp = rand(100000,999999);

        // DELETE OLD OTP
        mysqli_query($con, "DELETE FROM password_resets WHERE email='$email'");

        // INSERT NEW OTP
        mysqli_query($con, "INSERT INTO password_resets (email, otp) VALUES ('$email','$otp')");

        $mail = new PHPMailer(true);

        try{
            // ✅ SMTP CONFIG (FINAL WORKING)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            // 🔴 REPLACE WITH YOUR EMAIL
            $mail->Username = 'soeyashgiri@gmail.com';
            $mail->Password = 'xvauxmhhjslhqhdt';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // ✅ IMPORTANT FIX (SSL ISSUE REMOVE)
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // OPTIONAL DEBUG (remove later)
            // $mail->SMTPDebug = 2;
            // $mail->Debugoutput = 'html';

            // EMAIL DETAILS
            $mail->setFrom('soeyashgiri@gmail.com', 'SOAC Club');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'OTP Verification';
            $mail->Body = "
                <h2>Password Reset OTP</h2>
                <p>Your OTP is:</p>
                <h1 style='color:red;'>$otp</h1>
                <p>This OTP is valid for 5 minutes.</p>
            ";

            // SEND EMAIL
            $mail->send();

            $_SESSION['email'] = $email;
            $_SESSION['success'] = "OTP sent successfully!";

            header("Location: verify_otp.php");
            exit();

        }catch(Exception $e){
            $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;
            header("Location: Forgotpassword.php");
            exit();
        }

    }else{
        $_SESSION['error'] = "Email not found!";
        header("Location: Forgotpassword.php");
        exit();
    }
}
?>