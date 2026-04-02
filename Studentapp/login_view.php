<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
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
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(120deg, #9b0000, #d90429);
}

.login-container {
    width: 380px;
    padding: 35px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
}

.login-header {
    text-align: center;
    margin-bottom: 25px;
}

.login-header h2 {
    color: #9b0000;
}

.form-group {
    position: relative;
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

.form-group input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #ccc;
    outline: none;
}

/* VALIDATION */
.is-invalid {
    border: 1.8px solid #dc3545 !important;
    padding-right: 35px;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 13px;
    margin-top: 6px;
}

/* ICON */
.input-icon {
    position: absolute;
    right: 12px;
    top: 38px;
    color: #dc3545;
    font-weight: bold;
    display: none;
}

.extra-links {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.extra-links a {
    font-size: 14px;
    text-decoration: none;
    color: #d90429;
    font-weight: 600;
}

.login-btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(120deg, #9b0000, #d90429);
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

.login-footer {
    text-align: center;
    margin-top: 18px;
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

        <!-- EMAIL -->
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email">
            <span class="input-icon">!</span>
        </div>

        <!-- PASSWORD -->
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password">
            <span class="input-icon">!</span>
        </div>

        <div class="extra-links">
            <span></span>
            <a href="Forgotpassword.php" style="padding-bottom: 15px;">Forgot Password?</a>
        </div>

        <button type="submit" class="login-btn">Login</button>

    </form>

    <div class="login-footer">
        Don’t have an account? <a href="register_view.php">Register</a>
    </div>

</div>

<script>
$(document).ready(function(){

    $("#loginForm").validate({

        rules:{
            email:{ required:true, email:true },
            password:{ required:true, minlength:2 }
        },

        messages:{
            email:{
                required:"Enter valid email",
                email:"Enter valid email"
            },
            password:{
                required:"Enter password",
                minlength:"Minimum 6 characters required"
            }
        },

        errorElement:"div",
        errorClass:"invalid-feedback",

        highlight:function(element){
            $(element).addClass("is-invalid");
            $(element).closest(".form-group").find(".input-icon").show();
        },

        unhighlight:function(element){
            $(element).removeClass("is-invalid");
            $(element).closest(".form-group").find(".input-icon").hide();
        },

        submitHandler:function(form){

            $.ajax({
                url:"login_process.php",
                type:"POST",
                data:$(form).serialize(),

                success:function(response){

                    response = response.trim();

                    if(response == "admin"){
                        Swal.fire("Success","Admin Login Successful","success")
                        .then(()=>{
                            window.location.href = "../Adminapp/admin_dashboard.php";
                        });
                    }
                    else if(response == "faculty"){
                        Swal.fire("Success","Faculty Login Successful","success")
                        .then(()=>{
                            window.location.href = "../Facultyapp/faculty_dashboard.php";
                        });
                    }
                    else if(response == "user"){
                        Swal.fire("Success","User Login Successful","success")
                        .then(()=>{
                            window.location.href = "../Studentapp/index.php";
                        });
                    }
                    else{
                        Swal.fire("Error", response, "error");
                    }
                }
            });

            return false;
        }

    });

});
</script>

</body>
</html>