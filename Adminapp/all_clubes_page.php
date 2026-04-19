<?php
include 'admin_header.php';
include '../database.php';

// FETCH CLUBS
$query = "SELECT * FROM clubs ORDER BY id DESC";
$result = mysqli_query($con, $query);

// COUNTS
$total_clubs = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM clubs"))['total'];
$active_clubs = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM clubs WHERE status='Active'"))['total'];
$inactive_clubs = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM clubs WHERE status='Inactive'"))['total'];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>

/* 🌟 BODY */
body{
    background:#f4f6f9;
}

/* ✅ MAIN CONTENT FIX */
.content{
    margin-left:260px;   /* sidebar width */
    margin-top:80px;     /* navbar height */
    padding:20px;
}

/* MOBILE FIX */
@media(max-width:768px){
    .content{
        margin-left:0;
        margin-top:80px;
    }
}

/* HEADER */
.page-header{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

/* COUNTER */
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

.counter-card h2{
    color:#dc3545;
    font-weight:bold;
}

/* TABLE */
.table-card{
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

.table tbody tr:hover{
    background:#f1f3f5;
}

/* IMAGE */
.club-thumb{
    width:45px;
    height:45px;
    border-radius:8px;
    object-fit:cover;
    margin-right:10px;
}

/* BADGES */
.badge-paid{background:#198754;}
.badge-unpaid{background:#ffc107;color:#000;}

.action-btn{border-radius:50px;}

</style>

<div class="content">

<!-- COUNTER -->
<div class="d-flex flex-wrap mb-4">
    <div class="counter-card">
        <h2 class="counter" data-target="<?php echo $total_clubs; ?>">0</h2>
        <p>Total Clubs</p>
    </div>
    <div class="counter-card">
        <h2 class="counter" data-target="<?php echo $active_clubs; ?>">0</h2>
        <p>Active</p>
    </div>
    <div class="counter-card">
        <h2 class="counter" data-target="<?php echo $inactive_clubs; ?>">0</h2>
        <p>Inactive</p>
    </div>
</div>

<!-- HEADER -->
<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-danger m-0">All Clubs</h4>
    <a href="add_club.php" class="btn btn-danger">+ Add Club</a>
</div>

<!-- TABLE -->
<div class="card table-card p-3">
<div class="table-responsive">

<table class="table align-middle text-center">

<thead class="table-light">
<tr>
<th>#</th>
<th>Club</th>
<th>Faculty</th>
<th>Members</th>
<th>Status</th>
<th>Type</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php $i=1; while($row=mysqli_fetch_assoc($result)){ ?>

<tr id="row-<?php echo $row['id']; ?>">

<td><?php echo $i++; ?></td>

<td class="d-flex align-items-center">
<img src="uploads/<?php echo $row['clubimage']; ?>" class="club-thumb">
<?php echo htmlspecialchars($row['clubname']); ?>
</td>

<td><?php echo htmlspecialchars($row['faculty']); ?></td>

<td><?php echo $row['totalmembers']; ?></td>

<td>
<?php if($row['status']=="Active"){ ?>
<span class="badge bg-success">Active</span>
<?php }else{ ?>
<span class="badge bg-secondary">Inactive</span>
<?php } ?>
</td>

<td>
<?php if($row['club_paid']=="Paid"){ ?>
<span class="badge badge-paid">Paid</span>
<?php }else{ ?>
<span class="badge badge-unpaid">Unpaid</span>
<?php } ?>
</td>

<td>
<a href="view_club.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary action-btn">
<i class="bi bi-eye"></i>
</a>

<a href="edit_club.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning action-btn">
<i class="bi bi-pencil"></i>
</a>

<button class="btn btn-sm btn-outline-danger action-btn delete-btn" data-id="<?php echo $row['id']; ?>">
<i class="bi bi-trash"></i>
</button>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// DELETE
$('.delete-btn').click(function(){
    let id=$(this).data('id');

    Swal.fire({
        title:'Are you sure?',
        icon:'warning',
        showCancelButton:true
    }).then((res)=>{
        if(res.isConfirmed){
            $.post('delete_club_ajax.php',{id:id},function(){
                $('#row-'+id).remove();
                Swal.fire('Deleted','','success');
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