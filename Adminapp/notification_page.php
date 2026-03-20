<?php include 'admin_header.php'; ?>

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
    </div>

    <!-- Notifications List -->
    <div class="notifications-list">

        <div class="notification-card unread d-flex align-items-start gap-3">
            <i class="bi bi-envelope-fill text-danger mt-1"></i>
            <div>
                <p class="mb-1"><strong>New Message</strong> from Marmik Kalariya</p>
                <span class="time">2 minutes ago</span>
            </div>
        </div>

        <div class="notification-card d-flex align-items-start gap-3">
            <i class="bi bi-calendar-event-fill text-danger mt-1"></i>
            <div>
                <p class="mb-1"><strong>Event Reminder:</strong> Tech Club Meeting</p>
                <span class="time">30 minutes ago</span>
            </div>
        </div>

        <div class="notification-card unread d-flex align-items-start gap-3">
            <i class="bi bi-person-fill text-danger mt-1"></i>
            <div>
                <p class="mb-1"><strong>New User Registered:</strong> yashgirir Gauswami</p>
                <span class="time">1 hour ago</span>
            </div>
        </div>

        <div class="notification-card d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill text-danger mt-1"></i>
            <div>
                <p class="mb-1">System update completed successfully</p>
                <span class="time">Yesterday</span>
            </div>
        </div>

        <div class="notification-card d-flex align-items-start gap-3">
            <i class="bi bi-info-circle-fill text-danger mt-1"></i>
            <div>
                <p class="mb-1">Your profile has been updated</p>
                <span class="time">2 days ago</span>
            </div>
        </div>

    </div>

</div>