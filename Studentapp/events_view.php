<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include "../database.php"; // Database connection

// =====================
// SAFE GET VALUE FOR JOIN
$selected_event = isset($_GET['join']) ? htmlspecialchars($_GET['join']) : "";

// =====================
// LOGIN CHECK FOR JOIN
if($selected_event && !isset($_SESSION['user_id'])){
    echo "<script>
        alert('⚠️ Please login first to join event!');
        window.location.href='login_view.php';
    </script>";
    exit();
}

// =====================
// FORM SUBMIT BACKEND
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
    $event    = mysqli_real_escape_string($con, $_POST['event_name']);
    $message  = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO event_join_requests 
              (user_id, name, email, phone, event_name, message) 
              VALUES ('$user_id','$name','$email','$phone','$event','$message')";

    if(mysqli_query($con, $query)){
        header("Location: events_view.php");
        exit();
    } else {
        echo "<script>alert('Database Error');</script>";
    }
}

// =====================
// FETCH ALL ACTIVE EVENTS
$events_result = mysqli_query($con, "SELECT * FROM events WHERE status='Active' ORDER BY id ASC");
if(!$events_result){
    die("Query Error: ".mysqli_error($con));
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
        <?php if(mysqli_num_rows($events_result) > 0) {
            while($event = mysqli_fetch_assoc($events_result)) { 
                $event_name = htmlspecialchars($event['name']);
                $event_date = htmlspecialchars($event['date']);
                $event_desc = htmlspecialchars($event['description']);
                $event_img  = htmlspecialchars($event['image']);
        ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <img src="../uploads/<?php echo $event_img; ?>" class="card-img-top" alt="<?php echo $event_name; ?>">
                <div class="card-body">
                    <h5 class="card-title text-danger"><?php echo $event_name; ?></h5>
                    <p class="text-muted"><?php echo $event_date; ?></p>
                    <p><?php echo $event_desc; ?></p>

                    <a href="?join=<?php echo $event_name; ?>" class="btn btn-danger w-100">
                        Join Event
                    </a>
                </div>
            </div>
        </div>
        <?php } } else { ?>
            <p class="text-center text-muted">No events available right now.</p>
        <?php } ?>
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

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function(){

    var selectedEvent = "<?php echo $selected_event; ?>";

    <?php if(isset($_GET['join']) && isset($_SESSION['user_id'])){ ?>
        $("#event_name").val(selectedEvent);
        $("#joinModal").modal("show");
    <?php } ?>

    $("#eventForm").validate({
        rules: {
            name: { required: true, minlength: 3 },
            email: { required: true, email: true },
            phone: { required: true, digits: true, minlength: 10, maxlength: 10 },
            message: { required: true, minlength: 10 }
        },
        messages: {
            name: "Enter valid name",
            email: "Enter valid email",
            phone: "Enter 10 digit phone",
            message: "Please enter at least 10 characters"
        },
        errorClass: "text-danger",
        errorElement: "small",
        highlight: function(el) { $(el).addClass("is-invalid"); },
        unhighlight: function(el) { $(el).removeClass("is-invalid"); },
        submitHandler: function(form) { form.submit(); }
    });

});
</script>

<?php include 'footer.php'; ?>
</body>
</html>