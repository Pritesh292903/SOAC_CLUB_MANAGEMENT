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

    // CHECK DUPLICATE
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

// ================= FETCH CLUBS =================
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
body {
    font-family: 'Segoe UI', sans-serif;
    background: #fff5f5;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
main { flex: 1; }

.club-wrapper { margin-top: 50px; margin-bottom: 70px; }

.club-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f1c1c1;
    padding: 25px 20px;
    text-align: center;
    transition: 0.4s;
    height: 100%;
}
.club-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(183,28,28,0.2);
}

.club-card img {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    object-fit: cover;
}

.club-btn {
    padding: 7px 18px;
    font-size: 13px;
    border-radius: 30px;
    background: #e53935;
    color: white;
    border: none;
}
.club-btn:hover { background: #b71c1c; }

.badge-status {
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 20px;
}
footer { margin-top: auto; }
</style>
</head>

<body>

<main class="container club-wrapper">

    <div class="text-center mb-5">
        <h1 class="text-danger">Our Clubs</h1>
        <p class="text-muted">Join your favorite club</p>
    </div>

    <div class="row g-4">

        <?php while($club = mysqli_fetch_assoc($clubs_result)): 
        
            // ================= CHECK REQUEST STATUS =================
            $status_q = mysqli_query($con, "SELECT status FROM club_join_requests 
                                           WHERE user_id='$user_id' AND club_id='".$club['id']."'");
            
            $request = mysqli_fetch_assoc($status_q);
            $status = $request['status'] ?? null;
        ?>

        <div class="col-md-3">
            <div class="club-card">

                <img src="../Adminapp/uploads/<?php echo $club['clubimage']; ?>">

                <h5><?php echo $club['clubname']; ?></h5>
                <p><?php echo $club['faculty']; ?><p>
                <p class="small text-muted"><?php echo $club['clubdescription']; ?></p>

                <div class="d-flex justify-content-center gap-2">

                    <?php if($status == 'pending'): ?>
                        <span class="badge bg-warning text-dark badge-status">Requested</span>

                    <?php elseif($status == 'approved'): ?>
                        <span class="badge bg-success badge-status">Joined</span>

                    <?php elseif($status == 'rejected'): ?>
                        <span class="badge bg-danger badge-status">Rejected</span>

                    <?php else: ?>
                        <!-- JOIN BUTTON -->
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

<!-- HIDDEN FORM -->
<form id="joinForm" method="POST" style="display:none;">
    <input type="hidden" name="club_id" id="club_id">
    <input type="hidden" name="join_club">
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(".join-btn").click(function(e){
    e.preventDefault();

    let club_id = $(this).data("id");
    let club_name = $(this).data("name");

    Swal.fire({
        title: "Join " + club_name + "?",
        text: "Do you want to send request?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result)=>{
        if(result.isConfirmed){
            $("#club_id").val(club_id);
            $("#joinForm").submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>