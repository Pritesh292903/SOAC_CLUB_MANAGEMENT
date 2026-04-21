<?php
session_start();
include 'admin_header.php';
include '../database.php';

mysqli_select_db($con, "SOAE_CLUB");

/* SAFE */
function safe($arr, $keys, $default = 'N/A') {
    foreach ($keys as $key) {
        if (!empty($arr[$key])) return htmlspecialchars($arr[$key]);
    }
    return $default;
}

/* STATUS */
function statusBadge($status) {
    if ($status == "approved") return '<span class="badge bg-success">Approved</span>';
    elseif ($status == "pending") return '<span class="badge bg-warning text-dark">Pending</span>';
    else return '<span class="badge bg-danger">Rejected</span>';
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{ background:#f8f9fb; font-family:'Segoe UI'; }

.content{ margin-left:260px; margin-top:90px; padding:25px; }

@media(max-width:768px){
.content{ margin-left:0; margin-top:80px; }
}

.card-box{
background:#fff;
padding:25px;
border-radius:18px;
box-shadow:0 8px 25px rgba(0,0,0,0.05);
}

.page-title{
text-align:center;
color:#dc3545;
font-weight:600;
margin-bottom:25px;
}

.top-bar{
background:#fff;
padding:15px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
}

#searchInput{ border-radius:30px; padding:10px 15px; }
#statusFilter{ border-radius:30px; }

/* RED DELETE BUTTON */
#deleteAllBtn{
background:#dc3545;
color:#fff;
border:none;
border-radius:30px;
padding:8px 18px;
transition:0.3s;
}

#deleteAllBtn:hover{
background:#b02a37;
transform:scale(1.05);
}

.table thead th{
background:#dc3545;
color:#fff;
}

.table tbody tr:hover{
background:#fff5f5;
}

.action-btn,.delete-btn{
border-radius:30px;
padding:5px 12px;
font-size:12px;
margin:2px;
}

.delete-btn{
background:#212529;
color:#fff;
}

.table-responsive{
max-height:500px;
overflow-y:auto;
}

.badge.bg-warning{
background:#ffc107 !important;
color:#000 !important;
}
</style>

<div class="content">
<div class="card-box">

<h4 class="page-title">All Student Requests</h4>

<!-- TOP BAR -->
<div class="top-bar d-flex justify-content-between flex-wrap gap-2 mb-3">

<input type="text" id="searchInput" class="form-control w-50" placeholder="Search by name or club/event...">

<select id="statusFilter" class="form-select w-25">
<option value="all">All</option>
<option value="pending">Pending</option>
<option value="approved">Approved</option>
<option value="rejected">Rejected</option>
</select>

<button id="deleteAllBtn">Delete All</button>

</div>

<div class="table-responsive">
<table class="table table-bordered text-center">

<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Club/Event</th>
<th>Type</th>
<th>Status</th>
<th>Paid</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$i=1;

/* CLUB */
$club=mysqli_query($con,"
SELECT r.*,u.fullname,c.clubname,c.club_paid
FROM club_join_requests r
JOIN user u ON r.user_id=u.id
LEFT JOIN clubs c ON r.club_id=c.id
");

while($row=mysqli_fetch_assoc($club)){
$id=$row['id']; $status=$row['status'];

$name = strtolower($row['fullname']);
$title = strtolower(safe($row,['clubname']));

echo "<tr data-status='$status' data-name='$name' data-title='$title'>
<td>".$i++."</td>
<td>{$row['fullname']}</td>
<td>".safe($row,['clubname'])."</td>
<td><span class='badge bg-danger'>Club</span></td>
<td>".statusBadge($status)."</td>

<td>";
echo ($row['club_paid']=="Paid")
? "<span class='badge bg-success'>Paid</span>"
: "<span class='badge bg-warning text-dark'>Unpaid</span>";
echo "</td>

<td>";

if($status=="pending"){
echo "
<button class='btn btn-success btn-sm action-btn' data-id='$id' data-type='club' data-action='approve'>Approve</button>
<button class='btn btn-danger btn-sm action-btn' data-id='$id' data-type='club' data-action='reject'>Reject</button>
<button class='btn btn-dark btn-sm delete-btn' data-id='$id' data-type='club'>Delete</button>
";
}else{
echo "<button class='btn btn-dark btn-sm delete-btn' data-id='$id' data-type='club'>Delete</button>";
}

echo "</td></tr>";
}

/* EVENT */
$event=mysqli_query($con,"
SELECT r.*,u.fullname,e.name AS event_name,e.event_type
FROM event_join_requests r
JOIN user u ON r.user_id=u.id
LEFT JOIN events e ON r.event_id=e.id
");

while($row=mysqli_fetch_assoc($event)){
$id=$row['id']; $status=$row['status'];

$name = strtolower($row['fullname']);
$title = strtolower(safe($row,['event_name']));

echo "<tr data-status='$status' data-name='$name' data-title='$title'>
<td>".$i++."</td>
<td>{$row['fullname']}</td>
<td>".safe($row,['event_name'])."</td>
<td><span class='badge bg-primary'>Event</span></td>
<td>".statusBadge($status)."</td>

<td>";
echo ($row['event_type']=="Paid")
? "<span class='badge bg-success'>Paid</span>"
: "<span class='badge bg-warning text-dark'>Unpaid</span>";
echo "</td>

<td>";

if($status=="pending"){
echo "
<button class='btn btn-success btn-sm action-btn' data-id='$id' data-type='event' data-action='approve'>Approve</button>
<button class='btn btn-danger btn-sm action-btn' data-id='$id' data-type='event' data-action='reject'>Reject</button>
<button class='btn btn-dark btn-sm delete-btn' data-id='$id' data-type='event'>Delete</button>
";
}else{
echo "<button class='btn btn-dark btn-sm delete-btn' data-id='$id' data-type='event'>Delete</button>";
}

echo "</td></tr>";
}
?>

</tbody>
</table>
</div>
</div>
</div>

<script>
// APPROVE / REJECT
document.querySelectorAll('.action-btn').forEach(btn=>{
btn.onclick=()=>{
fetch('handle_request.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`id=${btn.dataset.id}&type=${btn.dataset.type}&action=${btn.dataset.action}`
})
.then(res=>res.text())
.then(d=>{alert(d);location.reload();});
};
});

// DELETE SINGLE
document.querySelectorAll('.delete-btn').forEach(btn=>{
btn.onclick=()=>{
if(!confirm("Delete this request?")) return;
fetch('handle_request.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`id=${btn.dataset.id}&type=${btn.dataset.type}&action=delete`
})
.then(res=>res.text())
.then(d=>{alert(d);location.reload();});
};
});

// 🔥 SMART SEARCH
document.getElementById("searchInput").addEventListener("keyup", function(){

let value = this.value.toLowerCase().trim();

document.querySelectorAll("tbody tr").forEach(row=>{

let name = row.dataset.name;
let title = row.dataset.title;

if(name.includes(value) || title.includes(value)){
row.style.display="";
}else{
row.style.display="none";
}

});

});

// FILTER
document.getElementById("statusFilter").onchange=function(){
let v=this.value;
document.querySelectorAll("tbody tr").forEach(r=>{
r.style.display=(v=="all"||r.dataset.status==v)?"":"none";
});
};

// DELETE ALL
document.getElementById("deleteAllBtn").onclick=()=>{
if(!confirm("Delete ALL requests?")) return;
fetch('handle_request.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`action=delete_all`
})
.then(res=>res.text())
.then(d=>{alert(d);location.reload();});
};
</script>

<?php include 'admin_footer.php'; ?>