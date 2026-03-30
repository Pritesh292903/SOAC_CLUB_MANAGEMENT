<?php
session_start();
include "../database.php";

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login_view.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH USER DATA
$result = mysqli_query($con, "SELECT * FROM User WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

// ================= UPDATE LOGIC =================
if (isset($_POST['fullname'])) {

    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['phone']);
    $department = mysqli_real_escape_string($con, $_POST['department']);

    // IMAGE UPLOAD
    $image = $user['clubimage']; // default old image

    if (!empty($_FILES['profileImage']['name'])) {

        $file_name = $_FILES['profileImage']['name'];
        $file_tmp = $_FILES['profileImage']['tmp_name'];
        $file_size = $_FILES['profileImage']['size'];
        $file_type = $_FILES['profileImage']['type'];

        $allowed = ["image/jpeg", "image/png", "image/webp"];

        if (in_array($file_type, $allowed) && $file_size <= 2 * 1024 * 1024) {

            $new_name = "uploads/" . time() . "_" . $file_name;
            move_uploaded_file($file_tmp, $new_name);
            $image = $new_name;
        }
    }

    // UPDATE QUERY
    $update = "UPDATE User SET 
        fullname='$fullname',
        email='$email',
        mobile='$mobile',
        department='$department',
        clubimage='$image'
        WHERE id='$user_id'";

    if (mysqli_query($con, $update)) {
        echo "<script>alert('✅ Profile Updated Successfully'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('❌ Error updating profile');</script>";
    }
}
?>

<?php include 'F_header.php'; ?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Title -->
            <h2 class="fw-bold text-danger mb-3">Edit Profile</h2>

            <div class="row">

                <!-- PROFILE IMAGE -->
                <div class="col-md-4 text-center">

                    <img id="profilePreview"
                        src="<?php echo !empty($user['clubimage']) ? $user['clubimage'] : 'assets/images/user.jpg'; ?>"
                        class="img-fluid rounded-circle shadow"
                        style="width:180px;height:180px;object-fit:cover;">

                    <input type="file" id="profileImage" name="profileImage" hidden>

                    <div class="mt-3">
                        <button type="button" id="changePhotoBtn"
                            class="btn btn-outline-secondary btn-sm rounded-pill">
                            Change Photo
                        </button>
                    </div>

                    <small id="photoError" class="text-danger d-none"></small>

                </div>

                <!-- FORM -->
                <div class="col-md-8">

                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                        <!-- FULL NAME -->
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control"
                                value="<?php echo $user['fullname']; ?>" required>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo $user['email']; ?>" required>
                        </div>

                        <!-- PHONE -->
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="<?php echo $user['mobile']; ?>"
                                pattern="[0-9]{10}" required>
                        </div>

                        <!-- DEPARTMENT -->
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control"
                                value="<?php echo $user['department']; ?>" required>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-danger">
                            Save Changes
                        </button>

                        <a href="profile.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

<!-- JS -->
<script>
document.getElementById("changePhotoBtn").onclick = () => {
    document.getElementById("profileImage").click();
};

document.getElementById("profileImage").onchange = function () {
    const file = this.files[0];
    const preview = document.getElementById("profilePreview");
    const error = document.getElementById("photoError");

    const allowed = ["image/jpeg", "image/png", "image/webp"];

    if (!allowed.includes(file.type)) {
        error.innerText = "Only JPG, PNG allowed";
        error.classList.remove("d-none");
        this.value = "";
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        error.innerText = "Max size 2MB";
        error.classList.remove("d-none");
        this.value = "";
        return;
    }

    const reader = new FileReader();
    reader.onload = e => preview.src = e.target.result;
    reader.readAsDataURL(file);
};
</script>

<?php include 'F_footer.php'; ?>