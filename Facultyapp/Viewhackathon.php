<?php include 'F_header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="fw-bold text-danger mb-4 text-center">Event Details</h2>

            <!-- Event Card -->
            <div class="card shadow-sm border-0 rounded-4">

                <img src="assets/images/hackathon.jpg"
                    class="card-img-top rounded-top-4"
                    style="height:300px; object-fit:cover;">

                <div class="card-body">
                    <h3 class="fw-bold text-danger">Hackathon 2026</h3>
                    <p class="text-muted"><strong>Date:</strong> 15 Aug 2026</p>
                    <p class="text-muted">
                        Coding competition organized by Coding Club. Participants will solve challenging programming problems within a limited time and showcase their coding skills.
                    </p>

                    <p class="text-muted"><strong>Location:</strong> RKU Campus, Auditorium</p>
                    <p class="text-muted"><strong>Organizer:</strong> Coding Club</p>

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