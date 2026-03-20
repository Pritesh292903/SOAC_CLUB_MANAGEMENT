<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ===== Page Animation ===== */
.content{
    animation: fadeIn 0.6s ease-in-out;
}
@keyframes fadeIn{
    from{opacity:0; transform:translateY(15px);}
    to{opacity:1; transform:translateY(0);}
}

/* ===== Card Styling ===== */
.card.custom-card{
    border:none;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    transition:0.3s;
    background:#fff;
}
.card.custom-card:hover{
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}

/* ===== Form Styling ===== */
.form-label{
    font-weight:500;
    font-size:0.9rem;
}
.btn-effect{
    border-radius:50px;
    transition:0.3s;
}
.btn-effect:hover{
    transform:translateY(-2px);
}

/* ===== Event Image ===== */
.event-img{
    width:100%;
    max-height:250px;
    object-fit:cover;
    border-radius:12px;
    margin-bottom:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
    transition: all 0.3s ease-in-out;
}

/* ===== Error Styling ===== */
.error{
    color:red;
    font-size:0.85rem;
    margin-top:5px;
}
</style>

<div class="content">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">Add New Event</h4>
        <a href="all_events_page.php" class="btn btn-outline-danger btn-effect">
            <i class="bi bi-arrow-left me-2"></i>Back to Events
        </a>
    </div>

    <!-- Add Event Card -->
    <div class="card custom-card p-4">
        <h5 class="fw-bold mb-3">Event Information</h5>

        <form id="addEventForm">

        <div class="row g-3">

            <!-- Image Preview -->
            <div class="col-12 text-center">
                <img src="https://via.placeholder.com/800x250?text=Event+Preview" 
                     class="event-img" id="eventImagePreview">
                <input type="file" class="form-control mt-2" id="eventImage" name="eventImage" accept="image/*">
            </div>

            <!-- Event Name -->
            <div class="col-md-6">
                <label class="form-label">Event Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="eventName" name="eventName">
            </div>

            <!-- Date -->
            <div class="col-md-6">
                <label class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="eventDate" name="eventDate">
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="eventStatus" name="eventStatus">
                    <option value="">Select Status</option>
                    <option>Active</option>
                    <option>Upcoming</option>
                    <option>Closed</option>
                </select>
            </div>

            <!-- Description -->
            <div class="col-12">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="4" id="eventDescription" name="eventDescription"></textarea>
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-danger btn-effect">
                <i class="bi bi-save me-2"></i>Create Event
            </button>
            <a href="all_events_page.php" class="btn btn-outline-danger btn-effect">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </a>
        </div>

        </form>

    </div>

</div>

<!-- jQuery & Validation -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>



<?php include 'admin_footer.php'; ?>