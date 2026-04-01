<?php 
include 'F_header.php';
include '../database.php';

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM my_club");
?>

<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger">Manage Clubs</h2>
            <p class="text-muted mb-0">Add, Edit or Delete Clubs</p> 
        </div>
    </div>

    <div class="row g-4">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">

                <!-- ✅ IMAGE FIX + CACHE BREAK -->
                <?php
                $image = $row['images'];
                $serverPath = __DIR__ . "/uploads/" . $image;
                $displayPath = "uploads/" . $image;
                ?>

                <?php if (!empty($image) && file_exists($serverPath)) { ?>
                    <img src="<?php echo $displayPath . '?t=' . time(); ?>"
                         class="card-img-top rounded-top-4"
                         style="height:200px; object-fit:cover;">
                <?php } else { ?>
                    <img src="https://via.placeholder.com/300x200"
                         class="card-img-top rounded-top-4">
                <?php } ?>

                <div class="card-body text-center">

                    <h5 class="card-title fw-bold text-danger">
                        <?php echo $row['name']; ?>
                    </h5>

                    <p class="text-muted">
                        <?php echo $row['Description']; ?>
                    </p>

                    <span class="badge bg-success mb-2">
                        <?php echo $row['Status']; ?>
                    </span>

                    <br>

                    <a href="editclube.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-warning btn-sm rounded-pill px-3">
                        Edit
                    </a>

                    <a href="delete_club.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Are you sure?')"
                       class="btn btn-danger btn-sm rounded-pill px-3">
                        Delete
                    </a>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include 'F_footer.php'; ?>