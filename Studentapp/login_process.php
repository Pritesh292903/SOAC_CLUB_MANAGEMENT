<?php
session_start();
include "../database.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM User WHERE email='$email' AND password='$password'";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['fullname'];

    echo "success";
}else{
    echo "Invalid email or password!";
}
?>