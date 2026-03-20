<?php include 'admin_header.php'; ?>

<h4 class="fw-bold mb-4">Events</h4>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <h5 class="text-danger">Event List</h5>
            <button class="btn btn-danger btn-sm">
                <i class="bi bi-plus-circle"></i> Add Event
            </button>
        </div>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Club</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Annual Sports Day</td>
                    <td>20 Mar 2026</td>
                    <td>Sports Club</td>
                    <td><span class="badge bg-success">Active</span></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<?php include 'admin_footer.php'; ?>
