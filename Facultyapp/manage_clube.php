<?php include 'F_header.php'; ?>

<div class="container my-5">

    <!-- Page Title + Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger">Manage Clubs</h2>
            <p class="text-muted mb-0">Add, Edit or Delete Clubs</p>
        </div>

        <!-- Add New Club Button with Link -->
        <a href="Addnewclub.php"
            class="btn btn-danger rounded-pill px-4 fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Add New Club
        </a>
    </div>


    <!-- Clubs Row -->
    <div class="row g-4">

        <!-- Club 1 -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <img src="assets/images/codingclub.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:200px; object-fit:cover;">

                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-danger">
                        Coding Club
                    </h5>
                    <p class="text-muted">
                        Programming, Hackathons & Tech Events
                    </p>

                    <a href="editclube.php"
                        class="btn btn-warning btn-sm rounded-pill px-3">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>

                    <!-- Delete Button (Still Button) -->
                    <button class="btn btn-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Club 2 -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <img src="assets/images/cultural.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:200px; object-fit:cover;">

                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-danger">
                        Cultural Club
                    </h5>
                    <p class="text-muted">
                        Dance, Music & Drama Activities
                    </p>

                    <a href="editclube.php"
                        class="btn btn-warning btn-sm rounded-pill px-3">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>

                    <!-- Delete Button (Still Button) -->
                    <button class="btn btn-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Club 3 -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <img src="assets/images/sports.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:200px; object-fit:cover;">

                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-danger">
                        Sports Club
                    </h5>
                    <p class="text-muted">
                        Indoor & Outdoor Sports Activities
                    </p>

                    <div class="d-flex justify-content-center gap-2">

                        <!-- Edit Button as Link -->
                        <a href="editclube.php"
                            class="btn btn-warning btn-sm rounded-pill px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>

                        <!-- Delete Button (Still Button) -->
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