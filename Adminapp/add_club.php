<?php
include 'admin_header.php';   // HEADER INCLUDE
include '../database.php';

if(isset($_POST['submit']))
{
    $clubname = $_POST['clubname'];
    $faculty = $_POST['faculty'];
    $totalmembers = $_POST['totalmembers'];
    $status = $_POST['status'];

    // Image Upload
    $filename = $_FILES['clubimage']['name'];
    $tempname = $_FILES['clubimage']['tmp_name'];
    $folder = "uploads/".$filename;

    move_uploaded_file($tempname, $folder);

    // Insert Query
    $query = "INSERT INTO clubs (clubimage, clubname, faculty, totalmembers, status)
              VALUES ('$filename', '$clubname', '$faculty', '$totalmembers', '$status')";

    if(mysqli_query($con, $query))
    {
        echo "<script>alert('Club Added Successfully');</script>";
    }
    else
    {
        echo "<script>alert('Error');</script>";
    }
}
?>

<style>
    .container {
        width: 400px;
        margin: 40px auto;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        font-weight: 500;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin: 8px 0 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    input:focus, select:focus {
        border-color: #3498db;
        outline: none;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background: #2980b9;
    }
</style>

<div class="container">
    <h2>Add Club</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Club Image:</label>
        <input type="file" name="clubimage" required>

        <label>Club Name:</label>
        <input type="text" name="clubname" required>

        <label>Faculty:</label>
        <input type="text" name="faculty" required>

        <label>Total Members:</label>
        <input type="number" name="totalmembers" required>

        <label>Status:</label>
        <select name="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>

        <button type="submit" name="submit">Save Club</button>

    </form>
</div>

<?php include 'admin_footer.php'; // FOOTER INCLUDE ?>