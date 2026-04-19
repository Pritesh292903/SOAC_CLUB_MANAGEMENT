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

/* ===== BACKGROUND ===== */
body{
    background: linear-gradient(135deg,#f8f9fa,#fff);
    font-family: 'Segoe UI', sans-serif;
}

/* ===== TITLE ===== */
.page-title{
    text-align:center;
    margin:40px 0;
}

.page-title h1{
    font-weight:800;
    color:#dc3545;
}

/* ===== CARD ===== */
.event-card{
    border: none;
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.event-card:hover{
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(220,53,69,0.25);
}

/* IMAGE */
.event-card img{
    height: 230px;
    object-fit: cover;
}

/* BODY */
.event-body{
    padding: 20px;
}

/* TITLE */
.event-title{
    font-size: 20px;
    font-weight: 700;
    color: #dc3545;
}

/* TAGS */
.tag{
    display:inline-block;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    margin-bottom:8px;
}

.tag-paid{
    background:#dc3545;
    color:#fff;
}

.tag-free{
    background:#198754;
    color:#fff;
}

/* BUTTON */
.join-btn{
    width:100%;
    border-radius:30px;
    padding:10px;
    font-weight:600;
}

/* BADGE */
.badge-status{
    font-size:12px;
    padding:6px 10px;
    border-radius:20px;
}

</style>
</head>

<body>

<div class="container">

    <div class="page-title">
        <h1>🎉 Explore Events</h1>
        <p class="text-muted">Join amazing campus events</p>
    </div>

    <div class="row g-4">

    <?php while($event = mysqli_fetch_assoc($events_result)):

        $status_q = mysqli_query($con, "SELECT status FROM event_join_requests 
                                       WHERE user_id='$user_id' AND event_id='".$event['id']."'");
        
        $request = mysqli_fetch_assoc($status_q);
        $status = $request['status'] ?? null;

        $type = $event['event_type'] ?? 'Free';
    ?>

    <div class="col-md-4">

        <div class="card event-card">

            <img src="../uploads/<?php echo $event['image']; ?>">

            <div class="event-body">

                <div class="event-title">
                    <?php echo $event['name']; ?>
                </div>

                <p class="text-muted mb-1">📅 <?php echo $event['date']; ?></p>

                <!-- TYPE TAG -->
                <?php if($type == 'Paid'){ ?>
                    <span class="tag tag-paid">Paid Event</span>
                <?php } else { ?>
                    <span class="tag tag-free">Free Event</span>
                <?php } ?>

                <p class="text-muted mt-2">
                    <?php echo substr($event['description'],0,90); ?>...
                </p>

                <!-- STATUS -->
                <?php if($status == 'pending'): ?>
                    <span class="badge bg-warning text-dark badge-status">Requested</span>

                <?php elseif($status == 'approved'): ?>
                    <span class="badge bg-success badge-status">Joined</span>

                <?php elseif($status == 'rejected'): ?>
                    <span class="badge bg-danger badge-status">Rejected</span>

                <?php else: ?>
                    <button class="btn btn-danger join-btn"
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

<!-- FORM -->
<form id="joinForm" method="POST" style="display:none;">
    <input type="hidden" name="event_id" id="event_id">
    <input type="hidden" name="join_event">
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(".join-btn").click(function(e){
    e.preventDefault();

    let id = $(this).data("id");
    let name = $(this).data("name");

    Swal.fire({
        title: "Join " + name + "?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((res)=>{
        if(res.isConfirmed){
            $("#event_id").val(id);
            $("#joinForm").submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>