<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include '../database.php'; // DB connection

// =====================
// LOGIN CHECK FOR JOIN BUTTON
if(isset($_GET['join'])){
    if(!isset($_SESSION['user_id'])){
        echo "<script>
            alert('⚠️ Please login first to join club!');
            window.location.href='login_view.php';
        </script>";
        exit();
    }
}

// =====================
// FORM SUBMIT BACKEND
if(isset($_POST['submit_club']))
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
    $club     = trim(mysqli_real_escape_string($con, $_POST['club_name']));
    $message  = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO club_join_requests 
              (user_id, name, email, phone, club_name, message) 
              VALUES ('$user_id','$name','$email','$phone','$club','$message')";

    if(mysqli_query($con, $query)){
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'You have successfully joined the club.',
                    icon: 'success'
                }).then(() => {
                    window.location.href='clubs_view.php';
                });
            });
        </script>";
    } else {
        echo "<script>alert('Database Error: ".mysqli_error($con)."');</script>";
    }
}

// =====================
// FETCH CLUBS
$clubs_result = mysqli_query($con, "SELECT * FROM clubs WHERE status='Active' ORDER BY id ASC");
if(!$clubs_result){
    die("Query Error: ".mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Our Clubs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
body { font-family: 'Segoe UI', sans-serif; background: #fff5f5; display: flex; flex-direction: column; min-height:100vh; }
main { flex:1; }

.club-wrapper { margin-top: 50px; margin-bottom: 70px; }

.club-card { background: #fff; border-radius: 18px; border: 1px solid #f1c1c1; padding: 25px 20px; text-align: center; transition: 0.4s; height: 100%; }
.club-card:hover { transform: translateY(-12px); box-shadow: 0 15px 35px rgba(183,28,28,0.2); border-color: #e53935; }

.club-card img { width: 85px; height: 85px; object-fit: cover; border-radius: 50%; border: 4px solid #f8d7da; margin-bottom: 15px; transition: 0.4s; }
.club-card:hover img { transform: scale(1.1) rotate(5deg); border-color: #e53935; }

.club-card h5 { font-weight: 700; color: #c62828; margin-bottom: 6px; }
.club-card .faculty { font-size: 13px; color: #555; margin-bottom:5px; }
.club-card p { font-size: 13px; color: #666; min-height: 55px; }

.club-btn { padding: 7px 18px; font-size: 13px; font-weight: 600; border-radius: 30px; border: none; background: linear-gradient(45deg, #e53935, #ff7043); color: white; transition: 0.3s; }
.club-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 18px rgba(229,57,53,0.4); background: linear-gradient(45deg, #b71c1c, #ff3d00); }

footer { margin-top: auto; }
</style>
</head>
<body>

<main class="container club-wrapper">
    <div class="text-center mb-5">
        <h1 class="display-5 animate__animated animate__fadeInDown text-danger">Our Clubs</h1>
        <p class="text-muted">Join your favorite club and grow your passion</p>
    </div>

    <div class="row g-4 justify-content-center">
        <?php if(mysqli_num_rows($clubs_result) > 0) {
            while($club = mysqli_fetch_assoc($clubs_result)) { 
                $clubname = $club['clubname'] ?? 'Unnamed Club';
                $faculty = $club['faculty'] ?? 'Not specified';
                $description = $club['description'] ?? 'No description available';
                $clubimage = $club['clubimage'] ?? 'default.png';
        ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="club-card text-center p-3 h-100">
                        <img src="../Adminapp/uploads/<?php echo htmlspecialchars($clubimage); ?>" alt="<?php echo htmlspecialchars($clubname); ?>">
                        <h5 class="mt-3 text-danger"><?php echo htmlspecialchars($clubname); ?></h5>
                        <p class="text-secondary mb-1"><?php echo htmlspecialchars($faculty); ?></p>
                       <p class="text-muted small"><?php echo htmlspecialchars($club['clubdescription']); ?></p>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="?join=<?php echo urlencode($clubname); ?>" class="club-btn">Join</a>
                            <a href="club_detail.php?club_id=<?php echo $club['id']; ?>" class="club-btn">Details</a>
                        </div>
                    </div>
                </div>
        <?php } } else { ?>
            <p class="text-center text-muted">No clubs available right now.</p>
        <?php } ?>
    </div>
</main>

<!-- JOIN MODAL -->
<div class="modal fade" id="joinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Join Club</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="clubForm" method="POST">
                    <div class="mb-3"><label>Your Name</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control" required></div>
                    <div class="mb-3"><label>Selected Club</label><input type="text" name="club_name" id="club_name" class="form-control" readonly></div>
                    <div class="mb-3"><label>Why do you want to join?</label><textarea name="message" rows="3" class="form-control" required></textarea></div>
                    <button type="submit" name="submit_club" class="btn btn-danger w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    <?php if(isset($_GET['join']) && isset($_SESSION['user_id'])){ ?>
        $("#club_name").val("<?php echo $_GET['join']; ?>");
        $("#joinModal").modal("show");
    <?php } ?>

    $("#clubForm").validate({
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
        highlight: function (el) { $(el).addClass("is-invalid"); },
        unhighlight: function (el) { $(el).removeClass("is-invalid"); },
        submitHandler: function (form) { form.submit(); }
    });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>