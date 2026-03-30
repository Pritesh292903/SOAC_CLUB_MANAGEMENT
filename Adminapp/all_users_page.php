<?php include 'admin_header.php'; ?>

<?php
include "../database.php";

// SAME QUERY
$adminFaculty = mysqli_query($con, "SELECT * FROM User WHERE role='admin' OR role='faculty'");
$students = mysqli_query($con, "SELECT * FROM User WHERE role='user'");
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* YOUR SAME CSS */
    .content {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: #fff;
        padding: 20px 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .page-header h4 {
        color: #dc3545;
    }

    .custom-card {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .search-box {
        max-width: 300px;
    }

    .user-thumb {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }

    .action-btn {
        border-radius: 50px;
        padding: 5px 10px;
    }

    .badge-admin {
        background: #dc3545;
    }

    .badge-faculty {
        background: #ff6b6b;
    }

    .badge-active {
        background: #28a745;
    }

    .badge-pending {
        background: #ffc107;
        color: #000;
    }
</style>

<div class="content">

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">All Users</h4>
            <small class="text-muted">Manage system users here</small>
        </div>

        <a href="faculty_register.php" class="btn btn-danger">
            <i class="bi bi-person-plus-fill"></i> Faculty Register
        </a>
    </div>

    <!-- ADMIN & FACULTY -->
    <div class="custom-card">


        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-danger mb-0">Admin & Faculty Users</h5>
            <input type="text" id="facultySearch" class="form-control search-box" placeholder="Search student...">
        </div>
        <div class="table-responsive">
            <table class="table align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($adminFaculty)) {

                        // 🔥 ONLY FIX (IMAGE PATH)
                        $img = (!empty($row['clubimage']) && file_exists("../uploads/" . $row['clubimage']))
                            ? "../uploads/" . $row['clubimage']
                            : "assets/images/p2.webp";
                        ?>

                        <tr>
                            <td><?php echo $i++; ?></td>

                            <td>
                                <img src="<?php echo $img; ?>" class="user-thumb me-2">
                                <?php echo $row['fullname']; ?>
                            </td>

                            <td><?php echo $row['email']; ?></td>

                            <td>
                                <span class="badge badge-admin"><?php echo $row['role']; ?></span>
                            </td>

                            <td><span class="badge badge-active">Active</span></td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-secondary action-btn delete-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- STUDENTS -->
    <div class="custom-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-danger mb-0">All Students List</h5>
            <input type="text" id="studentSearch" class="form-control search-box" placeholder="Search student...">
        </div>

        <div class="table-responsive">
            <table class="table align-middle" id="studentTable">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Enrollment</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($students)) {

                        // 🔥 ONLY FIX (IMAGE PATH)
                        $img = (!empty($row['clubimage']) && file_exists("../uploads/" . $row['clubimage']))
                            ? "../uploads/" . $row['clubimage']
                            : "assets/images/p2.webp";
                        ?>

                        <tr>
                            <td><?php echo $i++; ?></td>

                            <td>
                                <img src="<?php echo $img; ?>" class="user-thumb">
                            </td>

                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['enrollment']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['mobile']; ?></td>
                            <td><?php echo $row['department']; ?></td>

                            <td><span class="badge badge-active">Approved</span></td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-secondary action-btn delete-btn">
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

<script>
    // DELETE
    $('.delete-btn').click(function (e) {
        e.preventDefault();
        let row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                row.remove();
                Swal.fire('Deleted!', '', 'success');
            }
        });
    });

    // SEARCH
    $('#studentSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $("#studentTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>

<?php include 'admin_footer.php'; ?>