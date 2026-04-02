<?php
session_start(); // 

include 'admin_header.php';
include "../database.php";

// CHECK SESSION
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

// FETCH LOGGED IN USER DATA
$user_id = $_SESSION['user_id'];

$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user_id'"); // user (small letter)

// CHECK QUERY
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

// FETCH DATA
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("No user found");
}
?>

<style>
    /* CARD ANIMATION */
    .profile-card {
        transition: transform 0.5s, box-shadow 0.5s;
        background: #fff;
    }

    .profile-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    /* PROFILE IMAGE */
    .profile-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #dc3545;
        transition: transform 0.5s, box-shadow 0.5s;
    }

    .profile-img:hover {
        transform: scale(1.15) rotate(-5deg);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* BUTTON EFFECTS */
    .btn-effect {
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.4s;
        position: relative;
        overflow: hidden;
    }

    .btn-effect::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 0;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.2);
        transition: 0.4s;
    }

    .btn-effect:hover::after {
        height: 100%;
    }

    /* BUTTONS COLORS */
    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: #fff;
        transform: scale(1.05);
    }

    .btn-danger {
        background: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #b02a37;
        transform: scale(1.05);
    }

    /* GRADIENT CIRCLE ANIMATION */
    @keyframes pulse {
        0% {
            transform: translate(-50%, -50%) scale(0.9);
        }

        50% {
            transform: translate(-50%, -50%) scale(1.1);
        }

        100% {
            transform: translate(-50%, -50%) scale(0.9);
        }
    }

    .gradient-circle {
        animation: pulse 4s infinite ease-in-out;
        background: linear-gradient(45deg, #dc3545, #0d6efd);
    }

    /* RESPONSIVE */
    @media (max-width: 576px) {
        .profile-card {
            padding: 30px 20px;
        }

        .profile-img {
            width: 100px;
            height: 100px;
        }
    }
</style>

<div class="content py-5" style="background: #f8f9fa; min-height: 85vh;">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 40vh;">
        <div class="card profile-card shadow-lg rounded-5 p-5 text-center position-relative"
            style="max-width: 420px; width: 100%; overflow: hidden;">

            <!-- Animated Gradient Circle -->
            <div class="gradient-circle position-absolute top-0 start-50 translate-middle"
                style="width:200px; height:200px; border-radius:50%; filter: blur(70px); z-index:0;"></div>

            <!-- PROFILE IMAGE -->
            <div class="position-relative d-inline-block mb-4" style="z-index:1;">
                <img src="<?php
                            if (!empty($user['clubimage'])) {
                                echo '../uploads/' . $user['clubimage'];
                            } else {
                                echo 'assets/clubimage/profile.png';
                            }
                            ?>" class="rounded-circle profile-img" alt="Profile">
            </div>

            <!-- fullname AND EMAIL -->
            <h4 class="fw-bold mb-1"><?php echo $user['fullname']; ?></h4>
            <p class="text-muted mb-4"><?php echo $user['email']; ?></p>

            <!-- BUTTONS -->
            <div class="d-flex flex-column gap-3">
                <a href="edit_profile.php" class="btn btn-outline-danger btn-lg btn-effect">
                    Edit Profile
                </a>
                <a href="changepassword.php" class="btn btn-danger btn-lg btn-effect">
                    Change / Forgot Password
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'admin_footer.php'; ?>