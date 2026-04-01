<?php 
include 'F_header.php';
include '../database.php';

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM manage_clubs");
?>

<div class="container my-5">

    <!-- Page Title + Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger">Manage Events</h2>
            <p class="text-muted mb-0">Add, Edit or Delete Events</p>
        </div>

        <a href="Addevent.php"
            class="btn btn-danger rounded-pill px-4 fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Add Event
        </a>
    </div>

    <!-- Events Row -->
    <div class="row g-4">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 position-relative">

                <!-- DATE (Static for now) -->
                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
                    Club
                </span>

                <!-- IMAGE FROM DB -->
                <img src="../<?php echo $row['Image']; ?>"
                    class="card-img-top rounded-top-4"
                    style="height:200px; object-fit:cover;">

                <div class="card-body text-center">

                    <!-- CLUB NAME -->
                    <h5 class="fw-bold text-danger">
                        <?php echo $row['club_name']; ?>
                    </h5>

                    <!-- DESCRIPTION -->
                    <p class="text-muted">
                        <?php echo $row['Description']; ?>
                    </p>

                    <!-- OPTIONAL -->
                    <small class="text-secondary d-block">
                        <?php echo $row['Category']; ?> | <?php echo $row['Status']; ?>
                    </small>

                    <div class="d-flex justify-content-center gap-2 mt-3">

                        <!-- VIEW -->
                        <a href="Viewhackathon.php?id=<?php echo $row['Club_id']; ?>" 
                           class="btn btn-success btn-sm rounded-pill px-3">
                            <i class="bi bi-eye me-1"></i> View
                        </a>

                        <!-- EDIT -->
                        <a href="Edit_event.php?id=<?php echo $row['Club_id']; ?>" 
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>

                    </div>
                </div>

            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include 'F_footer.php'; ?>