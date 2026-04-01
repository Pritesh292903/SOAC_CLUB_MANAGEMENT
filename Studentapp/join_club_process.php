<?php
session_start();
include "../database.php";

if(!isset($_SESSION['user_id'])){
    echo "login_required";
    exit();
}

$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$club_name = $_POST['club_name'];
$message = $_POST['message'];

// INSERT QUERY
$query = "INSERT INTO club_join (user_id, name, email, phone, club_name, message) 
          VALUES ('$user_id','$name','$email','$phone','$club_name','$message')";

if(mysqli_query($con, $query)){
    echo "success";
}else{
    echo "error";
}
?>