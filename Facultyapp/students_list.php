<?php 
include 'F_header.php'; 
include '../database.php';
mysqli_select_db($con, "SOAE_CLUB");

/* ================= SAFE FUNCTION ================= */
function safe($arr, $keys, $default = 'N/A'){
    foreach($keys as $key){
        if(isset($arr[$key]) && $arr[$key] !== null && $arr[$key] !== ''){
            return htmlspecialchars($arr[$key]);
        }
    }
    return $default;
}

/* ================= CREATE MASTER TABLE ================= */
mysqli_query($con, "CREATE TABLE IF NOT EXISTS students_master (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    club_or_event VARCHAR(100),
    type ENUM('club','event'),
    join_date DATETIME,
    status VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>

<div class="container my-5">

<h2 class="mb-4">Students Management</h2>

<div class="table-responsive">
<table class="table table-bordered text-center">
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
</tr>
</thead>

<tbody>

<?php
$i = 1;

/* ================= CLUB REQUESTS ================= */
$club_requests = mysqli_query($con, "SELECT * FROM club_join_requests ORDER BY created_at DESC");

if($club_requests){
while($req = mysqli_fetch_assoc($club_requests)){

    $name  = safe($req, ['name','student_name']);
    $email = safe($req, ['email']);
    $phone = safe($req, ['phone','mobile']);
    $club  = safe($req, ['club_name','club']);
    $status= $req['status'] ?? 'pending';
    $date  = !empty($req['created_at']) ? date("d-m-Y", strtotime($req['created_at'])) : '-';

    echo "<tr>
        <td>".$i++."</td>
        <td>$name</td>
        <td>$email</td>
        <td>$phone</td>
        <td>$club</td>
        <td>Club</td>
        <td>$date</td>
        <td>".statusBadge($status)."</td>
    </tr>";

    /* ===== INSERT ONLY IF APPROVED ===== */
    if($status == "approved"){

        $name_db  = mysqli_real_escape_string($con, $req['name'] ?? $req['student_name'] ?? '');
        $email_db = mysqli_real_escape_string($con, $req['email'] ?? '');
        $phone_db = mysqli_real_escape_string($con, $req['phone'] ?? $req['mobile'] ?? '');
        $club_db  = mysqli_real_escape_string($con, $req['club_name'] ?? $req['club'] ?? '');
        $join     = $req['created_at'];

        $check = mysqli_query($con, "SELECT id FROM students_master 
            WHERE email='$email_db' AND type='club' AND club_or_event='$club_db' LIMIT 1");

        if(mysqli_num_rows($check) == 0){
            mysqli_query($con, "INSERT INTO students_master 
            (name,email,phone,club_or_event,type,join_date,status)
            VALUES ('$name_db','$email_db','$phone_db','$club_db','club','$join','approved')");
        }
    }
}
}

/* ================= EVENT REQUESTS ================= */
$event_requests = mysqli_query($con, "SELECT * FROM event_join_requests ORDER BY created_at DESC");

if($event_requests){
while($req = mysqli_fetch_assoc($event_requests)){

    $name  = safe($req, ['name','student_name']);
    $email = safe($req, ['email']);
    $phone = safe($req, ['phone','mobile']);
    $event = safe($req, ['event_name','event']);
    $status= $req['status'] ?? 'pending';
    $date  = !empty($req['created_at']) ? date("d-m-Y", strtotime($req['created_at'])) : '-';

    echo "<tr>
        <td>".$i++."</td>
        <td>$name</td>
        <td>$email</td>
        <td>$phone</td>
        <td>$event</td>
        <td>Event</td>
        <td>$date</td>
        <td>".statusBadge($status)."</td>
    </tr>";

    /* ===== INSERT ONLY IF APPROVED ===== */
    if($status == "approved"){

        $name_db  = mysqli_real_escape_string($con, $req['name'] ?? $req['student_name'] ?? '');
        $email_db = mysqli_real_escape_string($con, $req['email'] ?? '');
        $phone_db = mysqli_real_escape_string($con, $req['phone'] ?? $req['mobile'] ?? '');
        $event_db = mysqli_real_escape_string($con, $req['event_name'] ?? $req['event'] ?? '');
        $join     = $req['created_at'];

        $check = mysqli_query($con, "SELECT id FROM students_master 
            WHERE email='$email_db' AND type='event' AND club_or_event='$event_db' LIMIT 1");

        if(mysqli_num_rows($check) == 0){
            mysqli_query($con, "INSERT INTO students_master 
            (name,email,phone,club_or_event,type,join_date,status)
            VALUES ('$name_db','$email_db','$phone_db','$event_db','event','$join','approved')");
        }
    }
}
}
?>

</tbody>
</table>
</div>

</div>

<?php include 'F_footer.php'; ?>

<?php
/* ================= STATUS BADGE ================= */
function statusBadge($status){
    if($status == "approved"){
        return '<span class="badge bg-success">Approved</span>';
    } elseif($status == "pending"){
        return '<span class="badge bg-warning text-dark">Pending</span>';
    } else {
        return '<span class="badge bg-danger">Rejected</span>';
    }
}
?>