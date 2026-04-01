<?php
session_start();
include 'F_header.php';
include "../database.php";

// LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login_view.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH DATA
$query = "SELECT * FROM Faculty_register WHERE id='$user_id'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

// PROFILE IMAGE (CACHE FIX)
$profileImage = !empty($user['image']) 
    ? "../" . $user['image'] . "?t=" . time() 
    : "assets/images/user.jpg";
?>

<div class="container my-5">
    <div class="card shadow border-0 rounded-4"
         style="max-width: 400px; margin: 0 auto; text-align: center; padding: 30px; background: #fff;">

        <!-- PROFILE IMAGE -->
        <div class="mb-3">
            <img src="<?php echo $profileImage; ?>" alt="Profile Image"
                 style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #dc3545;">
        </div>

        <h2><?php echo htmlspecialchars($user['name']); ?></h2>
        <p class="text-muted">Faculty Profile 👨‍🏫</p>

        <div style="text-align:left; margin-top:20px;">
            <p><b>Full Name:</b> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><b>Phone:</b> <?php echo htmlspecialchars($user['mobile']); ?></p>
            <p><b>Department:</b> <?php echo htmlspecialchars($user['department']); ?></p>
            <p><b>Designation:</b> <?php echo htmlspecialchars($user['designation']); ?></p>
        </div>

        <a href="Editprofile.php"
           style="display:inline-block; margin-top:15px; padding:10px 20px; border-radius:25px; background:#dc3545; color:#fff; text-decoration:none;">
            ✏ Edit Profile
        </a>
    </div>
</div>

<?php include 'F_footer.php'; ?>