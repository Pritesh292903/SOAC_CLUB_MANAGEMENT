<?php
session_start(); // Always start session first

// CHECK LOGIN BEFORE ANY OUTPUT
if (!isset($_SESSION['user_id'])) {
    header("Location: Studentapp/login_view.php");
    exit();
}

include 'F_header.php';
include "../database.php";

// FETCH USER
$user_id = $_SESSION['user_id'];
$result = mysqli_query($con, "SELECT * FROM User WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);
?>

<style>
    /* Background Gradient */
    .profile-wrapper {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
        background: linear-gradient(135deg, #ffe5e5, #ffffff);
    }

    /* Animated Card */
    .profile-card {
        width: 350px;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 25px;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        text-align: center;
        backdrop-filter: blur(10px);
        animation: fadeSlide 0.6s ease;
        transition: 0.3s;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Avatar */
    .avatar {
        width: 95px;
        height: 95px;
        border-radius: 50%;
        background: linear-gradient(120deg, #dc3545, #b02a37);
        color: #fff;
        font-size: 36px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
        transition: 0.4s;
    }

    .avatar:hover {
        transform: scale(1.08) rotate(5deg);
    }

    /* Heading */
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

    /* Info Box */
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
        transform: scale(1.02);
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

    /* Buttons */
    .btn {
        width: 100%;
        padding: 10px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
        transition: 0.3s;
    }

    /* Edit Button */
    .btn-edit {
        background: #fff;
        border: 2px solid #dc3545;
        color: #dc3545;
    }

    .btn-edit:hover {
        background: #dc3545;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }

    /* Password Button */
    .btn-password {
        background: linear-gradient(120deg, #dc3545, #b02a37);
        color: #fff;
        border: none;
    }

    .btn-password:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
    }

    /* Responsive */
    @media(max-width:450px) {
        .profile-card {
            width: 100%;
            padding: 25px 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            font-size: 30px;
        }
    }
</style>

<div class="profile-wrapper">

    <di v class="profile-card">

        <div class="avatar"><?php if (!empty($user['clubimage'])) { ?>
                <img src="../uploads/<?php echo $user['clubimage']; ?>" class="avatar-img">
            <?php } else { ?>
                <img src="assets/images/user.jpg" class="avatar-img">
            <?php } ?>
        </div>

        <h2>User Profile</h2>
        <p class="sub-text">Welcome back 👋</p>

        <div class="info-box">
            <label>Full Name</label>
            <div class="info-value"><?php echo $user['fullname']; ?></div>
        </div>

        <div class="info-box">
            <label>Email Address</label>
            <div class="info-value"><?php echo $user['email']; ?></div>
        </div>

        <a href="Editprofile.php" class="btn btn-edit">
            ✏ Edit Profile
        </a>

        <a href="change_password.php" class="btn btn-password">
            🔑 Change Password
        </a>

    </div>

</div>

<?php include 'F_footer.php'; ?>