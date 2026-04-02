<?php
include '../database.php';

// SELECT DATABASE
mysqli_select_db($con, "SOAE_CLUB");

// CHECK ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: Manage_events.php");
    exit();
}

$id = intval($_GET['id']);

// FETCH EVENT (for image delete)
$result = mysqli_query($con, "SELECT * FROM events WHERE id='$id'");

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: Manage_events.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

// DELETE IMAGE FILE (if exists)
if (!empty($row['image'])) {
    $imagePath = "../uploads/events/" . $row['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath); // delete image from folder
    }
}

// DELETE EVENT FROM DATABASE
$delete = mysqli_query($con, "DELETE FROM events WHERE id='$id'");

if ($delete) {
    header("Location: Manage_events.php");
    exit();
} else {
    echo "Delete Failed: " . mysqli_error($con);
}
?>