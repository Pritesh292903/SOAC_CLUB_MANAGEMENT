<?php include 'F_header.php'; ?>

<style>
  .input-error {
    border: 1.5px solid #dc3545 !important;
    padding-right: 40px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%23dc3545' viewBox='0 0 16 16'%3E%3Cpath d='M7.001 4.002a.905.905 0 1 1 1.808 0l-.35 4.5a.552.552 0 0 1-1.108 0l-.35-4.5z'/%3E%3Cpath d='M8 1.002a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM8 13.002A6 6 0 1 1 8 1a6 6 0 0 1 0 12z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 18px;
  }
</style>

<div class="container my-5">
  <div class="card shadow border-0 rounded-4">
    <div class="card-body p-4">

      <div class="mb-4">
        <h2 class="fw-bold text-danger">
          <i class="bi bi-pencil-square me-2"></i>Edit Club
        </h2>
        <p class="text-muted mb-0">Update club details below</p>
      </div>

      <div class="row">
        <div class="col-md-4 text-center mb-4">
          <div class="mt-3">
            <!-- Image placeholder -->
          </div>
        </div>

        <div class="col-md-8">
          <!-- 🔥 action manage_clube.php -->
          <form id="editClubForm" method="POST" action="manage_clube.php" novalidate>

            <div class="mb-3">
              <label class="form-label fw-semibold">Club Name</label>
              <input type="text" name="club_name" id="clubName" class="form-control rounded-3">
              <small class="text-danger d-none" id="clubNameError">Please enter club name.</small>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" id="description" class="form-control rounded-3" rows="3"></textarea>
              <small class="text-danger d-none" id="descriptionError">Please enter description.</small>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Category</label>
              <select name="category" id="category" class="form-select rounded-3">
                <option value="">-- Select Category --</option>
                <option value="Technology">Technology</option>
                <option value="Cultural">Cultural</option>
                <option value="Sports">Sports</option>
              </select>
              <small class="text-danger d-none" id="categoryError">Please select category.</small>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" id="status" class="form-select rounded-3">
                <option value="">-- Select Status --</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
              <small class="text-danger d-none" id="statusError">Please select status.</small>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Club Members</label>
              <input type="number" name="members" id="clubMembers" class="form-control rounded-3" min="1">
              <small class="text-danger d-none" id="clubMembersError">Please enter valid number of members.</small>
            </div>

            <div class="d-flex gap-3">
              <button type="submit" class="btn btn-danger rounded-pill px-4">
                Save Changes
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
  function showError(input, errorId) {
    $(input).addClass("input-error");
    $(errorId).removeClass("d-none");
  }

  function clearError(input, errorId) {
    $(input).removeClass("input-error");
    $(errorId).addClass("d-none");
  }

  $("#editClubForm").on("submit", function(e) {
    let valid = true;

    if ($("#clubName").val().trim() === "") {
      showError("#clubName", "#clubNameError");
      valid = false;
    }

    if ($("#description").val().trim() === "") {
      showError("#description", "#descriptionError");
      valid = false;
    }

    if ($("#category").val() === "") {
      showError("#category", "#categoryError");
      valid = false;
    }

    if ($("#status").val() === "") {
      showError("#status", "#statusError");
      valid = false;
    }

    let members = $("#clubMembers").val().trim();
    if (members === "" || isNaN(members) || members <= 0) {
      showError("#clubMembers", "#clubMembersError");
      valid = false;
    }

    if (!valid) {
      e.preventDefault(); // ❌ Stop submit if error
    }
  });

  $("#clubName, #description").on("input", function() {
    if ($(this).val().trim() !== "") {
      clearError(this, "#" + this.id + "Error");
    }
  });

  $("#category, #status").on("change", function() {
    if ($(this).val() !== "") {
      clearError(this, "#" + this.id + "Error");
    }
  });

  $("#clubMembers").on("input", function() {
    let members = $(this).val().trim();
    if (members !== "" && !isNaN(members) && members > 0) {
      clearError(this, "#clubMembersError");
    }
  });
</script>

<?php include 'F_footer.php'; ?>  
