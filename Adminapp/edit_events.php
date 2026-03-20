<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ===== Page Animation ===== */
.content{ animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn{ from{opacity:0; transform:translateY(15px);} to{opacity:1; transform:translateY(0);} }

/* ===== Card Styling ===== */
.card.custom-card{ border:none; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05); transition:0.3s; background:#fff; }
.card.custom-card:hover{ box-shadow:0 15px 35px rgba(0,0,0,0.08); }

/* ===== Form Styling ===== */
.form-label{ font-weight:500; font-size:0.9rem; }
.btn-effect{ border-radius:50px; transition:0.3s; }
.btn-effect:hover{ transform:translateY(-2px); }

/* ===== Badges ===== */
.badge-status{ border-radius:12px; padding:5px 10px; font-size:0.85rem; }
.badge-active{ background-color:#dc3545; color:#fff; }
.badge-upcoming{ background-color:#ffc107; color:#212529; }
.badge-closed{ background-color:#6c757d; color:#fff; }

/* ===== Event Image Styling ===== */
.event-img{ width:100%; max-height:250px; object-fit:cover; border-radius:12px; margin-bottom:15px; box-shadow:0 8px 25px rgba(0,0,0,0.05); transition: all 0.3s ease-in-out; }

/* ===== Error Message Styling ===== */
.error{ color:red; font-size:0.85rem; }

</style>

<div class="content">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">View / Edit Event</h4>
        <a href="all_events_page.php" class="btn btn-outline-danger btn-effect">
            <i class="bi bi-arrow-left me-2"></i>Back to Events
        </a>
    </div>

    <!-- Event Details Card -->
    <div class="card custom-card p-4 mb-4">
        <h5 class="fw-bold mb-3">Event Details</h5>
        <form id="editEventsForm">
        <div class="row g-3">
            <!-- Event Image -->
            <div class="col-12 text-center">
                <img src="assets/images/e1.webp" alt="Event Image" class="event-img" id="eventImagePreview">
                <input type="file" class="form-control mt-2" id="eventImage" name="eventImage" accept="image/*">
            </div>

            <div class="col-md-6">
                <label class="form-label">Event Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="eventName" name="eventName" value="Cricket Tournament">
            </div>
            <div class="col-md-6">
                <label class="form-label">Club <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="eventClub" name="eventClub" value="Sports Club">
            </div>
            <div class="col-md-6">
                <label class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" value="2026-02-25">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="eventStatus" name="eventStatus">
                    <option value="">Select Status</option>
                    <option selected>Active</option>
                    <option>Upcoming</option>
                    <option>Closed</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="4">This is a cricket tournament organized by the Sports Club. All students are welcome to participate.</textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-danger btn-effect">
                <i class="bi bi-save me-2"></i>Save Changes
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