<?php 
include 'header.php'; 

// CHECK LOGIN
$isLoggedIn = isset($_SESSION['user_id']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <div class="card">

        <!-- Banner Image -->
        <img src="assets/images/e1.avif" alt="Cricket Tournament" class="hero-img mx-auto d-block">

        <div class="card-body">

            <!-- Event Name -->
            <h2 class="mb-4 text-center">Cricket Tournament</h2>

            <!-- Event Info -->
            <div class="event-info mx-auto" style="max-width:700px;">
                <h4>Event Details</h4>
                <ul class="list-unstyled mb-0">
                    <li><strong>Event Name:</strong> Cricket Tournament</li>
                    <li><strong>Date:</strong> 25-02-2026</li>
                    <li><strong>Status:</strong> Active</li>
                    <li><strong>Description:</strong> This is a cricket tournament organized by the Sports Club. All students are welcome to participate.</li>
                </ul>
            </div>

            <!-- Join Event Button -->
            <div class="text-center mb-4 mt-4">
                <button class="btn btn-theme btn-lg joinBtn" 
                        data-event="Cricket Tournament"
                        data-login="<?php echo $isLoggedIn ? 'yes' : 'no'; ?>">
                    Join Event
                </button>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="events_view.php" class="btn btn-outline-theme">Back to Events</a>
            </div>

        </div>
    </div>
</div>

<!-- ===== JOIN EVENT MODAL ===== -->
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

<!-- ===== STYLES (UNCHANGED) ===== -->
<style>
body {
    background: #fff5f5;
    color: #333;
    font-family: 'Segoe UI', sans-serif;
}

.card {
    border-radius: 25px;
    border: none;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.card:hover { transform: translateY(-10px); }

.hero-img {
    width: 100%;
    max-width: 450px;
    height: auto;
    object-fit: cover;
    border-radius: 25px 25px 0 0;
    animation: fadeInDown 1s;
}

.card-body { padding: 50px; }

h2 { font-weight: 700; color: #b71c1c; animation: fadeInUp 1.2s; }

.event-info {
    background: #fff;
    border-left: 5px solid #b71c1c;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 40px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    animation: fadeIn 1.5s;
}

.event-info h4 { font-weight: 600; margin-bottom: 15px; color: #b71c1c; }

.event-info ul li { margin-bottom: 12px; font-size: 1rem; }

.btn-theme {
    background-color: #b71c1c;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 45px;
    transition: all 0.3s;
    animation: fadeInUp 1.8s;
    text-decoration: none;
    display: inline-block;
}

.btn-theme:hover { background-color: #d32f2f; color: #fff; }

.btn-outline-theme {
    border: 2px solid #b71c1c;
    color: #b71c1c;
    border-radius: 50px;
    padding: 10px 35px;
    transition: all 0.3s;
    animation: fadeInUp 2s;
    text-decoration: none;
    display: inline-block;
}

.btn-outline-theme:hover { background-color: #b71c1c; color: #fff; }
</style>

<!-- ===== SCRIPTS ===== -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // ✅ LOGIN CHECK + ANIMATION
    $(".joinBtn").click(function(){

        let isLogin = $(this).data("login");

        if(isLogin === "no"){
            Swal.fire({
                title: "Oops!",
                text: "You need to login first",
                icon: "warning",
                confirmButtonColor: "#d90429",
                showClass: {
                    popup: 'animate__animated animate__zoomIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                }
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = "login_view.php";
                }
            });
            return;
        }

        let eventName = $(this).data("event");
        $("#event_name").val(eventName);
        $("#joinModal").modal("show");
    });

    // FORM VALIDATION
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
            Swal.fire({
                title: "Success!",
                text: "You have successfully joined the event.",
                icon: "success",
                confirmButtonColor: "#d90429",
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = "events_view.php";
                }
            });
        }
    });

});
</script>

<?php include 'footer.php'; ?>  