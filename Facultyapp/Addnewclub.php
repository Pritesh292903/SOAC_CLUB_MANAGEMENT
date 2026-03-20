<?php include 'F_header.php'; ?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Page Title -->
            <div class="mb-4">
                <h2 class="fw-bold text-danger">
                    <i class="bi bi-plus-circle me-2"></i>Add New Club
                </h2>
                <p class="text-muted mb-0">Fill the details to create a new club</p>
            </div>

            <div class="row">

                <!-- Image Section -->
                <div class="col-md-4 text-center mb-4">
                    <img id="clubPreview" 
                         src="assets/images/logo.png"
                         class="img-fluid rounded-4 shadow-sm"
                         style="height:220px; object-fit:cover;">
                </div>

                <!-- Form Section -->
                <div class="col-md-8">

                    <form class="needs-validation" novalidate>

                        <!-- Club Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Club Name</label>
                            <input type="text"
                                   class="form-control rounded-3"
                                   placeholder="Enter club name"
                                   required>
                            <div class="invalid-feedback">
                                Please enter the club name.
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control rounded-3"
                                      rows="3"
                                      placeholder="Enter club description"
                                      required></textarea>
                            <div class="invalid-feedback">
                                Please enter a description for the club.
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select rounded-3" required>
                                <option value="">Select Category</option>
                                <option>Technology</option>
                                <option>Cultural</option>
                                <option>Sports</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a category.
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select rounded-3" required>
                                <option value="">Select Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the status.
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Save Club
                            </button>

                            <a href="manage_clube.php" class="btn btn-secondary rounded-pill px-4">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(() => {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {

            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                event.preventDefault(); // Stop normal submit

                Swal.fire({
                    title: "Club Created!",
                    text: "Your club has been added successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "manage_clube.php";
                    }
                });
            }

            form.classList.add('was-validated')

        }, false)
    })
})();
</script>

<?php include 'F_footer.php'; ?>