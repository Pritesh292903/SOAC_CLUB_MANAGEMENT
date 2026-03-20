<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content d-flex justify-content-center align-items-center" style="min-height:85vh;">

    <div class="card shadow-lg rounded-4 p-4" style="max-width:400px; width:100%;">
        <h4 class="fw-bold text-center mb-3">Change Password</h4>

        <form id="changePasswordForm">
            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control" name="currentPassword" id="currentPassword">
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="newPassword" id="newPassword">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-key-fill me-2"></i>Change
                </button>
                <a href="admin_profile.php" class="btn btn-outline-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- jQuery & Validation -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function(){

    $("#changePasswordForm").validate({
        rules: {
            currentPassword: { required: true, minlength: 6 },
            newPassword: { required: true, minlength: 6 },
            confirmPassword: { required: true, equalTo: "#newPassword" }
        },
        messages: {
            currentPassword: { required: "Current password is required", minlength: "Minimum 6 characters" },
            newPassword: { required: "New password is required", minlength: "Minimum 6 characters" },
            confirmPassword: { required: "Confirm password is required", equalTo: "Passwords do not match" }
        },
        highlight: function(element) { $(element).addClass("is-invalid").removeClass("is-valid"); },
        unhighlight: function(element) { $(element).removeClass("is-invalid").addClass("is-valid"); },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) { error.insertAfter(element); },

        submitHandler: function(form) {
            Swal.fire({
                icon: 'success',
                title: 'Password Changed!',
                text: 'Your password has been updated successfully.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = "../Studentapp/login_view.php";
            });
            return false; 
        }
    });

});
</script>

<?php include 'admin_footer.php'; ?>