<?php
include "../database.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name = $_POST['eventName'];
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $description = $_POST['eventDescription'];

    $imageName = "";

    if(isset($_FILES['eventImage']['name']) && $_FILES['eventImage']['name'] != ""){
        $folder = "../uploads/";

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $imageName = time() . "_" . $_FILES['eventImage']['name'];
        move_uploaded_file($_FILES['eventImage']['tmp_name'], $folder.$imageName);
    }

    $query = "INSERT INTO events (image, name, date, status, description) 
              VALUES ('$imageName','$name','$date','$status','$description')";

    if(mysqli_query($con,$query)){
        echo "success";
    }else{
        echo "Database Error!";
    }
}
?>