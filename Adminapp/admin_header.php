<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../database.php";

// CHECK SESSION
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

// GET USER
$user_id = $_SESSION['user_id'];

$result = mysqli_query($con,"SELECT * FROM User WHERE id='$user_id'");

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SOAC Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/validation.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #fff;
            border-right: 1px solid #e5e5e5;
            padding-top: 20px;
            transition: 0.3s ease;
            z-index: 1050;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.03);
        }

        /* Sidebar Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .logo-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            transition: 0.3s ease;
        }

        .sidebar-brand:hover .logo-img {
            transform: rotate(10deg) scale(1.1);
        }

        /* Sidebar Links */
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px 10px;
            text-decoration: none;
            color: #333;
            border-radius: 8px;
            transition: 0.3s;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #dc3545;
            color: #fff !important;
            /* force white text on hover */
            transform: translateX(5px);
        }

        /* ===== LOGOUT HOVER FIX ===== */
        .sidebar a.text-danger:hover {
            background: #dc3545;
            color: #fff !important;
        }

        /* Hide sidebar on mobile */
        @media(max-width:992px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }
        }

        /* ===== OVERLAY ===== */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            z-index: 1040;
        }

        .overlay.show {
            display: block;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 65px;
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            transition: 0.3s ease;
            z-index: 1030;
        }

        @media(max-width:992px) {
            .topbar {
                left: 0;
            }
        }

        /* ===== SEARCH ===== */
        .search-box input {
            width: 250px;
            border-radius: 20px;
        }

        .search-box .input-group-text {
            border-radius: 20px 0 0 20px;
        }

        .search-box input {
            border-radius: 0 20px 20px 0;
        }

        /* ===== ICON BUTTONS ===== */
        .icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .icon-btn:hover {
            background: #dc3545;
            color: #fff;
        }

        .badge-notify {
            position: absolute;
            top: 2px;
            right: 4px;
            font-size: 10px;
            padding: 3px 6px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Topbar dropdown logout hover fix */
        .dropdown-menu a.dropdown-item.text-danger:hover {
            background: #dc3545;
            color: #fff !important;
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 260px;
            margin-top: 80px;
            padding: 30px;
        }

        @media(max-width:992px) {
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- OVERLAY -->
    <div class="overlay" id="overlay"></div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <div class="sidebar-brand">

            <img src="assets/images/logo.png" alt="Logo" class="logo-img">
            <span class="fw-bold text-danger fs-5">ADMIN</span>
        </div>
        <a href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="all_events_page.php"><i class="bi bi-calendar-event me-2"></i> All Events</a>
        <a href="all_clubes_page.php"><i class="bi bi-people me-2"></i> All Clubs</a>
        <a href="all_users_page.php"><i class="bi bi-person-lines-fill me-2"></i> All Users</a>
        <a href="contactus_page.php"><i class="bi bi-person-lines-fill me-2"></i> Contact us.</a>
        <a href="faculty_register.php"><i class="bi bi-person-plus-fill me-2"></i> Register Faculty</a>
        <a href="slider_image_page.php"><i class="bi bi-images me-2"></i> Slider Images</a>
        <a href="setting_page.php"><i class="bi bi-gear me-2"></i> Settings</a>
        <a href="Admin_logout.php" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>

    </div>

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="d-flex align-items-center gap-3">

            <button class="btn btn-light d-lg-none" id="menuBtn">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div class="search-box d-none d-md-block">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search here...">
                </div>
            </div>

        </div>

        <div class="d-flex align-items-center gap-3">

            <a href="notification_page.php" class="text-decoration-none">
                <div class="icon-btn position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="badge bg-danger badge-notify">3</span>
                </div>
            </a>

            <a href="msg_page.php" class="text-decoration-none">
                <div class="icon-btn position-relative">
                    <i class="bi bi-envelope fs-5"></i>
                    <span class="badge bg-primary badge-notify">5</span>
                </div>
            </a>

            <a href="setting_page.php" class="text-decoration-none">
                <div class="icon-btn">
                    <i class="bi bi-gear fs-5"></i>
                </div>
            </a>

            <div class="dropdown">
                <div class="d-flex align-items-center gap-2 cursor-pointer">
                    <a href="admin_profile.php">
                        <img src="assets/images/profile.png" class="rounded-circle" width="35" alt="Admin Avatar">
                    </a>
                    <span class="d-none d-md-inline"><?php echo $user['fullname']; ?></span>
                </div>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="setting_page.php"><i class="bi bi-gear me-2"></i>Settings</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>

        </div>

    </div>

    <script>
        const menuBtn = document.getElementById("menuBtn");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("show");
        });

        overlay.addEventListener("click", function () {
            sidebar.classList.remove("active");
            overlay.classList.remove("show");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>