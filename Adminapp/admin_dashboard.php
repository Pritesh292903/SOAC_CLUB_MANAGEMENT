<?php
include 'admin_header.php';
include '../database.php';
?>

<style>
body {
    background: linear-gradient(135deg, #fff, #ffe5e5);
    font-family: 'Segoe UI', sans-serif;
    overflow-x: hidden;
}

/* BACKGROUND GLOW */
body::before, body::after {
    content: '';
    position: fixed;
    width: 300px;
    height: 300px;
    background: rgba(220,53,69,0.15);
    border-radius: 50%;
    filter: blur(100px);
    z-index: 0;
}
body::before {
    top: -50px;
    left: -50px;
}
body::after {
    bottom: -50px;
    right: -50px;
}

/* CONTENT */
.content {
    position: relative;
    z-index: 1;
    animation: fadeIn 0.8s ease;
}
@keyframes fadeIn {
    from {opacity:0;}
    to {opacity:1;}
}

/* HEADER */
.dashboard-header {
    background: linear-gradient(135deg, #ff4b2b, #dc3545);
    color: white;
    padding: 22px;
    border-radius: 15px;
    margin-bottom: 30px;
    animation: slideDown 0.6s ease;
}
@keyframes slideDown {
    from {transform:translateY(-20px); opacity:0;}
    to {transform:translateY(0); opacity:1;}
}

/* KPI CARD */
.kpi-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 25px;
    text-align: center;
    transition: 0.4s;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
    transform-style: preserve-3d;
    animation: fadeUp 0.6s ease forwards;
}
.kpi-card:nth-child(1){animation-delay:0.1s;}
.kpi-card:nth-child(2){animation-delay:0.2s;}
.kpi-card:nth-child(3){animation-delay:0.3s;}
.kpi-card:nth-child(4){animation-delay:0.4s;}

@keyframes fadeUp {
    from {opacity:0; transform:translateY(40px);}
    to {opacity:1; transform:translateY(0);}
}

/* SHINE EFFECT */
.kpi-card::before {
    content: '';
    position: absolute;
    top: -100%;
    left: -100%;
    width: 200%;
    height: 200%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.5), transparent);
    transform: rotate(25deg);
    transition: 0.5s;
}
.kpi-card:hover::before {
    top: 100%;
    left: 100%;
}

/* HOVER TILT */
.kpi-card:hover {
    transform: rotateX(5deg) rotateY(5deg) scale(1.05);
}

/* TEXT */
.kpi-title {
    font-size: 14px;
    color: #666;
}
.kpi-value {
    font-size: 32px;
    font-weight: bold;
    color: #dc3545;
}

/* SUMMARY */
.summary-box {
    background: white;
    border-radius: 18px;
    padding: 25px;
    margin-top: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    animation: fadeUp 0.8s ease;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #eee;
    transition: 0.3s;
}
.summary-item:last-child {
    border-bottom: none;
}

.summary-item:hover {
    color: #dc3545;
    transform: translateX(8px);
}

</style>

<div class="content">

<div class="dashboard-header d-flex justify-content-between">
    <div>
        <h5>Admin Dashboard</h5>
        <small>Smart Overview Panel</small>
    </div>
    <div><?= date('d M Y') ?></div>
</div>

<?php
$totalEvents = mysqli_num_rows(mysqli_query($con, "SELECT id FROM events"));
$totalClubs = mysqli_num_rows(mysqli_query($con, "SELECT id FROM clubs"));
$totalStudents = mysqli_num_rows(mysqli_query($con, "SELECT id FROM User WHERE role='user'"));
$totalFaculties = mysqli_num_rows(mysqli_query($con, "SELECT id FROM Faculty_register"));
?>

<!-- KPI -->
<div class="row text-center">

<div class="col-md-3">
    <div class="kpi-card">
        <div class="kpi-title">Events</div>
        <div class="kpi-value counter" data-target="<?= $totalEvents ?>">0</div>
    </div>
</div>

<div class="col-md-3">
    <div class="kpi-card">
        <div class="kpi-title">Clubs</div>
        <div class="kpi-value counter" data-target="<?= $totalClubs ?>">0</div>
    </div>
</div>

<div class="col-md-3">
    <div class="kpi-card">
        <div class="kpi-title">Students</div>
        <div class="kpi-value counter" data-target="<?= $totalStudents ?>">0</div>
    </div>
</div>

<div class="col-md-3">
    <div class="kpi-card">
        <div class="kpi-title">Faculties</div>
        <div class="kpi-value counter" data-target="<?= $totalFaculties ?>">0</div>
    </div>
</div>

</div>

<!-- SUMMARY -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="summary-box">
            <h6 class="mb-3">System Summary</h6>

            <div class="summary-item">
                <span>Total Events</span>
                <strong><?= $totalEvents ?></strong>
            </div>

            <div class="summary-item">
                <span>Total Clubs</span>
                <strong><?= $totalClubs ?></strong>
            </div>

            <div class="summary-item">
                <span>Total Students</span>
                <strong><?= $totalStudents ?></strong>
            </div>

            <div class="summary-item">
                <span>Total Faculties</span>
                <strong><?= $totalFaculties ?></strong>
            </div>

        </div>
    </div>
</div>

</div>

<!-- 🔥 COUNTER SCRIPT -->
<script>
const counters = document.querySelectorAll('.counter');

counters.forEach(counter => {
    const update = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;

        const increment = target / 50;

        if(count < target){
            counter.innerText = Math.ceil(count + increment);
            setTimeout(update, 30);
        } else {
            counter.innerText = target;
        }
    };
    update();
});
</script>

<?php include 'admin_footer.php'; ?>