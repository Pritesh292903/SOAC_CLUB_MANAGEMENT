<?php
include "../database.php";
session_start();

$id = $_POST['id'];
$type = $_POST['type'];
$name = $_POST['name'];
$email = $_POST['email'];

$imageName = "";

// IMAGE UPLOAD
if (!empty($_FILES['image']['name'])) {
    $imageName = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
}

if ($type == 'faculty') {

    // 🔥 Faculty uses 'name'
    if ($imageName != '') {
        $query = "UPDATE Faculty_register 
                  SET name='$name', email='$email', image='$imageName' 
                  WHERE id=$id";
    } else {
        $query = "UPDATE Faculty_register 
                  SET name='$name', email='$email' 
                  WHERE id=$id";
    }

} else {

    // 🔥 User uses 'fullname'
    if ($imageName != '') {
        $query = "UPDATE User 
                  SET fullname='$name', email='$email', clubimage='$imageName' 
                  WHERE id=$id";
    } else {
        $query = "UPDATE User 
                  SET fullname='$name', email='$email' 
                  WHERE id=$id";
    }
}

// EXECUTE
if (mysqli_query($con, $query)) {
    $_SESSION['success'] = "User updated successfully!";
} else {
    $_SESSION['error'] = "Error: " . mysqli_error($con);
}

// REDIRECT BACK
header("Location: update_user_form.php?id=$id&type=$type");
exit();
?>