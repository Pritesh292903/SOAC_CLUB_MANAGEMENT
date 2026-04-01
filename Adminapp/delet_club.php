<?php 
include 'admin_header.php'; 
include '../database.php';

// DELETE LOGIC
if(isset($_GET['delete_id']))
{
    $id = intval($_GET['delete_id']);

    // Optional: delete image file too
    $img_query = mysqli_query($con, "SELECT clubimage FROM clubs WHERE id='$id'");
    $img_row = mysqli_fetch_assoc($img_query);
    if($img_row && file_exists("uploads/".$img_row['clubimage'])){
        unlink("uploads/".$img_row['clubimage']);
    }

    $delete = "DELETE FROM clubs WHERE id='$id'";
    mysqli_query($con, $delete);

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        title: 'Deleted!',
        text: 'Club has been deleted successfully.',
        icon: 'success',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'OK'
    }).then(()=>{ window.location.href='all_club_page.php'; });
    </script>
    ";
    exit;
}

// FETCH CLUBS
$query = "SELECT * FROM clubs ORDER BY id DESC";
$result = mysqli_query($con, $query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content { animation: fadeIn 0.6s ease-in-out; margin-top: 100px; margin-bottom:50px; }
@keyframes fadeIn { from {opacity:0; transform:translateY(15px);} to {opacity:1; transform:translateY(0);} }

.page-header { background:#fff; border-radius:15px; padding:20px 25px; box-shadow:0 8px 25px rgba(0,0,0,0.05);}
.custom-card { border:none; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05); }
.table tbody tr:hover { background:#f8f9fa; }
.action-btn { border-radius:50px; padding:5px 10px; margin:0 2px; }
.club-thumb { width:50px; height:50px; object-fit:cover; border-radius:5px; margin-right:10px; }
</style>

<div class="content container">

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-danger">All Clubs</h4>
    <a href="add_club.php" class="btn btn-danger">Add Club</a>
</div>

<div class="card custom-card p-4">
<div class="table-responsive">
<table class="table align-middle text-center">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Club</th>
    <th>Faculty</th>
    <th>Members</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php 
$i = 1;
while($row = mysqli_fetch_assoc($result)) 
{
?>
<tr>
    <td><?php echo $i++; ?></td>

    <td class="d-flex align-items-center">
        <img src="uploads/<?php echo $row['clubimage']; ?>" class="club-thumb">
        <?php echo htmlspecialchars($row['clubname']); ?>
    </td>

    <td><?php echo htmlspecialchars($row['faculty']); ?></td>
    <td><?php echo htmlspecialchars($row['totalmembers']); ?></td>
    <td>
        <?php if($row['status']=="Active"){ ?>
            <span class="badge bg-success">Active</span>
        <?php } else { ?>
            <span class="badge bg-secondary">Inactive</span>
        <?php } ?>
    </td>

    <td>
        <a href="view_club.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary action-btn" title="View">
            <i class="bi bi-eye"></i>
        </a>

        <a href="edit_club.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning action-btn" title="Edit">
            <i class="bi bi-pencil"></i>
        </a>

        <!-- Proper delete button with data-id -->
        <button class="btn btn-sm btn-outline-danger action-btn delete-btn" data-id="<?php echo $row['id']; ?>" title="Delete">
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
$(document).ready(function(){
    $('.delete-btn').click(function(){
        let id = $(this).data('id'); // important, use data-id

        Swal.fire({
            title: 'Are you sure?',
            text: "This club will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                // redirect with delete_id parameter
                window.location.href = "all_club_page.php?delete_id=" + id;
            }
        });
    });
});
</script>

<?php include 'admin_footer.php'; ?>