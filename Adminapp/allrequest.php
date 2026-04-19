<?php
session_start();
include 'admin_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

/* SAFE FUNCTION */
function safe($arr, $keys, $default = 'N/A')
{
    foreach ($keys as $key) {
        if (isset($arr[$key]) && $arr[$key] !== null && $arr[$key] !== '') {
            return htmlspecialchars($arr[$key]);
        }
    }
    return $default;
}

/* STATUS BADGE */
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== MAIN LAYOUT FIX ===== */
body{
    background:#f4f6f9;
}

.content{
    margin-left:260px;
    margin-top:80px;
    padding:20px;
}

/* MOBILE FIX */
@media(max-width:768px){
    .content{
        margin-left:0;
    }
}

/* ===== HEADER ===== */
.page-header{
    background:#fff;
    padding:18px 20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    margin-bottom:20px;
}

/* ===== CARD ===== */
.card-box{
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

/* ===== TABLE ===== */
.table thead th{
    background:#dc3545;
    color:#fff;
    border:none;
    font-weight:500;
}

.table tbody tr:hover{
    background:#f8f9fa;
}

/* ===== BADGES ===== */
.badge{
    padding:6px 12px;
    border-radius:20px;
}

.badge-club{ background:#dc3545; }
.badge-event{ background:#0d6efd; }

.badge-paid{ background:#198754; }
.badge-free{ background:#ffc107; color:#000; }

/* ===== BUTTON ===== */
.btn{
    border-radius:50px;
    padding:5px 12px;
    font-size:13px;
}

/* ===== SCROLL ===== */
.table-responsive{
    max-height:500px;
    overflow-y:auto;
}

/* CENTER */
.table th, .table td{
    text-align:center;
    vertical-align:middle;
}

</style>

<div class="content">

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center">
    <h5 class="text-danger m-0">All Student Requests</h5>
</div>

<!-- TABLE -->
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
    <th>Paid</th> <!-- ✅ NEW -->
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$i = 1;

/* ================= CLUB REQUESTS ================= */
$club_requests = mysqli_query($con, "
    SELECT r.*, u.fullname, u.email, u.mobile, 
           c.clubname, c.club_paid
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
        <td>".safe($req, ['clubname'], 'Not Assigned')."</td>
        <td><span class='badge badge-club'>Club</span></td>
        
        <!-- ✅ PAID FIELD -->
        <td>";
            if($req['club_paid']=="Paid"){
                echo "<span class='badge badge-paid'>Paid</span>";
            } else {
                echo "<span class='badge badge-free'>Unpaid</span>";
            }
        echo "</td>

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

/* ================= EVENT REQUESTS ================= */
$event_requests = mysqli_query($con, "
    SELECT r.*, u.fullname, u.email, u.mobile, 
           e.name AS event_name, e.event_type
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

        <!-- ✅ PAID FIELD -->
        <td>";
            if($req['event_type']=="Paid"){
                echo "<span class='badge badge-paid'>Paid</span>";
            } else {
                echo "<span class='badge badge-free'>Unpaid</span>";
            }
        echo "</td>

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