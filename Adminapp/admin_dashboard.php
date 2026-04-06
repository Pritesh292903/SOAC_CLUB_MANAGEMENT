<?php
include 'admin_header.php';
include '../database.php'; // Your database connection and tables
?>

<style>
    /* ===== Page Animation ===== */
    .content {
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Stat Cards ===== */
    .stat-card {
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        padding: 25px;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.08);
    }

    /* Gradient Top Border */
    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, #dc3545, #ff6b6b);
    }

    /* Icon Style */
    .stat-card i {
        transition: transform 0.4s ease;
        font-size: 2.5rem;
        color: #dc3545;
        margin-bottom: 10px;
    }

    .stat-card:hover i {
        transform: scale(1.2);
    }

    /* Card Fade Animation */
    .card {
        animation: fadeUp 1s ease;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Table Styling */
    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    /* Header Title */
    .content h4,
    .content h5 {
        color: #dc3545;
    }

    /* Buttons */
    .btn-danger {
        border-radius: 50px;
    }

    /* Badges */
    .badge-success {
        background-color: #28a745 !important;
    }

    .badge-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    .badge-danger {
        background-color: #6c757d !important;
    }

    /* Responsive */
    @media (max-width:767px) {
        .stat-card {
            margin-bottom: 20px;
        }
    }
</style>

<div class="content">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold">Dashboard Overview</h4>
        <span class="text-muted">Welcome back, Admin 👋</span>
    </div>

    <!-- Fetch dynamic counts -->
    <?php
    // Total Events
    $totalEvents = mysqli_num_rows(mysqli_query($con, "SELECT id FROM events"));

    // Total Clubs
    $totalClubs = mysqli_num_rows(mysqli_query($con, "SELECT id FROM clubs"));

    // Total Students
    $totalStudents = mysqli_num_rows(mysqli_query($con, "SELECT id FROM User WHERE role='user'"));

    // Total Faculties
    $totalFaculties = mysqli_num_rows(mysqli_query($con, "SELECT id FROM Faculty_register"));
    ?>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="stat-card">
                <i class="bi bi-calendar-event"></i>
                <h3 class="fw-bold"><?= $totalEvents ?></h3>
                <p class="text-muted mb-0">Total Events</p>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="stat-card">
                <i class="bi bi-people"></i>
                <h3 class="fw-bold"><?= $totalClubs ?></h3>
                <p class="text-muted mb-0">Total Clubs</p>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="stat-card">
                <i class="bi bi-mortarboard"></i>
                <h3 class="fw-bold"><?= $totalStudents ?></h3>
                <p class="text-muted mb-0">Total Students</p>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="stat-card">
                <i class="bi bi-person-badge"></i>
                <h3 class="fw-bold"><?= $totalFaculties ?></h3>
                <p class="text-muted mb-0">Total Faculties</p>
            </div>
        </div>

    </div>

    <!-- Recent Events Table -->
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="fw-bold mb-0">Recent Events</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Club</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $eventsRes = mysqli_query($con, "SELECT e.*, c.clubname FROM events e LEFT JOIN clubs c ON c.id=e.id ORDER BY e.id DESC LIMIT 5");
                    if (mysqli_num_rows($eventsRes) > 0) {
                        while ($row = mysqli_fetch_assoc($eventsRes)) {
                            $statusClass = ($row['status'] == 'Active') ? 'badge-success' : (($row['status'] == 'Upcoming') ? 'badge-warning' : 'badge-danger');
                            echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td>" . ($row['clubname'] ?? 'N/A') . "</td>
                                    <td>" . date('d M Y', strtotime($row['date'])) . "</td>
                                    <td><span class='{$statusClass}'>{$row['status']}</span></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No events found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?php include 'admin_footer.php'; ?>