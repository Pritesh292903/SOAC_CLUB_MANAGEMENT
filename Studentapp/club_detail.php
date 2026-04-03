<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include '../database.php'; // DB connection

// =====================
// CHECK LOGIN FOR JOIN BUTTON
$isLoggedIn = isset($_SESSION['user_id']);

// GET CLUB ID FROM URL
$club_id = isset($_GET['club_id']) ? intval($_GET['club_id']) : 0;

// FETCH CLUB DETAILS
if($club_id > 0){
    $club_query = mysqli_query($con, "SELECT * FROM clubs WHERE id='$club_id' LIMIT 1");
} else {
    $club_query = mysqli_query($con, "SELECT * FROM clubs ORDER BY id ASC LIMIT 1");
}

if(mysqli_num_rows($club_query) == 0){
    echo "<script>alert('Club not found!'); window.location.href='clubs_view.php';</script>";
    exit();
}

$club = mysqli_fetch_assoc($club_query);

// =====================
// HANDLE FORM SUBMISSION
if(isset($_POST['submit_event'])) {
    if(!$isLoggedIn){
        echo "<script>
            alert('Please login first!');
            window.location.href='login_view.php';
        </script>";
        exit();
    }

    $user_id   = $_SESSION['user_id'];
    $name      = mysqli_real_escape_string($con, $_POST['name']);
    $email     = mysqli_real_escape_string($con, $_POST['email']);
    $phone     = mysqli_real_escape_string($con, $_POST['phone']);
    $club_id_post   = intval($_POST['club_id']);
    $message   = mysqli_real_escape_string($con, $_POST['message']);

    // Fetch club name safely from DB
    $club_query2 = mysqli_query($con, "SELECT clubname FROM clubs WHERE id='$club_id_post' LIMIT 1");
    $club_data   = mysqli_fetch_assoc($club_query2);
    $club_name   = $club_data['clubname'] ?? 'Unknown Club';

    $query = "INSERT INTO club_join_requests 
              (user_id, name, email, phone, club_name, message, club_id) 
              VALUES ('$user_id', '$name', '$email', '$phone', '$club_name', '$message', '$club_id_post')";

    if(mysqli_query($con, $query)) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                title: 'Success!',
                text: 'You have successfully joined the club.',
                icon: 'success',
                confirmButtonColor: '#d90429',
            }).then(() => {
                window.location.href='clubs_view.php';
            });
        });
        </script>";
    } else {
        echo "<script>alert('Database error! ".mysqli_error($con)."');</script>";
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <div class="card">

        <!-- Banner Image -->
        <img src="../Adminapp/uploads/<?php echo !empty($club['clubimage']) ? $club['clubimage'] : 'assets/images/e1.avif'; ?>" 
             alt="<?php echo htmlspecialchars($club['clubname']); ?>" 
             class="hero-img mx-auto d-block">

        <div class="card-body">

            <!-- Club Name -->
            <h2 class="mb-4 text-center"><?php echo htmlspecialchars($club['clubname']); ?></h2>

            <!-- Club Info -->
            <div class="event-info mx-auto" style="max-width:700px;">
                <h4>Club Details</h4>
                <ul class="list-unstyled mb-0">
                    <li><strong>Club Name:</strong> <?php echo htmlspecialchars($club['clubname']); ?></li>
                    <li><strong>Faculty Name:</strong> <?php echo htmlspecialchars($club['faculty']); ?></li>
                    <li><strong>Status:</strong> <?php echo htmlspecialchars($club['status']); ?></li>
                    <li><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($club['clubdescription'])); ?></li>
                </ul>
            </div>

            <!-- Join Club Button -->
            <div class="text-center mb-4 mt-4">
                <button class="btn btn-theme btn-lg joinBtn" 
                        data-clubid="<?php echo $club['id']; ?>"
                        data-login="<?php echo $isLoggedIn ? 'yes' : 'no'; ?>">
                    Join Club
                </button>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="clubs_view.php" class="btn btn-outline-theme">Back to Clubs</a>
            </div>

        </div>
    </div>
</div>

<!-- ===== JOIN CLUB MODAL ===== -->
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
                <input type="hidden" name="club_id" id="club_id">
                <label>Selected Club</label>
                <input type="text" id="club_name_display" class="form-control" readonly>
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

/* Smaller hero image */
.hero-img {
    width: 100%;
    max-width: 200px;  /* very small */
    height: auto;
    object-fit: cover;
    border-radius: 25px 25px 0 0;
    animation: fadeInDown 1s;
    display: block;
    margin: 0 auto 15px;
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
    .hero-img { max-width: 150px; max-height: 150px; margin-bottom: 10px; }
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

    // Prefill modal with club ID and name
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

        let clubId = $(this).data("clubid");
        let clubName = "<?php echo htmlspecialchars($club['clubname']); ?>";

        $("#club_id").val(clubId);
        $("#club_name_display").val(clubName);
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