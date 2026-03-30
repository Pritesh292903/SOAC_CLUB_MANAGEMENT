<?php
include "../database.php";

$success = false;

if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $enrollment = $_POST['enrollment'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Image Upload
    $filename = $_FILES['clubimage']['name'];
    $tempname = $_FILES['clubimage']['tmp_name'];
    $folder = "../uploads/" . $filename;

    if ($password == $cpassword) {

        move_uploaded_file($tempname, $folder);

        $insert = "INSERT INTO User(clubimage,fullname,email,department,enrollment,mobile,password)
        VALUES('$filename','$fullname','$email','$department','$enrollment','$mobile','$password')";

        if (mysqli_query($con, $insert)) {
            $success = true;
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "<p style='color:red;text-align:center;'>Passwords do not match</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #9b0000, #d90429);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            background: #fff;
            width: 750px;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h2 {
            color: #9b0000;
            font-size: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 15px;
            outline: none;
        }

        .full-width {
            grid-column: span 2;
        }

        .register-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(120deg, #9b0000, #d90429);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .register-btn:hover {
            opacity: 0.9;
        }

        .is-invalid {
            border: 1.8px solid #dc3545 !important;
        }

        .is-valid {
            border: 1.8px solid #28a745 !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        .register-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .register-footer a {
            color: #d90429;
            font-weight: 600;
            text-decoration: none;
        }

        @media(max-width:768px) {

            .register-container {
                width: 95%;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }

        }
    </style>
</head>

<body>

    <div class="register-container">

        <div class="register-header">
            <h2>Create Account</h2>
        </div>

        <form method="POST" id="registerForm" enctype="multipart/form-data">

            <div class="form-grid">

                <div class="form-group full-width">
                    <label>Choose Image</label>
                    <input type="file" name="clubimage" id="clubimage" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" id="fullname">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" id="department">
                </div>

                <div class="form-group">
                    <label>Enrollment No</label>
                    <input type="text" name="enrollment" id="enrollment">
                </div>

                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" id="mobile">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-group full-width">
                    <label>Confirm Password</label>
                    <input type="password" name="cpassword" id="cpassword">
                </div>

                <div class="full-width">
                    <input type="submit" name="submit" class="register-btn" value="Register">
                </div>

            </div>
        </form>

        <div class="register-footer">
            Already have an account? <a href="login_view.php">Login</a>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            $("#registerForm").validate({

                rules: {
                    clubimage: {
                        required: true
                    },
                    fullname: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    department: {
                        required: true
                    },
                    enrollment: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    cpassword: {
                        required: true,
                        equalTo: "#password"
                    }
                },

                messages: {
                    clubimage: "Select image",
                    fullname: "Enter full name",
                    email: "Enter valid email",
                    department: "Enter department",
                    enrollment: "Enter enrollment",
                    mobile: "Enter 10 digit mobile",
                    password: "Enter password",
                    cpassword: "Passwords do not match"
                },

                errorElement: 'div',
                errorClass: 'invalid-feedback',

                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },

                unhighlight: function(element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                }

            });

        });
    </script>

    <?php
    if ($success) {
    ?>

        <script>
            Swal.fire({
                title: 'Registration Successful!',
                text: 'Your account has been created',
                icon: 'success',
                confirmButtonColor: '#28a745'
            }).then(function() {
                window.location = 'login_view.php';
            });
        </script>

    <?php
    }
    ?>

</body>

</html>