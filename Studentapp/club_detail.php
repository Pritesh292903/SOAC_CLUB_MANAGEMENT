<?php include 'header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <div class="card">

        <!-- Banner Image -->
        <img src="assets/images/e1.avif" alt="Cricket Tournament" class="hero-img mx-auto d-block">

        <div class="card-body">

            <!-- Event Name -->
            <h2 class="mb-4 text-center">Sports club</h2>

            <!-- Event Info -->
            <div class="event-info mx-auto" style="max-width:700px;">
                <h4>Clube Details</h4>
                <ul class="list-unstyled mb-0">
                    <li><strong>Event Name:</strong> Sport Clube</li>
                    <li><strong>Date:</strong> 25-02-2026</li>
                    <li><strong>Status:</strong> Active</li>
                    <li><strong>Description:</strong> This is a cricket tournament organized by the Sports Club. All students are welcome to participate.</li>
                </ul>
            </div>

            <!-- Join Event Button -->
            <div class="text-center mb-4 mt-4">
                <a href="join_club.php?club=Sports Club" class="btn btn-theme btn-lg">
                    Join Club
                </a>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="clubs_view.php" class="btn btn-outline-theme">Back to Events</a>
            </div>

        </div>
    </div>
</div>

<!-- ===== STYLES ===== -->
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

@media (max-width: 768px) {
    .card-body { padding: 30px 20px; }
    .hero-img { max-width: 100%; max-height: 300px; margin-bottom: 20px; }
    .btn-theme, .btn-outline-theme { padding: 10px 30px; }
    .event-info { padding: 20px; }
}
</style>

<!-- ===== SCRIPTS ===== -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Open modal & prefill event name
    $(".joinBtn").click(function(){
        let eventName = $(this).data("event");
        $("#event_name").val(eventName);
        $("#joinModal").modal("show");
    });

    // Form validation + SweetAlert
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
                confirmButtonText: "OK"
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = "clubs_view.php"; // redirect after success
                }
            });
        }
    });

});
</script>

<?php include 'footer.php'; ?>