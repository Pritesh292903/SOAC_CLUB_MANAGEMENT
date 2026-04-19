<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include '../database.php';

$club_id = isset($_GET['club_id']) ? intval($_GET['club_id']) : 0;

if ($club_id > 0) {
    $club_query = mysqli_query($con, "SELECT * FROM clubs WHERE id='$club_id' LIMIT 1");
} else {
    $club_query = mysqli_query($con, "SELECT * FROM clubs ORDER BY id ASC LIMIT 1");
}

if (mysqli_num_rows($club_query) == 0) {
    echo "<script>alert('Club not found!'); window.location.href='clubs_view.php';</script>";
    exit();
}

$club = mysqli_fetch_assoc($club_query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* PAGE BACKGROUND */
    body {
        background: #f6f6f6;
    }

    /* MAIN CARD */
    .club-wrapper {
        max-width: 850px;
        margin: 40px auto;
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    /* HEADER */
    .club-header {
        background: linear-gradient(135deg, #b71c1c, #e53935);
        padding: 30px;
        text-align: center;
        color: white;
    }

    .club-header h1 {
        font-size: 28px;
        font-weight: 700;
    }

    /* IMAGE */
    .club-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -60px;
        background: #fff;
    }

    /* CONTENT */
    .club-body {
        padding: 30px;
    }

    /* INFO BOX */
    .info-box {
        background: #fff5f5;
        border-left: 5px solid #b71c1c;
        border-radius: 12px;
        padding: 20px;
    }

    .info-box li {
        padding: 8px 0;
        font-size: 15px;
    }

    /* BADGE */
    .badge-paid {
        background: #b71c1c;
        color: #fff;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .badge-free {
        background: #198754;
        color: #fff;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    /* BACK BUTTON */
    .back-btn {
        border: 2px solid #b71c1c;
        color: #b71c1c;
        border-radius: 30px;
        padding: 8px 25px;
        text-decoration: none;
        display: inline-block;
        transition: 0.3s;
    }

    .back-btn:hover {
        background: #b71c1c;
        color: #fff;
    }
</style>

<div class="container">

    <div class="club-wrapper">

        <!-- HEADER -->
        <div class="club-header">
            <h1><?php echo htmlspecialchars($club['clubname']); ?></h1>
            <p>Club Details</p>
        </div>
<br>
        <!-- IMAGE -->
        <div class="text-center">
            <img class="club-img" src="../Adminapp/uploads/<?php echo $club['clubimage']; ?>">
        </div>

        <!-- BODY -->
        <div class="club-body">

            <div class="info-box">

                <ul class="list-unstyled m-0">

                    <li><strong>Club Name:</strong> <?php echo $club['clubname']; ?></li>

                    <li><strong>Faculty:</strong> <?php echo $club['faculty']; ?></li>

                    <li><strong>Status:</strong> <?php echo $club['status']; ?></li>

                    <!-- NEW FIELD -->
                    <li>
                        <strong>Type:</strong>
                        <?php if ($club['club_paid'] == 'Paid') { ?>
                            <span class="badge-paid">Paid Club</span>
                        <?php } else { ?>
                            <span class="badge-free">Free Club</span>
                        <?php } ?>
                    </li>

                    <li>
                        <strong>Description:</strong><br>
                        <?php echo nl2br($club['clubdescription']); ?>
                    </li>

                </ul>

            </div>

            <!-- BACK BUTTON ONLY -->
            <div class="text-center mt-4">
                <a href="clubs_view.php" class="back-btn">← Back to Clubs</a>
            </div>

        </div>

    </div>

</div>