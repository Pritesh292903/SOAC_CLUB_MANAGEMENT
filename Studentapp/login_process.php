<?php
session_start();
include "../database.php";

$email = $_POST['email'];
$password = $_POST['password'];


// ================= USER LOGIN =================
$query = "SELECT * FROM User WHERE email='$email'";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    // ✅ FIX: support BOTH plain + hashed password
    if(password_verify($password, $row['password']) || $password == $row['password']){

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];

        echo $row['role']; // admin / user
        exit;
    }
}


// ================= FACULTY LOGIN =================
$query2 = "SELECT * FROM Faculty_register WHERE email='$email'";
$result2 = mysqli_query($con, $query2);

if(mysqli_num_rows($result2) > 0){

    $row = mysqli_fetch_assoc($result2);

    // ✅ FIX here also
    if(password_verify($password, $row['password']) || $password == $row['password']){

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['role'] = "faculty";

        echo "faculty";
        exit;
    }
}


// ❌ INVALID
echo "Invalid email or password!";
?>