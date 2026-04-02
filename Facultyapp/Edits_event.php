<?php
ob_start(); // ADD THIS LINE
include 'F_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

// CHECK ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: Manage_events.php"); // FIXED
    exit();
}

$id = intval($_GET['id']); // safer

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM events WHERE id='$id'");

if (!$result || mysqli_num_rows($result) == 0) {
    die("Event Not Found");
}

$row = mysqli_fetch_assoc($result);

// UPDATE LOGIC
if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $date = $_POST['date'];
    $status = $_POST['status'];

    // IMAGE UPDATE
    if (!empty($_FILES['image']['name'])) {

        $image = time() . "_" . basename($_FILES['image']['name']);
        $tmp = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmp, "../uploads/events/" . $image)) {

            $sql = "UPDATE events SET 
                name='$name',
                description='$description',
                date='$date',
                status='$status',
                image='$image'
                WHERE id='$id'";
        } else {
            die("Image Upload Failed");
        }

    } else {

        $sql = "UPDATE events SET 
            name='$name',
            description='$description',
            date='$date',
            status='$status'
            WHERE id='$id'";
    }

    // EXECUTE UPDATE
    if (mysqli_query($con, $sql)) {

        // 🔥 REDIRECT FIXED HERE
        header("Location: Manage_events.php");
        exit();

    } else {
        echo "Update Failed: " . mysqli_error($con);
    }
}
?>

<div class="container my-5">
    <div class="card shadow border-0 rounded-4 p-4">

        <h3 class="text-danger mb-4">Edit Event</h3>

        <form method="POST" enctype="multipart/form-data">

            <!-- NAME -->
            <label class="fw-semibold">Event Name</label>
            <input type="text" name="name"
                   value="<?php echo htmlspecialchars($row['name']); ?>"
                   class="form-control mb-3" required>

            <!-- DESCRIPTION -->
            <label class="fw-semibold">Description</label>
            <textarea name="description"
                      class="form-control mb-3"
                      rows="4"
                      required><?php echo htmlspecialchars($row['description']); ?></textarea>

            <!-- DATE -->
            <label class="fw-semibold">Date</label>
            <input type="date" name="date"
                   value="<?php echo $row['date']; ?>"
                   class="form-control mb-3" required>

            <!-- STATUS -->
            <label class="fw-semibold">Status</label>
            <select name="status" class="form-control mb-3">
                <option value="Active" <?php if($row['status']=='Active') echo 'selected'; ?>>Active</option>
                <option value="Closed" <?php if($row['status']=='Closed') echo 'selected'; ?>>Closed</option>
            </select>

            <!-- IMAGE -->
            <label class="fw-semibold">Change Image</label>
            <input type="file" name="image" class="form-control mb-3">

            <!-- CURRENT IMAGE -->
            <?php if (!empty($row['image']) && file_exists("../uploads/events/".$row['image'])) { ?>
                <img src="../uploads/events/<?php echo $row['image']; ?>"
                     style="height:100px; object-fit:cover;"
                     class="mb-3 rounded">
            <?php } ?>

            <!-- BUTTON -->
            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
            <a href="Manage_events.php" class="btn btn-secondary">Cancel</a>

        </form>

    </div>
</div>

<?php include 'F_footer.php'; ?>
<?php ob_end_flush(); ?>