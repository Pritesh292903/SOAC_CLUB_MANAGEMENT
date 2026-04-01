<?php
session_start();
include '../database.php';

// CHECK SESSION EMAIL
if (!isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['email'];

$error = "";

if (isset($_POST['verify'])) {

    $otp = $_POST['otp'];

    // CHECK OTP FROM DATABASE (latest OTP)
    $check = mysqli_query($con, "SELECT * FROM password_resets 
                                WHERE email='$email' 
                                ORDER BY id DESC LIMIT 1");

    $row = mysqli_fetch_assoc($check);

    if ($row && $row['otp'] == $otp) {

        // OTP CORRECT → ALLOW RESET
        $_SESSION['otp_verified'] = true;

        header("Location: reset_password.php");
        exit();

    } else {
        $error = "Invalid OTP! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify OTP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            height: 100vh;
        }
        .card{
            border-radius: 20px;
        }
        .btn-custom{
            background: #ff416c;
            color: white;
        }
        .btn-custom:hover{
            background: #ff4b2b;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    
    <div class="card shadow p-4" style="width:400px;">
        
        <h3 class="text-center mb-3">Verify OTP</h3>
        <p class="text-center text-muted">Enter the OTP sent to your email</p>

        <?php if($error != ""){ ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Enter OTP</label>
                <input type="number" name="otp" class="form-control" required placeholder="Enter 6-digit OTP">
            </div>

            <button type="submit" name="verify" class="btn btn-custom w-100">
                Verify OTP
            </button>

        </form>

    </div>

</div>

</body>
</html>