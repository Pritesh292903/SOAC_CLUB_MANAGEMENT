<?php
session_start();
include 'header.php';
include "../database.php";

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
  header("Location: login_view.php");
  exit();
}

// FETCH LATEST USER DATA
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM User WHERE id='$user_id'";
$result = mysqli_query($con, $query);

if (!$result) {
  die("Query Error: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

// IMAGE PATH FIX
if (!empty($user['clubimage'])) {
  $image_path = "../uploads/" . $user['clubimage'];
} else {
  $image_path = "assets/images/user.jpg";
}
?>

<style>
  html,
  body {
    height: 100%;
  }

  .profile-wrapper {
    height: calc(100vh - 110px);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .profile-card {
    background: #fff;
    width: 100%;
    max-width: 420px;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    text-align: center;
  }

  .avatar-img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
  }

  .form-control {
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 15px;
  }

  .btn-group-custom {
    display: flex;
    gap: 10px;
    margin-top: 15px;
  }

  .btn-custom {
    flex: 1;
    padding: 10px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    color: #fff;
    background: linear-gradient(120deg, #9b0000, #d90429);
  }

  .btn-custom:hover {
    opacity: 0.9;
  }

  @media (max-width: 480px) {
    .btn-group-custom {
      flex-direction: column;
    }
  }
</style>

<div class="profile-wrapper">
  <div class="profile-card">

    <!-- PROFILE IMAGE -->
    <img src="<?php echo $image_path; ?>" class="avatar-img">

    <!-- NAME -->
    <input type="text" class="form-control" value="<?php echo $user['fullname'] ?? ''; ?>" readonly>

    <!-- EMAIL -->
    <input type="email" class="form-control" value="<?php echo $user['email'] ?? ''; ?>" readonly>

    <!-- PHONE (FIXED 🔥) -->
    <input type="text" class="form-control" value="<?php echo $user['mobile'] ?? ''; ?>" readonly>

    <!-- DEPARTMENT -->
    <input type="text" class="form-control" value="<?php echo $user['department'] ?? ''; ?>" readonly>

    <!-- DESIGNATION -->
    <input type="text" class="form-control" value="<?php echo $user['designation'] ?? ''; ?>" readonly>

    <!-- BUTTONS -->
    <div class="btn-group-custom">
      <a href="edit_profile.php" class="btn-custom">Edit</a>
      <a href="change_password.php" class="btn-custom">Change Password</a>
      <a href="logout.php" class="btn-custom">Logout</a>
    </div>

  </div>
</div>

<?php include 'footer.php'; ?>