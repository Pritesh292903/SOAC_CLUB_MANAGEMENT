<?php include 'header.php'; ?>

<div class="container my-5">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-danger">
            <i class="bi bi-bell-fill me-2"></i>Notifications
        </h2>
        <span class="badge bg-danger">3 New</span>
    </div>

    <div class="row justify-content-center">

        <!-- ================= STUDENT ANNOUNCEMENTS ================= -->
        <div class="col-md-8 col-lg-6 mb-4">
            <div class="card shadow border-0 rounded-4 h-100">
                <div class="card-body">

                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-mortarboard-fill me-2"></i>Student Announcements
                    </h5>

                    <div class="list-group list-group-flush">

                        <div class="list-group-item">
                            <h6 class="mb-1">📌 Hackathon Registration Open</h6>
                            <p class="mb-1 text-muted">
                                Computer Engineering department is organizing a 24-hour coding hackathon.
                                Last date: <strong>15 March 2026</strong>
                            </p>
                            <small class="text-secondary">2 hours ago</small>
                        </div>

                        <div class="list-group-item">
                            <h6 class="mb-1">🧠 Problem Solving Workshop</h6>
                            <p class="mb-1 text-muted">
                                Special workshop on Data Structures & Algorithms for improving coding skills.
                            </p>
                            <small class="text-secondary">Yesterday</small>
                        </div>

                        <div class="list-group-item">
                            <h6 class="mb-1">📊 Internal Exam Schedule Released</h6>
                            <p class="mb-1 text-muted">
                                Check your student portal for updated internal exam timetable.
                            </p>
                            <small class="text-secondary">2 days ago</small>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-danger rounded-pill px-4">
            Back to Home
        </a>
    </div>

</div>

<?php include 'footer.php'; ?>






 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
        <script src="js/validation.js"></script>
