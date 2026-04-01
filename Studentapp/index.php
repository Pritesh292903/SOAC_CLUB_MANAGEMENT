<?php
include 'header.php';
include '../database.php'; // Database connection

// Select the database
mysqli_select_db($con, "SOAE_CLUB");

// Create the slider_images table if it doesn't exist
mysqli_query($con, "CREATE TABLE IF NOT EXISTS slider_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255)
)");

// Fetch slider images from database
$slider_images = mysqli_query($con, "SELECT * FROM slider_images ORDER BY id DESC");
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* ===== SLIDER STYLES ===== */
    .carousel-item {
        padding: 0 70px;
        box-sizing: border-box;
    }

    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 100px;
        transition: transform 0.5s ease;
    }

    .carousel-item img:hover {
        transform: scale(1.05);
    }

    /* ===== CLUB/EVENT CARDS ===== */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .card-img-top.rounded-circle {
        transition: transform 0.3s ease;
    }

    .card-img-top.rounded-circle:hover {
        transform: rotate(10deg) scale(1.1);
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #fff;
        color: #333;
    }

    /* ===== WELCOME SECTION ===== */
    .welcome-section {
        background-color: #ffe5e5;
        padding: 30px 20px;
        text-align: center;
        border-radius: 50px;
    }

    .welcome-section h1 {
        color: #d32f2f;
        font-weight: bold;
        font-size: 2.5rem;
    }

    .welcome-section p {
        color: #555;
        font-size: 1.1rem;
    }

    /* ===== CLUB CARDS ===== */
    .club-card {
        border: 2px solid #d32f2f;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .club-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .club-card img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #d32f2f;
        margin-top: 15px;
    }

    /* ===== EVENT CARDS ===== */
    .event-card {
        border: 2px solid #d32f2f;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .event-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-danger-custom {
        border-color: #d32f2f;
        color: #d32f2f;
    }

    .btn-outline-danger-custom:hover {
        background-color: #d32f2f;
        color: #fff;
    }
</style>

<!-- ===== WELCOME SECTION ===== -->
<section class="container my-2">
    <div class="welcome-section mx-auto">
        <h1>Welcome To RKU SOAC Clubs</h1>
        <p>Explore our amazing clubs, participate in exciting events, and unleash your talent. From arts and sports to
            coding and performing arts, there’s a club for everyone!</p>
    </div>
</section>

<!-- ===== DYNAMIC SLIDER ===== -->
<div id="miniSlider" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $isFirst = true;
        if (mysqli_num_rows($slider_images) > 0) {
            while ($img = mysqli_fetch_assoc($slider_images)) {
                $activeClass = $isFirst ? "active" : "";
                echo '<div class="carousel-item ' . $activeClass . '">
                        <img src="../Adminapp/slider_images/' . $img['image'] . '" class="d-block w-100" alt="Slider Image">
                      </div>';
                $isFirst = false;
            }
        } else {
            echo '<div class="carousel-item active">
                    <img src="../Adminapp/slider_images/nirf-ranking-slider.jpg" class="d-block w-100" alt="Default Slide">
                  </div>';
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#miniSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#miniSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- ===== CLUBS SECTION ===== -->
<section class="container my-5">
    <h2 class="text-center text-danger mb-4">Our Clubs</h2>
    <div class="row g-4 justify-content-center">
        <!-- Music Club -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="club-card text-center p-3 h-100">
                <img src="assets/images/Music.webp" alt="Music Club">
                <h5 class="mt-3 text-danger">Music Club</h5>
                <p class="text-secondary mb-1">Arts & Performance</p>
                <p class="text-muted small">Join music events and jam sessions to improve your skills.</p>
                <div class="d-flex justify-content-center gap-2 mt-2">
                    <a href="club_detail.php?club=music" class="btn btn-outline-danger-custom btn-sm">Details</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== EVENTS SECTION ===== -->
<section class="container my-5">
    <h2 class="text-center text-danger mb-4">Our Events</h2>
    <div class="row g-4 justify-content-center">
        <!-- Music Festival -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="event-card h-100 shadow-sm">
                <img src="assets/images/s1.jpg" alt="Music Festival">
                <div class="p-3">
                    <h5 class="text-danger">Cricket Tournament</h5>
                    <p class="text-muted small">Join our annual Cricket Tournament and showcase your talent!</p>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <a href="event_details.php" class="btn btn-outline-danger-custom btn-sm">Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>