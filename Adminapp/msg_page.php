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

/* ===== MESSAGE CARD ===== */
.message-card{
    background:#fff;
    border-radius:15px;
    padding:20px;
    margin-bottom:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    transition:0.3s ease;
    cursor:pointer;
}

.message-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

.message-card.unread{
    border-left:4px solid #dc3545;
    background:#fff5f5;
}

/* MESSAGE HEADER */
.message-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:5px;
}

.message-header h5{
    margin:0;
    font-weight:600;
    color:#dc3545;
}

.message-time{
    font-size:12px;
    color:#999;
}

/* MESSAGE BODY */
.message-body{
    color:#555;
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
        <h3><i class="bi bi-envelope-fill me-2"></i>Messages</h3>
    </div>

    <!-- Messages List -->
    <div class="messages-list">

        <div class="message-card unread">
            <div class="message-header">
                <h5>Marmik Kalariya</h5>
                <span class="message-time">2 mins ago</span>
            </div>
            <div class="message-body">
                Hi Admin, I wanted to ask about the upcoming Tech Club event schedule...
            </div>
        </div>

        <div class="message-card">
            <div class="message-header">
                <h5>Yashgiri Gauswami</h5>
                <span class="message-time">30 mins ago</span>
            </div>
            <div class="message-body">
                Please review the new member registrations for the Sports Club.
            </div>
        </div>

        <div class="message-card unread">
            <div class="message-header">
                <h5>Pritesh B</h5>
                <span class="message-time">1 hour ago</span>
            </div>
            <div class="message-body">
                The system update was successful, but I noticed a small glitch in the dashboard charts.
            </div>
        </div>

        <div class="message-card">
            <div class="message-header">
                <h5>Aaryan Patel</h5>
                <span class="message-time">Yesterday</span>
            </div>
            <div class="message-body">
                Reminder: Please submit the event report for the Art Club meeting.
            </div>
        </div>

    </div>

</div>