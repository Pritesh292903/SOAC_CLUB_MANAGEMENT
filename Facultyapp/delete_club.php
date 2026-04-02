<?php
include '../database.php';

// CHECK ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_club.php");
    exit();
}

$id = (int)$_GET['id'];

// GET IMAGE NAME
$result = mysqli_query($con, "SELECT clubimage FROM clubs WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if ($row) {

    $image = $row['clubimage'];

    // SERVER PATH
    $filePath = __DIR__ . "/../uploads/" . $image;

    // DELETE IMAGE FILE
    if (!empty($image) && file_exists($filePath)) {
        unlink($filePath);
    }

    // DELETE FROM DATABASE
    mysqli_query($con, "DELETE FROM clubs WHERE id=$id");
}

// REDIRECT
header("Location: manage_clube.php");
exit();
?>