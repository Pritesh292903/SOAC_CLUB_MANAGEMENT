<?php  
include 'admin_header.php';  
include '../database.php';  

// Fetch Faculty Data
$faculty_query = "SELECT id, name FROM faculty_register WHERE role='faculty'";
$faculty_result = mysqli_query($con, $faculty_query);

// ✅ KEEP YOUR ORIGINAL LOGIC
if(isset($_POST['submit']))
{
    $clubname = mysqli_real_escape_string($con, $_POST['clubname']);
    $faculty_id = intval($_POST['faculty']);
    $totalmembers = intval($_POST['totalmembers']);
    $clubdescription = mysqli_real_escape_string($con, $_POST['clubdescription']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $club_paid = mysqli_real_escape_string($con, $_POST['club_paid']);

    $getFaculty = mysqli_query($con, "SELECT name FROM faculty_register WHERE id='$faculty_id'");
    $fdata = mysqli_fetch_assoc($getFaculty);
    $faculty_name = $fdata['name'];

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
                $query = "INSERT INTO clubs 
                (clubimage, clubname, faculty_id, faculty, totalmembers, clubdescription, status, club_paid) 
                VALUES 
                ('$filename', '$clubname', '$faculty_id', '$faculty_name', '$totalmembers', '$clubdescription', '$status', '$club_paid')";

                if(mysqli_query($con, $query))
                {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Club Added Successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = '../Adminapp/all_clubes_page.php';
                    });
                    </script>";
                }
                else
                {
                    $error = mysqli_error($con);
                }
            }
            else
            {
                $error = "Image upload failed";
            }
        }
        else
        {
            $error = "Invalid file type";
        }
    }
    else
    {
        $error = "Image required";
    }

    if(isset($error))
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire('Error', '$error', 'error');
        </script>";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.card{border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05);}
.form-control, .form-select{border-radius:10px;}

.upload-box{
    border:2px dashed #ddd;
    padding:15px;
    border-radius:12px;
    text-align:center;
}

.event-img{
    width:100%;
    max-height:250px;
    object-fit:cover;
    border-radius:12px;
}

/* ✅ VALIDATION COLORS */
.input-success{
    border:2px solid #28a745 !important;
}
.input-error{
    border:2px solid red !important;
}

.error-text{
    color:red;
    font-size:0.8rem;
}
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
        while($row = mysqli_fetch_assoc($faculty_result)){
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

<!-- CLUB TYPE -->
<div class="col-md-6">
    <label>Club Type</label>
    <select name="club_paid" class="form-select">
        <option value="">Select</option>
        <option value="Paid">Paid</option>
        <option value="Unpaid">Unpaid</option>
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

// LIVE VALIDATION (GREEN)
$("input, select, textarea").on("input change", function(){
    if($(this).val().trim() != ""){
        $(this).removeClass("input-error").addClass("input-success");
        $(this).next(".error-text").remove();
    }else{
        $(this).removeClass("input-success");
    }
});

// FORM VALIDATION (NO AJAX)
$("form").submit(function(e){

    let valid = true;

    $(".error-text").remove();
    $("input, select, textarea").removeClass("input-error");

    function showError(el, msg){
        el.removeClass("input-success")
          .addClass("input-error")
          .after("<div class='error-text'>"+msg+"</div>");
        valid = false;
    }

    let clubname = $("input[name='clubname']");
    let faculty = $("select[name='faculty']");
    let members = $("input[name='totalmembers']");
    let status = $("select[name='status']");
    let type = $("select[name='club_paid']");
    let desc = $("textarea[name='clubdescription']");
    let image = $("#image");

    if(clubname.val().trim() == "") showError(clubname, "Enter club name");
    if(faculty.val() == "") showError(faculty, "Select faculty");
    if(members.val() == "" || members.val() <= 0) showError(members, "Enter valid members");
    if(status.val() == "") showError(status, "Select status");
    if(type.val() == "") showError(type, "Select club type");
    if(desc.val().trim() == "") showError(desc, "Enter description");
    if(image.val() == "") showError(image, "Upload image");

    if(!valid){
        e.preventDefault(); // stop only if error
    }

});
</script>

<?php include 'admin_footer.php'; ?>