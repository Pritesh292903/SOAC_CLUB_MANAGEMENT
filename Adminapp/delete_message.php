<?php
include '../database.php';

if (isset($_POST['id'])) {

    $id = intval($_POST['id']);

    $stmt = $con->prepare("DELETE FROM contact_us WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>