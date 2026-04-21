<?php
session_start();
include 'admin_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

function safe($arr, $keys, $default = 'N/A') {
    foreach ($keys as $key) {
        if (!empty($arr[$key])) {
            return htmlspecialchars($arr[$key]);
        }
    }
    return $default;
}

function statusBadge($status) {
    if ($status == "approved") return '<span class="badge bg-success">Approved</span>';
    elseif ($status == "pending") return '<span class="badge bg-warning text-dark">Pending</span>';
    else return '<span class="badge bg-danger">Rejected</span>';
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">

<h4 class="text-danger mb-4">All Student Requests</h4>

<table class="table table-bordered text-center">
<thead class="table-danger">
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Club/Event</th>
    <th>Type</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$i = 1;

/* CLUB */
$club = mysqli_query($con,"
SELECT r.*,u.fullname,c.clubname
FROM club_join_requests r
JOIN user u ON r.user_id=u.id
LEFT JOIN clubs c ON r.club_id=c.id
");

while($row = mysqli_fetch_assoc($club)){
$id=$row['id'];
$status=$row['status'];

echo "<tr>
<td>".$i++."</td>
<td>{$row['fullname']}</td>
<td>".safe($row,['clubname'])."</td>
<td><span class='badge bg-danger'>Club</span></td>
<td>".statusBadge($status)."</td>
<td>";

if($status=="pending"){
echo "
<button class='btn btn-success btn-sm action-btn' data-id='$id' data-type='club' data-action='approve'>Approve</button>
<button class='btn btn-danger btn-sm action-btn' data-id='$id' data-type='club' data-action='reject'>Reject</button>
";
}else{
echo "-";
}

echo "</td></tr>";
}

/* EVENT */
$event = mysqli_query($con,"
SELECT r.*,u.fullname,e.name AS event_name
FROM event_join_requests r
JOIN user u ON r.user_id=u.id
LEFT JOIN events e ON r.event_id=e.id
");

while($row = mysqli_fetch_assoc($event)){
$id=$row['id'];
$status=$row['status'];

echo "<tr>
<td>".$i++."</td>
<td>{$row['fullname']}</td>
<td>".safe($row,['event_name'])."</td>
<td><span class='badge bg-primary'>Event</span></td>
<td>".statusBadge($status)."</td>
<td>";

if($status=="pending"){
echo "
<button class='btn btn-success btn-sm action-btn' data-id='$id' data-type='event' data-action='approve'>Approve</button>
<button class='btn btn-danger btn-sm action-btn' data-id='$id' data-type='event' data-action='reject'>Reject</button>
";
}else{
echo "-";
}

echo "</td></tr>";
}
?>

</tbody>
</table>
</div>

<!-- ✅ IMPORTANT JS -->
<script>
document.querySelectorAll('.action-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        const id = btn.dataset.id;
        const type = btn.dataset.type;
        const action = btn.dataset.action;

        fetch('handle_request.php', {   // ✅ SAME FOLDER
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `id=${id}&type=${type}&action=${action}`
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            location.reload();
        });

    });

});
</script>

<?php include 'admin_footer.php'; ?>