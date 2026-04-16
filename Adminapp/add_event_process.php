<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = mysqli_real_escape_string($con, $_POST['eventName']);
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $desc = mysqli_real_escape_string($con, $_POST['eventDescription']);

    // IMAGE UPLOAD
    $imageName = "";

    if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == 0) {

        $ext = pathinfo($_FILES['eventImage']['name'], PATHINFO_EXTENSION);
        $imageName = time() . "_" . rand(1000,9999) . "." . $ext;

        $uploadPath = "../uploads/" . $imageName;

        if (!move_uploaded_file($_FILES['eventImage']['tmp_name'], $uploadPath)) {
            echo "Image upload failed!";
            exit;
        }
    }

    // INSERT
    $query = "INSERT INTO events (image, name, date, status, description) 
              VALUES ('$imageName', '$name', '$date', '$status', '$desc')";

    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "Database Error!";
    }
}
?>