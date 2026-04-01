<?php
session_start();
include "../database.php";

// GET DATA
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// FETCH USER BY EMAIL ONLY
$query = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0){
    
    $row = mysqli_fetch_assoc($result);
    $dbPassword = $row['password'];

    // ✅ CHECK PASSWORD (PLAIN + HASH BOTH)
    if($password === $dbPassword || password_verify($password, $dbPassword))
    {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['fullname'];

        echo "success";
    }
    else
    {
        echo "Invalid password!";
    }

}else{
    echo "User not found!";
}
?>