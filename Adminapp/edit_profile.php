<?php
session_start();

include 'admin_header.php';
include "../database.php";

// CHECK SESSION
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

// FETCH USER DATA
$user_id = $_SESSION['user_id'];

$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user_id'");

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("No user found");
}
?>

<!-- Bootstrap + jQuery + Validation + SweetAlert -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content" style="min-height:85vh; display:flex; justify-content:center; align-items:center;">
    <div class="card shadow-lg rounded-4 p-4" style="max-width:450px; width:100%;">
        <h4 class="fw-bold text-center mb-3">Edit Profile</h4>

        <form id="editProfileForm" method="POST" enctype="multipart/form-data">

            <!-- PROFILE IMAGE -->
            <div class="mb-3 text-center">
                <img 
                    src="<?php
                        if (!empty($user['clubimage'])) {
                            echo '../uploads/' . $user['clubimage'];
                        } else {
                            echo 'assets/images/profile-placeholder.png';
                        }
                    ?>" 
                    id="profilePreview"
                    style="width:120px; height:120px; object-fit:cover; border-radius:50%; margin-bottom:10px;"
                >

                <input type="file" class="form-control" name="profilePhoto" id="profilePhoto" accept="image/*">

                <!-- OLD IMAGE -->
                <input type="hidden" name="old_image" value="<?php echo $user['clubimage']; ?>">
            </div>

            <!-- FULL NAME -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullname" 
                       value="<?php echo $user['fullname']; ?>">
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" 
                       value="<?php echo $user['email']; ?>">
            </div>

            <!-- PHONE -->
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" 
                       value="<?php echo $user['mobile']; ?>">
            </div>

            <!-- BUTTONS -->
            <div class="d-flex justify-content-between">
                <button type="submit" name="updateProfile" class="btn btn-danger">
                    Save
                </button>
                <a href="admin_profile.php" class="btn btn-outline-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
$(document).ready(function () {

    // ===== Live Image Preview =====
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

    // ===== Validation Methods =====
    $.validator.addMethod("fileType", function (value, element) {
        if (element.files.length === 0) return true;
        let allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        return allowedTypes.includes(element.files[0].type);
    });

    $.validator.addMethod("fileSize", function (value, element) {
        if (element.files.length === 0) return true;
        return element.files[0].size <= 5 * 1024 * 1024;
    });

    $.validator.addMethod("phoneValidation", function (value) {
        return /^[0-9+\-\s]{10,15}$/.test(value);
    });

    // ===== Form Validation =====
    $("#editProfileForm").validate({
        rules: {
            profilePhoto: {
                fileType: true,
                fileSize: true,
                required: false   // ✅ FINAL FIX
            },
            fullname: { required: true, minlength: 3, maxlength: 50 },
            email: { required: true, email: true },
            phone: { required: true, phoneValidation: true }
        },
        messages: {
            profilePhoto: {
                fileType: "Upload JPG, PNG, GIF only",
                fileSize: "File must be <5MB"
            },
            fullname: {
                required: "Full name is required",
                minlength: "Minimum 3 characters",
                maxlength: "Maximum 50 characters"
            },
            email: {
                required: "Email is required",
                email: "Enter valid email"
            },
            phone: {
                required: "Phone is required",
                phoneValidation: "Enter valid phone number"
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });

});
</script>

<?php
// ================= UPDATE LOGIC =================
if (isset($_POST['updateProfile'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $old_image = $_POST['old_image'];

    if (!empty($_FILES['profilePhoto']['name'])) {

        $image = $_FILES['profilePhoto']['name'];
        $tmp = $_FILES['profilePhoto']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/" . $image);

    } else {
        $image = $old_image; // ✅ keep old image
    }

    $update = "UPDATE user SET 
                fullname='$fullname',
                email='$email',
                mobile='$phone',
                clubimage='$image'
               WHERE id='$user_id'";

    $run = mysqli_query($con, $update);

    if ($run) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href='admin_profile.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Error', 'Update Failed', 'error');
        </script>";
    }
}
?>

<?php include 'admin_footer.php'; ?>