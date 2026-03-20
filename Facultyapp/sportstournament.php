<?php include 'F_header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="fw-bold text-danger mb-4 text-center">Event Details</h2>

            <!-- Event Card -->
            <div class="card shadow-sm border-0 rounded-4">

                <img src="assets/images/sports.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:300px; object-fit:cover;">

                <div class="card-body">
                    <h3 class="fw-bold text-danger">Sports Tournament</h3>
                    <p class="text-muted"><strong>Date:</strong> 20 Oct 2026</p>
                    <p class="text-muted">
                        Annual inter-department sports championship. Students compete in cricket, football, basketball, and other sports to showcase their athletic skills and teamwork.
                    </p>

                    <p class="text-muted"><strong>Location:</strong> RKU Sports Complex</p>
                    <p class="text-muted"><strong>Organizer:</strong> RKU Sports Committee</p>

                    <!-- Back Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="Manage_events.php" class="btn btn-secondary rounded-pill px-4">
                            Back to Events
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<?php include 'F_footer.php'; ?>