<?php
include 'F_header.php';
include '../database.php';

// CHECK ID
if (!isset($_GET['id'])) {
    echo "<script>window.location='manage_clube.php';</script>";
    exit();
}

$id = intval($_GET['id']);

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM clubs WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>window.location='manage_clube.php';</script>";
    exit();
}

// UPDATE
if (isset($_POST['update'])) {

    $clubname = mysqli_real_escape_string($con, $_POST['clubname']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $members = intval($_POST['totalmembers']);
    $status = $_POST['status'];

    $image = $row['clubimage'];

    // IMAGE UPDATE
    if (!empty($_FILES['clubimage']['name'])) {

        $filename = time() . "_" . $_FILES['clubimage']['name'];
        $tmpname = $_FILES['clubimage']['tmp_name'];
        $uploadPath = "../Adminapp/uploads/" . $filename;

        if (move_uploaded_file($tmpname, $uploadPath)) {

            if (!empty($row['clubimage']) && file_exists("../Adminapp/uploads/" . $row['clubimage'])) {
                unlink("../Adminapp/uploads/" . $row['clubimage']);
            }

            $image = $filename;
        }
    }

    // UPDATE QUERY
    $updateQuery = "UPDATE clubs SET 
        clubname='$clubname',
        faculty='$faculty',
        totalmembers='$members',
        status='$status',
        clubimage='$image'
        WHERE id='$id'";

    if (mysqli_query($con, $updateQuery)) {

        // ✅ REDIRECT TO manage_clube.php
        echo "<script>
                alert('Club Updated Successfully');
                window.location.href='manage_clube.php';
              </script>";
        exit();

    } else {
        echo "<script>alert('Update Failed');</script>";
    }
}
?>

<div class="container my-5">
    <div class="card shadow p-4">

        <h3 class="text-warning mb-4">Edit Club</h3>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Club Name</label>
                <input type="text" name="clubname" class="form-control"
                       value="<?php echo htmlspecialchars($row['clubname']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Faculty</label>
                <input type="text" name="faculty" class="form-control"
                       value="<?php echo htmlspecialchars($row['faculty']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Members</label>
                <input type="number" name="totalmembers" class="form-control"
                       value="<?php echo $row['totalmembers']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Active" <?php if($row['status']=="Active") echo "selected"; ?>>Active</option>
                    <option value="Inactive" <?php if($row['status']=="Inactive") echo "selected"; ?>>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="../Adminapp/uploads/<?php echo $row['clubimage']; ?>"
                     width="100" height="100" style="object-fit:cover;">
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" name="clubimage" class="form-control">
            </div>

            <button type="submit" name="update" class="btn btn-warning">Update Club</button>
            <a href="manage_clube.php" class="btn btn-secondary">Cancel</a>

        </form>

    </div>
</div>

<?php include 'F_footer.php'; ?>