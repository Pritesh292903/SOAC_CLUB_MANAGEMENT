<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="card shadow p-4 rounded-4">
        <h2 class="text-center text-danger mb-4">Join Music Club 🎵</h2>

        <form id="joinForm" method="POST" action="">

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Your Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Your Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Your Phone</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>

            <!-- Age -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Your Age</label>
                <input type="number" name="age" id="age" class="form-control">
            </div>

                       <div class="text-center mt-4">
                <button type="submit" class="btn btn-danger rounded-pill px-5 py-2">
                    Confirm Join
                </button>
            </div>

        </form>
    </div>
</div>

<style>
body {
    background: #f8f9fa;
}
.form-control.is-invalid {
    border-color: #dc3545;
}
.card {
    border-radius: 15px;
}
</style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    // Letters only validation for Name and Instrument
    $.validator.addMethod("lettersOnly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Only letters allowed");

    // Form validation
    $("#joinForm").validate({

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
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            age: {
                required: true,
                digits: true,
                min: 5,
                max: 100
            },
            instrument: {
                lettersOnly: true
            },
            experience: {
                required: true,
                digits: true,
                min: 0,
                max: 50
            },
            notes: {
                maxlength: 250
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
            phone: {
                required: "Please enter phone number",
                digits: "Only numbers allowed",
                minlength: "Phone must be exactly 10 digits",
                maxlength: "Phone must be exactly 10 digits"
            },
            age: {
                required: "Please enter your age",
                digits: "Only numbers allowed",
                min: "Age must be at least 5",
                max: "Age cannot exceed 100"
            },
            experience: {
                required: "Please enter experience in years",
                digits: "Only numbers allowed",
                min: "Minimum is 0",
                max: "Maximum 50 years"
            },
            notes: {
                maxlength: "Maximum 250 characters allowed"
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

        submitHandler: function(form) {
            // Show SweetAlert popup
            Swal.fire({
                title: "Welcome to Music Club!",
                text: "Your membership request has been submitted successfully.",
                icon: "success",
                confirmButtonColor: "#d90429",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php";
                }
            });
        }

    });

});
</script>

<?php include 'footer.php'; ?>