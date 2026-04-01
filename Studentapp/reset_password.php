<?php
session_start();
include '../database.php';

if(!isset($_SESSION['otp_verified'])){
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['email'];
$error="";

if(isset($_POST['reset'])){

    $pass=$_POST['password'];
    $cpass=$_POST['cpassword'];

    if($pass==$cpass){

        mysqli_query($con,"UPDATE Faculty_register SET password='$pass' WHERE email='$email'");

        session_destroy();

        echo "<script>alert('Password Updated Successfully'); window.location='login_view.php';</script>";

    }else{
        $error="Password not match!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<style>
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(120deg,#9b0000,#d90429);
    font-family:'Segoe UI';
}
.box{
    background:#fff;
    padding:30px;
    border-radius:18px;
    width:400px;
    text-align:center;
}
input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:12px;
    border:1px solid #ccc;
}
button{
    margin-top:15px;
    padding:12px;
    width:100%;
    border:none;
    border-radius:12px;
    background:linear-gradient(120deg,#9b0000,#d90429);
    color:#fff;
}
.error{color:red;}
</style>
</head>

<body>

<div class="box">
<h2>Reset Password</h2>

<p class="error"><?php echo $error; ?></p>

<form method="POST">
<input type="password" name="password" placeholder="New Password" required>
<input type="password" name="cpassword" placeholder="Confirm Password" required>
<button name="reset">Change Password</button>
</form>
</div>

</body>
</html>