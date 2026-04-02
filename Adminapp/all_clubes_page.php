<?php
include 'admin_header.php';
include '../database.php';

// FETCH CLUBS
$query = "SELECT * FROM clubs ORDER BY id DESC";
$result = mysqli_query($con, $query);

// FETCH COUNTS FOR COUNTERS
$total_clubs = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM clubs"))['total'];
$active_clubs = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM clubs WHERE status='Active'"))['total'];
$inactive_clubs = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM clubs WHERE status='Inactive'"))['total'];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(15px);} to {opacity:1; transform:translateY(0);} }

.page-header { background: #fff; border-radius: 15px; padding: 20px 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.05); }
.custom-card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
.table tbody tr:hover { background: #f8f9fa; }

.action-btn { border-radius: 50px; padding: 5px 10px; margin: 0 2px; }
.club-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 10px; }

/* COUNTER CARDS */
.counter-card {
    display: inline-block; width: 200px; margin-right: 20px;
    padding: 20px 15px; border-radius: 12px; background: #fff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05); text-align: center;
    transition: transform 0.3s;
}
.counter-card:hover { transform: translateY(-5px); }
.counter-card h2 { font-size: 2.5rem; margin: 0; color: #dc3545; }
.counter-card p { margin: 5px 0 0; font-weight: 500; color: #555; }
</style>

<div class="content">

    <!-- COUNTER CARDS -->
    <div class="mb-4 d-flex flex-wrap">
        <div class="counter-card">
            <h2 class="counter" data-target="<?php echo $total_clubs; ?>">0</h2>
            <p>Total Clubs</p>
        </div>
        <div class="counter-card">
            <h2 class="counter" data-target="<?php echo $active_clubs; ?>">0</h2>
            <p>Active Clubs</p>
        </div>
        <div class="counter-card">
            <h2 class="counter" data-target="<?php echo $inactive_clubs; ?>">0</h2>
            <p>Inactive Clubs</p>
        </div>
    </div>

    <!-- PAGE HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">All Clubs</h4>
        <a href="add_club.php" class="btn btn-danger">Add Club</a>
    </div>

    <!-- CLUB TABLE -->
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
                <tbody id="clubTableBody">
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr id="row-<?php echo $row['id']; ?>">
                            <td><?php echo $i++; ?></td>
                            <td class="d-flex align-items-center">
                                <img src="uploads/<?php echo $row['clubimage']; ?>" class="club-thumb">
                                <?php echo htmlspecialchars($row['clubname']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['faculty']); ?></td>
                            <td><?php echo htmlspecialchars($row['totalmembers']); ?></td>
                            <td>
                                <?php if ($row['status'] == "Active") { ?>
                                    <span class="badge bg-danger">Active</span>
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
$(document).ready(function () {

    // DELETE CONFIRM + AJAX
    $('.delete-btn').click(function () {
        let btn = $(this);
        let id = btn.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This club will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                // AJAX request to delete
                $.ajax({
                    url: 'delete_club_ajax.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(response){
                        // remove row from table
                        $('#row-' + id).remove();

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Club has been deleted successfully.',
                            icon: 'success',
                            confirmButtonColor: '#dc3545',
                        });
                    },
                    error: function(){
                        Swal.fire('Error','Something went wrong','error');
                    }
                });
            }
        });
    });

    // COUNTER ANIMATION
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / 100;
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

});
</script>

<?php include 'admin_footer.php'; ?>