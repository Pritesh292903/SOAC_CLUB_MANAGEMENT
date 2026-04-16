<?php include 'admin_header.php'; ?>
<?php include "../database.php"; ?>

<?php
$admins = mysqli_query($con, "SELECT * FROM User WHERE role='admin'");
$faculties = mysqli_query($con, "SELECT * FROM Faculty_register");
$students = mysqli_query($con, "SELECT * FROM User WHERE role='user'");
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content-wrapper {
    margin-left: 250px;
    padding: 25px;
    margin-top: 60px;
    background: #fff5f5;
}

/* Cards */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(255,0,0,0.08);
}

.card-header {
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    color: white;
    border-radius: 12px 12px 0 0;
}

/* Table */
.table th {
    font-weight: 600;
    color: #cc0000;
}

.table tbody tr:hover {
    background: #ffe5e5;
    transition: 0.2s;
}

.table {
    border-radius: 10px;
    overflow: hidden;
}

/* User image */
.user-thumb {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ff4d4d;
}

/* Buttons */
.btn {
    border-radius: 8px;
    transition: 0.2s;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-primary {
    background: #ff4d4d;
    border: none;
}

.btn-primary:hover {
    background: #cc0000;
}

.btn-danger {
    background: #cc0000;
    border: none;
}

/* Badges */
.badge {
    padding: 6px 10px;
    font-size: 12px;
}

.badge.bg-primary {
    background: #ff4d4d !important;
}

.badge.bg-info {
    background: #ff8080 !important;
}

.badge.bg-success {
    background: #cc0000 !important;
}
</style>

<div class="content-wrapper">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-danger">👥 User Management</h4>

    <a href="faculty_register.php" class="btn btn-primary">
        + Faculty Register
    </a>
</div>

<!-- ADMIN + FACULTY -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            Admins & Faculty (<?= mysqli_num_rows($admins) + mysqli_num_rows($faculties) ?>)
        </h5>
    </div>

    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php $i = 1; ?>

            <!-- ADMIN -->
            <?php while ($row = mysqli_fetch_assoc($admins)) {
                $img = (!empty($row['clubimage']) && file_exists("../uploads/" . $row['clubimage']))
                    ? "../uploads/" . $row['clubimage'] : "assets/images/p2.webp";
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="<?= $img ?>" class="user-thumb me-2">
                        <div><?= htmlspecialchars($row['fullname']) ?></div>
                    </div>
                </td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><span class="badge bg-primary">Admin</span></td>
                <td><span class="badge bg-success">Active</span></td>
                <td class="text-end">
                    <a href="update_user_form.php?id=<?= $row['id'] ?>&type=admin"
                       class="btn btn-sm btn-primary">Edit</a>
                    <button class="delete-btn btn btn-sm btn-danger"
                        data-id="<?= $row['id'] ?>" data-type="admin">Delete</button>
                </td>
            </tr>
            <?php } ?>

            <!-- FACULTY -->
            <?php while ($row = mysqli_fetch_assoc($faculties)) {
                $img = (!empty($row['image']) && file_exists("../uploads/" . $row['image']))
                    ? "../uploads/" . $row['image'] : "assets/images/p2.webp";
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="<?= $img ?>" class="user-thumb me-2">
                        <div><?= htmlspecialchars($row['name']) ?></div>
                    </div>
                </td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><span class="badge bg-info">Faculty</span></td>
                <td><span class="badge bg-success">Active</span></td>
                <td class="text-end">
                    <a href="update_user_form.php?id=<?= $row['id'] ?>&type=faculty"
                       class="btn btn-sm btn-primary">Edit</a>
                    <button class="delete-btn btn btn-sm btn-danger"
                        data-id="<?= $row['id'] ?>" data-type="faculty">Delete</button>
                </td>
            </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<!-- STUDENTS -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Students (<?= mysqli_num_rows($students) ?>)</h5>
    </div>

    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Department</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php $i = 1; mysqli_data_seek($students, 0); ?>

            <?php while ($row = mysqli_fetch_assoc($students)) {
                $img = (!empty($row['clubimage']) && file_exists("../uploads/" . $row['clubimage']))
                    ? "../uploads/" . $row['clubimage'] : "assets/images/p2.webp";
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="<?= $img ?>" class="user-thumb me-2">
                        <div><?= htmlspecialchars($row['fullname']) ?></div>
                    </div>
                </td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['mobile']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td class="text-end">
                    <a href="update_user_form.php?id=<?= $row['id'] ?>&type=student"
                       class="btn btn-sm btn-primary">Edit</a>
                    <button class="delete-btn btn btn-sm btn-danger"
                        data-id="<?= $row['id'] ?>" data-type="student">Delete</button>
                </td>
            </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('.delete-btn').click(function () {
    let row = $(this).closest('tr');
    let id = $(this).data('id');
    let type = $(this).data('type');

    Swal.fire({
        title: 'Delete User?',
        text: "This action cannot be undone",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#cc0000',
        confirmButtonText: 'Yes Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('delete_user.php', { id, type }, function (res) {
                if (res.trim() === 'success') {
                    row.fadeOut(300);
                    Swal.fire('Deleted!', '', 'success');
                } else {
                    Swal.fire('Error!', '', 'error');
                }
            });
        }
    });
});
</script>

<?php include 'admin_footer.php'; ?>