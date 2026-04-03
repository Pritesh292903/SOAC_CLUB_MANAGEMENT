<?php
include '../database.php';
mysqli_select_db($con, "SOAE_CLUB");

if(!isset($_POST['action'], $_POST['id'], $_POST['type'])){
    exit('Invalid request');
}

$action = $_POST['action']; // approve or reject
$id = intval($_POST['id']);
$type = $_POST['type'];

// Determine table
if($type === 'club'){
    $table = 'club_join_requests';
} elseif($type === 'event'){
    $table = 'event_join_requests';
} else {
    exit('Invalid type');
}

// Determine new status
if($action === 'approve'){
    $status = 'approved';
} elseif($action === 'reject'){
    $status = 'rejected';
} else {
    exit('Invalid action');
}

// Update status
$sql = "UPDATE `$table` SET status='$status' WHERE id='$id' LIMIT 1";
if(mysqli_query($con, $sql)){
    echo ucfirst($action) . "d successfully!";
} else {
    echo "Error: " . mysqli_error($con);
}