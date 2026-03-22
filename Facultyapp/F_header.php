<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Faculty Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      padding-top: 110px;
      background: #f5f7fa;
      min-height: 200vh;
    }

    /* ================= NAVBAR DESIGN ================= */
    .custom-navbar {
      background: linear-gradient(120deg, #9b0000, #d90429);
      box-shadow: 0 4px 15px rgba(0, 0, 0, .25);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 9999;
    }

    /* ================= LOGO ================= */
    .navbar-brand img {
      height: 75px;
      transition: transform 0.3s ease;
    }

    .navbar-brand img:hover {
      transform: scale(1.05);
    }

    /* ================= NAV LINKS ================= */
    .navbar-nav .nav-link {
      position: relative;
      font-weight: 600;
      font-size: 18px;
      margin: 0 12px;
      color: white !important;
      transition: 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
      transform: translateY(-2px);
    }

    .navbar-nav .nav-link::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -6px;
      width: 0%;
      height: 3px;
      background: white;
      transition: 0.35s ease;
    }

    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
      width: 100%;
    }

    /* ================= PROFILE IMAGE ================= */
    .profile-img {
      width: 42px;
      height: 42px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.6);
      transition: 0.3s ease;
    }

    .profile-img:hover {
      transform: scale(1.08);
      border-color: white;
    }

    /* ================= NOTIFICATION ================= */
    .notification-btn {
      background: transparent;
      border: none;
      color: white;
      font-size: 20px;
      position: relative;
      padding: 8px;
    }

    .notification-btn:hover {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
    }

    .badge-custom {
      position: absolute;
      top: -6px;
      right: -6px;
      background: #ff0000;
      font-size: 12px;
    }

    /* ================= LOGOUT BUTTON ================= */
    .logout-btn {
      background: linear-gradient(135deg, #ffffff, #f8d7da);
      color: #9b0000;
      font-weight: 600;
      border: none;
      border-radius: 25px;
      padding: 8px 22px;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.35s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .logout-btn i {
      transition: transform 0.4s ease;
    }

    .logout-btn:hover {
      background: linear-gradient(135deg, #ff0000, #9b0000);
      color: white;
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .logout-btn:hover i {
      transform: translateX(5px);
    }

    .logout-btn:active {
      transform: scale(0.95);
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark custom-navbar py-3 fixed-top">
    <div class="container-fluid px-4">

      <!-- Logo -->
      <a class="navbar-brand" href="faculty_dashboard.php">
        <img src="assets/images/logo.png" alt="Logo">
      </a>

      <!-- Hamburger -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#facultyNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="facultyNavbar">

        <!-- Faculty Menu -->
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link " href="faculty_dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_clube.php">My Clubs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Manage_events.php">Manage Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="students_list.php">Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Students_request.php">Student Requests</a>
          </li>
        </ul>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-3">

          <!-- Notification -->
          <a href="notification.php" class="position-relative d-inline-block text-decoration-none">
            <button class="notification-btn" type="button">
              <i class="bi bi-bell-fill"></i>
              <span class="badge rounded-pill badge-custom">5</span>
            </button>
          </a>

          <!-- Profile -->
          <a href="profile.php">
            <img src="assets/images/user.jpg" class="profile-img" alt="User">
          </a>

          <!-- Logout Button -->
          <a href="../Studentapp/login_view.php" class="text-decoration-none">
            <button class="logout-btn">
              <i class="bi bi-box-arrow-right"></i> Logout
            </button>
          </a>

        </div>
      </div>
    </div>
  </nav>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>