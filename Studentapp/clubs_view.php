<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../database.php';

// ================= PAYMENT SUCCESS AJAX HANDLER =================
if(isset($_POST['payment_id']) && isset($_POST['club_id'])){
    $user_id = $_SESSION['user_id'] ?? 0;
    $club_id = intval($_POST['club_id']);
    $payment_id = mysqli_real_escape_string($con, $_POST['payment_id']);

    if($user_id && $club_id && $payment_id){
        $check = mysqli_query($con, "SELECT * FROM club_join_requests WHERE user_id='$user_id' AND club_id='$club_id'");
        if(mysqli_num_rows($check) > 0){
            mysqli_query($con, "UPDATE club_join_requests SET status='pending', payment_id='$payment_id' WHERE user_id='$user_id' AND club_id='$club_id'");
        } else {
            mysqli_query($con, "INSERT INTO club_join_requests (user_id, club_id, status, payment_id) VALUES ('$user_id','$club_id','pending','$payment_id')");
        }
    }
    exit();
}

include 'header.php';

$user_id = $_SESSION['user_id'] ?? 0;

/* ================= FREE CLUB JOIN ================= */
if (isset($_POST['join_club'])) {

    if (!$user_id) {
        echo "<script>
            alert('Please login first!');
            window.location.href='login_view.php';
        </script>";
        exit();
    }

    $club_id = intval($_POST['club_id']);

    $check = mysqli_query($con, "SELECT * FROM club_join_requests 
                                 WHERE user_id='$user_id' AND club_id='$club_id'");

    if (mysqli_num_rows($check) > 0) {

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Already Sent', 'You already requested or joined!', 'info');
            });
        </script>";

    } else {

        mysqli_query($con, "INSERT INTO club_join_requests 
        (user_id, club_id, status)
        VALUES ('$user_id','$club_id','pending')");

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Success', 'Request sent successfully!', 'success')
                .then(()=> location.href='clubs_view.php');
            });
        </script>";
    }
}

$clubs_result = mysqli_query($con, "SELECT * FROM clubs WHERE status='Active' ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Our Clubs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(135deg, #fff5f5, #ffecec);
            font-family: 'Segoe UI', sans-serif;
        }

        .club-wrapper {
            margin-top: 50px;
            margin-bottom: 70px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title h1 {
            font-weight: 700;
            color: #b71c1c;
        }

        .club-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .club-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(183, 28, 28, 0.2);
        }

        .club-card img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e53935;
        }

        .club-btn {
            padding: 7px 16px;
            font-size: 13px;
            border-radius: 25px;
            background: #e53935;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .club-btn:hover {
            background: #b71c1c;
        }
    </style>
</head>

<body>

    <main class="container club-wrapper">

        <div class="page-title">
            <h1>🎯 Our Clubs</h1>
            <p class="text-muted">Join your favorite club & grow your skills</p>
        </div>

        <div class="row g-4">

            <?php while ($club = mysqli_fetch_assoc($clubs_result)): ?>

                <?php
                $status = null;

                $status_q = mysqli_query($con, "SELECT status FROM club_join_requests 
                                WHERE user_id='$user_id' 
                                AND club_id='" . $club['id'] . "'");

                if (mysqli_num_rows($status_q) > 0) {
                    $row = mysqli_fetch_assoc($status_q);
                    $status = $row['status'];
                }
                ?>

                <div class="col-md-3">
                    <div class="club-card">

                        <img src="../Adminapp/uploads/<?php echo $club['clubimage']; ?>">

                        <h5 class="mt-3"><?php echo $club['clubname']; ?></h5>
                        <p class="text-muted"><?php echo $club['faculty']; ?></p>

                        <?php if (isset($club['club_paid']) && $club['club_paid'] == "Paid") { ?>
                            <span class="badge bg-danger">Paid Club</span>
                        <?php } else { ?>
                            <span class="badge bg-success">Free Club</span>
                        <?php } ?>

                        <div class="mt-3 d-flex justify-content-center gap-2">

                            <?php if ($status == 'pending'): ?>

                                <span class="badge bg-warning text-dark">Requested</span>

                            <?php elseif ($status == 'approved'): ?>

                                <span class="badge bg-success">Already Joined</span>

                            <?php else: ?>

                                <button class="club-btn join-btn" data-id="<?php echo $club['id']; ?>"
                                    data-name="<?php echo $club['clubname']; ?>" data-type="<?php echo $club['club_paid']; ?>"
                                    data-amount="<?php echo $club['price'] ?? 0; ?>">
                                    Join
                                </button>

                            <?php endif; ?>

                            <a href="club_detail.php?club_id=<?php echo $club['id']; ?>" class="club-btn">
                                Details
                            </a>

                        </div>

                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    </main>

    <form id="joinForm" method="POST" style="display:none;">
        <input type="hidden" name="club_id" id="club_id">
        <input type="hidden" name="join_club">
    </form>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(".join-btn").click(function () {

            let user_id = <?php echo $user_id; ?>;
            if (user_id === 0) {
                alert('Please login first!');
                window.location.href = 'login_view.php';
                return;
            }

            let id = $(this).data("id");
            let name = $(this).data("name");
            let type = $(this).data("type");
            let amount = $(this).data("amount");

            /* ================= FREE CLUB ================= */
            if (type !== "Paid") {

                Swal.fire({
                    title: "Join " + name + "?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes"
                }).then((res) => {
                    if (res.isConfirmed) {
                        $("#club_id").val(id);
                        $("#joinForm").submit();
                    }
                });

            }

            /* ================= PAID CLUB ================= */
            else {

                let options = {
                    "key": "rzp_test_SfdQKUUAVf86gW",
                    "amount": amount * 100,
                    "currency": "INR",
                    "name": name,
                    "description": "Club Membership",

                    "handler": function (response) {

                        $.ajax({
                            url: "",
                            type: "POST",
                            data: {
                                club_id: id,
                                payment_id: response.razorpay_payment_id
                            },
                            success: function () {

                                Swal.fire("Success", "Payment Done & Joined!", "success")
                                    .then(() => location.reload());

                            },
                            error: function () {
                                Swal.fire("Error", "Payment done but request failed", "error");
                            }
                        });

                    },

                    "theme": {
                        "color": "#e53935"
                    }
                };

                let rzp = new Razorpay(options);
                rzp.open();
            }

        });
    </script>

    <?php include 'footer.php'; ?>

</body>

</html>