<?php
include '../database.php';

// CHECK ID
if (!isset($_GET['id'])) {
    header("Location: manage_club.php");
    exit();
}

$id = $_GET['id'];

// FETCH CLUB DATA (for image delete)
$result = mysqli_query($con, "SELECT * FROM clubs WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: manage_club.php");
    exit();
}

// DELETE IMAGE FILE
if (!empty($row['clubimage'])) {
    $imagePath = "../uploads/" . $row['clubimage'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// DELETE FROM DATABASE
$delete = "DELETE FROM clubs WHERE id='$id'";

if (mysqli_query($con, $delete)) {
    echo "<script>alert('Club Deleted Successfully'); window.location='manage_club.php';</script>";
} else {
    echo "<script>alert('Delete Failed'); window.location='manage_club.php';</script>";
}
?>