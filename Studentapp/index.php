<?php
include 'header.php';
include '../database.php';

// FETCH
$slider_images = mysqli_query($con, "SELECT * FROM slider_images ORDER BY id DESC");
$clubs = mysqli_query($con, "SELECT * FROM clubs WHERE status='Active' ORDER BY id ASC");
$events = mysqli_query($con, "SELECT * FROM events WHERE status='Active' ORDER BY id ASC");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* BODY */
body{
    font-family: 'Segoe UI', sans-serif;
    background:#f6f7fb;
}

/* WELCOME */
.welcome-box{
    background: linear-gradient(135deg,#dc3545,#ff6b6b);
    color:white;
    padding:30px;
    border-radius:20px;
    text-align:center;
    margin-top:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* SECTION TITLE */
.section-title{
    font-weight:700;
    margin:40px 0 20px;
    text-align:center;
    color:#dc3545;
    position:relative;
}
.section-title::after{
    content:'';
    width:80px;
    height:3px;
    background:#dc3545;
    display:block;
    margin:10px auto;
    border-radius:10px;
}

/* CARD COMMON */
.card-box{
    background:#fff;
    border-radius:18px;
    padding:20px;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    height:100%;
    position:relative;
    overflow:hidden;
}

.card-box:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 30px rgba(0,0,0,0.15);
}

/* CLUB IMAGE */
.club-img{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #dc3545;
}

/* EVENT IMAGE */
.event-img{
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:12px;
}

/* BADGES */
.badge-paid{
    position:absolute;
    top:15px;
    right:15px;
    background:#dc3545;
    color:white;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
}

.badge-free{
    position:absolute;
    top:15px;
    right:15px;
    background:#198754;
    color:white;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
}

/* BUTTON */
.btn-custom{
    background:#dc3545;
    color:white;
    border-radius:30px;
    font-size:13px;
    padding:6px 15px;
}
.btn-custom:hover{
    background:#b02a37;
    color:#fff;
}

</style>

<main class="container">

<!-- WELCOME -->
<div class="welcome-box">
    <h2>Welcome To RKU SOAC Clubs</h2>
    <p>Explore clubs, join events & grow your skills 🚀</p>
</div>

<!-- SLIDER (UNCHANGED) -->
<div id="miniSlider" class="carousel slide my-4" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php $first=true; while($img=mysqli_fetch_assoc($slider_images)){ ?>
            <div class="carousel-item <?php if($first){echo 'active'; $first=false;} ?>">
                <img src="../Adminapp/slider_images/<?php echo $img['image']; ?>" class="d-block w-100" style="height:400px;object-fit:cover;border-radius:20px;">
            </div>
        <?php } ?>
    </div>
</div>

<!-- ================= CLUBS ================= -->
<h2 class="section-title">Our Clubs</h2>

<div class="row g-4">

<?php while($club=mysqli_fetch_assoc($clubs)){ ?>

<div class="col-md-3 col-sm-6">

    <div class="card-box text-center">

        <!-- PAID/FREE -->
        <?php if(isset($club['club_paid']) && $club['club_paid']=="Paid"){ ?>
            <div class="badge-paid">Paid Club</div>
        <?php } else { ?>
            <div class="badge-free">Free Club</div>
        <?php } ?>

        <img src="../Adminapp/uploads/<?php echo $club['clubimage']; ?>" class="club-img">

        <h5 class="mt-3 text-danger"><?php echo $club['clubname']; ?></h5>
        <p class="text-muted small"><?php echo $club['faculty']; ?></p>
        <p class="small"><?php echo substr($club['clubdescription'],0,60); ?>...</p>

        <a href="club_detail.php?club_id=<?php echo $club['id']; ?>" class="btn btn-custom btn-sm">Details</a>

    </div>
</div>

<?php } ?>

</div>

<!-- ================= EVENTS ================= -->
<h2 class="section-title">Our Events</h2>

<div class="row g-4">

<?php while($event=mysqli_fetch_assoc($events)){ ?>

<div class="col-md-3 col-sm-6">

    <div class="card-box">

        <!-- EVENT TYPE -->
        <?php if(isset($event['event_type']) && $event['event_type']=="Paid"){ ?>
            <div class="badge-paid">Paid Event</div>
        <?php } else { ?>
            <div class="badge-free">Free Event</div>
        <?php } ?>

        <img src="../uploads/<?php echo $event['image']; ?>" class="event-img">

        <h5 class="mt-3 text-danger"><?php echo $event['name']; ?></h5>
        <p class="small text-muted"><?php echo substr($event['description'],0,70); ?>...</p>

        <a href="event_details.php?id=<?php echo $event['id']; ?>" class="btn btn-custom btn-sm w-100">View</a>

    </div>

</div>

<?php } ?>

</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>