<?php
session_start();
include 'F_header.php'; // Faculty header
include "../database.php"; // DB connection

// LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login_view.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH EXISTING DATA
$result = mysqli_query($con, "SELECT * FROM Faculty_register WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

// ================= UPDATE LOGIC =================
if (isset($_POST['name'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);

    // KEEP OLD IMAGE
    $image = !empty($user['image']) ? $user['image'] : 'uploads/default.png';

    // IMAGE UPLOAD
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {

        $file_name = $_FILES['profileImage']['name'];
        $file_tmp = $_FILES['profileImage']['tmp_name'];
        $file_size = $_FILES['profileImage']['size'];
        $file_type = $_FILES['profileImage']['type'];

        $allowed = ["image/jpeg", "image/png", "image/webp"];

        if (in_array($file_type, $allowed) && $file_size <= 2 * 1024 * 1024) {

            $new_name = "uploads/" . time() . "_" . basename($file_name);

            // DELETE OLD IMAGE
            if (!empty($user['image']) && file_exists("../" . $user['image'])) {
                unlink("../" . $user['image']);
            }

            if (move_uploaded_file($file_tmp, "../" . $new_name)) {
                $image = $new_name;
            }
        }
    }

    // UPDATE QUERY
    $update = "UPDATE Faculty_register SET 
        name='$name',
        email='$email',
        mobile='$mobile',
        department='$department',
        designation='$designation',
        image='$image'
        WHERE id='$user_id'";

    if (mysqli_query($con, $update)) {
        echo "<script>alert('✅ Profile Updated Successfully'); window.location='edit_profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('❌ Error updating profile');</script>";
    }
}

// PROFILE IMAGE PATH
$profileImage = (!empty($user['image']) && file_exists("../" . $user['image']))
    ? "../" . $user['image']
    : "assets/images/user.jpg";
?>

<div class="container my-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <h2 class="fw-bold text-danger mb-3">Edit Profile</h2>

            <div class="row">

                <!-- PROFILE IMAGE -->
                <div class="col-md-4 text-center">

                    <img id="profilePreview"
                        src="<?php echo $profileImage; ?>"
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

                    <form method="POST" enctype="multipart/form-data" novalidate>

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?php echo $user['name']; ?>" required>
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
                            <input type="text" name="mobile" class="form-control"
                                value="<?php echo $user['mobile']; ?>"
                                pattern="[0-9]{10}" required>
                        </div>

                        <!-- DEPARTMENT -->
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control"
                                value="<?php echo $user['department']; ?>" required>
                        </div>

                        <!-- DESIGNATION -->
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control"
                                value="<?php echo $user['designation']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-danger">Save Changes</button>
                        <a href="profile.php" class="btn btn-secondary">Cancel</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- JS FOR IMAGE PREVIEW -->
<script>
document.getElementById("changePhotoBtn").onclick = () => {
    document.getElementById("profileImage").click();
};

document.getElementById("profileImage").onchange = function () {

    const file = this.files[0];
    const preview = document.getElementById("profilePreview");
    const error = document.getElementById("photoError");

    if (!file) return;

    const allowed = ["image/jpeg", "image/png", "image/webp"];

    if (!allowed.includes(file.type)) {
        error.innerText = "Only JPG, PNG, WEBP allowed";
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

    error.classList.add("d-none");

    const reader = new FileReader();
    reader.onload = e => preview.src = e.target.result;
    reader.readAsDataURL(file);
};
</script>

<?php include 'F_footer.php'; ?>