<?php 
include 'header.php';
include "../database.php";

// CHECK LOGIN
$isLoggedIn = isset($_SESSION['user_id']);

// GET EVENT ID FROM URL
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// FETCH EVENT DETAILS
if($event_id > 0){
    $event_query = mysqli_query($con, "SELECT * FROM events WHERE id='$event_id' LIMIT 1");
} else {
    $event_query = mysqli_query($con, "SELECT * FROM events ORDER BY id ASC LIMIT 1");
}

if(mysqli_num_rows($event_query) == 0){
    echo "<script>alert('Event not found!'); window.location.href='clubs_view.php';</script>";
    exit();
}

$event = mysqli_fetch_assoc($event_query);

// HANDLE FORM SUBMISSION
if(isset($_POST['submit_event'])) {
    if(!$isLoggedIn){
        echo "<script>
            alert('Please login first!');
            window.location.href='login_view.php';
        </script>";
        exit();
    }

    $user_id     = $_SESSION['user_id'];
    $name        = mysqli_real_escape_string($con, $_POST['name']);
    $email       = mysqli_real_escape_string($con, $_POST['email']);
    $phone       = mysqli_real_escape_string($con, $_POST['phone']);
    $event_name  = mysqli_real_escape_string($con, $_POST['event_name']);
    $message     = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO club_join_requests 
              (user_id, name, email, phone, club_name, message) 
              VALUES ('$user_id', '$name', '$email', '$phone', '$event_name', '$message')";

    if(mysqli_query($con, $query)) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                title: 'Success!',
                text: 'You have successfully joined the event.',
                icon: 'success',
                confirmButtonColor: '#d90429',
            }).then(() => {
                window.location.href='clubs_view.php';
            });
        });
        </script>";
    } else {
        echo "<script>alert('Database error!');</script>";
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <div class="card">

        <!-- Banner Image -->
        <img src="<?php echo !empty($event['banner']) ? $event['banner'] : 'assets/images/e1.avif'; ?>" 
             alt="<?php echo htmlspecialchars($event['name']); ?>" 
             class="hero-img mx-auto d-block">

        <div class="card-body">

            <!-- Event Name -->
            <h2 class="mb-4 text-center"><?php echo htmlspecialchars($event['name']); ?></h2>

            <!-- Event Info -->
            <div class="event-info mx-auto" style="max-width:700px;">
                <h4>Club Details</h4>
                <ul class="list-unstyled mb-0">
                    <li><strong>Event Name:</strong> <?php echo htmlspecialchars($event['name']); ?></li>
                    <li><strong>Date:</strong> <?php echo date('d-m-Y', strtotime($event['date'])); ?></li>
                    <li><strong>Status:</strong> <?php echo htmlspecialchars($event['status']); ?></li>
                    <li><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></li>
                </ul>
            </div>

            <!-- Join Event Button -->
            <div class="text-center mb-4 mt-4">
                <button class="btn btn-theme btn-lg joinBtn" 
                        data-event="<?php echo htmlspecialchars($event['name']); ?>"
                        data-login="<?php echo $isLoggedIn ? 'yes' : 'no'; ?>">
                    Join Club
                </button>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="clubs_view.php" class="btn btn-outline-theme">Back to Events</a>
            </div>

        </div>
    </div>
</div>

<!-- ===== JOIN EVENT MODAL ===== -->
<div class="modal fade" id="joinModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Join Club</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="eventForm" method="POST">

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

<style>
body {
    background: #fff5f5;
    color: #333;
    font-family: 'Segoe UI', sans-serif;
}

.card {
    border-radius: 25px;
    border: none;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.card:hover { transform: translateY(-10px); }

.hero-img {
    width: 100%;
    max-width: 600px;
    height: auto;
    object-fit: cover;
    border-radius: 25px 25px 0 0;
    animation: fadeInDown 1s;
}

.card-body { padding: 50px; }

h2 { font-weight: 700; color: #b71c1c; animation: fadeInUp 1.2s; }

.event-info {
    background: #fff;
    border-left: 5px solid #b71c1c;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 40px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    animation: fadeIn 1.5s;
}

.event-info h4 { font-weight: 600; margin-bottom: 15px; color: #b71c1c; }

.event-info ul li { margin-bottom: 12px; font-size: 1rem; }

.btn-theme {
    background-color: #b71c1c !important;
    color: #fff !important;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 45px;
    transition: all 0.3s;
    animation: fadeInUp 1.8s;
}

.btn-theme:hover { background-color: #d32f2f; }

.btn-outline-theme {
    border: 2px solid #b71c1c;
    color: #b71c1c;
    border-radius: 50px;
    padding: 10px 35px;
    transition: all 0.3s;
    animation: fadeInUp 2s;
}
.btn-outline-theme:hover { background-color: #b71c1c; color: #fff; }

@media (max-width: 768px) {
    .card-body { padding: 30px 20px; }
    .hero-img { max-width: 100%; max-height: 300px; margin-bottom: 20px; }
    .btn-theme, .btn-outline-theme { padding: 10px 30px; }
    .event-info { padding: 20px; }
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Open modal & prefill event name
    $(".joinBtn").click(function(){
        let isLogin = $(this).data("login");
        if(isLogin === "no"){
            Swal.fire({
                title: "Oops!",
                text: "You need to login first",
                icon: "warning",
                confirmButtonColor: "#d90429",
                showClass: { popup: 'animate__animated animate__zoomIn' },
                hideClass: { popup: 'animate__animated animate__zoomOut' }
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = "login_view.php";
                }
            });
            return;
        }

        let eventName = $(this).data("event");
        $("#event_name").val(eventName);
        $("#joinModal").modal("show");
    });

    // Form validation
    $("#eventForm").validate({
        rules:{
            name:{ required:true, minlength:3 },
            email:{ required:true, email:true },
            phone:{ required:true, digits:true, minlength:10, maxlength:10 },
            message:{ required:true, minlength:10 }
        },
        messages:{
            name:"Enter valid name",
            email:"Enter valid email",
            phone:"Enter 10 digit phone",
            message:"Please enter at least 10 characters"
        },
        errorClass:"text-danger",
        errorElement:"small",
        highlight:function(el){ $(el).addClass("is-invalid"); },
        unhighlight:function(el){ $(el).removeClass("is-invalid"); }
    });

});
</script>

<?php include 'footer.php'; ?>