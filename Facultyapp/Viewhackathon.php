<?php 
include 'F_header.php';
include '../database.php';

// CHECK ID
if(!isset($_GET['id'])){
    header("Location: Manage_events.php");
    exit();
}

$id = $_GET['id'];

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM manage_clubs WHERE Club_id='$id'");
$data = mysqli_fetch_assoc($result);

// IF NOT FOUND
if(!$data){
    echo "<h3 class='text-center text-danger mt-5'>Event Not Found</h3>";
    exit();
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="fw-bold text-danger mb-4 text-center">Event Details</h2>

            <!-- Event Card -->
            <div class="card shadow-sm border-0 rounded-4">

                <!-- IMAGE -->
                <img src="../<?php echo $data['Image']; ?>"
                    class="card-img-top rounded-top-4"
                    style="height:300px; object-fit:cover;">

                <div class="card-body">

                    <!-- TITLE -->
                    <h3 class="fw-bold text-danger">
                        <?php echo $data['club_name']; ?>
                    </h3>

                    <!-- CATEGORY / STATUS -->
                    <p class="text-muted">
                        <strong>Category:</strong> <?php echo $data['Category']; ?>
                    </p>

                    <p class="text-muted">
                        <strong>Status:</strong> <?php echo $data['Status']; ?>
                    </p>

                    <!-- MEMBERS -->
                    <p class="text-muted">
                        <strong>Members:</strong> <?php echo $data['Club_member']; ?>
                    </p>

                    <!-- DESCRIPTION -->
                    <p class="text-muted">
                        <?php echo $data['Description']; ?>
                    </p>

                    <!-- STATIC (optional keep) -->
                    <p class="text-muted"><strong>Location:</strong> RKU Campus, Auditorium</p>
                    <p class="text-muted"><strong>Organizer:</strong> <?php echo $data['Category']; ?></p>

                    <!-- BACK BUTTON -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="Manage_events.php" class="btn btn-secondary rounded-pill px-4">
                            Back to Events
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<?php include 'F_footer.php'; ?>