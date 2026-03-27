<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy session
session_destroy();

// FORCE REDIRECT
header("Location: ../Studentapp/login_view.php");
exit(); // ✅ VERY IMPORTANT
?>