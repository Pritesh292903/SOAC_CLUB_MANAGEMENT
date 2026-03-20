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

/* ===== SETTINGS CARD ===== */
.settings-card{
    background:#fff;
    border-radius:15px;
    padding:25px;
    margin-bottom:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    transition:0.3s ease;
}

.settings-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

.settings-card h5{
    color:#dc3545;
    font-weight:700;
}

.settings-card p{
    color:#555;
}

/* BUTTONS */
.settings-card .btn{
    border-radius:25px;
    padding:6px 25px;
}

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
        <h3><i class="bi bi-gear-fill me-2"></i>Settings</h3>
    </div>

    <div class="row">

        <!-- Profile Settings -->
        <div class="col-md-6">
            <div class="settings-card">
                <h5>Profile Settings</h5>
                <p>Update your profile info like name, email, and profile picture.</p>
                <a href="edit_profile.php" class="btn btn-outline-danger btn-sm">Edit Profile</a>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="settings-card">
                <h5>Change Password</h5>
                <p>Update your account password for security reasons.</p>
                <a href="changepassword.php" class="btn btn-outline-danger btn-sm">Change Password</a>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="col-md-6">
            <div class="settings-card">
                <h5>Notification Settings</h5>
                <p>Manage email and in-app notifications.</p>
                <a href="notification_page.php" class="btn btn-outline-danger btn-sm">Manage Notifications</a>
            </div>
        </div>


    </div>

</div>