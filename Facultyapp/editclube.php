<?php
include "../database.php";

// GET ID
if (!isset($_GET['id'])) {
    header("Location: manage_clube.php");
    exit();
}

$id = $_GET['id'];

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM my_club WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: manage_clube.php");
    exit();
}

// UPDATE
if (isset($_POST['club_name'])) {

    $name = mysqli_real_escape_string($con, $_POST['club_name']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $cat  = mysqli_real_escape_string($con, $_POST['category']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $members = mysqli_real_escape_string($con, $_POST['members']);

    $uploadDir = __DIR__ . "/uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_to_store = $row['images'];

    // IMAGE UPLOAD
    if (isset($_FILES['club_image']) && $_FILES['club_image']['error'] == 0) {

        $file_tmp  = $_FILES['club_image']['tmp_name'];
        $file_name = $_FILES['club_image']['name'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png'];

        if (in_array($file_ext, $allowed)) {

            $new_name = time() . "_" . rand(1000,9999) . "." . $file_ext;
            $target = $uploadDir . $new_name;

            if (move_uploaded_file($file_tmp, $target)) {

                // DELETE OLD IMAGE
                if (!empty($row['images']) && file_exists($uploadDir . $row['images'])) {
                    unlink($uploadDir . $row['images']);
                }

                $image_to_store = $new_name;
            }
        }
    }

    // UPDATE QUERY
    mysqli_query($con, "UPDATE my_club SET 
        name='$name',
        Description='$desc',
        Category='$cat',
        Status='$status',
        Club_member='$members',
        images='$image_to_store'
        WHERE id='$id'
    ");

    header("Location: manage_clube.php");
    exit();
}
?>

<?php include 'F_header.php'; ?>

<style>
.preview-img {
  width: 160px;
  height: 160px;
  object-fit: cover;
  border-radius: 12px;
  border: 2px dashed #ccc;
}
</style>

<div class="container my-5">
  <div class="card shadow border-0 rounded-4">
    <div class="card-body p-4">

      <h2 class="text-danger fw-bold mb-4">Edit Club</h2>
      

      <form method="POST" enctype="multipart/form-data">

        <div class="row">

          <!-- IMAGE -->
          <div class="col-md-4 text-center">

            <?php
            $image = $row['images'];
            $serverPath = __DIR__ . "/uploads/" . $image;
            $displayPath = "uploads/" . $image;
            ?>

            <?php if (!empty($image) && file_exists($serverPath)) { ?>
                <img src="<?php echo $displayPath; ?>" id="previewImage" class="preview-img mb-3">
            <?php } else { ?>
                <img src="https://via.placeholder.com/150" id="previewImage" class="preview-img mb-3">
            <?php } ?>

            <br>
            <label>Edit Club Image</label>
            <br>
            <input type="file" name="club_image" id="clubImage" class="form-control">

          </div>

          <!-- FORM -->
          <div class="col-md-8">

            <div class="mb-3">
              <label>Club Name</label>
              <input type="text" name="club_name"
                     value="<?php echo $row['name']; ?>"
                     class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Description</label>
              <textarea name="description" class="form-control" required><?php echo $row['Description']; ?></textarea>
            </div>

            <div class="mb-3">
              <label>Category</label>
              <select name="category" class="form-control">
                <option value="Software" <?php if($row['Category']=="Software") echo "selected"; ?>>Software</option>
                <option value="Cultural" <?php if($row['Category']=="Cultural") echo "selected"; ?>>Cultural</option>
                <option value="Sports" <?php if($row['Category']=="Sports") echo "selected"; ?>>Sports</option>
              </select>
            </div>

            <div class="mb-3">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="Active" <?php if($row['Status']=="Active") echo "selected"; ?>>Active</option>
                <option value="Inactive" <?php if($row['Status']=="Inactive") echo "selected"; ?>>Inactive</option>
              </select>
            </div>

            <div class="mb-3">
              <label>Club Members</label>
              <input type="number" name="members"
                     value="<?php echo $row['Club_member']; ?>"
                     class="form-control" required>
            </div>

            <button class="btn btn-danger">Update</button>
            <a href="manage_clube.php" class="btn btn-secondary">Cancel</a>

          </div>

        </div>

      </form>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// IMAGE PREVIEW
$("#clubImage").on("change", function() {
  let file = this.files[0];

  if (file) {
    let reader = new FileReader();

    reader.onload = function(e) {
      $("#previewImage").attr("src", e.target.result);
    }

    reader.readAsDataURL(file);
  }
});
</script>

<?php include 'F_footer.php'; ?>