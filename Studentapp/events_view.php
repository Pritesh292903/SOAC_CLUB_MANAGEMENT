<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include "../database.php";

// ================= JOIN INSERT =================
if(isset($_POST['join_event']))
{
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('Please login first!'); window.location.href='login_view.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $event_id = intval($_POST['event_id']);

    // CHECK DUPLICATE
    $check = mysqli_query($con, "SELECT * FROM event_join_requests 
                                WHERE user_id='$user_id' AND event_id='$event_id'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Already Requested', 'You already joined this event!', 'info');
            });
        </script>";
    } else {

        mysqli_query($con, "INSERT INTO event_join_requests (user_id, event_id) 
                           VALUES ('$user_id','$event_id')");

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Event request sent!',
                    icon: 'success'
                }).then(()=>{ window.location.href='events_view.php'; });
            });
        </script>";
    }
}

// ================= FETCH EVENTS =================
$events_result = mysqli_query($con, "SELECT * FROM events WHERE status='Active' ORDER BY id ASC");

$user_id = $_SESSION['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Events</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(217,4,41,.3);
    transition: 0.3s;
}
.card-img-top {
    height: 200px;
    object-fit: cover;
}
.badge-status {
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 20px;
}
</style>
</head>

<body>

<div class="container my-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-danger">Explore Our Events</h1>
        <p class="lead text-muted">Join exciting events!</p>
    </div>

    <div class="row g-4">

        <?php while($event = mysqli_fetch_assoc($events_result)): 
        
            // CHECK STATUS
            $status_q = mysqli_query($con, "SELECT status FROM event_join_requests 
                                           WHERE user_id='$user_id' AND event_id='".$event['id']."'");
            
            $request = mysqli_fetch_assoc($status_q);
            $status = $request['status'] ?? null;
        ?>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">

                <img src="../uploads/<?php echo $event['image']; ?>" class="card-img-top">

                <div class="card-body">
                    <h5 class="card-title text-danger"><?php echo $event['name']; ?></h5>
                    <p class="text-muted"><?php echo $event['date']; ?></p>
                    <p><?php echo $event['description']; ?></p>

                    <?php if($status == 'pending'): ?>
                        <span class="badge bg-warning text-dark badge-status">Requested</span>

                    <?php elseif($status == 'approved'): ?>
                        <span class="badge bg-success badge-status">Joined</span>

                    <?php elseif($status == 'rejected'): ?>
                        <span class="badge bg-danger badge-status">Rejected</span>

                    <?php else: ?>
                        <button class="btn btn-danger w-100 join-btn"
                            data-id="<?php echo $event['id']; ?>"
                            data-name="<?php echo $event['name']; ?>">
                            Join Event
                        </button>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <?php endwhile; ?>

    </div>
</div>

<!-- HIDDEN FORM -->
<form id="joinForm" method="POST" style="display:none;">
    <input type="hidden" name="event_id" id="event_id">
    <input type="hidden" name="join_event">
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(".join-btn").click(function(e){
    e.preventDefault();

    let event_id = $(this).data("id");
    let event_name = $(this).data("name");

    Swal.fire({
        title: "Join " + event_name + "?",
        text: "Do you want to join this event?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result)=>{
        if(result.isConfirmed){
            $("#event_id").val(event_id);
            $("#joinForm").submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>