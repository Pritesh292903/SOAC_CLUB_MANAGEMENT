<?php include 'F_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Your Website</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(120deg,#9b0000,#d90429);
}

/* ===== CONTAINER ===== */
.login-container{
    width:380px;
    padding:35px;
    background:#fff;
    border-radius:18px;
    box-shadow:0 20px 45px rgba(0,0,0,0.25);
}

/* ===== HEADER ===== */
.login-header{
    text-align:center;
    margin-bottom:25px;
}

.login-header h2{
    color:#9b0000;
}

.login-header p{
    color:#666;
    font-size:14px;
}

/* ===== FORM GROUP ===== */
.form-group{
    margin-bottom:18px;
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
    border-radius:12px;
    border:2px solid #ccc;
    outline:none;
    font-size:15px;
    transition:0.3s;
}

/* ===== ERROR INPUT STYLE ===== */
input.error{
    border:2px solid red !important;
    background:#fff5f5;
}

/* ===== ERROR MESSAGE ===== */
label.error{
    color:red;
    font-size:14px;
    margin-top:6px;
    display:block;
}

/* ===== ERROR ICON ===== */
.error-icon{
    position:absolute;
    right:12px;
    top:38px;
    color:red;
    font-weight:bold;
    font-size:18px;
    display:none;
}

/* ===== BUTTON ===== */
.login-btn{
    width:100%;
    padding:13px;
    border:none;
    border-radius:12px;
    background:linear-gradient(120deg,#9b0000,#d90429);
    color:#fff;
    font-size:16px;
    cursor:pointer;
}

.login-btn:hover{
    opacity:0.9;
}

.login-footer{
    text-align:center;
    margin-top:18px;
}

.login-footer a{
    color:#d90429;
    text-decoration:none;
    font-weight:600;
}

.login-footer a:hover{
    text-decoration:underline;
}

@media(max-width:420px){
    .login-container{
        width:90%;
    }
}

/* ===== FORCE FOOTER FULL WIDTH ===== */
footer {
    width: 100% !important;
    left: 0;
    right: 0;
    display: block;
    position: relative;
}
</style>
</head>

<body>

<div class="login-container">
    <div class="login-header">
        <h2>Welcome</h2>
        <p>Login to continue</p>
    </div>

    <form id="loginForm">

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email">
            <span class="error-icon">!</span>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">
            <span class="error-icon">!</span>
        </div>

        <button type="submit" class="login-btn">Login</button>

    </form>

    <div class="login-footer">
        Don’t have an account? <a href="register.php">Register</a>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function(){

    $("#loginForm").validate({

        rules:{
            email:{
                required:true,
                email:true
            },
            password:{
                required:true,
                minlength:6
            }
        },

        messages:{
            email:{
                required:"Email is required",
                email:"Enter a valid email"
            },
            password:{
                required:"Password is required",
                minlength:"Password must be at least 6 characters"
            }
        },

        errorPlacement:function(error,element){
            error.insertAfter(element);
        },

        highlight:function(element){
            $(element).addClass("error");
            $(element).siblings(".error-icon").show();  // show ! icon
        },

        unhighlight:function(element){
            $(element).removeClass("error");
            $(element).siblings(".error-icon").hide();  // hide ! icon
        },

        submitHandler: function(form) {
            // Redirect to faculty_dashboard.php if validation passes
            window.location.href = 'faculty_dashboard.php';
            return false; // prevent actual form submission
        }

    });

});
</script>

<?php include 'F_footer.php'; ?>
</body>
</html>