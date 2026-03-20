<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ===== Smooth Page Animation ===== */
.content{
    animation: fadeIn 0.6s ease-in-out;
}
@keyframes fadeIn{
    from{opacity:0; transform:translateY(15px);}
    to{opacity:1; transform:translateY(0);}
}

/* ===== Mini Stat Cards ===== */
.stat-mini{
    border:none;
    border-radius:12px;
    padding:20px;
    text-align:center;
    transition:0.3s;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    background:#fff;
}
.stat-mini:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}
.stat-mini h6{
    color: #6c757d;
}

/* ===== Main Table Card ===== */
.custom-card{
    border:none;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    transition:0.3s;
    background:#fff;
}
.custom-card:hover{
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}

/* ===== Table Hover ===== */
.table tbody tr{
    transition:0.3s;
}
.table tbody tr:hover{
    background:#f8f9fa;
}

/* ===== Buttons ===== */
.action-btn{
    border-radius:50px;
    padding:5px 10px;
    transition:0.3s;
}
.action-btn:hover{
    transform:translateY(-2px);
}

/* ===== Badges ===== */
.badge-success{
    background-color:#dc3545 !important; /* red theme for active */
}
.badge-warning{
    background-color:#ffc107 !important;
    color:#212529 !important;
}
.badge-danger{
    background-color:#6c757d !important; /* grey for closed */
}

/* ===== Search Box ===== */
.search-box{
    max-width:250px;
}

/* ===== Event Images ===== */
.event-thumb{
    width:50px;
    height:50px;
    object-fit:cover;
    border-radius:5px;
    margin-right:10px;
    vertical-align: middle;
}

/* ===== Responsive Adjustments ===== */
@media (max-width:767px){
    .stat-mini{
        text-align:center;
    }
}
</style>

<div class="content">

   <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0 text-danger">All Events</h4>
            <small class="text-muted">Manage and monitor all club events</small>
        </div>

        <!-- ADD EVENT BUTTON -->
        <a href="add_event.php" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Add Event
        </a>
    </div>

    <!-- Mini Statistics Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Total Events</h6>
                <h5 class="fw-bold mb-0">28</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Active</h6>
                <h5 class="fw-bold mb-0">15</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini">
                <h6>Closed</h6>
                <h5 class="fw-bold mb-0">13</h5>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card custom-card p-4">

        <!-- Top Controls -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="fw-semibold mb-0 text-danger">Event List</h5>

            <div class="d-flex gap-2">
                <select class="form-select search-box">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Upcoming</option>
                    <option>Closed</option>
                </select>
                <input type="text" class="form-control search-box" placeholder="Search event...">
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Club</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="assets/images/e1.webp" alt="Cricket Tournament" class="event-thumb">
                            Cricket Tournament
                        </td>
                        <td>Sports Club</td>
                        <td>25 Feb 2026</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td class="text-center">
                            <a href="view_events.php" class="btn btn-sm btn-outline-danger action-btn">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit_events.php" class="btn btn-sm btn-outline-warning action-btn">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-secondary action-btn delete-btn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            <img src="assets/images/e2.jpg" alt="Music Fest" class="event-thumb">
                            Music Fest
                        </td>
                        <td>Music Club</td>
                        <td>10 Mar 2026</td>
                        <td><span class="badge badge-warning">Upcoming</span></td>
                        <td class="text-center">
                            <a href="view_events.php" class="btn btn-sm btn-outline-danger action-btn">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit_events.php" class="btn btn-sm btn-outline-warning action-btn">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-secondary action-btn delete-btn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>
                            <img src="assets/images/e3.jpg" alt="Tech Workshop" class="event-thumb">
                            Tech Workshop
                        </td>
                        <td>Tech Club</td>
                        <td>05 Apr 2026</td>
                        <td><span class="badge badge-danger">Closed</span></td>
                        <td class="text-center">
                            <a href="view_events.php" class="btn btn-sm btn-outline-danger action-btn">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit_events.php" class="btn btn-sm btn-outline-warning action-btn">
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function(){
    // Delete Button Confirmation
    $('.delete-btn').click(function(e){
        e.preventDefault();
        let row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "This event will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                row.remove(); // Remove row visually
                Swal.fire(
                    'Deleted!',
                    'The event has been deleted.',
                    'success'
                );
            }
        });
    });
});
</script>

<?php include 'admin_footer.php'; ?>