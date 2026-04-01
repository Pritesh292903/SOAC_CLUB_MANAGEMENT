<?php
session_start();

include 'admin_header.php';
include "../database.php";

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.card-custom {
    border-radius: 20px;
    padding: 25px;
}
.profile-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #dc3545;
}
.form-control {
    border-radius: 10px;
}
.section-title {
    font-size: 14px;
    font-weight: 600;
    color: #999;
    margin-bottom: 10px;
}
</style>

<div class="content d-flex justify-content-center align-items-center" style="min-height:90vh;">
    <div class="card shadow card-custom" style="max-width:480px; width:100%;">

        <h4 class="text-center fw-bold mb-4">Edit Profile</h4>

        <form id="editProfileForm" method="POST" enctype="multipart/form-data">

            <!-- PROFILE IMAGE -->
            <div class="text-center mb-4">
                <img 
                    src="<?php echo !empty($user['clubimage']) ? '../uploads/'.$user['clubimage'] : 'assets/images/profile-placeholder.png'; ?>" 
                    id="profilePreview"
                    class="profile-img mb-3"
                >

                <!-- LABEL BELOW IMAGE -->
                <label class="fw-semibold mb-1 d-block">Choose Profile Photo</label>

                <input type="file" class="form-control" name="profilePhoto" id="profilePhoto" accept="image/*">

                <input type="hidden" name="old_image" value="<?php echo $user['clubimage']; ?>">
            </div>

            <div class="section-title">PERSONAL DETAILS</div>

            <!-- FULL NAME -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" class="form-control" name="fullname" value="<?php echo $user['fullname']; ?>">
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>">
            </div>

            <!-- PHONE -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Mobile Number</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $user['mobile']; ?>">
            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between">
                <button type="submit" name="updateProfile" class="btn btn-danger px-4">Save</button>
                <a href="admin_profile.php" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>

        </form>
    </div>
</div>

<script>
$(document).ready(function () {

    // IMAGE PREVIEW
    $('#profilePhoto').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // PHONE VALIDATION
    $.validator.addMethod("phoneValidation", function (value) {
        return /^[0-9+\-\s]{10,15}$/.test(value);
    });

    // FORM VALIDATION
    $("#editProfileForm").validate({
        ignore: "#profilePhoto",

        rules: {
            fullname: { required: true, minlength: 3 },
            email: { required: true, email: true },
            phone: { required: true, phoneValidation: true }
        }
    });

});
</script>

<?php
if (isset($_POST['updateProfile'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $old_image = $_POST['old_image'];

    if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == 0) {
        $image = time() . "_" . $_FILES['profilePhoto']['name'];
        move_uploaded_file($_FILES['profilePhoto']['tmp_name'], "../uploads/" . $image);
    } else {
        $image = $old_image;
    }

    $update = "UPDATE user SET 
        fullname='$fullname',
        email='$email',
        mobile='$phone',
        clubimage='$image'
        WHERE id='$user_id'";

    if (mysqli_query($con, $update)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href='admin_profile.php';
            });
        </script>";
    }
}
?>

<?php include 'admin_footer.php'; ?>