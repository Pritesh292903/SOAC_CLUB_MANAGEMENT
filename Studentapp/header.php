<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { padding-top: 110px; background: #f5f7fa; }

    .custom-navbar {
      background: linear-gradient(120deg, #9b0000, #d90429);
    }

    .navbar-nav .nav-link {
      font-weight: 600;
      color: white !important;
      margin: 0 12px;
    }

    .profile-img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
    }

    .notification-btn {
      position: relative;
      background: white;
      color: #9b0000;
      border-radius: 50%;
      width: 42px;
      height: 42px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
    }

    .notification-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: red;
      color: white;
      font-size: 11px;
      padding: 3px 6px;
      border-radius: 50%;
    }

    .btn-custom {
      background: white;
      color: #9b0000;
      font-weight: 600;
      border-radius: 25px;
      padding: 6px 18px;
      border: none;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top py-3">
  <div class="container-fluid px-4">

    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.png" height="60">
    </a>

    <!-- Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navBar">

      <!-- Menu -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="clubs_view.php">Clubs</a></li>
        <li class="nav-item"><a class="nav-link" href="events_view.php">Events</a></li>

        <?php if(isset($_SESSION['user_id'])) { ?>
          <li class="nav-item"><a class="nav-link" href="contactus_view.php">Contact Us</a></li>
        <?php } ?>

        <li class="nav-item"><a class="nav-link" href="aboutrku_view.php">About RKU</a></li>
      </ul>

      <!-- Right Side -->
      <div class="d-flex align-items-center gap-3">

        <?php if(isset($_SESSION['user_id'])) { ?>

          <a href="notification.php" class="notification-btn">
            <i class="bi bi-bell-fill"></i>
            <span class="notification-badge">3</span>
          </a>

          <a href="profile_view.php">
            <img src="assets/images/user.jpg" class="profile-img">
          </a>

          <a href="logout.php">
            <button class="btn-custom">
              <i class="bi bi-box-arrow-right"></i> Logout
            </button>
          </a>

        <?php } else { ?>

          <a href="login_view.php">
            <button class="btn-custom">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
          </a>

        <?php } ?>

      </div>

    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>