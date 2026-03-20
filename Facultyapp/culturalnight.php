<?php include 'F_header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="fw-bold text-danger mb-4 text-center">Event Details</h2>

            <!-- Event Card -->
            <div class="card shadow-sm border-0 rounded-4">

                <img src="assets/images/cultural.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:300px; object-fit:cover;">

                <div class="card-body">
                    <h3 class="fw-bold text-danger">Cultural Night</h3>
                    <p class="text-muted"><strong>Date:</strong> 05 Sep 2026</p>
                    <p class="text-muted">
                        Dance, Music & Drama celebration program. A night full of cultural performances organized by the RKU cultural club to showcase talent across departments.
                    </p>

                    <p class="text-muted"><strong>Location:</strong> RKU Campus, Main Auditorium</p>
                    <p class="text-muted"><strong>Organizer:</strong> RKU Cultural Club</p>

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