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
    /* ===== YOUR EXISTING HEADER STYLES (UNCHANGED) ===== */
    .custom-navbar {
      background: linear-gradient(120deg, #9b0000, #d90429);
      box-shadow: 0 4px 15px rgba(0, 0, 0, .25);
    }
    .navbar-brand img { height: 75px; transition: transform 0.3s ease; }
    .navbar-brand img:hover { transform: scale(1.05); }
    .navbar-nav .nav-link {
      position: relative; font-weight: 600; font-size: 18px; margin: 0 12px;
      color: white !important; transition: 0.3s ease;
    }
    .navbar-nav .nav-link:hover { transform: translateY(-2px); }
    .navbar-nav .nav-link::after {
      content: ""; position: absolute; left: 0; bottom: -6px;
      width: 0%; height: 3px; background: white; transition: 0.35s ease;
    }
    .navbar-nav .nav-link:hover::after { width: 100%; }

    .profile-img {
      width: 42px; height: 42px; object-fit: cover; border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.6); transition: 0.3s ease;
    }

    .notification-btn {
      background: transparent; border: none; color: white; font-size: 20px;
      position: relative; padding: 8px;
    }
    .notification-btn:hover {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
    }

    .badge-custom {
      position: absolute; top: -6px; right: -6px; background: #ff0000; font-size: 12px;
    }

    /* ===== NOTIFICATION DROPDOWN (MATCHES YOUR SITE) ===== */
    .notification-dropdown {
      width: 320px;
      max-height: 360px;
      overflow-y: auto;
      border-radius: 14px;
      border: none;
      padding: 0;
    }

    @media (max-width: 576px) {
      .notification-dropdown {
        width: 95vw;
        max-height: 70vh;
      }
    }

    .notification-header {
      background: linear-gradient(120deg, #9b0000, #d90429);
      color: white;
      position: sticky;
      top: 0;
      z-index: 2;
    }

    .notification-item {
      white-space: normal;
      padding: 12px 14px;
      font-size: 14px;
      transition: 0.2s ease;
    }

    .notification-item:hover {
      background: rgba(217, 4, 41, 0.08);
    }

    .notification-time {
      font-size: 11px;
      color: #777;
    }

    .view-all {
      font-weight: 600;
      color: #d90429;
    }

    .view-all:hover {
      background: rgba(217, 4, 41, 0.1);
    }

    /* ===== FOOTER PLACEHOLDER (UNCHANGED DESIGN) ===== */
    footer {
      background: linear-gradient(120deg, #9b0000, #d90429);
      color: white;
      padding: 20px;
      text-align: center;
      margin-top: 80px;
    }

    /* ===== FORCE FOOTER TO BOTTOM (NO DESIGN CHANGES) ===== */
    html, body {
      height: 100%;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    .page-wrapper {
      flex: 1;
    }
  </style>
</head>
<body>

<!-- ===== HEADER (UNCHANGED) ===== -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar py-3">
  <div class="container-fluid px-4">

    <a class="navbar-brand" href="faculty_dashboard.php">
      <img src="assets/images/logo.png" alt="Logo">
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#facultyNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="facultyNavbar">

      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="faculty_dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_clube.php">Manage Clubs</a></li>
        <li class="nav-item"><a class="nav-link" href="Manage_events.php">Manage Events</a></li>
        <li class="nav-item"><a class="nav-link" href="Students_request.php">Student Requests</a></li>
      </ul>

      <div class="d-flex align-items-center gap-3">

        <!-- Notification -->
        <div class="dropdown position-relative">
          <button class="notification-btn dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-bell-fill"></i>
            <span class="badge rounded-pill badge-custom">5</span>
          </button>

          <ul class="dropdown-menu dropdown-menu-end notification-dropdown shadow-lg">
            <li class="notification-header px-3 py-2"><strong>Notifications</strong></li>
            <li><hr class="dropdown-divider m-0"></li>

            <li>
              <a class="dropdown-item notification-item" href="Students_request.php">
                New student joined <b>Robotics Club</b>
                <div class="notification-time">2 mins ago</div>
              </a>
            </li>

            <li>
              <a class="dropdown-item notification-item" href="Manage_events.php">
                Event approved for <b>Coding Club</b>
                <div class="notification-time">1 hour ago</div>
              </a>
            </li>

            <li><hr class="dropdown-divider m-0"></li>

            <li>
              <a class="dropdown-item text-center view-all" href="Students_request.php">
                View All Notifications
              </a>
            </li>
          </ul>
        </div>

        <a href="profile.php">
          <img src="assets/images/user.jpg" class="profile-img">
        </a>

      </div>
    </div>
  </div>
</nav>

<!-- ===== PAGE CONTENT ===== -->
<div class="page-wrapper">
  <div class="container py-5">

    <!-- Welcome -->
    <div class="mb-4">
      <h3 class="fw-bold">Welcome to Faculty Panel 👋</h3>
      <p class="text-muted">Here are the latest club announcements, new clubs, and upcoming activities.</p>
    </div>

    <div class="row g-4">

      <!-- Announcements -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header bg-white fw-bold">
            📢 Club Announcements
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <strong>Robotics Club</strong> meeting rescheduled to  
              <span class="text-danger fw-semibold">26 Feb, 3:00 PM</span>
            </li>
            <li class="list-group-item">
              <strong>Coding Club</strong> hackathon registration open until  
              <span class="text-danger fw-semibold">28 Feb, 11:59 PM</span>
            </li>
            <li class="list-group-item">
              <strong>Drama Club</strong> auditions announced for  
              <span class="text-danger fw-semibold">1 Mar, 10:00 AM</span>
            </li>
            <li class="list-group-item">
              <strong>Photography Club</strong> outdoor shoot this  
              <span class="text-danger fw-semibold">27 Feb, 4:30 PM</span>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ===== FOOTER (UNCHANGED) ===== -->
<footer>
  © 2026 Club Management System | Faculty Panel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>