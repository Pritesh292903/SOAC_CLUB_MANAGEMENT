<?php
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;

$query = "SELECT * FROM clubs WHERE id='$id'";
$result = mysqli_query($con, $query);
$club = mysqli_fetch_assoc($result);

if (!$club) {
    echo "<script>alert('Club not found!'); window.location.href='all_clubes_page.php';</script>";
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
/* SAME DESIGN LIKE EVENT PAGE */
.content {
    margin-top: 80px;
    margin-left: 250px;
    padding: 20px;
    animation: fadeIn 0.6s ease-in-out;
}

@media(max-width:992px){
    .content{ margin-left: 0; }
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}

/* CARD */
.event-box {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    display: flex;
    flex-wrap: wrap;
    max-width: 1100px;
    margin: auto;
}

/* IMAGE SIDE */
.event-img-box {
    flex: 1;
    min-height: 350px;
    background-size: cover;
    background-position: center;
    cursor: pointer;
    transition: 0.3s;
}
.event-img-box:hover {
    transform: scale(1.03);
}

/* DETAILS */
.event-details {
    flex: 1;
    padding: 40px;
}

.event-title {
    font-size: 32px;
    font-weight: bold;
    color: #dc3545;
    margin-bottom: 20px;
}

.info-row {
    margin-bottom: 15px;
    font-size: 16px;
}

.info-row span {
    font-weight: 600;
    color: #555;
}

/* BADGES */
.badge-custom {
    padding: 6px 15px;
    border-radius: 50px;
    color: #fff;
    font-size: 14px;
}

.active { background: #28a745; }
.inactive { background: #6c757d; }
.paid { background: #dc3545; }
.free { background: #17a2b8; }

/* BUTTON */
.back-btn {
    margin-top: 25px;
    border-radius: 50px;
    padding: 10px 25px;
}

/* MOBILE */
@media(max-width:768px){
    .event-box { flex-direction: column; }
    .event-details { padding: 20px; }
}
</style>

<div class="content">

<div class="event-box">

    <!-- IMAGE -->
    <div class="event-img-box"
        id="clubImage"
        style="background-image: url('uploads/<?php echo $club['clubimage'] ?: 'default.png'; ?>');">
    </div>

    <!-- DETAILS -->
    <div class="event-details">

        <div class="event-title">
            <?php echo htmlspecialchars($club['clubname']); ?>
        </div>

        <div class="info-row">
            <span>Faculty:</span>
            <?php echo htmlspecialchars($club['faculty']); ?>
        </div>

        <div class="info-row">
            <span>Total Members:</span>
            <?php echo htmlspecialchars($club['totalmembers']); ?>
        </div>

        <div class="info-row">
            <span>Status:</span>
            <span class="badge-custom <?php echo ($club['status']=='Active')?'active':'inactive'; ?>">
                <?php echo $club['status']; ?>
            </span>
        </div>

        <div class="info-row">
            <span>Club Type:</span>
            <span class="badge-custom <?php echo ($club['club_paid']=='Paid')?'paid':'free'; ?>">
                <?php echo $club['club_paid'] ?? 'Free'; ?>
            </span>
        </div>

        <div class="info-row">
            <span>Description:</span><br>
            <?php echo nl2br(htmlspecialchars($club['clubdescription'])); ?>
        </div>

        <a href="all_clubes_page.php" class="btn btn-danger back-btn">
            ← Back to Clubs
        </a>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// IMAGE POPUP
document.getElementById('clubImage')?.addEventListener('click', function () {
    Swal.fire({
        imageUrl: this.style.backgroundImage.slice(5, -2),
        showCloseButton: true,
        showConfirmButton: false,
        width: '600px'
    });
});
</script>

<?php include 'admin_footer.php'; ?>