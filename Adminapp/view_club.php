<?php
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;

$query = "SELECT * FROM clubs WHERE id='$id'";
$result = mysqli_query($con, $query);
$club = mysqli_fetch_assoc($result);

if (!$club) {
    echo "<script>alert('Club not found!'); window.location.href='all_clubes_page.php';</script>";
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    html,
    body {
        height: 100%;
        margin: 20px;
        overflow: hidden;
        /* 🚫 NO SCROLL */
        background: linear-gradient(135deg, #f5f7fa, #e4e8f0);
    }

    /* FULL SCREEN CENTER */
    .main-wrapper {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    /* CARD */
    .card-modern {
        width: 100%;
        max-width: 700px;
        height: 90vh;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* IMAGE */
    .club-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 15px;
        border: 3px solid #eee;
    }

    /* TITLE */
    .club-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #e63946;
    }

    /* INFO GRID */
    .info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 15px;
    }

    .box {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .label {
        font-weight: 600;
        color: #555;
    }

    .value {
        font-weight: 500;
    }

    /* DESCRIPTION LIMIT */
    .desc {
        font-size: 0.9rem;
        max-height: 80px;
        overflow: auto;
        /* only inner scroll if long */
    }

    /* BUTTON */
    .back-btn {
        border-radius: 50px;
        padding: 8px 20px;
    }

    /* MOBILE */
    @media(max-width:600px) {
        .card-modern {
            height: 95vh;
            padding: 15px;
        }

        .info {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-wrapper">

    <div class="card-modern text-center">

        <!-- TOP -->
        <div>
            <img src="uploads/<?php echo htmlspecialchars($club['clubimage']); ?>" class="club-img mb-2">

            <div class="club-title">
                <?php echo htmlspecialchars($club['clubname']); ?>
            </div>
        </div>

        <!-- INFO -->
        <div class="info">

            <div class="box">
                <div class="label">Faculty</div>
                <div class="value"><?php echo htmlspecialchars($club['faculty']); ?></div>
            </div>

            <div class="box">
                <div class="label">Members</div>
                <div class="value"><?php echo htmlspecialchars($club['totalmembers']); ?></div>
            </div>

            <div class="box">
                <div class="label">Status</div>
                <div class="value">
                    <?php if ($club['status'] == "Active") { ?>
                        <span class="badge bg-success">Active</span>
                    <?php } else { ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php } ?>
                </div>
            </div>

            <div class="box">
                <div class="label">Type</div>
                <div class="value">
                    <?php if ($club['club_paid'] == "Paid") { ?>
                        <span class="badge bg-warning text-dark">💰 Paid</span>
                    <?php } else { ?>
                        <span class="badge bg-info text-dark">🆓 Free</span>
                    <?php } ?>
                </div>
            </div>

        </div>

        <!-- DESCRIPTION -->
        <div class="box mt-2">
            <div class="label">Description</div>
            <div class="desc">
                <?php echo nl2br(htmlspecialchars($club['clubdescription'])); ?>
            </div>
        </div>

        <!-- BUTTON -->
        <div>
            <a href="all_clubes_page.php" class="btn btn-danger back-btn">Back</a>
        </div>

    </div>
</div>

<?php include 'admin_footer.php'; ?>