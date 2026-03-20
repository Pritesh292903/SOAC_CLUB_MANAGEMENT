<?php include 'header.php'; ?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Page Title -->
            <div class="mb-4">
                <h2 class="fw-bold text-danger">
                    <i class="bi bi-person-circle me-2"></i>Edit Profile
                </h2>
                <p class="text-muted mb-0">Update your profile information</p>
            </div>

            <div class="row">

                <!-- Left Side: Profile Image -->
                <div class="col-md-4 text-center mb-4">

                    <img id="profilePreview" src="assets/images/user.jpg"
                        class="img-fluid rounded-circle shadow"
                        style="width:180px; height:180px; object-fit:cover;">

                    <input type="file" id="photoInput" accept="image/*" style="display:none;">

                    <div class="mt-3">
                        <button type="button" id="changePhotoBtn"
                            class="btn btn-outline-secondary btn-sm rounded-pill">
                            Change Photo
                        </button>
                    </div>
                </div>

                <!-- Right Side: Form -->
                <div class="col-md-8">

                    <form id="editProfileForm">

                        <!-- Full Name -->
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="fullname"
                                class="form-control rounded-3 pe-5"
                                value="kalariya Marmik S.">
                            <span class="error-icon">!</span>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email"
                                class="form-control rounded-3 pe-5"
                                value="mkalariya518@rku.ac.in">
                            <span class="error-icon">!</span>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" name="phone"
                                class="form-control rounded-3 pe-5"
                                value="9726866944">
                            <span class="error-icon">!</span>
                        </div>

                        <!-- Department -->
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold">Department</label>
                            <input type="text" name="department"
                                class="form-control rounded-3 pe-5"
                                value="COMPUTER ENGINEERING">
                            <span class="error-icon">!</span>
                        </div>

                        <!-- Designation -->
                        <div class="mb-4 position-relative">
                            <label class="form-label fw-semibold">Designation</label>
                            <input type="text" name="designation"
                                class="form-control rounded-3 pe-5"
                                value="PROBLEM SOLVING">
                            <span class="error-icon">!</span>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit"
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

<!-- ================== STYLE ================== -->
<style>
input.error{
    border:2px solid red !important;
    background:#fff5f5;
}

label.error{
    color:red;
    font-size:14px;
    margin-top:5px;
    display:block;
}

.error-icon{
    position:absolute;
    right:15px;
    top:42px;
    color:red;
    font-weight:bold;
    font-size:18px;
    display:none;
}
</style>

<!-- ================== SCRIPTS ================== -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Image Change Button
    $("#changePhotoBtn").click(function () {
        $("#photoInput").click();
    });

    // Image Preview
    $("#photoInput").change(function (event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#profilePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // ================= VALIDATION =================
    $("#editProfileForm").validate({

        rules:{
            fullname:{
                required:true,
                minlength:3
            },
            email:{
                required:true,
                email:true
            },
            phone:{
                required:true,
                digits:true,
                minlength:10,
                maxlength:10
            },
            department:{
                required:true
            },
            designation:{
                required:true
            }
        },

        messages:{
            fullname:{
                required:"Full name is required",
                minlength:"Minimum 3 characters required"
            },
            email:{
                required:"Email is required",
                email:"Enter valid email"
            },
            phone:{
                required:"Phone number is required",
                digits:"Only numbers allowed",
                minlength:"Enter 10 digit number",
                maxlength:"Enter 10 digit number"
            },
            department:{
                required:"Department is required"
            },
            designation:{
                required:"Designation is required"
            }
        },

        errorPlacement:function(error,element){
            error.insertAfter(element);
        },

        highlight:function(element){
            $(element).addClass("error");
            $(element).siblings(".error-icon").show();
        },

        unhighlight:function(element){
            $(element).removeClass("error");
            $(element).siblings(".error-icon").hide();
        },

        submitHandler: function(form) {
            // SweetAlert popup
            Swal.fire({
                title: "Profile Updated!",
                text: "Your changes have been saved successfully.",
                icon: "success",
                confirmButtonColor: "#d90429",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "profile_view.php";
                }
            });
        }

    });

});
</script>

<?php include 'footer.php'; ?>