<?php include 'F_header.php'; ?>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.input-error { border:1.5px solid #dc3545 !important; }
.event-img{
  width:100%;
  max-height:220px;
  object-fit:cover;
  border-radius:12px;
  margin-bottom:15px;
  box-shadow:0 8px 25px rgba(0,0,0,0.05);
}
</style>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="card shadow border-0 rounded-4 p-4">

        <h3 class="fw-bold text-danger mb-4 text-center">
          Edit Event
        </h3>

        <form id="editEventForm">

          <!-- Image Preview -->
          <div class="text-center mb-3">
            <img src="assets/images/e1.webp"
                 id="eventImagePreview"
                 class="event-img">
            <input type="file"
                   class="form-control mt-2"
                   id="eventImage"
                   name="eventImage"
                   accept="image/*">
            <small class="text-muted">JPG, PNG or GIF (Max 5MB)</small>
          </div>

          <!-- Event Name -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Event Name *</label>
            <input type="text"
                   class="form-control"
                   name="eventName"
                   id="eventName"
                   value="Hackathon 2026">
          </div>

          <!-- Club -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Club *</label>
            <input type="text"
                   class="form-control"
                   name="eventClub"
                   id="eventClub"
                   value="Coding Club">
          </div>

          <!-- Date -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Event Date *</label>
            <input type="date"
                   class="form-control"
                   name="eventDate"
                   id="eventDate"
                   value="2026-08-15">
          </div>

          <!-- Status -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Status *</label>
            <select class="form-select"
                    name="eventStatus"
                    id="eventStatus">
              <option value="">Select Status</option>
              <option selected>Active</option>
              <option>Upcoming</option>
              <option>Closed</option>
            </select>
          </div>

          <!-- Description -->
          <div class="mb-4">
            <label class="form-label fw-semibold">Description *</label>
            <textarea class="form-control"
                      name="eventDescription"
                      id="eventDescription"
                      rows="4">Coding competition organized by Coding Club.</textarea>
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-between">
            <a href="Manage_events.php"
               class="btn btn-secondary rounded-pill px-4">
              Cancel
            </a>

            <button type="submit"
                    class="btn btn-danger rounded-pill px-4">
              Save Changes
            </button>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function(){

  // ===== Image Preview =====
  $('#eventImage').change(function(){
      const file = this.files[0];
      if(file){
          const reader = new FileReader();
          reader.onload = function(e){
              $('#eventImagePreview').attr('src', e.target.result);
          }
          reader.readAsDataURL(file);
      }
  });

  // ===== Custom File Validation =====
  $.validator.addMethod("fileSize", function(value, element){
      if(element.files.length === 0) return true;
      return element.files[0].size <= 5*1024*1024;
  }, "File size must not exceed 5MB");

  $.validator.addMethod("fileType", function(value, element){
      if(element.files.length === 0) return true;
      return /\.(jpe?g|png|gif)$/i.test(element.files[0].name);
  }, "Please upload a valid image file");

  // ===== Form Validation =====
  $("#editEventForm").validate({

      rules: {
          eventImage: {
              fileType: true,
              fileSize: true
          },
          eventName: {
              required: true,
              minlength: 3,
              maxlength: 100
          },
          eventClub: {
              required: true
          },
          eventDate: {
              required: true,
              date: true
          },
          eventStatus: {
              required: true
          },
          eventDescription: {
              required: true,
              minlength: 10,
              maxlength: 500
          }
      },

      messages: {
          eventName: {
              required: "Event name is required",
              minlength: "Minimum 3 characters required",
              maxlength: "Maximum 100 characters allowed"
          },
          eventClub: "Please enter club name",
          eventDate: "Please select valid date",
          eventStatus: "Please select status",
          eventDescription: {
              required: "Description is required",
              minlength: "Minimum 10 characters required",
              maxlength: "Maximum 500 characters allowed"
          }
      },

      highlight: function(element){
          $(element).addClass("is-invalid").removeClass("is-valid");
      },

      unhighlight: function(element){
          if ($(element).attr('type') === 'file' && $(element).val() === '') {
              $(element).removeClass("is-invalid is-valid");
          } else {
              $(element).removeClass("is-invalid").addClass("is-valid");
          }
      },

      errorElement: 'div',
      errorClass: 'invalid-feedback',
      errorPlacement: function(error, element){
          error.insertAfter(element);
      },

      submitHandler: function(form){

          Swal.fire({
              icon: 'success',
              title: 'Event Updated!',
              text: 'Your changes have been saved successfully.',
              confirmButtonText: 'OK'
          }).then((result) => {
              if(result.isConfirmed){
                  window.location.href = "Manage_events.php";
              }
          });

          return false;
      }

  });

});
</script>

<?php include 'F_footer.php'; ?>