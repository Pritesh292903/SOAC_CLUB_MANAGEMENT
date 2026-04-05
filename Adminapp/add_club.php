<?php 
include 'admin_header.php'; 
include '../database.php';  

// Fetch Faculty Data
$faculty_query = "SELECT id, name FROM faculty_register WHERE role='faculty'";
$faculty_result = mysqli_query($con, $faculty_query);

// Insert Data
if(isset($_POST['submit']))
{
    $clubname = mysqli_real_escape_string($con, $_POST['clubname']);
    $faculty_id = intval($_POST['faculty']); // ✅ GET ID
    $totalmembers = intval($_POST['totalmembers']);
    $clubdescription = mysqli_real_escape_string($con, $_POST['clubdescription']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // ✅ GET FACULTY NAME FROM ID
    $getFaculty = mysqli_query($con, "SELECT name FROM faculty_register WHERE id='$faculty_id'");
    $fdata = mysqli_fetch_assoc($getFaculty);
    $faculty_name = $fdata['name'];

    // Handle image upload
    if(isset($_FILES['clubimage']) && $_FILES['clubimage']['error'] == 0)
    {
        $filename = time() . '_' . basename($_FILES['clubimage']['name']);
        $target_dir = "uploads/"; 

        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . $filename;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if(in_array($fileType, $allowed))
        {
            if(move_uploaded_file($_FILES['clubimage']['tmp_name'], $target_file))
            {
                // ✅ INSERT WITH faculty_id + faculty_name
                $query = "INSERT INTO clubs 
                (clubimage, clubname, faculty_id, faculty, totalmembers, clubdescription, status) 
                VALUES 
                ('$filename', '$clubname', '$faculty_id', '$faculty_name', '$totalmembers', '$clubdescription', '$status')";

                if(mysqli_query($con, $query))
                {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Club Added Successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../Adminapp/all_clubes_page.php';
                    });
                    </script>";
                }
                else
                {
                    $error = "DB Error: " . mysqli_error($con);
                }
            }
            else
            {
                $error = "Failed to upload image!";
            }
        }
        else
        {
            $error = "Invalid file type!";
        }
    }
    else
    {
        $error = "Please upload image!";
    }

    if(isset($error))
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Error!',
            text: '$error',
            icon: 'error'
        });
        </script>";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.card{border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05);}
.form-control, .form-select{border-radius:10px;}
.upload-box{border:2px dashed #ddd; padding:15px; border-radius:12px; text-align:center;}
.event-img{width:100%; max-height:250px; object-fit:cover; border-radius:12px;}
.input-error{border:2px solid red;}
.error-text{color:red; font-size:0.8rem;}
</style>

<div class="content">

<h4 class="fw-bold text-danger mb-4">Add New Club</h4>

<div class="card p-4">

<form method="POST" enctype="multipart/form-data">

<div class="row g-3">

<!-- IMAGE -->
<div class="col-12">
    <label>Club Image</label>
    <div class="upload-box">
        <img src="https://via.placeholder.com/800x250" id="preview" class="event-img">
        <input type="file" name="clubimage" id="image" class="form-control mt-2">
    </div>
</div>

<!-- CLUB NAME -->
<div class="col-md-6">
    <label>Club Name</label>
    <input type="text" name="clubname" class="form-control">
</div>

<!-- FACULTY -->
<div class="col-md-6">
    <label>Faculty</label>
    <select name="faculty" class="form-select">
        <option value="">Select Faculty</option>
        <?php
        while($row = mysqli_fetch_assoc($faculty_result))
        {
            // ✅ VALUE = ID
            echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
    </select>
</div>

<!-- MEMBERS -->
<div class="col-md-6">
    <label>Total Members</label>
    <input type="number" name="totalmembers" class="form-control">
</div>

<!-- STATUS -->
<div class="col-md-6">
    <label>Status</label>
    <select name="status" class="form-select">
        <option value="">Select</option>
        <option>Active</option>
        <option>Inactive</option>
    </select>
</div>

<!-- DESCRIPTION -->
<div class="col-12">
    <label>Description</label>
    <textarea name="clubdescription" class="form-control"></textarea>
</div>

</div>

<div class="mt-4">
    <button type="submit" name="submit" class="btn btn-danger">Save</button>
</div>

</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// Image Preview
$("#image").change(function(){
    let reader = new FileReader();
    reader.onload = function(e){
        $("#preview").attr("src", e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
});

// Validation
$("form").submit(function(e){
    let valid = true;

    $("input, select, textarea").each(function(){
        if($(this).val() == ""){
            $(this).addClass("input-error");
            valid = false;
        }
    });

    if(!valid){
        e.preventDefault();
        alert("Fill all fields!");
    }
});
</script>

<?php include 'admin_footer.php'; ?>