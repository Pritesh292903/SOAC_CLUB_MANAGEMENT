<?php include 'header.php'; ?>

<style>
html, body {
  height: 100%;
}

.profile-wrapper {
  height: calc(100vh - 110px);
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-card {
  background: #fff;
  width: 100%;
  max-width: 420px;
  padding: 30px;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  text-align: center;
}

.avatar-img {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #fff;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  margin-bottom: 20px;
}

.form-control {
  border-radius: 10px;
  padding: 10px;
  margin-bottom: 15px;
}

.btn-group-custom {
  display: flex;
  gap: 10px;
  margin-top: 15px;
}

.btn-custom {
  flex: 1;
  padding: 10px;
  border-radius: 10px;
  font-weight: 600;
  text-decoration: none;
  text-align: center;
  color: #fff;
  background: linear-gradient(120deg, #9b0000, #d90429);
  transition: 0.3s;
}

.btn-custom:hover {
  opacity: 0.9;
}

@media (max-width: 480px) {
  .btn-group-custom {
    flex-direction: column;
  }
}
</style>

<div class="profile-wrapper">
  <div class="profile-card">

    <img src="assets/images/user.jpg" class="avatar-img">

    <div class="mb-3">
      <input type="text" class="form-control"
        value="Marmik Kalariya" readonly>
    </div>

    <div class="mb-3">
      <input type="email" class="form-control"
        value="marmik.kalariya@rku.ac.in" readonly>
    </div>

    <!-- Buttons -->
    <div class="btn-group-custom">
      <a href="edit_profile.php" class="btn-custom">
        <i class="bi bi-pencil-square me-1"></i> Edit
      </a>

      <a href="change_password.php" class="btn-custom">
        <i class="bi bi-key-fill me-1"></i> Change Password
      </a>

      <a href="logout.php" class="btn-custom">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>

  </div>
</div>

<?php include 'footer.php'; ?>