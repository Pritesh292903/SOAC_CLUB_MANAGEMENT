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

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* KEEP YOUR CSS SAME */
    .content {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-mini {
        border: none;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }

    .stat-mini:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-mini h6 {
        color: #6c757d;
    }

    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        background: #fff;
    }

    .custom-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .action-btn {
        border-radius: 50px;
        padding: 5px 10px;
    }

    .event-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }
</style>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0 text-danger">All Events</h4>
            <small class="text-muted">Manage and monitor all club events</small>
        </div>
        <a href="add_event.php" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">Add Event</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Total Events</h6>
                <h5><?= $total; ?></h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Active</h6>
                <h5><?= $active; ?></h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Closed</h6>
                <h5><?= $closed; ?></h5>
            </div>
        </div>
    </div>

    <div class="card custom-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
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
                            $image = !empty($row['image']) ? $row['image'] : 'default.png'; ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><img src="../uploads/<?php echo $image; ?>" class="event-thumb"
                                        onerror="this.src='../uploads/default.png'"></td>
                                <td><?= $date; ?></td>
                                <td><?= $status; ?></td>
                                <td class="text-center">
                                    <a href="view_event.php?id=<?= $id; ?>"
                                        class="btn btn-sm btn-outline-danger action-btn">View</a>
                                    <a href="edit_event.php?id=<?= $id; ?>"
                                        class="btn btn-sm btn-outline-warning action-btn">Edit</a>
                                    <button class="btn btn-sm btn-outline-secondary action-btn delete-btn"
                                        data-id="<?= $id; ?>">Delete</button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No Events Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('.delete-btn').click(function () {
        let id = $(this).data('id');
        let row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('delete_event.php', { id: id }, function (res) {
                    row.remove();
                    Swal.fire('Deleted!', 'Event has been deleted.', 'success');
                });
            }
        });
    });
</script>

<?php include 'admin_footer.php'; ?>