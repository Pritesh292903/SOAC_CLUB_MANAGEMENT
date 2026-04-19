<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include '../database.php';

// ================= JOIN INSERT =================
if(isset($_POST['join_club']))
{
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('Please login first!'); window.location.href='login_view.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $club_id = intval($_POST['club_id']);

    $check = mysqli_query($con, "SELECT * FROM club_join_requests 
                                WHERE user_id='$user_id' AND club_id='$club_id'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Already Requested', 'You already sent request!', 'info');
            });
        </script>";
    } else {

        mysqli_query($con, "INSERT INTO club_join_requests (user_id, club_id) 
                           VALUES ('$user_id','$club_id')");

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Request sent successfully!',
                    icon: 'success'
                }).then(()=>{ window.location.href='clubs_view.php'; });
            });
        </script>";
    }
}

$clubs_result = mysqli_query($con, "SELECT * FROM clubs WHERE status='Active' ORDER BY id ASC");

$user_id = $_SESSION['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Our Clubs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

body{
    background: linear-gradient(135deg,#fff5f5,#ffecec);
    font-family: 'Segoe UI', sans-serif;
}

.club-wrapper{
    margin-top:50px;
    margin-bottom:70px;
}

/* HEADER TITLE */
.page-title{
    text-align:center;
    margin-bottom:40px;
}

.page-title h1{
    font-weight:700;
    color:#b71c1c;
}

/* CARD DESIGN */
.club-card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    text-align:center;
    transition:0.3s;
    border:1px solid #eee;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.club-card:hover{
    transform:translateY(-10px);
    box-shadow:0 15px 30px rgba(183,28,28,0.2);
}

/* IMAGE */
.club-card img{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #e53935;
}

/* BADGE */
.badge-status{
    font-size:11px;
    padding:5px 12px;
    border-radius:20px;
    margin-top:10px;
}

/* BUTTON */
.club-btn{
    padding:7px 16px;
    font-size:13px;
    border-radius:25px;
    background:#e53935;
    color:white;
    border:none;
    text-decoration:none;
    display:inline-block;
    transition:0.3s;
}

.club-btn:hover{
    background:#b71c1c;
    transform:scale(1.05);
}

</style>
</head>

<body>

<main class="container club-wrapper">

<div class="page-title">
    <h1>🎯 Our Clubs</h1>
    <p class="text-muted">Join your favorite club & grow your skills</p>
</div>

<div class="row g-4">

<?php while($club = mysqli_fetch_assoc($clubs_result)): 

    $status_q = mysqli_query($con, "SELECT status FROM club_join_requests 
                                   WHERE user_id='$user_id' AND club_id='".$club['id']."'");
    
    $request = mysqli_fetch_assoc($status_q);
    $status = $request['status'] ?? null;
?>

<div class="col-md-3">
<div class="club-card">

    <img src="../Adminapp/uploads/<?php echo $club['clubimage']; ?>">

    <h5 class="mt-3"><?php echo $club['clubname']; ?></h5>
    <p class="text-muted mb-1"><?php echo $club['faculty']; ?></p>

    <p class="small text-muted">
        <?php echo substr($club['clubdescription'],0,60); ?>...
    </p>

    <!-- PAID / FREE -->
    <?php if(isset($club['club_paid']) && $club['club_paid']=="Paid"){ ?>
        <div><span class="badge bg-danger badge-status">Paid Club</span></div>
    <?php } else { ?>
        <div><span class="badge bg-success badge-status">Free Club</span></div>
    <?php } ?>

    <div class="mt-3 d-flex justify-content-center gap-2">

        <?php if($status == 'pending'): ?>
            <span class="badge bg-warning text-dark">Requested</span>

        <?php elseif($status == 'approved'): ?>
            <span class="badge bg-success">Joined</span>

        <?php elseif($status == 'rejected'): ?>
            <span class="badge bg-danger">Rejected</span>

        <?php else: ?>
            <button class="club-btn join-btn"
                data-id="<?php echo $club['id']; ?>"
                data-name="<?php echo $club['clubname']; ?>">
                Join
            </button>
        <?php endif; ?>

        <a href="club_detail.php?club_id=<?php echo $club['id']; ?>" class="club-btn">
            Details
        </a>

    </div>

</div>
</div>

<?php endwhile; ?>

</div>
</main>

<form id="joinForm" method="POST" style="display:none;">
    <input type="hidden" name="club_id" id="club_id">
    <input type="hidden" name="join_club">
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(".join-btn").click(function(){
    let id=$(this).data("id");
    let name=$(this).data("name");

    Swal.fire({
        title:"Join "+name+"?",
        icon:"question",
        showCancelButton:true,
        confirmButtonText:"Yes"
    }).then((res)=>{
        if(res.isConfirmed){
            $("#club_id").val(id);
            $("#joinForm").submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>