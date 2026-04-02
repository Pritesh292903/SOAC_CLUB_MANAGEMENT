<?php
session_start();
include '../database.php';

// guest user
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 0;
}

// INSERT LOGIC
if(isset($_POST['action']) && $_POST['action'] == "sendMessage"){

    $user_id = $_SESSION['user_id'];

    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
        echo "empty";
        exit();
    }

    $name = mysqli_real_escape_string($con,$_POST['name']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $subject = mysqli_real_escape_string($con,$_POST['subject']);
    $message = mysqli_real_escape_string($con,$_POST['message']);

    $query = "INSERT INTO contact_us(user_id,name,email,subject,message)
              VALUES('$user_id','$name','$email','$subject','$message')";

    if(mysqli_query($con,$query)){
        echo "success";
    } else {
        echo "error";
    }
    exit();
}
?>

<?php include 'header.php'; ?>

<div class="container my-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-danger animate__animated animate__fadeInDown" style="color:#9b0000;">
            Contact Us
        </h1>
        <p class="lead text-muted animate__animated animate__fadeInUp animate__delay-1s">
            We’d love to hear from you! Reach out for any queries, suggestions, or feedback.
        </p>
    </div>

    <div class="row g-4">

        <!-- Contact Info -->
        <div class="col-md-5 animate__animated animate__fadeInLeft">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h4 class="text-danger mb-3">Get in Touch</h4>
                <p><i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                    RK University, Rajkot
                </p>
                <p><i class="bi bi-telephone-fill me-2 text-danger"></i>
                    +91-9909952030
                </p>
                <p><i class="bi bi-envelope-fill me-2 text-danger"></i>
                    info@rku.ac.in
                </p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-7 animate__animated animate__fadeInRight">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h4 class="text-danger mb-3">Send Us a Message</h4>

                <form id="contactForm">

                    <div class="mb-3 position-relative">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control border-danger">
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control border-danger">
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control border-danger">
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="5" class="form-control border-danger"></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">
                        Send Message
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

<style>
/* Red border */
input.error, textarea.error {
    border-color: #dc3545 !important;
}

/* ! icon */
.error-icon {
    position: absolute;
    right: 10px;
    top: 38px;
    color: #dc3545;
    font-weight: bold;
    font-size: 18px;
}

/* error text */
label.error {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    $("#contactForm").validate({

        rules: {
            name: { required: true, minlength: 3 },
            email: { required: true, email: true },
            subject: { required: true, minlength: 5 },
            message: { required: true, minlength: 10 }
        },

        messages: {
            name: {
                required: "This field is required",
                minlength: "Minimum 3 characters required"
            },
            email: {
                required: "This field is required",
                email: "Enter valid email"
            },
            subject: {
                required: "This field is required",
                minlength: "Minimum 5 characters required"
            },
            message: {
                required: "This field is required",
                minlength: "Minimum 10 characters required"
            }
        },

        errorPlacement: function(error, element) {
            element.closest(".mb-3").find(".error-icon").remove();
            element.closest(".mb-3").append('<span class="error-icon">!</span>');
            error.insertAfter(element);
        },

        success: function(label, element) {
            $(element).closest(".mb-3").find(".error-icon").remove();
        },

        submitHandler: function(form) {

            $.ajax({
                url: "",
                type: "POST",
                data: $("#contactForm").serialize() + "&action=sendMessage",

                success: function(response) {

                    if (response.trim() == "success") {

                        Swal.fire({
                            title: "Success!",
                            text: "Your message has been sent successfully.",
                            icon: "success",
                            confirmButtonColor: "#d90429"
                        });

                        $("#contactForm")[0].reset();

                    } 
                    else if(response == "empty"){
                        Swal.fire("Warning!", "All fields are required!", "warning");
                    }
                    else {
                        Swal.fire("Error!", "Database error!", "error");
                    }
                }
            });

        }

    });

});
</script>

<?php include 'footer.php'; ?>