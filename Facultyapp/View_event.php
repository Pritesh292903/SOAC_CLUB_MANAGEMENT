<?php
include 'F_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

// CHECK ID
if (!isset($_GET['id'])) {
    header("Location: Manage_events.php"); // FIXED (s added)
    exit();
}

$id = $_GET['id'];

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM events WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<h3 class='text-center mt-5'>Event Not Found</h3>";
    exit();
}

// IMAGE
$imgPath = (!empty($row['image']) && file_exists("../uploads/events/".$row['image'])) 
            ? "../uploads/events/".$row['image'] 
            : "../uploads/default.png";

// SAFE CATEGORY (FIX HERE)
$category = isset($row['category']) ? $row['category'] : "Not Available";
// OR modern way:
// $category = $row['category'] ?? "Not Available";
?>

<div class="container my-5">
    <div class="card shadow border-0 rounded-4 p-4">

        <img src="<?= $imgPath ?>" style="height:300px; object-fit:cover;" class="rounded mb-4">

        <h2 class="text-danger fw-bold"><?= $row['name']; ?></h2>

        <p class="text-muted"><?= $row['description']; ?></p>

        <p><strong>Date:</strong> <?= date('d M Y', strtotime($row['date'])); ?></p>
        <p><strong>Status:</strong> <?= $row['status']; ?></p>

        <a href="Manage_events.php" class="btn btn-secondary mt-3">Back</a>

    </div>
</div>

<?php include 'F_footer.php'; ?>