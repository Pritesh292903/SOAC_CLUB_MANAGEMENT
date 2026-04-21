<?php
include '../database.php';

if(isset($_POST['action'])){

$action=$_POST['action'];

/* DELETE ALL */
if($action=='delete_all'){
mysqli_query($con,"DELETE FROM club_join_requests");
mysqli_query($con,"DELETE FROM event_join_requests");
echo "All requests deleted";
exit;
}

/* SINGLE */
$id=intval($_POST['id']);
$type=$_POST['type'];

if($action=='delete'){
$table=($type=='club')?'club_join_requests':'event_join_requests';
mysqli_query($con,"DELETE FROM $table WHERE id='$id'");
echo "Deleted";
exit;
}

$status=($action=='approve')?'approved':'rejected';
$table=($type=='club')?'club_join_requests':'event_join_requests';

mysqli_query($con,"UPDATE $table SET status='$status' WHERE id='$id'");
echo "Updated";
}
?>