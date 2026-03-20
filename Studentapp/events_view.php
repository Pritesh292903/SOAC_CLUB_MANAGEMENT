<?php include 'header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">

    <!-- Heading -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-danger animate__animated animate__fadeInDown">
            Our Events
        </h1>
        <p class="lead text-muted animate__animated animate__fadeInUp">
            Join exciting events and enhance your experience!
        </p>
    </div>

    <div class="row g-4">

        <!-- Event 1 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <img src="assets/images/e1.avif" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-danger">Music Festival</h5>
                    <p class="text-muted">25th Feb 2026</p>
                    <p>Enjoy live performances from amazing artists.</p>
                    <button class="btn btn-danger w-100 joinBtn" data-event="Music Festival">
                        Join Event
                    </button>
                </div>
            </div>
        </div>

        <!-- Event 2 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <img src="assets/images/e2.jpg" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-danger">Art Exhibition</h5>
                    <p class="text-muted">1st Mar 2026</p>
                    <p>Explore creativity and talent from artists.</p>
                    <button class="btn btn-danger w-100 joinBtn" data-event="Art Exhibition">
                        Join Event
                    </button>
                </div>
            </div>
        </div>

        <!-- Event 3 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <img src="assets/images/e3.webp" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-danger">Tech Workshop</h5>
                    <p class="text-muted">10th Mar 2026</p>
                    <p>Learn latest technologies from experts.</p>
                    <button class="btn btn-danger w-100 joinBtn" data-event="Tech Workshop">
                        Join Event
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Join Event Modal -->
<div class="modal fade" id="joinModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Join Event</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="eventForm">

            <div class="mb-3">
                <label>Your Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label>Selected Event</label>
                <input type="text" name="event_name" id="event_name" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label>Why do you want to join?</label>
                <textarea name="message" rows="3" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-danger w-100">Submit</button>

        </form>
      </div>
    </div>
  </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(217,4,41,.3);
    transition: 0.3s;
}
.card-img-top {
    height: 200px;
    object-fit: cover;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Open modal & set event name
    $(".joinBtn").click(function(){
        let eventName = $(this).data("event");
        $("#event_name").val(eventName);
        $("#joinModal").modal("show");
    });

    // Validation
    $("#eventForm").validate({
        rules:{
            name:{ required:true, minlength:3 },
            email:{ required:true, email:true },
            phone:{ required:true, digits:true, minlength:10, maxlength:10 },
            message:{ required:true, minlength:10 }
        },
        messages:{
            name:"Enter valid name",
            email:"Enter valid email",
            phone:"Enter 10 digit phone",
            message:"Please enter at least 10 characters"
        },
        errorClass:"text-danger",
        errorElement:"small",
        highlight:function(el){ $(el).addClass("is-invalid"); },
        unhighlight:function(el){ $(el).removeClass("is-invalid"); },

        submitHandler: function(form) {
            // SweetAlert popup
            Swal.fire({
                title: "Success!",
                text: "You have successfully joined the event.",
                icon: "success",
                confirmButtonColor: "#d90429",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php";
                }
            });
        }

    });

});
</script>

<?php include 'footer.php'; ?>