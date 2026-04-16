<?php
include 'admin_header.php';
include "../database.php";
session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = $_GET['type'] ?? '';

$userData = [];
$currentImage = '';
$nameValue = '';

if ($id && $type) {

    if ($type == 'faculty') {
        $query = "SELECT * FROM Faculty_register WHERE id = $id";
        $result = mysqli_query($con, $query);
        $userData = mysqli_fetch_assoc($result);

        $currentImage = $userData['image'] ?? '';
        $nameValue = $userData['name'] ?? '';

    } else {
        $query = "SELECT * FROM User WHERE id = $id";
        $result = mysqli_query($con, $query);
        $userData = mysqli_fetch_assoc($result);

        $currentImage = $userData['clubimage'] ?? '';
        $nameValue = $userData['fullname'] ?? '';
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    /* FIX LAYOUT */
    .content-wrapper {
        margin-left: 450px;
        /* sidebar width */
        padding: 10px;
        margin-top: 20px;
    }

    .card {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .img-preview img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #667eea;
    }

    /* RESPONSIVE FIX */
    @media(max-width:768px) {
        .content-wrapper {
            margin-left: 0;
        }
    }
</style>

<!-- ✅ IMPORTANT WRAPPER -->
<div class="content-wrapper">

    <div class="container-fluid">

        <h4 class="mb-4">Edit <?= ucfirst($type) ?> Details</h4>

        <?php if (empty($userData)): ?>
            <div class="alert alert-danger">User not found!</div>
        <?php else: ?>

            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">

                            <form action="update_user.php" method="POST" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="type" value="<?= $type ?>">

                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?= htmlspecialchars($nameValue) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?= htmlspecialchars($userData['email']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                <div class="text-center mb-3 img-preview">
                                    <img id="previewImage"
                                        src="<?= !empty($currentImage) ? '../uploads/' . $currentImage : 'https://via.placeholder.com/120' ?>">
                                </div>

                                <div class="text-end">
                                    <a href="all_users.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // IMAGE PREVIEW
    document.querySelector('input[name="image"]').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('previewImage').src = URL.createObjectURL(file);
        }
    });
</script>

<?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?= $_SESSION['success'] ?>'
        }).then(() => {
            window.location = 'all_users.php';
        });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= $_SESSION['error'] ?>'
        });
    </script>
    <?php unset($_SESSION['error']); endif; ?>

<?php include 'admin_footer.php'; ?>