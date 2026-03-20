<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      padding-top: 110px;
      background: #f5f7fa;
      margin: 0;
    }

    /* NAVBAR */
    .custom-navbar {
      background: linear-gradient(120deg, #9b0000, #d90429);
      box-shadow: 0 6px 20px rgba(0, 0, 0, .3);
    }

    .navbar-nav .nav-link {
      font-weight: 600;
      font-size: 17px;
      margin: 0 12px;
      color: white !important;
      transition: 0.3s;
    }

    .navbar-nav .nav-link:hover {
      transform: translateY(-2px);
      opacity: 0.9;
    }

    /* MOBILE FIX */
    @media (max-width: 991px) {
      .navbar-nav {
        text-align: center;
        margin-top: 15px;
      }

      .navbar-nav .nav-link {
        margin: 10px 0;
      }

      .navbar-right {
        justify-content: center;
        margin-top: 15px;
      }
    }

    .profile-img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.7);
      transition: 0.3s;
    }

    .profile-img:hover {
      transform: scale(1.08);
      border-color: #fff;
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
      transition: 0.3s;
      text-decoration: none;
    }

    .notification-btn:hover {
      background: #ffe5e5;
      transform: scale(1.08);
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

    .logout-btn {
      background: white;
      color: #9b0000;
      font-weight: 600;
      border-radius: 25px;
      padding: 6px 18px;
      border: none;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: #ffe5e5;
      transform: translateY(-2px);
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar py-3 fixed-top">
  <div class="container-fluid px-4">

    <!-- LOGO -->
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.png" height="60">
    </a>

    <!-- TOGGLER -->
    <button class="navbar-toggler border-0"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#facultyNavbar"
      aria-controls="facultyNavbar"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- COLLAPSE -->
    <div class="collapse navbar-collapse" id="facultyNavbar">

      <!-- CENTER MENU -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="clubs_view.php">Clubs</a></li>
        <li class="nav-item"><a class="nav-link" href="events_view.php">Events</a></li>
        <li class="nav-item"><a class="nav-link" href="contactus_view.php">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="aboutrku_view.php">About RKU</a></li>
      </ul>

      <!-- RIGHT SIDE -->
      <div class="d-flex align-items-center gap-3 navbar-right">

        <a href="notification.php" class="notification-btn">
          <i class="bi bi-bell-fill"></i>
          <span class="notification-badge">3</span>
        </a>

        <a href="profile_view.php">
          <img src="assets/images/user.jpg" class="profile-img">
        </a>

        <a href="login_view.php">
          <button class="logout-btn">
            <i class="bi bi-box-arrow-right me-1"></i> Login
          </button>
        </a>

      </div>

    </div>
  </div>
</nav>

<!-- Bootstrap JS (ONLY ONE TIME) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AUTO CLOSE NAVBAR ON MOBILE -->
<script>
document.addEventListener("DOMContentLoaded", function () {

  const navLinks = document.querySelectorAll(".navbar-nav .nav-link");
  const navbarCollapse = document.getElementById("facultyNavbar");
  const bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });

  navLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      if (window.innerWidth < 992) {
        bsCollapse.hide();
      }
    });
  });

});
</script>

</body>
</html>