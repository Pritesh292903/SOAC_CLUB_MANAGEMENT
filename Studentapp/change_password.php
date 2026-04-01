<?php 
include 'header.php'; 

// DATABASE CONNECTION
$con = mysqli_connect("localhost","root","","soae_club");

// CHECK CONNECTION
if(!$con){
    die("Connection failed: " . mysqli_connect_error());
}

// CHECK LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: login_view.php");
    exit();
}

// CHANGE PASSWORD LOGIC
if(isset($_POST['change_password']))
{
    $user_id = $_SESSION['user_id'];

    $currentPassword = $_POST['currentPassword'];
    $newPassword     = $_POST['newPassword'];

    // FETCH USER DATA
    $query = mysqli_query($con, "SELECT * FROM user WHERE id='$user_id'");
    $user  = mysqli_fetch_assoc($query);

    $dbPassword = $user['password'];

    // CHECK PASSWORD (PLAIN + HASH BOTH)
    if($currentPassword === $dbPassword || password_verify($currentPassword, $dbPassword))
    {
        // HASH NEW PASSWORD
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // UPDATE PASSWORD
        $update = mysqli_query($con, "UPDATE user SET password='$hashedPassword' WHERE id='$user_id'");

        if($update){
            echo "<script>
                Swal.fire({
                    title: 'Success',
                    text: 'Password updated successfully',
                    icon: 'success',
                    confirmButtonColor: '#d90429'
                }).then(() => {
                    window.location.href = 'profile_view.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong',
                    icon: 'error',
                    confirmButtonColor: '#d90429'
                });
            </script>";
        }
    } 
    else 
    {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Current password is incorrect',
                icon: 'error',
                confirmButtonColor: '#d90429'
            });
        </script>";
    }
}
?>

<!-- ===== STYLE (UNCHANGED) ===== -->
<style>
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(120deg,#f8f8f8,#fff);
}

.password-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.password-card {
    background: #fff;
    width: 100%;
    max-width: 450px;
    padding: 35px 30px;
    border-radius: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    text-align: center;
}

.password-card h2 {
    color: #9b0000;
    margin-bottom: 20px;
}

.form-group {
    position: relative;
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
}

.form-group input {
    width: 100%;
    padding: 12px 40px 12px 14px;
    border-radius: 12px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 15px;
    transition: 0.3s;
}

.is-invalid {
    border: 2px solid #dc3545 !important;
}

.is-valid {
    border: 2px solid #28a745 !important;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.form-group.error-icon::after {
    content: "!";
    position: absolute;
    right: 12px;
    top: 38px;
    width: 20px;
    height: 20px;
    background: #dc3545;
    color: #fff;
    font-size: 13px;
    font-weight: bold;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
}

.submit-btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(120deg,#9b0000,#d90429);
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

.submit-btn:hover {
    opacity: 0.9;
}
</style>

<div class="password-wrapper">
    <div class="password-card">
        <h2>Change Password</h2>

        <form id="changePasswordForm" method="POST" novalidate>

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="currentPassword" placeholder="Enter current password" id="currentPassword">
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="newPassword" placeholder="Enter new password" id="newPassword">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" placeholder="Confirm new password">
            </div>

            <button type="submit" name="change_password" class="submit-btn">Update Password</button>

        </form>
    </div>
</div>

<!-- ===== SCRIPTS (UNCHANGED) ===== -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    if ($('#changePasswordForm').length) {
        $("#changePasswordForm").validate({
            rules: {
                currentPassword: { required:true, minlength:6 },
                newPassword: { required:true, minlength:6 },
                confirmPassword: { required:true, equalTo:"#newPassword" }
            },
            messages: {
                currentPassword: { 
                    required:"Current password is required",
                    minlength:"Minimum 6 characters required"
                },
                newPassword: {
                    required:"New password is required",
                    minlength:"Minimum 6 characters required"
                },
                confirmPassword: {
                    required:"Confirm password is required",
                    equalTo:"Passwords do not match"
                }
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid").closest(".form-group").addClass("error-icon");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid").closest(".form-group").removeClass("error-icon");
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    }
});
</script>

<?php include 'footer.php'; ?>