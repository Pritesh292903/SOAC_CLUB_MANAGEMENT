<?php
session_start();
include 'admin_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

/* ================= SAFE FUNCTION ================= */
function safe($arr, $keys, $default = 'N/A')
{
    foreach ($keys as $key) {
        if (isset($arr[$key]) && $arr[$key] !== null && $arr[$key] !== '') {
            return htmlspecialchars($arr[$key]);
        }
    }
    return $default;
}

/* ================= STATUS BADGE ================= */
function statusBadge($status)
{
    if ($status == "approved") {
        return '<span class="badge bg-success">Approved</span>';
    } elseif ($status == "pending") {
        return '<span class="badge bg-warning text-dark">Pending</span>';
    } else {
        return '<span class="badge bg-danger">Rejected</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== BODY FIX (MAIN IMPORTANT) ===== */
body {
    background: #f4f6f9;
    font-family: 'Segoe UI', sans-serif;
    padding-top: 90px;   /* header space */
    padding-bottom: 70px; /* footer space */
    padding-left: 280px;
}

/* ===== HEADER FIX ===== */
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

/* ===== FOOTER FIX ===== */
footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 1000;
}

/* ===== PAGE TITLE ===== */
.page-title {
    background: linear-gradient(45deg, #dc3545, #ff6b6b);
    color: #fff;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    font-weight: 600;
    margin-bottom: 20px;
}

/* ===== CARD ===== */
.card-box {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 50px;
}

/* ===== TABLE ===== */
.table thead th {
    background: #dc3545;
    color: white;
    padding: 12px;
    border: none;
}

.table tbody td {
    padding: 12px;
    vertical-align: middle;
}

.table tbody tr:hover {
    background: #fff3f3;
}

/* ===== BADGES ===== */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
}

.badge-club {
    background: #dc3545;
}

.badge-event {
    background: #ffc107;
    color: black;
}

/* ===== BUTTONS ===== */
.btn {
    border-radius: 20px;
    font-size: 12px;
    padding: 5px 12px;
}

/* ===== SCROLL TABLE ===== */
.table-responsive {
    max-height: 500px;
    overflow-y: auto;
}

/* CENTER ALIGN */
.table th, .table td {
    text-align: center;
}

</style>
</head>

<body>

<div class="container-fluid px-4">

    <div class="page-title">
        All Student Requests
    </div>

    <div class="card-box">

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Club/Event</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

<?php
$i = 1;

/* ===== CLUB REQUESTS ===== */
$club_requests = mysqli_query($con, "
    SELECT r.*, u.fullname, u.email, u.mobile, c.clubname AS club_name
    FROM club_join_requests r
    JOIN user u ON r.user_id = u.id
    LEFT JOIN clubs c ON r.club_id = c.id
    ORDER BY r.created_at DESC
");

while ($req = mysqli_fetch_assoc($club_requests)) {

    $id     = $req['id'];
    $status = $req['status'];

    echo "<tr>
        <td>".$i++."</td>
        <td>".htmlspecialchars($req['fullname'])."</td>
        <td>".htmlspecialchars($req['email'])."</td>
        <td>".htmlspecialchars($req['mobile'])."</td>
        <td>".safe($req, ['club_name'], 'Not Assigned')."</td>
        <td><span class='badge badge-club'>Club</span></td>
        <td>".date("d-m-Y", strtotime($req['created_at']))."</td>
        <td>".statusBadge($status)."</td>
        <td>";

    if ($status == "pending") {
        echo "
        <div class='d-flex justify-content-center gap-2'>
            <a href='update_status.php?id=$id&type=club&status=approved' class='btn btn-success btn-sm'>Approve</a>
            <a href='update_status.php?id=$id&type=club&status=rejected' class='btn btn-danger btn-sm'>Reject</a>
        </div>";
    } else {
        echo "-";
    }

    echo "</td></tr>";
}

/* ===== EVENT REQUESTS ===== */
$event_requests = mysqli_query($con, "
    SELECT r.*, u.fullname, u.email, u.mobile, e.name AS event_name
    FROM event_join_requests r
    JOIN user u ON r.user_id = u.id
    LEFT JOIN events e ON r.event_id = e.id
    ORDER BY r.created_at DESC
");

while ($req = mysqli_fetch_assoc($event_requests)) {

    $id     = $req['id'];
    $status = $req['status'];

    echo "<tr>
        <td>".$i++."</td>
        <td>".htmlspecialchars($req['fullname'])."</td>
        <td>".htmlspecialchars($req['email'])."</td>
        <td>".htmlspecialchars($req['mobile'])."</td>
        <td>".safe($req, ['event_name'], 'Not Assigned')."</td>
        <td><span class='badge badge-event'>Event</span></td>
        <td>".date("d-m-Y", strtotime($req['created_at']))."</td>
        <td>".statusBadge($status)."</td>
        <td>";

    if ($status == "pending") {
        echo "
        <div class='d-flex justify-content-center gap-2'>
            <a href='update_status.php?id=$id&type=event&status=approved' class='btn btn-success btn-sm'>Approve</a>
            <a href='update_status.php?id=$id&type=event&status=rejected' class='btn btn-danger btn-sm'>Reject</a>
        </div>";
    } else {
        echo "-";
    }

    echo "</td></tr>";
}
?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include 'admin_footer.php'; ?>

</body>
</html>