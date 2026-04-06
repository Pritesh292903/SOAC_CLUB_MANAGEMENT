<?php
include 'admin_header.php';
include "../database.php";

$table = "Faculty_register";

$success = false;

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Only password match check (rest handled by jQuery)
    if ($password == $cpassword) {

        $check = mysqli_query($con, "SELECT * FROM $table WHERE email='$email'");
        if (mysqli_num_rows($check) == 0) {

            // IMAGE UPLOAD
            $imageName = "";

            if (!empty($_FILES['faculty_image']['name'])) {

                $targetDir = "uploads/";

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $imageName = time() . "_" . $_FILES['faculty_image']['name'];
                $target = $targetDir . $imageName;

                move_uploaded_file($_FILES['faculty_image']['tmp_name'], $target);
            }

            $query = "INSERT INTO $table(name,email,mobile,department,designation,password,image)
                      VALUES('$name','$email','$mobile','$department','$designation','$password','$imageName')";

            if (mysqli_query($con, $query)) {
                $success = true;
            }
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.content{
    animation: fadeIn 0.5s ease-in-out;
}
@keyframes fadeIn{
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}
.page-header{
    background:#fff;
    padding:20px 25px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    margin-bottom:25px;
}
.register-card{
    background:#fff;
    padding:35px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
}
.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}
.form-control{
    border-radius:10px;
    padding:10px 12px;
}
.btn-register{
    background:#dc3545;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:10px;
}
.full-width{
    grid-column:span 2;
}
.image-preview{
    width:120px;
    height:120px;
    border-radius:10px;
    object-fit:cover;
    border:2px solid #dc3545;
    margin-top:10px;
    display:none;
}
@media(max-width:768px){
    .form-grid{ grid-template-columns:1fr; }
    .full-width{ grid-column:span 1; }
}
</style>

<div class="content">

    <div class="page-header">
        <h4 class="fw-bold mb-0">Faculty Registration</h4>
    </div>

    <div class="register-card">

        <form method="POST" enctype="multipart/form-data" id="facultyForm">

            <div class="form-grid">

                <div>
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name">
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div>
                    <label>Mobile</label>
                    <input type="text" class="form-control" name="mobile">
                </div>

                <div>
                    <label>Department</label>
                    <input type="text" class="form-control" name="department">
                </div>

                <div>
                    <label>Designation</label>
                    <input type="text" class="form-control" name="designation">
                </div>

                <div>
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="full-width">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword">
                </div>

                <div class="full-width">
                    <label>Faculty Image</label>
                    <input type="file" class="form-control" name="faculty_image" id="faculty_image">
                    <img id="previewImage" class="image-preview">
                </div>

                <div class="full-width">
                    <button type="submit" name="register" class="btn-register w-100">
                        Register Faculty
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// Image Preview
$('#faculty_image').change(function () {
    let reader = new FileReader();
    reader.onload = function (e) {
        $('#previewImage').attr('src', e.target.result).show();
    }
    reader.readAsDataURL(this.files[0]);
});

// jQuery Validation
$('#facultyForm').submit(function (e) {

    let name = $('input[name="name"]').val().trim();
    let email = $('input[name="email"]').val().trim();
    let mobile = $('input[name="mobile"]').val().trim();
    let department = $('input[name="department"]').val().trim();
    let designation = $('input[name="designation"]').val().trim();
    let password = $('input[name="password"]').val().trim();
    let cpassword = $('input[name="cpassword"]').val().trim();

    if (name == "" || email == "" || mobile == "" || department == "" || designation == "" || password == "") {
        Swal.fire("Error", "All fields are required", "error");
        e.preventDefault();
        return;
    }

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        Swal.fire("Error", "Invalid email format", "error");
        e.preventDefault();
        return;
    }

    if (!/^[0-9]{10}$/.test(mobile)) {
        Swal.fire("Error", "Mobile must be 10 digits", "error");
        e.preventDefault();
        return;
    }

    if (password !== cpassword) {
        Swal.fire("Error", "Password not matched", "error");
        e.preventDefault();
        return;
    }

});
</script>

<?php if($success){ ?>
<script>
Swal.fire({
    title: "Success!",
    text: "Faculty Registered Successfully",
    icon: "success",
    confirmButtonColor: "#dc3545"
}).then(() => {
    window.location.href = "all_users_page.php";
});
</script>
<?php } ?>

<?php include 'admin_footer.php'; ?>