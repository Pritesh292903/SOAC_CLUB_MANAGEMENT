<?php include 'F_header.php'; ?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Page Title -->
            <div class="mb-4">
                <h2 class="fw-bold text-danger">
                    <i class="bi bi-person-circle me-2"></i>Edit Profile
                </h2>
                <p class="text-muted mb-0">Update your profile information</p>
            </div>

            <div class="row">

                <!-- Left Side: Profile Image -->
                <div class="col-md-4 text-center mb-4">
                    <img id="profilePreview" src="assets/images/user.jpg"
                        class="img-fluid rounded-circle shadow"
                        style="width:180px; height:180px; object-fit:cover;">

                    <!-- Hidden File Input -->
                    <input type="file" id="profileImage" name="profileImage" accept="image/*" hidden>

                    <div class="mt-2">
                        <small id="photoError" class="text-danger d-none"></small>
                    </div>

                    <div class="mt-3">
                        <button type="button" id="changePhotoBtn" class="btn btn-outline-secondary btn-sm rounded-pill">
                            Change Photo
                        </button>
                    </div>
                </div>

                <!-- Right Side: Form -->
                <div class="col-md-8">

                    <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="fullname" class="form-control rounded-3"
                                placeholder="Enter your full name" required>
                            <div class="invalid-feedback">Please enter your full name.</div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control rounded-3"
                                placeholder="Enter your email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control rounded-3"
                                pattern="^[0-9]{10}$" maxlength="10"
                                placeholder="Enter 10 digit phone number" required>
                            <small class="text-muted">Enter 10 digit phone number</small>
                            <div class="invalid-feedback">Please enter a valid 10 digit phone number.</div>
                        </div>

                        <!-- Department -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Department</label>
                            <input type="text" name="department" class="form-control rounded-3"
                                placeholder="Enter department" required>
                            <div class="invalid-feedback">Department is required.</div>
                        </div>

                        <!-- Designation -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Designation</label>
                            <input type="text" name="designation" class="form-control rounded-3"
                                placeholder="Enter designation" required>
                            <div class="invalid-feedback">Designation is required.</div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Save Changes
                            </button>

                            <a href="profile.php" class="btn btn-secondary rounded-pill px-4">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<!-- Bootstrap Validation Script -->
<script>
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>

<!-- Change Photo Validation Script -->
<script>
  const changeBtn = document.getElementById("changePhotoBtn");
  const fileInput = document.getElementById("profileImage");
  const preview = document.getElementById("profilePreview");
  const errorText = document.getElementById("photoError");

  const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
  const maxSize = 2 * 1024 * 1024; // 2MB

  changeBtn.addEventListener("click", () => {
    fileInput.click();
  });

  fileInput.addEventListener("change", () => {
    const file = fileInput.files[0];
    errorText.classList.add("d-none");
    errorText.innerText = "";

    if (!file) return;

    if (!allowedTypes.includes(file.type)) {
      errorText.innerText = "Only JPG, PNG, or WEBP images allowed.";
      errorText.classList.remove("d-none");
      fileInput.value = "";
      return;
    }

    if (file.size > maxSize) {
      errorText.innerText = "Image must be less than 2MB.";
      errorText.classList.remove("d-none");
      fileInput.value = "";
      return;
    }

    const reader = new FileReader();
    reader.onload = e => preview.src = e.target.result;
    reader.readAsDataURL(file);
  });
</script>

<?php include 'F_footer.php'; ?>