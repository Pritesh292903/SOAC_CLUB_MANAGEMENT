<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include "../database.php";

// CHECK LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: login_view.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH USER DATA
$result = mysqli_query($con,"SELECT * FROM User WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

// IMAGE PATH
$image_path = !empty($user['clubimage']) 
    ? "../uploads/" . $user['clubimage'] 
    : "assets/images/user.jpg";

// UPDATE DATA
if(isset($_POST['update_profile'])){

    $fullname   = mysqli_real_escape_string($con, $_POST['fullname']);
    $email      = mysqli_real_escape_string($con, $_POST['email']);
    $mobile     = mysqli_real_escape_string($con, $_POST['phone']);
    $department = mysqli_real_escape_string($con, $_POST['department']);

    $image_name = $user['clubimage'];

    // ✅ IMAGE VALIDATION + UPLOAD
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){

        $file_tmp  = $_FILES['photo']['tmp_name'];
        $file_name = $_FILES['photo']['name'];
        $file_size = $_FILES['photo']['size'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if(!in_array($ext, $allowed)){
            echo "<script>alert('Only JPG, JPEG, PNG allowed');</script>";
        }
        elseif($file_size > 3 * 1024 * 1024){
            echo "<script>alert('Max file size is 3MB');</script>";
        }
        else{
            $new_name = "user_" . time() . "." . $ext;
            $upload_path = "../uploads/" . $new_name;

            if(move_uploaded_file($file_tmp, $upload_path)){
                $image_name = $new_name;
            }
        }
    }

    // UPDATE QUERY
    $update = "UPDATE User SET 
        fullname='$fullname',
        email='$email',
        mobile='$mobile',
        department='$department',
        clubimage='$image_name'
        WHERE id='$user_id'";

    if(mysqli_query($con, $update)){
        header("Location: profile_view.php");
        exit();
    }
}
?>

<style>
label.error {
    color: red;
    font-size: 13px;
    margin-top: 5px;
}

input.error {
    border: 2px solid red !important;
    border-radius: 12px;
    padding-right: 35px;
}

input.valid {
    border: 2px solid green !important;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    right: 12px;
    top: 38px;
    color: red;
    font-weight: bold;
    display: none;
}
</style>

<div class="container my-5">
<div class="card shadow border-0 rounded-4">
<div class="card-body p-4">

<h2 class="fw-bold text-danger mb-4">
<i class="bi bi-person-circle me-2"></i>Edit Profile
</h2>

<div class="row">

<!-- LEFT IMAGE -->
<div class="col-md-4 text-center mb-4">

<img id="profilePreview"
src="<?php echo $image_path; ?>"
class="img-fluid rounded-circle shadow"
style="width:180px;height:180px;object-fit:cover;">

<button type="button" id="changePhotoBtn"
class="btn btn-outline-secondary btn-sm rounded-pill mt-3">
Change Photo
</button>

</div>

<!-- RIGHT FORM -->
<div class="col-md-8">

<form method="POST" enctype="multipart/form-data" id="editProfileForm">

<input type="file" name="photo" id="photoInput" accept="image/*" style="display:none;">

<!-- NAME -->
<div class="mb-3 input-wrapper">
<label class="form-label">Full Name</label>
<input type="text" name="fullname" class="form-control"
value="<?php echo $user['fullname']; ?>">
<span class="input-icon">!</span>
</div>

<!-- EMAIL -->
<div class="mb-3 input-wrapper">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control"
value="<?php echo $user['email']; ?>">
<span class="input-icon">!</span>
</div>

<!-- PHONE -->
<div class="mb-3 input-wrapper">
<label class="form-label">Phone</label>
<input type="text" name="phone" class="form-control"
value="<?php echo $user['mobile']; ?>">
<span class="input-icon">!</span>
</div>

<!-- DEPARTMENT -->
<div class="mb-3 input-wrapper">
<label class="form-label">Department</label>
<input type="text" name="department" class="form-control"
value="<?php echo $user['department']; ?>">
<span class="input-icon">!</span>
</div>

<div class="d-flex gap-3">
<button type="submit" name="update_profile"
class="btn btn-danger rounded-pill px-4">
Save Changes
</button>

<a href="profile_view.php"
class="btn btn-secondary rounded-pill px-4">
Cancel
</a>
</div>

</form>

</div>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
// IMAGE PREVIEW
$("#changePhotoBtn").click(function () {
    $("#photoInput").click();
});

$("#photoInput").change(function (event) {
    let file = event.target.files[0];
    if (file) {

        // ✅ FRONTEND VALIDATION
        let ext = file.name.split('.').pop().toLowerCase();
        let allowed = ['jpg','jpeg','png'];

        if(!allowed.includes(ext)){
            alert("Only JPG, JPEG, PNG allowed");
            return;
        }

        if(file.size > 3 * 1024 * 1024){
            alert("Max file size is 3MB");
            return;
        }

        let reader = new FileReader();
        reader.onload = function (e) {
            $("#profilePreview").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

// FORM VALIDATION
$("#editProfileForm").validate({
rules: {
    fullname: { required: true, minlength: 3 },
    email: { required: true, email: true },
    phone: { required: true, digits: true, minlength: 10, maxlength: 10 },
    department: { required: true }
},
messages: {
    fullname: "Enter valid name",
    email: "Enter valid email",
    phone: "Enter 10 digit phone",
    department: "Enter department"
},
errorElement: "label",
errorClass: "error",
highlight: function (el) {
    $(el).addClass("error").removeClass("valid");
    $(el).closest(".input-wrapper").find(".input-icon").show();
},
unhighlight: function (el) {
    $(el).removeClass("error").addClass("valid");
    $(el).closest(".input-wrapper").find(".input-icon").hide();
}
});
</script>

<?php include 'footer.php'; ?>