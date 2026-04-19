<?php 
include 'F_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

/* ONLY ACTIVE EVENTS */
$result = mysqli_query($con, "SELECT * FROM events WHERE status='Active' ORDER BY id DESC");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background: linear-gradient(135deg,#f8f9fa,#eef1f7);
    font-family:'Segoe UI',sans-serif;
}

.page-title{
    text-align:center;
    font-weight:800;
    margin:30px 0;
    color:#dc3545;
}

/* CARD */
.event-card{
    position:relative;
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    transition:0.4s;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.event-card:hover{
    transform: translateY(-10px);
}

/* IMAGE WRAPPER */
.image-box{
    position:relative;
}

/* IMAGE */
.event-img{
    width:100%;
    height:220px;
    object-fit:cover;
}

/* 🔥 PAID / FREE CENTER BADGE */
.event-type-badge{
    position:absolute;
    top:15px;
    left:50%;
    transform:translateX(-50%);
    padding:6px 18px;
    font-size:13px;
    border-radius:30px;
    font-weight:600;
    backdrop-filter: blur(10px);
    color:#fff;
}

.paid{
    background: rgba(220,53,69,0.85);
}

.free{
    background: rgba(25,135,84,0.85);
}

/* CONTENT */
.event-body{
    padding:20px;
    text-align:center;
}

.event-name{
    font-size:18px;
    font-weight:700;
    color:#dc3545;
}

.event-text{
    font-size:14px;
    color:#666;
}

/* BUTTONS */
.btn-edit, .btn-delete{
    display:inline-block;
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
    text-decoration:none;
    margin:2px;
}

.btn-edit{
    background: linear-gradient(135deg,#ffc107,#ffda6a);
    color:#000;
}

.btn-delete{
    background: linear-gradient(135deg,#dc3545,#ff6b6b);
    color:#fff;
}

</style>

<div class="container my-4">

<h2 class="page-title">Manage Events</h2>

<div class="row g-4">

<?php while($row = mysqli_fetch_assoc($result)): ?>

<?php
$image = $row['image'] ?? '';
$path = "../uploads/".$image;

$finalImage = (!empty($image) && file_exists(__DIR__."/../uploads/".$image))
    ? $path
    : "https://via.placeholder.com/600x300";

/* PAID / FREE */
$type = strtolower(trim($row['event_type'] ?? ''));

if(in_array($type,['paid','1','yes','true'])){
    $label = "PAID EVENT";
    $class = "paid";
}else{
    $label = "FREE EVENT";
    $class = "free";
}
?>

<div class="col-lg-4 col-md-6">

    <div class="event-card">

        <!-- IMAGE -->
        <div class="image-box">

            <img src="<?php echo $finalImage; ?>" class="event-img">

            <!-- CENTER BADGE -->
            <div class="event-type-badge <?php echo $class; ?>">
                <?php echo $label; ?>
            </div>

        </div>

        <!-- BODY -->
        <div class="event-body">

            <div class="event-name">
                <?php echo htmlspecialchars($row['name']); ?>
            </div>

            <div class="event-text">
                📅 <?php echo date('d M Y', strtotime($row['date'])); ?>
            </div>

            <div class="event-text">
                🏷 <?php echo $row['category'] ?? 'General'; ?>
            </div>

            <div class="event-text">
                <?php echo substr($row['description'],0,80); ?>...
            </div>

            <div class="mt-3">

                <a href="Edits_event.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                    Edit
                </a>

                <a href="Delete_event.php?id=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Delete this event?')" 
                   class="btn-delete">
                    Delete
                </a>

            </div>

        </div>

    </div>

</div>

<?php endwhile; ?>

</div>

</div>

<?php include 'F_footer.php'; ?>