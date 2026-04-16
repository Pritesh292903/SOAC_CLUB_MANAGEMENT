<?php
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;
$type = $_GET['type'] ?? '';

// FETCH DATA
if ($type == 'faculty') {
    $result = mysqli_query($con, "SELECT * FROM Faculty_register WHERE id='$id'");
} else {
    $result = mysqli_query($con, "SELECT * FROM User WHERE id='$id'");
}

$data = mysqli_fetch_assoc($result);

// IMAGE FIELD
$current_image = ($type == 'faculty') ? $data['image'] : $data['clubimage'];

// ===== UPDATE =====
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // IMAGE
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    } else {
        $image = $current_image;
    }

    if ($type == 'student') {
        $mobile = $_POST['mobile'];
        $department = $_POST['department'];

        mysqli_query($con, "UPDATE User SET 
            fullname='$name',
            email='$email',
            mobile='$mobile',
            department='$department',
            clubimage='$image'
            WHERE id='$id'");
    } elseif ($type == 'admin') {
        mysqli_query($con, "UPDATE User SET 
            fullname='$name',
            email='$email',
            clubimage='$image'
            WHERE id='$id'");
    } elseif ($type == 'faculty') {
        mysqli_query($con, "UPDATE Faculty_register SET 
            name='$name',
            email='$email',
            image='$image'
            WHERE id='$id'");
    }

    // IMPORTANT: STOP HTML OUTPUT & SHOW ONLY JS
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: 'User Updated Successfully',
            icon: 'success',
            confirmButtonColor: '#cc0000'
        }).then(() => {
            window.location.href = 'all_users_page.php';
        });
    });
    </script>
    ";
    exit;
}
?>

<style>
    .content-wrapper {
        margin-left: 250px;
        margin-top: 70px;
        padding: 30px;
        background: #fff5f5;
        min-height: 100vh;
    }

    .form-container {
        max-width: 600px;
        margin: auto;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .profile-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #cc0000;
    }
</style>

<div class="content-wrapper">

    <div class="form-container">
        <div class="card p-4">

            <h5 class="text-danger mb-3">Update User</h5>

            <form method="POST" enctype="multipart/form-data">

                <!-- IMAGE -->
                <div class="text-center mb-3">
                    <img src="../uploads/<?= $current_image ?: 'p2.webp'; ?>" class="profile-img" id="preview">
                    <input type="file" name="image" class="form-control mt-2" onchange="previewImage(event)">
                </div>

                <!-- NAME -->
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control"
                        value="<?= ($type == 'faculty') ? $data['name'] : $data['fullname']; ?>" required>
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $data['email']; ?>" required>
                </div>

                <!-- STUDENT -->
                <?php if ($type == 'student') { ?>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?= $data['mobile']; ?>">
                    </div>

                    <div class="mb-3">
                        <label>Department</label>
                        <input type="text" name="department" class="form-control" value="<?= $data['department']; ?>">
                    </div>
                <?php } ?>

                <!-- BUTTONS -->
                <div class="d-flex justify-content-between">
                    <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" name="update" class="btn btn-danger">Update</button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
    // IMAGE PREVIEW
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // CANCEL BUTTON FIX
    function goBack() {
        window.location.href = 'all_users_page.php';
    }
</script>

<?php include 'admin_footer.php'; ?>