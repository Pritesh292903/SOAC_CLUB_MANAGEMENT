<?php include 'F_header.php'; ?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Page Title -->
            <div class="mb-4">
                <h2 class="fw-bold text-danger">
                    <i class="bi bi-calendar-plus me-2"></i>Add New Event
                </h2>
                <p class="text-muted mb-0">Fill in the details to create a new event</p>
            </div>

            <div class="row">

                <!-- Left Side: Image Preview -->
                <div class="col-md-4 text-center mb-4">
                    <img src="https://via.placeholder.com/400x250?text=Event+Preview"
                         id="eventImagePreview"
                         class="img-fluid rounded-4 shadow-sm"
                         style="height:220px; object-fit:cover;">
                    
                    <input type="file"
                           class="form-control mt-3"
                           id="eventImage"
                           name="eventImage"
                           accept="image/*">
                    <small class="text-muted">JPG, PNG or GIF (Max 5MB)</small>
                </div>

                <!-- Right Side: Event Form -->
                <div class="col-md-8">

                    <form id="addEventForm">

                        <!-- Event Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Event Name *</label>
                            <input type="text"
                                   class="form-control rounded-3"
                                   name="eventName"
                                   id="eventName">
                        </div>

                        <!-- Club Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Club Name *</label>
                            <select class="form-select rounded-3" name="clubName" id="clubName">
                                <option value="">Select Club</option>
                                <option>Computer Club</option>
                                <option>Sports Club</option>
                                <option>Cultural Club</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date *</label>
                            <input type="date"
                                   class="form-control rounded-3"
                                   name="eventDate"
                                   id="eventDate">
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status *</label>
                            <select class="form-select rounded-3"
                                    name="eventStatus"
                                    id="eventStatus">
                                <option value="">Select Status</option>
                                <option>Active</option>
                                <option>Upcoming</option>
                                <option>Closed</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description *</label>
                            <textarea class="form-control rounded-3"
                                      rows="4"
                                      name="eventDescription"
                                      id="eventDescription"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Save Event
                            </button>

                            <a href="manage_events.php" class="btn btn-secondary rounded-pill px-4">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    // ===== Custom Validation Methods =====
    $.validator.addMethod("fileSize", function(value, element){
        if(element.files.length === 0) return true;
        return element.files[0].size <= 5*1024*1024;
    }, "File size must be less than 5MB");

    $.validator.addMethod("fileType", function(value, element){
        if(element.files.length === 0) return true;
        return /\.(jpe?g|png|gif)$/i.test(element.files[0].name);
    }, "Please select a valid image file");

    // ===== Form Validation =====
    $("#addEventForm").validate({

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
            clubName: {
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
            eventName: "Enter event name (min 3 characters)",
            clubName: "Select club",
            eventDate: "Select date",
            eventStatus: "Select status",
            eventDescription: "Enter description (min 10 characters)"
        },

        highlight: function(element){
            $(element).addClass("is-invalid");
        },

        unhighlight: function(element){
            $(element).removeClass("is-invalid").addClass("is-valid");
        },

        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element){
            error.insertAfter(element);
        },

        submitHandler: function(form){

            Swal.fire({
                title: "Event Created!",
                text: "Your event has been added successfully",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "manage_events.php";
                }
            });

            return false;
        }

    });

});
</script>

<?php include 'F_footer.php'; ?>