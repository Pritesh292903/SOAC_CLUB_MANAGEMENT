<?php 
include '../database.php';
include 'F_header.php';  

$faculty_id = $_SESSION['user_id'];

$result = mysqli_query($con, "SELECT * FROM clubs WHERE faculty_id='$faculty_id' ORDER BY id DESC"); 
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
.club-card{
    position:relative;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border-radius:25px;
    padding:25px;
    text-align:center;
    transition:0.4s;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    overflow:hidden;
}

/* IMPORTANT FIX (pseudo element click issue remove pointer block) */
.club-card::before{
    content:'';
    position:absolute;
    top:-50%;
    left:-50%;
    width:200%;
    height:200%;
    background: radial-gradient(circle, rgba(220,53,69,0.08), transparent 70%);
    transform:rotate(25deg);
    pointer-events:none;   /* 🔥 FIX CLICK ISSUE */
    z-index:0;
}

.club-card:hover{
    transform: translateY(-12px) scale(1.02);
}

/* CONTENT ABOVE BACKGROUND */
.club-card *{
    position:relative;
    z-index:2;
}

/* IMAGE */
.club-img{
    width:110px;
    height:110px;
    object-fit:cover;
    border-radius:50%;
    border:4px solid #dc3545;
}

/* TEXT */
.club-name{
    font-size:18px;
    font-weight:700;
    margin-top:15px;
    color:#dc3545;
}

.club-text{
    font-size:14px;
    color:#666;
}

/* RIBBON */
.ribbon{
    position:absolute;
    top:15px;
    right:-10px;
    background:#dc3545;
    color:#fff;
    padding:5px 20px;
    font-size:12px;
    transform:rotate(10deg);
    border-radius:5px;
    z-index:3;
}

.ribbon.free{
    background:#198754;
}

/* STATUS */
.status-badge{
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    display:inline-block;
    margin-top:5px;
}

/* BUTTON FIX (MOST IMPORTANT PART) */
.btn-edit, .btn-delete{
    display:inline-block;
    position:relative;
    z-index:5;   /* 🔥 ensure clickable */
    pointer-events:auto;
    text-decoration:none;
}

/* BUTTONS */
.btn-edit{
    background: linear-gradient(135deg,#ffc107,#ffda6a);
    border:none;
    padding:6px 18px;
    border-radius:30px;
    font-size:13px;
    color:#000;
    margin-right:5px;
}

.btn-delete{
    background: linear-gradient(135deg,#dc3545,#ff6b6b);
    border:none;
    padding:6px 18px;
    border-radius:30px;
    font-size:13px;
    color:#fff;
}

</style>

<div class="container my-4">

<h2 class="page-title">My Clubs Dashboard</h2>

<div class="row g-4">

<?php if(mysqli_num_rows($result) > 0): ?>
<?php while($row = mysqli_fetch_assoc($result)): ?>

<div class="col-lg-4 col-md-6">

    <div class="club-card">

        <!-- PAID / FREE -->
        <?php if(isset($row['club_paid']) && $row['club_paid'] == 'Paid'){ ?>
            <div class="ribbon">PAID</div>
        <?php } else { ?>
            <div class="ribbon free">FREE</div>
        <?php } ?>

        <?php
        $image = $row['clubimage'];
        $path = "../Adminapp/uploads/".$image;
        $finalImage = (!empty($image) && file_exists(__DIR__."/../Adminapp/uploads/".$image))
            ? $path
            : "https://via.placeholder.com/150";
        ?>

        <img src="<?php echo $finalImage; ?>" class="club-img">

        <div class="club-name">
            <?php echo htmlspecialchars($row['clubname']); ?>
        </div>

        <div class="club-text">
            Faculty: <?php echo htmlspecialchars($row['faculty']); ?>
        </div>

        <div class="club-text">
            Members: <?php echo $row['totalmembers'] ?? '0'; ?>
        </div>

        <span class="status-badge bg-<?php echo ($row['status']=='Active')?'success':'secondary'; ?> text-white">
            <?php echo $row['status']; ?>
        </span>

        <div class="mt-3">

            <!-- ✅ FIXED WORKING BUTTONS -->
            <a href="editclube.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">
                Edit
            </a>

            <a href="delete_club.php?id=<?php echo $row['id']; ?>" 
               onclick="return confirm('Delete this club?')" 
               class="btn btn-delete">
                Delete
            </a>

        </div>

    </div>

</div>

<?php endwhile; ?>
<?php else: ?>

<div class="col-12 text-center">
    <h5 class="text-muted">No clubs assigned to you</h5>
</div>

<?php endif; ?>

</div>
</div>

<?php include 'F_footer.php'; ?>