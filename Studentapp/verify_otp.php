<?php
session_start();
include '../database.php';

if(!isset($_SESSION['email'])){
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['email'];
$error = "";

if(isset($_POST['verify'])){

    $otp = $_POST['otp'];

    $check = mysqli_query($con,"SELECT * FROM password_resets 
                               WHERE email='$email' 
                               ORDER BY id DESC LIMIT 1");

    $row = mysqli_fetch_assoc($check);

    if($row && $row['otp'] == $otp){

        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.php");
        exit();

    }else{
        $error = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>
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
.timer{
    margin-top:10px;
}
.error{color:red;}
</style>
</head>

<body>

<div class="box">
<h2>Verify OTP</h2>
<p>Enter OTP sent to your email</p>

<p class="error"><?php echo $error; ?></p>

<form method="POST">
<input type="number" name="otp" placeholder="Enter OTP" required>
<button name="verify">Verify</button>
</form>

<div class="timer">
OTP expires in <span id="time">60</span> sec
</div>

<p id="resend" style="display:none;">
<a href="resend_otp.php">Resend OTP</a>
</p>
</div>

<script>
let t=60;
let timer=setInterval(()=>{
t--;
document.getElementById("time").innerHTML=t;
if(t<=0){
clearInterval(timer);
document.getElementById("resend").style.display="block";
}
},1000);
</script>

</body>
</html>