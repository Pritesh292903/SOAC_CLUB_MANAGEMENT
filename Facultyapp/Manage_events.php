<?php 
include 'F_header.php';
include '../database.php';

// Select Database and Create Events Table if Not Exists
mysqli_select_db($con, "SOAE_CLUB");
mysqli_query($con, "CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    name VARCHAR(100),
    date DATE,
    status VARCHAR(50),
    description TEXT,
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM events ORDER BY date DESC");
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

        <?php while($row = mysqli_fetch_assoc($result)) { 
            // Set image path
            $imgPath = !empty($row['image']) ? "../uploads/events/" . $row['image'] : "../uploads/default.png";
        ?>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 position-relative">

                <!-- IMAGE FROM DB -->
                <img src="<?php echo $imgPath; ?>" 
                     class="card-img-top rounded-top-4" 
                     style="height:200px; object-fit:cover;">

                <div class="card-body text-center">

                    <!-- EVENT NAME -->
                    <h5 class="fw-bold text-danger">
                        <?php echo $row['name']; ?>
                    </h5>

                    <!-- DESCRIPTION -->
                    <p class="text-muted">
                        <?php echo $row['description']; ?>
                    </p>

                    <!-- DATE AND STATUS -->
                    <small class="text-secondary d-block">
                        <?php echo date('d M Y', strtotime($row['date'])); ?> | <?php echo $row['status']; ?>
                    </small>

                    <div class="d-flex justify-content-center gap-2 mt-3">

                        <!-- VIEW -->
                        <a href="View_event.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-success btn-sm rounded-pill px-3">
                            <i class="bi bi-eye me-1"></i> View
                        </a>

                        <!-- EDIT -->
                        <a href="Edit_event.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>

                        <!-- DELETE -->
                        <a href="Delete_event.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-danger btn-sm rounded-pill px-3">
                            <i class="bi bi-trash me-1"></i> Delete
                        </a>

                    </div>
                </div>

            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include 'F_footer.php'; ?>