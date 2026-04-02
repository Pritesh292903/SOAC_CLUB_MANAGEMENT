<?php 
include 'admin_header.php'; 
include '../database.php';  

// Fetch Faculty Data
$faculty_query = "SELECT id, name FROM Faculty_register WHERE role='faculty'";
$faculty_result = mysqli_query($con, $faculty_query);

// Insert Data
if(isset($_POST['submit']))
{
    $clubname = mysqli_real_escape_string($con, $_POST['clubname']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $totalmembers = intval($_POST['totalmembers']);
    $clubdescription = mysqli_real_escape_string($con, $_POST['clubdescription']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Handle image upload
    if(isset($_FILES['clubimage']) && $_FILES['clubimage']['error'] == 0)
    {
        $filename = time() . '_' . basename($_FILES['clubimage']['name']); // unique name
        $target_dir = "uploads/"; 

        // Create folder if it doesn't exist
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
                // Insert into database
                $query = "INSERT INTO clubs (clubimage, clubname, faculty, totalmembers, clubdescription, status) 
                          VALUES ('$filename', '$clubname', '$faculty', '$totalmembers', '$clubdescription', '$status')";
                if(mysqli_query($con, $query))
                {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Club Added Successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../Adminapp/all_clubes_page.php';
                        }
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
                $error = "Failed to move uploaded file. Check folder permissions!";
            }
        }
        else
        {
            $error = "Invalid file type. Only JPG, JPEG, PNG, GIF allowed.";
        }
    }
    else
    {
        $error = "Please upload an image.";
    }

    if(isset($error))
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Error!',
            text: '$error',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        </script>";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from { opacity:0; transform:translateY(15px);} to { opacity:1; transform:translateY(0);} }

.card.custom-card{ border:none; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05); background:#fff; }
.form-label{ font-weight:600; font-size:0.9rem; }
.form-control, .form-select{ border-radius:10px; padding:10px; }
.btn-effect{ border-radius:50px; transition:0.3s; }
.btn-effect:hover{ transform:translateY(-2px); }

.event-img{ width:100%; max-height:250px; object-fit:cover; border-radius:12px; margin-bottom:10px; }
.upload-box{ border:2px dashed #ddd; padding:15px; border-radius:12px; text-align:center; background:#fafafa; }
.upload-box:hover{ border-color:#dc3545; }

/* Validation Styles */
.input-error { border: 2px solid #dc3545 !important; background: #fff5f5; }
.input-valid { border: 2px solid #28a745 !important; background: #f6fffa; }
.error-text { color: #dc3545; font-size: 0.8rem; margin-top: 4px; }
</style>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">Add New Club</h4>
        <a href="all_club_page.php" class="btn btn-outline-danger btn-effect">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card custom-card p-4">

        <form method="POST" enctype="multipart/form-data">

        <div class="row g-3">

            <!-- IMAGE -->
            <div class="col-12">
                <label class="form-label">Choose Club Image</label>
                <div class="upload-box">
                    <img src="https://via.placeholder.com/800x250?text=Club+Preview" class="event-img" id="clubImagePreview">
                    <input type="file" class="form-control mt-2" id="clubImage" name="clubimage" accept="image/*">
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Club Name *</label>
                <input type="text" class="form-control" name="clubname">
            </div>

            <div class="col-md-6">
                <label class="form-label">Faculty *</label>
                <select class="form-select" name="faculty">
                    <option value="">Select Faculty</option>
                    <?php
                    while($row = mysqli_fetch_assoc($faculty_result))
                    {
                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Total Members *</label>
                <input type="number" class="form-control" name="totalmembers">
            </div>

            <div class="col-md-6">
                <label class="form-label">Status *</label>
                <select class="form-select" name="status">
                    <option value="">Select Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Club Description *</label>
                <textarea class="form-control" rows="4" name="clubdescription"></textarea>
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" name="submit" class="btn btn-danger btn-effect">
                <i class="bi bi-save me-2"></i>Save Club
            </button>
            <a href="all_club_page.php" class="btn btn-outline-secondary btn-effect">Cancel</a>
        </div>

        </form>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function(){

    // IMAGE PREVIEW
    $("#clubImage").on("change", function(){
        let reader = new FileReader();
        reader.onload = function(e){
            $("#clubImagePreview").attr("src", e.target.result);
        }
        if(this.files[0]) reader.readAsDataURL(this.files[0]);
    });

    // REMOVE ERROR ON INPUT
    $("input, textarea, select").on("keyup change", function(){
        $(this).removeClass("input-error").addClass("input-valid");
        $(this).next(".error-text").remove();
    });

    // FORM VALIDATION
    $("form").on("submit", function(e){
        let valid = true;
        function showError(element, message){
            element.addClass("input-error").removeClass("input-valid");
            if(element.next(".error-text").length == 0){
                element.after("<div class='error-text'>" + message + "</div>");
            }
        }

        let clubname = $("input[name='clubname']");
        if(clubname.val().trim() == ""){ showError(clubname, "Club name is required"); valid = false; }

        let faculty = $("select[name='faculty']");
        if(faculty.val() == ""){ showError(faculty, "Please select faculty"); valid = false; }

        let members = $("input[name='totalmembers']");
        if(members.val() == "" || members.val() <= 0){ showError(members, "Enter valid number"); valid = false; }

        let status = $("select[name='status']");
        if(status.val() == ""){ showError(status, "Select status"); valid = false; }

        let desc = $("textarea[name='clubdescription']");
        if(desc.val().trim() == ""){ showError(desc, "Description required"); valid = false; }

        let image = $("#clubImage");
        if(image.val() == ""){ showError(image, "Upload image"); valid = false; }

        if(!valid) e.preventDefault();
    });

});
</script>

<?php include 'admin_footer.php'; ?>