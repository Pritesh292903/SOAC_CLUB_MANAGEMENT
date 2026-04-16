<?php
include "../database.php";

if(isset($_POST['id']) && isset($_POST['type'])){

$id = intval($_POST['id']);
$type = $_POST['type'];

if($type == 'admin' || $type == 'student'){
$query = "DELETE FROM User WHERE id = $id";
}
elseif($type == 'faculty'){
$query = "DELETE FROM Faculty_register WHERE id = $id";
}

if(mysqli_query($con,$query)){
echo "success";
}else{
echo "error";
}

}
?>