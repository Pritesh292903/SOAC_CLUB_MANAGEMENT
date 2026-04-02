<?php include 'admin_header.php'; ?>
<?php
include '../database.php';

// Fetch notifications array
$notifications = [];

// 1️⃣ Contact messages
$msgQuery = "SELECT name, subject, created_at FROM contact_us ORDER BY created_at DESC LIMIT 5";
$msgResult = mysqli_query($con, $msgQuery);
while($row = mysqli_fetch_assoc($msgResult)){
    $notifications[] = [
        'type' => 'message',
        'title' => "New Contact Message",
        'desc' => "{$row['name']} sent a message: {$row['subject']}",
        'time' => date("d M Y H:i", strtotime($row['created_at']))
    ];
}

// 2️⃣ Admin profile changes (using Option 1: current timestamp)
$profileQuery = "SELECT fullname, email FROM User WHERE role='admin' ORDER BY id DESC LIMIT 5";
$profileResult = mysqli_query($con, $profileQuery);
while($row = mysqli_fetch_assoc($profileResult)){
    $notifications[] = [
        'type' => 'profile',
        'title' => "Admin Profile Updated",
        'desc' => "Profile updated: {$row['fullname']} ({$row['email']})",
        'time' => date("d M Y H:i") // current time as placeholder
    ];
}

// Sort notifications by time descending (latest first)
usort($notifications, function($a, $b){
    return strtotime($b['time']) - strtotime($a['time']);
});
?>

<style>
/* ===== PAGE ANIMATION ===== */
.content{
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(15px);}
    to{opacity:1; transform:translateY(0);}
}

/* ===== NOTIFICATION CARD ===== */
.notification-card{
    background:#fff;
    border-radius:15px;
    padding:20px;
    margin-bottom:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    transition:0.3s ease;
}

.notification-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

.notification-card i{
    font-size:20px;
}

.notification-card .time{
    font-size:12px;
    color:#999;
}

.notification-card.unread{
    border-left:4px solid #dc3545;
    background:#fff5f5;
}

/* PAGE HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.page-header h3{
    color:#dc3545;
    font-weight:700;
}
</style>

<div class="content">

    <div class="page-header">
        <h3><i class="bi bi-bell-fill me-2"></i>Notifications</h3>
        <a href="admin_dashboard.php" class="btn btn-outline-danger">Back to Dashboard</a>
    </div>

    <!-- Notifications List -->
    <div class="notifications-list">
        <?php if(!empty($notifications)): ?>
            <?php foreach($notifications as $n): ?>
                <?php 
                $unreadClass = ($n['type'] == 'message') ? 'unread' : '';
                $icon = 'bi-info-circle-fill';
                if($n['type'] == 'message') $icon = 'bi-envelope-fill';
                if($n['type'] == 'profile') $icon = 'bi-person-fill';
                ?>
                <div class="notification-card <?= $unreadClass ?> d-flex align-items-start gap-3">
                    <i class="bi <?= $icon ?> text-danger mt-1"></i>
                    <div>
                        <p class="mb-1"><strong><?= $n['title'] ?></strong> - <?= $n['desc'] ?></p>
                        <span class="time"><?= $n['time'] ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted py-4">No notifications found.</p>
        <?php endif; ?>
    </div>

</div>

<?php include 'admin_footer.php'; ?>