<?php include 'F_header.php'; ?>

<div class="container my-5">

    <!-- Page Title + Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger">Manage Events</h2>
            <p class="text-muted mb-0">Add, Edit or Delete Events</p>
        </div>

        <a href="Addevent.php"
            class="btn btn-danger rounded-pill px-4 fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Add Event
        </a>

    </div>

    <!-- Events Row -->
    <div class="row g-4">

        <!-- Event 1 -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 position-relative">

                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
                    15 Aug
                </span>
                <img src="assets/images/hackathon.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:200px; object-fit:cover;">

                <div class="card-body text-center">
                    <h5 class="fw-bold text-danger">
                        Hackathon 2026
                    </h5>

                    <p class="text-muted">
                        Coding competition organized by Coding Club.
                    </p>

                        <div class="d-flex justify-content-center gap-2 mt-3">

                        <a href="Viewhackathon.php" class="btn btn-success btn-sm rounded-pill px-3">
                            <i class="bi bi-eye me-1"></i> View
                        </a>

                        <a href="Edit_event.php" class="btn btn-warning btn-sm rounded-pill px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>

                        <button class="btn btn-danger btn-sm rounded-pill px-3">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </div>
                </div>

            </div>
        </div>

  

    </div>

</div>

<?php include 'F_footer.php'; ?>