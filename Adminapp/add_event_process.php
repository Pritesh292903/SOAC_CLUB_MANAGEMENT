<?php
include "../database.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name = trim($_POST['eventName']);
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $description = trim($_POST['eventDescription']);

    $imageName = "";

    // IMAGE UPLOAD
    if(isset($_FILES['eventImage']['name']) && $_FILES['eventImage']['name'] != ""){
        $folder = "../uploads/events/"; // separate folder for events
        if(!is_dir($folder)){ 
            mkdir($folder, 0777, true); 
        }

        // Optional: validate image type
        $ext = strtolower(pathinfo($_FILES['eventImage']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if(!in_array($ext, $allowed)){
            echo "Invalid image format! Only JPG, PNG, JPEG, WEBP allowed.";
            exit();
        }

        $imageName = time() . "_" . basename($_FILES['eventImage']['name']);
        $imagePath = $folder . $imageName;

        if(!move_uploaded_file($_FILES['eventImage']['tmp_name'], $imagePath)){
            echo "Failed to upload image!";
            exit();
        }

        // Save relative path for frontend
        $imageName = "uploads/events/" . $imageName;
    }

    $query = "INSERT INTO events (image, name, date, status, description) 
              VALUES ('$imageName','$name','$date','$status','$description')";

    if(mysqli_query($con,$query)){
        echo "success";
    } else {
        echo "Database Error: " . mysqli_error($con);
    }
}
?>  