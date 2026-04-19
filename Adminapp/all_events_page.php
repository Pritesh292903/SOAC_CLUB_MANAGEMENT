<?php
include 'admin_header.php';
include '../database.php';

// FETCH ALL EVENTS
$result = mysqli_query($con, "SELECT * FROM events ORDER BY id DESC");

// COUNT TOTALS
$total = mysqli_num_rows($result);
$active = mysqli_num_rows(mysqli_query($con, "SELECT id FROM events WHERE status='Active'"));
$closed = mysqli_num_rows(mysqli_query($con, "SELECT id FROM events WHERE status='Closed'"));
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
body{background:#f4f6f9;}

.content{
    margin-left:260px;
    margin-top:80px;
    padding:20px;
}
@media(max-width:768px){
    .content{margin-left:0;}
}

.page-header{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.counter-card{
    flex:1;
    min-width:180px;
    padding:20px;
    border-radius:15px;
    background:#fff;
    text-align:center;
    margin:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}
.counter-card h2{color:#dc3545;font-weight:bold;}

.table-card{
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}
.table tbody tr:hover{background:#f1f3f5;}

.event-thumb{
    width:45px;
    height:45px;
    border-radius:8px;
    object-fit:cover;
    margin-right:10px;
}

.badge-active{background:#198754;}
.badge-closed{background:#6c757d;}
.badge-paid{background:#dc3545;}
.badge-unpaid{background:#17a2b8;}

.action-btn{border-radius:50px;margin:2px;}
</style>

<div class="content">

<!-- COUNTER -->
<div class="d-flex flex-wrap mb-4">
    <div class="counter-card">
        <h2 class="counter" data-target="<?= $total; ?>">0</h2>
        <p>Total Events</p>
    </div>
    <div class="counter-card">
        <h2 class="counter" data-target="<?= $active; ?>">0</h2>
        <p>Active</p>
    </div>
    <div class="counter-card">
        <h2 class="counter" data-target="<?= $closed; ?>">0</h2>
        <p>Closed</p>
    </div>
</div>

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-danger m-0">All Events</h4>
    <a href="add_event.php" class="btn btn-danger">+ Add Event</a>
</div>

<!-- TABLE -->
<div class="card table-card p-3">
<div class="table-responsive">

<table class="table align-middle text-center">

<thead class="table-light">
<tr>
<th>#</th>
<th>Event</th>
<th>Date</th>
<th>Status</th>
<th>Type</th> <!-- ✅ NEW -->
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id'];
        $name = $row['name'];
        $date = $row['date'];
        $status = $row['status'];
        $type = $row['event_type'] ?? 'Unpaid'; // ✅ NEW
        $image = !empty($row['image']) ? $row['image'] : 'default.png';
?>

<tr id="row-<?= $id; ?>">

<td><?= $i++; ?></td>

<td class="d-flex align-items-center">
<img src="../uploads/<?= $image; ?>" class="event-thumb">
<?= htmlspecialchars($name); ?>
</td>

<td><?= $date; ?></td>

<td>
<?php if($status=="Active"){ ?>
<span class="badge badge-active">Active</span>
<?php } else { ?>
<span class="badge badge-closed">Closed</span>
<?php } ?>
</td>

<!-- ✅ EVENT TYPE -->
<td>
<?php if($type=="Paid"){ ?>
<span class="badge badge-paid">Paid</span>
<?php } else { ?>
<span class="badge badge-unpaid">Unpaid</span>
<?php } ?>
</td>

<td>
<a href="view_event.php?id=<?= $id; ?>" class="btn btn-sm btn-outline-primary action-btn">
<i class="bi bi-eye"></i>
</a>

<a href="edit_event.php?id=<?= $id; ?>" class="btn btn-sm btn-outline-warning action-btn">
<i class="bi bi-pencil"></i>
</a>

<button class="btn btn-sm btn-outline-danger action-btn delete-btn" data-id="<?= $id; ?>">
<i class="bi bi-trash"></i>
</button>
</td>

</tr>

<?php
    }
} else {
    echo "<tr><td colspan='6'>No Events Found</td></tr>";
}
?>

</tbody>
</table>

</div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// DELETE
$('.delete-btn').click(function () {
    let id = $(this).data('id');
    let row = $('#row-' + id);

    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true
    }).then((res) => {
        if (res.isConfirmed) {
            $.post('delete_event.php', { id: id }, function () {
                row.remove();
                Swal.fire('Deleted', '', 'success');
            });
        }
    });
});

// COUNTER
$('.counter').each(function(){
    let $this=$(this), target=+$this.data('target');
    let count=0, inc=target/100;

    function update(){
        count+=inc;
        if(count<target){
            $this.text(Math.ceil(count));
            setTimeout(update,20);
        }else{
            $this.text(target);
        }
    }
    update();
});

</script>

<?php include 'admin_footer.php'; ?>