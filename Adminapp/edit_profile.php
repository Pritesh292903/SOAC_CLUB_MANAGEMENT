<?php require 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content" style="min-height:85vh; display:flex; justify-content:center; align-items:center;">
    <div class="card shadow-lg rounded-4 p-4" style="max-width:450px; width:100%;">
        <h4 class="fw-bold text-center mb-3">Edit Profile</h4>

        <form id="editProfileForm" enctype="multipart/form-data">
            <div class="mb-3 text-center">
                <img src="assets/images/profile-placeholder.png" alt="Profile Photo" id="profilePreview"
                    style="width:120px; height:120px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
                <input type="file" class="form-control" name="profilePhoto" id="profilePhoto" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullName" id="fullName" value="Bharadwa Pritesh">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="pbharadwa789@gmail.com">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="+91 7405437207">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-check-circle me-2"></i> Save
                </button>
                <a href="admin_profile.php" class="btn btn-outline-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<?php include 'admin_footer.php'; ?>