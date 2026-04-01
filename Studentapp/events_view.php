<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include "../database.php";

// =====================
// LOGIN CHECK
if(isset($_GET['join'])){
    if(!isset($_SESSION['user_id'])){
        echo "<script>
            alert('⚠️ Please login first to join event!');
            window.location.href='login_view.php';
        </script>";
        exit();
    }
}

// =====================
// FORM SUBMIT BACKEND (SAME AS CLUB)
if(isset($_POST['submit_event']))
{
    if(!isset($_SESSION['user_id'])){
        echo "<script>
            alert('Please login first!');
            window.location.href='login_view.php';
        </script>";
        exit();
    }

    $user_id  = $_SESSION['user_id'];
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $event    = trim(mysqli_real_escape_string($con, $_POST['event_name']));
    $message  = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO event_join_requests 
              (user_id, name, email, phone, event_name, message) 
              VALUES ('$user_id','$name','$email','$phone','$event','$message')";

    if(mysqli_query($con, $query)){
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'You have successfully joined the event.',
                    icon: 'success'
                }).then(() => {
                    window.location.href='event_view.php';
                });
            });
        </script>";
    } else {
        echo "<script>alert('Database Error');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Events</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
</style>
</head>

<body>

<div class="container my-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-danger animate__animated animate__fadeInDown">
            Explore Our Events
        </h1>
        <p class="lead text-muted animate__animated animate__fadeInUp">
            Join exciting events and enhance your experience!
        </p>
    </div>

    <div class="row g-4">

        <!-- EVENT CARD -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <img src="assets/images/e1.avif" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-danger">Music Festival</h5>
                    <p class="text-muted">25th Feb 2026</p>
                    <p>Enjoy live performances from amazing artists.</p>

                    <a href="?join=Music Festival" class="btn btn-danger w-100">
                        Join Event
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JOIN MODAL -->
<div class="modal fade" id="joinModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Join Event</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form method="POST">

            <div class="mb-3">
                <label>Your Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label>Selected Event</label>
                <input type="text" name="event_name" id="event_name" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label>Why do you want to join?</label>
                <textarea name="message" rows="3" class="form-control"></textarea>
            </div>

            <button type="submit" name="submit_event" class="btn btn-danger w-100">Submit</button>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    <?php if(isset($_GET['join']) && isset($_SESSION['user_id'])){ ?>
        $("#event_name").val("<?php echo $_GET['join']; ?>");
        $("#joinModal").modal("show");
    <?php } ?>

});
</script>

<?php include 'footer.php'; ?>