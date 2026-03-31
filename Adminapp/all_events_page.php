<?php
include 'admin_header.php';
include '../database.php';

// SIMPLE QUERY
$result = mysqli_query($con, "SELECT * FROM events ORDER BY id DESC");

// SIMPLE COUNT
$total = mysqli_num_rows($result);

$active = mysqli_num_rows(mysqli_query($con, "SELECT id FROM events WHERE status='Active'"));
$closed = mysqli_num_rows(mysqli_query($con, "SELECT id FROM events WHERE status='Closed'"));
?>

<!-- SweetAlert (SAME) -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- YOUR SAME CSS (NO CHANGE) -->
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

    .badge-success {
        background: #dc3545 !important;
    }

    .badge-warning {
        background: #ffc107 !important;
        color: #212529 !important;
    }

    .badge-danger {
        background: #6c757d !important;
    }

    .search-box {
        max-width: 250px;
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

    <!-- HEADER SAME -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0 text-danger">All Events</h4>
            <small class="text-muted">Manage and monitor all club events</small>
        </div>

        <a href="add_event.php" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
            Add Event
        </a>
    </div>

    <!-- STATS SAME -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Total Events</h6>
                <h5><?php echo $total; ?></h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Active</h6>
                <h5><?php echo $active; ?></h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Closed</h6>
                <h5><?php echo $closed; ?></h5>
            </div>
        </div>
    </div>

    <!-- TABLE SAME -->
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

                            // SAFE VALUES (ERROR FIX)
                            $id = isset($row['id']) ? $row['id'] : '';
                            $name = isset($row['name']) ? $row['name'] : 'No Name';
                            $date = isset($row['date']) ? $row['date'] : '';
                            $status = isset($row['status']) ? $row['status'] : 'Unknown';
                            $image = isset($row['image']) ? $row['image'] : 'default.png';
                            ?>

                            <tr>
                                <td><?php echo $i++; ?></td>

                                <td>
                                    <img src="../uploads/<?php echo $image; ?>" class="event-thumb"
                                        onerror="this.src='../uploads/default.png'">
                                    <?php echo $name; ?>
                                </td>

                                <td><?php echo $date; ?></td>

                                <td>
                                    <?php echo $status; ?>
                                </td>

                                <td class="text-center">
                                    <a href="view_events.php?id=<?php echo $id; ?>"
                                        class="btn btn-sm btn-outline-danger action-btn">View</a>
                                    <a href="edit_events.php?id=<?php echo $id; ?>"
                                        class="btn btn-sm btn-outline-warning action-btn">Edit</a>

                                    <button class="btn btn-sm btn-outline-secondary action-btn delete-btn"
                                        data-id="<?php echo $id; ?>">
                                        Delete
                                    </button>
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

<!-- DELETE SCRIPT SAME -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $('.delete-btn').click(function () {
        let id = $(this).data('id');
        let row = $(this).closest('tr');

        if (confirm("Delete this event?")) {
            $.post('delete_event.php', { id: id }, function () {
                row.remove();
            });
        }
    });
</script>

<?php include 'admin_footer.php'; ?>