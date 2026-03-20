<?php include 'F_header.php'; ?>

<?php

$success = "";
$error = "";

// Optional: PHP server-side validation (kept for reference)
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $cpass = trim($_POST['cpassword']);

    if ($password !== $cpass) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 5) {
        $error = "Password must be at least 5 characters!";
    } else {
        $success = "Registration successful! Redirecting...";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | Your Website</title>

<style>
/* ===== GLOBAL ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(120deg,#9b0000,#d90429);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ===== CARD ===== */
.register-container{
    background:#fff;
    width:400px;
    padding:35px;
    border-radius:18px;
    box-shadow:0 20px 45px rgba(0,0,0,0.25);
}

/* ===== HEADER ===== */
.register-header{
    text-align:center;
    margin-bottom:22px;
}

.register-header h2{
    color:#9b0000;
    font-size:28px;
}

.register-header p{
    color:#666;
    font-size:14px;
}

/* ===== INPUTS ===== */
.form-group{
    margin-bottom:16px;
    position:relative;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
}

.form-group input{
    width:100%;
    padding:12px 40px 12px 14px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:15px;
    outline:none;
    transition:0.3s;
}

.form-group input:focus{
    border-color:#d90429;
}

/* ===== IMAGE STYLE ERROR ===== */
.input-error{
    border:2px solid #e10000 !important;
}

.field-error{
    color:#e10000;
    font-size:13px;
    margin-top:5px;
    display:block;
}

.error-icon{
    position:absolute;
    right:12px;
    top:40px;
    color:#e10000;
    font-size:16px;
    display:none;
}

/* ===== SERVER MESSAGE ===== */
.error{
    color:#b00000;
    margin-bottom:15px;
    text-align:center;
    font-size:14px;
}

.success{
    background:#e6fff0;
    color:#0a7a3d;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    font-size:14px;
}

/* ===== BUTTON ===== */
.register-btn{
    width:100%;
    padding:13px;
    border:none;
    border-radius:12px;
    background:linear-gradient(120deg,#9b0000,#d90429);
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

.register-btn:hover{
    opacity:0.9;
}

.register-footer{
    text-align:center;
    margin-top:18px;
    font-size:14px;
}

.register-footer a{
    color:#d90429;
    font-weight:600;
    text-decoration:none;
}

/* ===== FORCE FOOTER FULL WIDTH ===== */
footer {
    width: 100% !important;
    left: 0;
    right: 0;
    display: block;
    position: relative;
}

@media(max-width:420px){
    .register-container{
        width:90%;
    }
}
</style>
</head>

<body>

<div class="register-container">

<div class="register-header">
<h2>Create Account</h2>
<p>Join us and get started</p>
</div>

<?php if ($error != "") { ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<?php if ($success != "") { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST" id="registerForm">

<div class="form-group">
<label>Full Name</label>
<input type="text" id="name" name="name" placeholder="Enter your full name">
<span class="error-icon">❗</span>
<span id="nameError" class="field-error"></span>
</div>

<div class="form-group">
<label>Email Address</label>
<input type="email" id="email" name="email" placeholder="Enter your email">
<span class="error-icon">❗</span>
<span id="emailError" class="field-error"></span>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" id="password" name="password" placeholder="Create password">
<span class="error-icon">❗</span>
<span id="passError" class="field-error"></span>
</div>

<div class="form-group">
<label>Confirm Password</label>
<input type="password" id="cpassword" name="cpassword" placeholder="Confirm password">
<span class="error-icon">❗</span>
<span id="cpassError" class="field-error"></span>
</div>

<button type="submit" name="register" class="register-btn">
Register
</button>

</form>

<div class="register-footer">
  Already have an account? 
  <a href="login.php">Login</a>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<script>
$(document).ready(function(){

    $("#registerForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                lettersonly: true
            },
            email: {
                required: true,
                email: true
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
            name: {
                required: "Please enter your full name",
                minlength: "Name must be at least 3 characters",
                lettersonly: "Name can contain only letters and spaces"
            },
            email: {
                required: "Please enter your email",
                email: "Enter a valid email address"
            },
            password: {
                required: "Please enter a password",
                minlength: "Password must be at least 5 characters"
            },
            cpassword: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            }
        },
        errorPlacement: function(error, element){
            var id = element.attr("id") + "Error";
            $("#" + id).html(error);
            element.addClass("input-error");
            element.siblings(".error-icon").show();
        },
        success: function(label, element){
            $(element).removeClass("input-error");
            $(element).siblings(".error-icon").hide();
        },
        submitHandler: function(form) {
            // Redirect to faculty_dashboard.php after successful validation
            window.location.href = 'faculty_dashboard.php';
            return false; // prevent actual form submission
        }
    });

});
</script>

<?php include 'F_footer.php'; ?>

</body>
</html>