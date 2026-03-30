<?php
include 'header.php';
include "../database.php";   // ✅ FIX PATH

// ❌ session_start() REMOVE (already in header)

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login_view.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ================= FETCH USER DATA =================
$result = mysqli_query($con, "SELECT * FROM User WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

// ================= UPDATE CODE =================
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $department = $_POST['department'] ?? '';
    $designation = $_POST['designation'] ?? '';

    // IMAGE UPLOAD
    if (!empty($_FILES['photo']['name'])) {

        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $filename = time() . "_" . $_FILES['photo']['name'];
        $path = $folder . $filename;

        move_uploaded_file($_FILES['photo']['tmp_name'], $path);

        $update = "UPDATE User SET 
            fullname='$fullname',
            email='$email',
            mobile='$phone',
            department='$department',
            designation='$designation',
            clubimage='$path'
            WHERE id='$user_id'";
    } else {

        $update = "UPDATE User SET 
            fullname='$fullname',
            email='$email',
            mobile='$phone',
            department='$department',
            designation='$designation'
            WHERE id='$user_id'";
    }

    mysqli_query($con, $update);

    echo "<script>
    Swal.fire({
        title: 'Profile Updated!',
        icon: 'success'
    }).then(() => {
        window.location.href='profile_view.php';
    });
    </script>";
}
?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <div class="mb-4">
                <h2 class="fw-bold text-danger">
                    <i class="bi bi-person-circle me-2"></i>Edit Profile
                </h2>
                <p class="text-muted mb-0">Update your profile information</p>
            </div>

            <div class="row">

                <!-- IMAGE -->
                <div class="col-md-4 text-center mb-4">

                    <img id="profilePreview"
                        src="<?php echo !empty($user['clubimage']) ? $user['clubimage'] : 'assets/images/user.jpg'; ?>"
                        class="img-fluid rounded-circle shadow" style="width:180px; height:180px; object-fit:cover;">

                    <input type="file" name="photo" id="photoInput" accept="image/*" style="display:none;">

                    <div class="mt-3">
                        <button type="button" id="changePhotoBtn" class="btn btn-outline-secondary btn-sm rounded-pill">
                            Change Photo
                        </button>
                    </div>
                </div>

                <!-- FORM -->
                <div class="col-md-8">

                    <!-- ✅ IMPORTANT FIX -->
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="fullname" class="form-control"
                                value="<?php echo $user['fullname']; ?>">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
                        </div>

                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $user['mobile']; ?>">
                        </div>

                        <div class="mb-3">
                            <label>Department</label>
                            <input type="text" name="department" class="form-control"
                                value="<?php echo $user['department']; ?>">
                        </div>

                        

                        <button type="submit" class="btn btn-danger">
                            Save Changes
                        </button>

                        <a href="profile_view.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // IMAGE CLICK
    $("#changePhotoBtn").click(function () {
        $("#photoInput").click();
    });

    // PREVIEW
    $("#photoInput").change(function (e) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $("#profilePreview").attr("src", e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>

<?php include 'footer.php'; ?>