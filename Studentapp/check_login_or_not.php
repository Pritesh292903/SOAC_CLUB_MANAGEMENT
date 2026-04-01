<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login_view.php");
    exit();
}
?>