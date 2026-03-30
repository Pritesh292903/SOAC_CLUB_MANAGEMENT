<?php
session_start();

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: Studentapp/login_view.php");
    exit();
}

include 'F_header.php';
include "../database.php";

// FETCH USER DATA
$user_id = intval($_SESSION['user_id']); // security

$query = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($con, $query);

// ERROR CHECK
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

// DEFAULT IMAGE
$profileImage = (!empty($user['clubimage']) && file_exists("../uploads/" . $user['clubimage']))
    ? "../uploads/" . $user['clubimage']
    : "assets/images/user.jpg";
?>

<style>
    .profile-wrapper {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
        background: linear-gradient(135deg, #ffe5e5, #ffffff);
    }

    .profile-card {
        width: 350px;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 25px;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        text-align: center;
        backdrop-filter: blur(10px);
        transition: 0.3s;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    }

    .avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto 15px;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #dc3545;
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
    }

    .profile-card h2 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .sub-text {
        font-size: 14px;
        color: #777;
        margin-bottom: 20px;
    }

    .info-box {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 12px;
        text-align: left;
        transition: 0.3s;
    }

    .info-box:hover {
        background: #fff3f3;
    }

    .info-box label {
        font-size: 12px;
        color: #888;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .btn {
        width: 100%;
        padding: 10px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
    }

    .btn-edit {
        background: #fff;
        border: 2px solid #dc3545;
        color: #dc3545;
    }

    .btn-edit:hover {
        background: #dc3545;
        color: #fff;
    }

    .btn-password {
        background: linear-gradient(120deg, #dc3545, #b02a37);
        color: #fff;
        border: none;
    }

    @media(max-width:450px) {
        .profile-card {
            width: 100%;
        }
    }
</style>

<div class="profile-wrapper">

    <div class="profile-card">

        <!-- PROFILE IMAGE -->
        <div class="avatar">
            <img src="<?php echo $profileImage; ?>" alt="Profile Image">
        </div>

        <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
        <p class="sub-text">Welcome back 👋</p>

        <!-- NAME -->
        <div class="info-box">
            <label>Full Name</label>
            <div class="info-value">
                <?php echo htmlspecialchars($user['fullname']); ?>
            </div>
        </div>

        <!-- EMAIL -->
        <div class="info-box">
            <label>Email Address</label>
            <div class="info-value">
                <?php echo htmlspecialchars($user['email']); ?>
            </div>
        </div>

        <!-- BUTTONS -->
        <a href="Editprofile.php" class="btn btn-edit">
            ✏ Edit Profile
        </a>

        <a href="change_password.php" class="btn btn-password">
            🔑 Change Password
        </a>

    </div>

</div>

<?php include 'F_footer.php'; ?>