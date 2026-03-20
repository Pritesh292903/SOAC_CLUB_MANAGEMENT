<?php include 'header.php'; ?>

<div class="container my-5">
    <!-- Hero / Intro Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-danger animate__animated animate__fadeInDown" style="color:#9b0000;">
            About RKU
        </h1>
        <p class="lead text-muted animate__animated animate__fadeInUp animate__delay-1s">
            Welcome to RKU – a hub of excellence in education, innovation, and research.
        </p>
        <p class="text-secondary animate__animated animate__fadeInUp animate__delay-2s">
            Explore our journey, mission, and the people behind our success.
        </p>
    </div>

    <!-- Mission & Vision Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 animate__animated animate__fadeInLeft">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h3 class="text-danger mb-3">Our Mission</h3>
                <p>To provide quality education that empowers students with knowledge, skills, and values to succeed in
                    a dynamic world.</p>
            </div>
        </div>
        <div class="col-md-6 animate__animated animate__fadeInRight">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h3 class="text-danger mb-3">Our Vision</h3>
                <p>To be a leading institution recognized for academic excellence, innovative research, and community
                    engagement.</p>
            </div>
        </div>
    </div>

    <!-- History / Background -->
    <div class="row g-4 mb-5 animate__animated animate__fadeInUp">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-danger mb-3">Our History</h3>
                <p>
                    RKU was established with a vision to transform education in the region. Over the years, we have
                    nurtured
                    thousands of students, fostered innovative research, and built a vibrant community of learners and
                    educators.
                </p>
                <p>
                    With state-of-the-art infrastructure and experienced faculty, RKU stands as a beacon of knowledge,
                    preparing
                    students for real-world challenges while instilling a sense of responsibility and ethics.
                </p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="text-center mb-4 animate__animated animate__fadeInUp">
        <h2 class="text-danger mb-3">Meet Our Team</h2>
        <p class="text-secondary">Dedicated faculty and staff guiding our students to success.</p>
    </div>

    <div class="row g-4 mb-5">
        <!-- Team Member 1 -->
        <div class="col-md-3 text-center animate__animated animate__fadeInUp">
            <img src="assets/images/p1.avif" class="rounded-circle mb-3 team-img" alt="Team 1">
            <h5 class="text-danger">Prof. Nisha Kukdiya</h5>
            <p class="text-muted">Head of Department</p>
        </div>
        <!-- Team Member 2 -->
        <div class="col-md-3 text-center animate__animated animate__fadeInUp animate__delay-1s">
            <img src="assets/images/p2.webp" class="rounded-circle mb-3 team-img" alt="Team 2">
            <h5 class="text-danger">Dr. Rajesh Patel</h5>
            <p class="text-muted">Senior Faculty</p>
        </div>
        <!-- Team Member 3 -->
        <div class="col-md-3 text-center animate__animated animate__fadeInUp animate__delay-2s">
            <img src="assets/images/p1.avif" class="rounded-circle mb-3 team-img" alt="Team 3">
            <h5 class="text-danger">Dr. Priya Sharma</h5>
            <p class="text-muted">Research Coordinator</p>
        </div>
        <!-- Team Member 4 -->
        <div class="col-md-3 text-center animate__animated animate__fadeInUp animate__delay-3s">
            <img src="assets/images/p2.webp" class="rounded-circle mb-3 team-img" alt="Team 4">
            <h5 class="text-danger">Mr. Pritesh Bharadwa</h5>
            <p class="text-muted">Student Affairs</p>
        </div>
    </div>

    <!-- Call to Action / Footer Info -->
    <div class="text-center mb-5 animate__animated animate__fadeInUp">
        <h3 class="text-danger mb-3">Join Our Journey</h3>
        <p class="text-secondary">Be part of a vibrant community that fosters learning, creativity, and growth. Explore
            programs, events, and opportunities at RKU today!</p>
        <a href="contactus_view.php" class="btn btn-danger">Contact Us</a>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .team-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 3px solid #d90429;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(217, 4, 41, 0.3);
        transition: 0.3s;
    }

    .btn-danger {
        background: linear-gradient(120deg, #9b0000, #d90429);
        border: none;
    }
</style>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<?php include 'footer.php'; ?>