<?php

// Database Connection
$con = mysqli_connect("localhost", "root", "");

// Check Connection
if (!$con) {
    die("Database Connection Failed");
}

// Create Database
mysqli_query($con, "CREATE DATABASE IF NOT EXISTS SOAE_CLUB");

// Select Database
mysqli_select_db($con, "SOAE_CLUB");

// Create User Table
$create_table = "CREATE TABLE IF NOT EXISTS User(
id INT AUTO_INCREMENT PRIMARY KEY,
clubimage VARCHAR(255),
fullname VARCHAR(100),
email VARCHAR(100),
department VARCHAR(100),
enrollment VARCHAR(100),
mobile VARCHAR(20),
password VARCHAR(100),
role ENUM('admin','faculty','user') DEFAULT 'user'
)";

mysqli_query($con, $create_table);


// Create Slider Table
mysqli_select_db($con, "SOAE_CLUB");
mysqli_query($con, "CREATE TABLE IF NOT EXISTS slider_images (

id INT AUTO_INCREMENT PRIMARY KEY,
image VARCHAR(255)

)");

?>