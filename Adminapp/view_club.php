<?php
include 'admin_header.php';
include '../database.php';

// GET CLUB ID
$id = $_GET['id'] ?? 0;

// FETCH CLUB DATA
$query = "SELECT * FROM clubs WHERE id='$id'";
$result = mysqli_query($con, $query);
$club = mysqli_fetch_assoc($result);

if (!$club) {
    echo "<script>alert('Club not found!'); window.location.href='all_club_page.php';</script>";
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* Ensure content is below header */
.content {
    animation: fadeIn 0.6s ease-in-out;
    margin-top: 100px; /* Adjust this according to your header height */
    margin-bottom: 50px;
}

/* Fade-in animation */
@keyframes fadeIn {
    from { opacity:0; transform:translateY(15px); }
    to { opacity:1; transform:translateY(0); }
}

/* Club image styling */
.club-img {
    width:200px; 
    height:200px; 
    object-fit:cover; 
    border-radius:12px; 
    margin-bottom:20px;
    border: 2px solid #ddd;
}

/* Card styling */
.card {
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    background-color: #fff;
}

/* Titles */
.card-title { font-weight:700; font-size:1.8rem; }

/* Field labels */
.fw-bold { font-weight:600; }

/* Back button */
.back-btn { border-radius:50px; padding:10px 25px; }
</style>

<div class="content container">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="text-center mb-4">
            <img src="uploads/<?php echo htmlspecialchars($club['clubimage']); ?>" class="club-img" alt="Club Image">
        </div>

        <h3 class="card-title text-center text-danger"><?php echo htmlspecialchars($club['clubname']); ?></h3>
        <hr>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Assigned Faculty:</div>
            <div class="col-md-8"><?php echo htmlspecialchars($club['faculty']); ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Total Members:</div>
            <div class="col-md-8"><?php echo htmlspecialchars($club['totalmembers']); ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Status:</div>
            <div class="col-md-8">
                <?php if($club['status'] == 'Active') { ?>
                    <span class="badge bg-success">Active</span>
                <?php } else { ?>
                    <span class="badge bg-secondary">Inactive</span>
                <?php } ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Description:</div>
            <div class="col-md-8"><?php echo nl2br(htmlspecialchars($club['clubdescription'])); ?></div>
        </div>

        <div class="text-center mt-4">
            <a href="all_clubes_page.php" class="btn btn-danger back-btn">Back to All Clubs</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'admin_footer.php'; ?>