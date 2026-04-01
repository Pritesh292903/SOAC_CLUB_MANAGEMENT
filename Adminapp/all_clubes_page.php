<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ===== Smooth Page Animation ===== */
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

    /* ===== Header Design ===== */
    .page-header {
        background: #fff;
        border-radius: 15px;
        padding: 20px 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .page-header h4 {
        color: #dc3545;
    }

    /* ===== Card Design ===== */
    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        background: #fff;
    }

    .custom-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    /* ===== Table Hover ===== */
    .table tbody tr {
        transition: 0.3s;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    /* ===== Action Buttons ===== */
    .action-btn {
        border-radius: 50px;
        padding: 5px 10px;
        transition: 0.3s;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    /* ===== Badges ===== */
    .badge-success {
        background-color: #dc3545 !important;
        /* Active red theme */
    }

    .badge-danger {
        background-color: #6c757d !important;
        /* Inactive grey */
    }

    /* ===== Search Box ===== */
    .search-box {
        max-width: 300px;
    }

    /* ===== Club Images ===== */
    .club-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
        vertical-align: middle;
    }

    /* ===== Responsive ===== */
    @media (max-width:767px) {

        .page-header,
        .custom-card {
            text-align: center;
        }
    }
</style>

<div class="content">

    <!-- Header Section -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0 text-danger">All Clubs</h4>
            <small class="text-muted">Manage all student clubs here</small>
        </div>

        <a href="add_club.php" class="btn btn-danger action-btn">
            <i class="bi bi-plus-circle me-2"></i>Add Club
        </a>
    </div>

    <!-- Main Card -->
    <div class="card custom-card p-4">

        <!-- Top Controls -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="fw-semibold mb-0 text-danger">Club List</h5>
            <input type="text" class="form-control search-box" placeholder="Search club...">
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Club Name</th>
                        <th>President</th>
                        <th>Total Members</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="assets/images/c1.jpg" alt="Sports Club" class="club-thumb">
                            Sports Club
                        </td>
                        <td>Rahul Mehta</td>
                        <td>120</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td class="text-center">
                            <a href="view_club.php" class="btn btn-sm btn-outline-danger action-btn">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit_club.php" class="btn btn-sm btn-outline-warning action-btn">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-secondary action-btn delete-btn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function () {

        // Delete Button Confirmation
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let row = $(this).closest('tr'); // Get the table row

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
                if (result.isConfirmed) {
                    // Remove the row visually
                    row.remove();

                    // Show success message
                    Swal.fire(
                        'Deleted!',
                        'The club has been deleted.',
                        'success'
                    );
                }
            });
        });

    });
</script>

<?php include 'admin_footer.php'; ?>