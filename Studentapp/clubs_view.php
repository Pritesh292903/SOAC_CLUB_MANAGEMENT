<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Explore Clubs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fff5f5;
        }

        /* Heading */
        .page-title {
            font-weight: 700;
            color: #b71c1c;
            letter-spacing: 1px;
        }

        /* Club Card */
        .club-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #f1c1c1;
            padding: 25px 20px;
            text-align: center;
            transition: 0.4s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .club-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 35px rgba(183, 28, 28, 0.2);
            border-color: #e53935;
        }

        .club-card img {
            width: 85px;
            height: 85px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f8d7da;
            margin-bottom: 15px;
            transition: 0.4s;
        }

        .club-card:hover img {
            transform: scale(1.1) rotate(5deg);
            border-color: #e53935;
        }

        .club-card h5 {
            font-weight: 700;
            color: #c62828;
            margin-bottom: 6px;
        }

        .club-card .category {
            font-size: 13px;
            color: #777;
        }

        .club-card .members {
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 10px;
        }

        .club-card p {
            font-size: 13px;
            color: #666;
            min-height: 55px;
        }

        .club-btn {
            padding: 7px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 30px;
            border: none;
            background: linear-gradient(45deg, #e53935, #ff7043);
            color: white;
            transition: 0.3s;
        }

        .club-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(229, 57, 53, 0.4);
            background: linear-gradient(45deg, #b71c1c, #ff3d00);
        }

        .club-wrapper {
            margin-top: 50px;
            margin-bottom: 70px;
        }
    </style>
</head>

<body>

    <div class="container club-wrapper">
        <!-- Heading -->
        <div class="text-center mb-5">
            <h1 class="page-title display-5 animate__animated animate__fadeInDown">Explore Our Clubs</h1>
            <p class="text-muted">Join your favorite club and grow your passion</p>
        </div>

        <div class="row g-4">

            <!-- Music Club -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="club-card">
                    <img src="assets/images/Music.webp" alt="Music Club">
                    <h5>Music Club</h5>
                    <div class="category">Arts & Performance</div>
                    <div class="members">35 Members</div>
                    <p>Join music events and jam sessions to improve your skills.</p>
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <button class="club-btn joinBtn" data-club="Music Club">Join</button>
                        <a href="club_detail.php?club=music" class="club-btn">Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== JOIN CLUB MODAL ===== -->
    <div class="modal fade" id="joinModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Join Club</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="clubForm">
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
                            <label>Selected Club</label>
                            <input type="text" name="club_name" id="club_name" class="form-control" readonly>
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

    <!-- ===== SCRIPTS ===== -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Open modal & prefill club name
            $(".joinBtn").click(function () {
                let clubName = $(this).data("club");
                $("#club_name").val(clubName);
                $("#joinModal").modal("show");
            });

            // Form validation + SweetAlert
            $("#clubForm").validate({
                rules: {
                    name: { required: true, minlength: 3 },
                    email: { required: true, email: true },
                    phone: { required: true, digits: true, minlength: 10, maxlength: 10 },
                    message: { required: true, minlength: 10 }
                },
                messages: {
                    name: "Enter valid name",
                    email: "Enter valid email",
                    phone: "Enter 10 digit phone",
                    message: "Please enter at least 10 characters"
                },
                errorClass: "text-danger",
                errorElement: "small",
                highlight: function (el) { $(el).addClass("is-invalid"); },
                unhighlight: function (el) { $(el).removeClass("is-invalid"); },

                submitHandler: function (form) {
                    Swal.fire({
                        title: "Success!",
                        text: "You have successfully joined the club.",
                        icon: "success",
                        confirmButtonColor: "#d90429",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "clubs_view.php";
                        }
                    });
                }
            });
        });
    </script>

    <?php include 'footer.php'; ?>