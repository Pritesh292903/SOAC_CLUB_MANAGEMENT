<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(120deg, #9b0000, #d90429);
}

.container {
    width: 400px;
    padding: 35px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h2 {
    color: #9b0000;
}

.header p {
    font-size: 14px;
    color: #666;
}

.form-group {
    margin-bottom: 20px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ccc;
    outline: none;
}

.is-invalid {
    border: 1.8px solid #dc3545 !important;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(120deg, #9b0000, #d90429);
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.btn:hover {
    opacity: 0.9;
}

.footer {
    text-align: center;
    margin-top: 15px;
}

.footer a {
    color: #d90429;
    text-decoration: none;
    font-weight: 600;
}
</style>
</head>

<body>

<div class="container">
    <div class="header">
        <h2>Forgot Password</h2>
        <p>Enter your email to receive OTP</p>
    </div>

     <form id="forgotForm" method="POST" action="send_reset_link.php">

     <div class="form-group">
        <input type="email" name="email" placeholder="Enter your email" required>
    </div>
        <button type="submit" class="btn">Send OTP</button>
    </form>

    <div class="footer">
    <a href="login_view.php" class="back-login">← Back to Login</a>
    </div>
</div>

<script>
$(document).ready(function(){

    $("#forgotForm").validate({

        rules:{
            email:{
                required:true,
                email:true
            }
        },

        messages:{
            email:{
                required:"Please enter your email",
                email:"Enter valid email"
            }
        },

        errorElement:"div",
        errorClass:"invalid-feedback",

        highlight:function(element){
            $(element).addClass("is-invalid");
        },

        unhighlight:function(element){
            $(element).removeClass("is-invalid");
        }

    });

});
</script>

</body>
</html>