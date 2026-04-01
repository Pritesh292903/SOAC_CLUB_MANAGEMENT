<?php 
include 'F_header.php';
include '../database.php';

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM my_club");
?>

<div class="container my-5">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger">Manage Clubs</h2>
            <p class="text-muted mb-0">Add, Edit or Delete Clubs</p> 
        </div>

        <a href="add_club.php" class="btn btn-danger rounded-pill">
            <i class="bi bi-plus-circle"></i> Add Club
        </a>
    </div>

    <!-- Clubs Row -->
    <div class="row g-4">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">

                <!-- IMAGE -->
                <img src="../<?php echo $row['images']; ?>"
                     class="card-img-top rounded-top-4"
                     style="height:200px; object-fit:cover;">

                <div class="card-body text-center">

                    <!-- NAME -->
                    <h5 class="card-title fw-bold text-danger">
                        <?php echo $row['name']; ?>
                    </h5>

                    <!-- DESCRIPTION -->
                    <p class="text-muted">
                        <?php echo $row['Description']; ?>
                    </p>

                    <!-- STATUS -->
                    <span class="badge bg-success mb-2">
                        <?php echo $row['Status']; ?>
                    </span>

                    <br>

                    <!-- EDIT -->
                    <a href="editclube.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-warning btn-sm rounded-pill px-3">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>

                    <!-- DELETE -->
                    <a href="delete_club.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this club?')"
                       class="btn btn-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-trash me-1"></i> Delete
                    </a>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include 'F_footer.php'; ?>