<?php include 'admin_header.php'; ?>

<!-- ✅ SweetAlert CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content {
    animation: fadeIn 0.6s ease-in-out;
}
@keyframes fadeIn {
    from { opacity:0; transform:translateY(15px);}
    to { opacity:1; transform:translateY(0);}
}

.card.custom-card{
    border:none;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    background:#fff;
}

.form-label{
    font-weight:600;
    font-size:0.9rem;
}

.form-control, .form-select{
    border-radius:10px;
    padding:10px;
}

.btn-effect{
    border-radius:50px;
    transition:0.3s;
}
.btn-effect:hover{
    transform:translateY(-2px);
}

.event-img{
    width:100%;
    max-height:250px;
    object-fit:cover;
    border-radius:12px;
    margin-bottom:10px;
}

.upload-box{
    border:2px dashed #ddd;
    padding:15px;
    border-radius:12px;
    text-align:center;
    background:#fafafa;
}
.upload-box:hover{
    border-color:#dc3545;
}
</style>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">Add New Event</h4>
        <a href="all_events_page.php" class="btn btn-outline-danger btn-effect">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card custom-card p-4">

        <!-- ✅ FORM -->
        <form id="addEventForm" enctype="multipart/form-data">

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label">Choose Event Image</label>

                <div class="upload-box">
                    <img src="https://via.placeholder.com/800x250?text=Event+Preview" 
                         class="event-img" id="eventImagePreview">

                    <input type="file" class="form-control mt-2" 
                           id="eventImage" name="eventImage" accept="image/*">
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Event Name *</label>
                <input type="text" class="form-control" id="eventName" name="eventName">
            </div>

            <div class="col-md-6">
                <label class="form-label">Event Date *</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate">
            </div>

            <div class="col-md-6">
                <label class="form-label">Event Status *</label>
                <select class="form-select" id="eventStatus" name="eventStatus">
                    <option value="">Select status</option>
                    <option>Active</option>
                    <option>Upcoming</option>
                    <option>Closed</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Event Description *</label>
                <textarea class="form-control" rows="4" id="eventDescription" name="eventDescription"></textarea>
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <!-- ✅ IMPORTANT CHANGE -->
            <button type="button" id="submitBtn" class="btn btn-danger btn-effect">
                <i class="bi bi-save me-2"></i>Create Event
            </button>

            <a href="all_events_page.php" class="btn btn-outline-secondary btn-effect">
                Cancel
            </a>
        </div>

        </form>

    </div>

</div>

<!-- ✅ JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ✅ IMAGE PREVIEW -->
<script>
$(document).ready(function(){

    $("#eventImage").on("change", function(){
        let reader = new FileReader();

        reader.onload = function(e){
            $("#eventImagePreview").attr("src", e.target.result);
        }

        if(this.files[0]){
            reader.readAsDataURL(this.files[0]);
        }
    });

});
</script>

<!-- ✅ AJAX -->
<script>
$(document).ready(function(){

    $("#submitBtn").click(function(){

        let form = $("#addEventForm")[0];
        let formData = new FormData(form);

        // Validation
        if ($("#eventName").val().trim() === "" ||
            $("#eventDate").val() === "" ||
            $("#eventStatus").val() === "" ||
            $("#eventDescription").val().trim() === "") {

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Please fill all required fields!"
            });
            return;
        }

        // Loading
        Swal.fire({
            title: "Please wait...",
            text: "Creating Event...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "add_event_process.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(response){

                response = response.trim();

                if(response === "success"){
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Event Created Successfully!",
                        confirmButtonText: "OK"
                    }).then((result)=>{
                        if(result.isConfirmed){
                            window.location.href = "all_events_page.php";
                        }
                    });
                }
                else{
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response
                    });
                }
            },

            error: function(){
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong!"
                });
            }

        });

    });

});
</script>

<?php include 'admin_footer.php'; ?>