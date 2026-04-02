<?php
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;
$res = mysqli_query($con, "SELECT * FROM events WHERE id='$id'");
$event = mysqli_fetch_assoc($res);
?>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Full-screen gradient background */
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffe6e6, #ffd6d6);
}

/* Full-page container */
.content {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.8s ease-in-out;
    padding: 20px;
    box-sizing: border-box;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(50px);}
    to { opacity: 1; transform: translateY(0);}
}

/* Main event section */
.event-full {
    width: 100%;
    height: 90%;
    background: #fff;
    border-radius: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
    box-shadow: 0 0 30px rgba(0,0,0,0.15);
    animation: slideUp 0.8s ease forwards;
}

@keyframes slideUp {
    from { transform: translateY(100px); opacity:0; }
    to { transform: translateY(0); opacity:1; }
}

/* Left side - image */
.event-full .left {
    background: url('../uploads/<?= $event['image'] ?: 'default.png'; ?>') center center / cover no-repeat;
    cursor: pointer;
    transition: transform 0.3s;
}
.event-full .left:hover {
    transform: scale(1.05);
}

/* Right side - details */
.event-full .right {
    padding: 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 25px;
}

.event-full .right h1 {
    color: #dc3545;
    font-size: 48px;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.event-full .right .info {
    font-size: 20px;
    line-height: 1.6;
    display: flex;
    align-items: center;
    gap: 10px;
}

.event-full .right .info span {
    font-weight: bold;
    color: #333;
}

/* Status badge */
.status-badge {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 16px;
    color: #fff;
}
.status-active { background: #28a745; }
.status-closed { background: #6c757d; }

/* Back button */
.btn-back {
    margin-top: 30px;
    background: #dc3545;
    color: #fff;
    padding: 12px 35px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
    width: fit-content;
}
.btn-back:hover {
    background: #b71c1c;
}

/* Responsive */
@media (max-width: 900px){
    .event-full {
        grid-template-columns: 1fr;
        height: auto;
    }
    .event-full .left {
        height: 300px;
    }
}
</style>

<div class="content">
<?php if($event): ?>
    <div class="event-full">
        <div class="left" id="popup-image"></div>
        <div class="right">
            <h1><?= $event['name']; ?></h1>
            <div class="info"><span><i class="fa fa-calendar"></i> Date:</span> <?= date('d M, Y', strtotime($event['date'])); ?></div>
            <div class="info"><span><i class="fa fa-toggle-on"></i> Status:</span>
                <span class="status-badge <?= $event['status']=='Active'?'status-active':'status-closed'; ?>">
                    <?= $event['status']; ?>
                </span>
            </div>
            <div class="info"><span><i class="fa fa-align-left"></i> Description:</span> <?= $event['description'] ?: 'No Description'; ?></div>
            <a href="all_events.php" class="btn-back">← Back to Events</a>
        </div>
    </div>
<?php else: ?>
    <p style="font-size:22px; color:#333;">Event not found.</p>
<?php endif; ?>
</div>

<script>
// Popup for image
document.getElementById('popup-image').addEventListener('click', function(){
    Swal.fire({
        title: 'Event Image',
        imageUrl: this.style.backgroundImage.slice(5, -2),
        imageAlt: 'Event Image',
        showCloseButton: true,
        showConfirmButton: false,
        width: '600px',
        background: '#fff0f0',
    });
});
</script>