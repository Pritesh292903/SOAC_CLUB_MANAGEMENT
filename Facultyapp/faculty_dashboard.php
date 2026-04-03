<?php 
include 'F_header.php'; 
include '../database.php';

// Select the correct database
mysqli_select_db($con, "SOAE_CLUB") or die("Database not found: " . mysqli_error($con));

// ===== Fetch dynamic counts =====

// Total students
$res_students = mysqli_query($con, "SELECT COUNT(*) as total_students FROM students") 
    or die("Error fetching students: " . mysqli_error($con));
$total_students = mysqli_fetch_assoc($res_students)['total_students'] ?? 0;

// Active clubs
$res_clubs = mysqli_query($con, "SELECT COUNT(*) as total_clubs FROM clubs") 
    or die("Error fetching clubs: " . mysqli_error($con));
$total_clubs = mysqli_fetch_assoc($res_clubs)['total_clubs'] ?? 0;

// Upcoming events
$res_events = mysqli_query($con, "SELECT COUNT(*) as total_events FROM events WHERE date >= CURDATE()") 
    or die("Error fetching events: " . mysqli_error($con));
$total_events = mysqli_fetch_assoc($res_events)['total_events'] ?? 0;

// Pending requests (club + event)
$res_requests = mysqli_query($con, "SELECT 
    (SELECT COUNT(*) FROM club_join_requests WHERE status='pending') +
    (SELECT COUNT(*) FROM event_join_requests WHERE status='pending') 
    AS total_pending") 
    or die("Error fetching requests: " . mysqli_error($con));
$total_requests = mysqli_fetch_assoc($res_requests)['total_pending'] ?? 0;

?>

<!-- ================= DASHBOARD CONTENT ================= -->

<style>
/* Background Gradient */
body { background: linear-gradient(135deg, #f8f9fa, #e9ecef); }

/* Animated Title */
.dashboard-title { animation: fadeDown 1s ease; }
@keyframes fadeDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }

/* Card Design */
.dashboard-card {
    border: none;
    border-radius: 20px;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    background: #ffffff;
    cursor: pointer;
}
.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

/* Icon Circle */
.icon-circle {
    width: 80px;
    height: 80px;
    line-height: 80px;
    border-radius: 50%;
    margin: 0 auto 15px;
    font-size: 30px;
    color: #fff;
}

/* Different Colors */
.bg-students { background: linear-gradient(45deg, #ff4d4d, #ff9999); }
.bg-clubs    { background: linear-gradient(45deg, #28a745, #6ddf91); }
.bg-events   { background: linear-gradient(45deg, #007bff, #66b2ff); }
.bg-requests { background: linear-gradient(45deg, #ffc107, #ffe066); }

/* Fade Animation for Cards */
.animate-card { animation: fadeUp 1s ease forwards; opacity:0; }
.animate-card:nth-child(1){ animation-delay:0.2s; }
.animate-card:nth-child(2){ animation-delay:0.4s; }
.animate-card:nth-child(3){ animation-delay:0.6s; }
.animate-card:nth-child(4){ animation-delay:0.8s; }
@keyframes fadeUp { from{opacity:0; transform:translateY(40px);} to{opacity:1; transform:translateY(0);} }

/* Remove link underline */
a { text-decoration:none !important; color:inherit !important; }
</style>

<div class="container py-5">

    <!-- Page Title -->
    <div class="text-center mb-5 dashboard-title">
        <h2 class="fw-bold display-6">Faculty Dashboard Overview</h2>
        <p class="text-muted">Welcome to Faculty Management Panel</p>
        <hr class="w-25 mx-auto">
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4">

        <!-- Total Students -->
        <div class="col-lg-3 col-md-6 animate-card">
            <a href="students_list.php">
                <div class="card dashboard-card text-center p-4">
                    <div class="icon-circle bg-students">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="fw-bold counter"><?= $total_students ?></h3>
                    <p class="text-muted mb-0">Total Students</p>
                </div>
            </a>
        </div>

        <!-- Active Clubs -->
        <div class="col-lg-3 col-md-6 animate-card">                
            <a href="manage_clube.php">
                <div class="card dashboard-card text-center p-4">
                    <div class="icon-circle bg-clubs">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <h3 class="fw-bold counter"><?= $total_clubs ?></h3>
                    <p class="text-muted mb-0">Active Clubs</p>
                </div>
            </a>
        </div>

        <!-- Upcoming Events -->
        <div class="col-lg-3 col-md-6 animate-card">
            <a href="Manage_events.php">
                <div class="card dashboard-card text-center p-4">
                    <div class="icon-circle bg-events">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <h3 class="fw-bold counter"><?= $total_events ?></h3>
                    <p class="text-muted mb-0">Upcoming Events</p>
                </div>
            </a>
        </div>

        <!-- Pending Requests -->
        <div class="col-lg-3 col-md-6 animate-card">
            <a href="Students_request.php">
                <div class="card dashboard-card text-center p-4">
                    <div class="icon-circle bg-requests">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h3 class="fw-bold counter"><?= $total_requests ?></h3>
                    <p class="text-muted mb-0">Pending Requests</p>
                </div>
            </a>
        </div>

    </div>

</div>

<?php include 'F_footer.php'; ?>