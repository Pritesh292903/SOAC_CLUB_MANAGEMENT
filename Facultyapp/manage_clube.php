<?php
include 'F_header.php';
include '../database.php';

// FETCH ALL CLUBS
$result = mysqli_query($con, "SELECT * FROM clubs ORDER BY id DESC");
?>

<div class="container my-5">

    <div class="row g-4">

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 h-100">

                        <?php
                        $image = $row['clubimage'];

                        // SERVER PATH (for checking file)
                        $filePath = __DIR__ . "/../uploads/" . $image;

                        // BROWSER PATH (for display)
                        $displayPath = "../Adminapp/uploads/" . $image;

                        if (!empty($image) && file_exists($filePath)) {
                            $finalImage = $displayPath . '?t=' . time();
                        } else {
                            $finalImage = "https://via.placeholder.com/150";
                        }
                        ?>

                        <div class="text-center mt-3">
                            <img src="<?php echo $finalImage; ?>"
                                class="rounded-circle"
                                style="width:120px;height:120px;object-fit:cover;">
                        </div>

                        <div class="card-body text-center">

                            <h5 class="fw-bold text-danger">
                                <?php echo htmlspecialchars($row['clubname']); ?>
                            </h5>

                            <p class="text-muted">
                                Faculty: <?php echo htmlspecialchars($row['faculty']); ?>
                            </p>

                            <p class="text-muted">
                                Members: <?php echo $row['totalmembers']; ?>
                            </p>

                            <span class="badge <?php echo ($row['status'] == 'Active') ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo $row['status']; ?>
                            </span>

                            <br><br>

                            <!-- EDIT + DELETE BUTTONS -->
                            <a href="editclube.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-warning btn-sm me-2 text-dark">
                                Edit
                            </a>

                            <a href="delete_club.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Delete this club?')"
                                class="btn btn-danger btn-sm">
                                Delete
                            </a>

                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>No clubs found.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'F_footer.php'; ?>