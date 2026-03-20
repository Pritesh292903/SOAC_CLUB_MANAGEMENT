<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ===== Smooth Page Animation ===== */
    .content {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Card Styling ===== */
    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        background: #fff;
    }

    .custom-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    /* ===== Header Styling ===== */
    .page-header {
        background: #fff;
        border-radius: 15px;
        padding: 20px 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .page-header h4 {
        color: #dc3545;
    }

    /* ===== Form Styling ===== */
    .form-label {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .club-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        margin-bottom: 15px;
        transition: all 0.3s ease-in-out;
    }

    /* ===== Buttons ===== */
    .btn-effect {
        border-radius: 50px;
        transition: 0.3s;
    }

    .btn-effect:hover {
        transform: translateY(-2px);
    }

    /* ===== Validation Styles ===== */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
    }
</style>

<div class="content">

    <!-- Header Section -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0 text-danger">Edit Club</h4>
            <small class="text-muted">Update club details and members information</small>
        </div>
        <a href="all_clubes_page.php" class="btn btn-outline-danger btn-effect">
            <i class="bi bi-arrow-left me-2"></i>Back to Clubs
        </a>
    </div>

    <!-- Edit Club Card -->
    <div class="card custom-card p-4 mb-4">
        <form enctype="multipart/form-data" id="editClubForm">
            <div class="text-center">
                <img src="assets/images/c1.jpg" alt="Sports Club" class="club-img" id="clubImagePreview">
                <input type="file" class="form-control mt-2" id="clubImage" name="clubImage" accept="image/*">
                <small class="text-muted">JPG, PNG or GIF (Max 5MB)</small>
                <div class="invalid-feedback">Please select a valid image file</div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Club Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clubName" id="clubName" value="Sports Club">
                    <div class="invalid-feedback">Please enter club name</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">President <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="president" id="president" value="Rahul Mehta">
                    <div class="invalid-feedback">Please enter president name</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Total Members <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="totalMembers" id="totalMembers" value="120">
                    <div class="invalid-feedback">Please enter total members</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" id="status">
                        <option value="">Select status</option>
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <div class="invalid-feedback">Please select status</div>
                </div>

                <div class="col-12">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="4" name="description"
                        id="description">This is the Sports Club. We organize tournaments, fitness sessions, and other sports activities for students.</textarea>
                    <div class="invalid-feedback">Please enter description</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex gap-2 justify-content-center">
                <button type="submit" class="btn btn-danger btn-effect">
                    <i class="bi bi-save me-2"></i>Save Changes
                </button>
                <a href="all_clubes_page.php" class="btn btn-outline-danger btn-effect">
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