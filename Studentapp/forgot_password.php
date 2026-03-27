<?php
include "../database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: linear-gradient(120deg, #9b0000, #d90429);
}

.card{
    width:350px;
    padding:25px;
    border-radius:15px;
}
</style>
</head>

<body>

<div class="card">

<h4 class="text-center mb-3">Forgot Password</h4>

<form method="POST">

    <!-- EMAIL -->
    <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>

    <!-- NEW PASSWORD -->
    <input type="password" name="new_password" class="form-control mb-3" placeholder="New Password" required>

    <button type="submit" name="reset" class="btn btn-danger w-100">Reset Password</button>

</form>

<?php

if(isset($_POST['reset']))
{
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // CHECK EMAIL EXISTS
    $check = mysqli_query($con,"SELECT * FROM User WHERE email='$email'");

    if(mysqli_num_rows($check) > 0)
    {
        // UPDATE PASSWORD
        mysqli_query($con,"UPDATE User SET password='$new_password' WHERE email='$email'");

        echo "<script>alert('Password Updated Successfully'); window.location='login_view.php';</script>";
    }
    else
    {
        echo "<script>alert('Email Not Found');</script>";
    }
}

?>

</div>

</body>
</html>