<?php
session_start();
include '../database.php';

// guest user
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 0;
}

// INSERT LOGIC (ADDED)
if(isset($_POST['action']) && $_POST['action'] == "sendMessage"){

    $user_id = $_SESSION['user_id'];

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

    <!-- Animated Heading -->
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
                    RK University, Bhavnagar Highway, Kasturbadham,
                    Rajkot - 360020, Gujarat, India.
                </p>
                <p><i class="bi bi-telephone-fill me-2 text-danger"></i>
                    +91-9909952030/31
                </p>
                <p><i class="bi bi-envelope-fill me-2 text-danger"></i>
                    info@rku.ac.in
                </p>
                <p><i class="bi bi-clock-fill me-2 text-danger"></i>
                    Mon - Fri: 8:00 AM - 5:00 PM
                </p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-7 animate__animated animate__fadeInRight">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h4 class="text-danger mb-3">Send Us a Message</h4>

                <form id="contactForm">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control border-danger">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control border-danger">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control border-danger">
                    </div>

                    <div class="mb-3">
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

<!-- Custom Styles -->
<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(217, 4, 41, 0.3);
    transition: 0.3s;
}

.form-control:focus {
    border-color: #d90429;
    box-shadow: 0 0 0 2px rgba(217, 4, 41, 0.15);
}

.form-control.is-invalid {
    border-color: #dc3545;
}
</style>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    $.validator.addMethod("lettersOnly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Only letters allowed");

    $("#contactForm").validate({

        rules: {
            name: {
                required: true,
                minlength: 3,
                lettersOnly: true
            },
            email: {
                required: true,
                email: true
            },
            subject: {
                required: true,
                minlength: 5
            },
            message: {
                required: true,
                minlength: 10
            }
        },

        messages: {
            name: {
                required: "Please enter your name",
                minlength: "Minimum 3 characters required"
            },
            email: {
                required: "Please enter your email",
                email: "Enter valid email address"
            },
            subject: {
                required: "Please enter subject",
                minlength: "Subject must be at least 5 characters"
            },
            message: {
                required: "Please enter your message",
                minlength: "Message must be at least 10 characters"
            }
        },

        errorElement: "small",
        errorClass: "text-danger",

        highlight: function (element) {
            $(element).addClass("is-invalid");
        },

        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },

        // ONLY CHANGE HERE
        submitHandler: function(form) {

            $.ajax({
                url: "",
                type: "POST",
                data: $("#contactForm").serialize() + "&action=sendMessage",

                success: function(response) {

                    if (response == "success") {
                        Swal.fire({
                            title: "Success!",
                            text: "Your message has been sent successfully.",
                            icon: "success",
                            confirmButtonColor: "#d90429",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "index.php";
                            }
                        });
                    } else {
                        Swal.fire("Error!", "Database error!", "error");
                    }
                }
            });

        }

    });

});
</script>

<?php include 'footer.php'; ?>