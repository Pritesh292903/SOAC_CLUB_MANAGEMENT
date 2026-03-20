<?php include 'F_header.php'; ?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

/* Background */
.password-wrapper{
    min-height: calc(100vh - 140px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 15px;
    background:linear-gradient(135deg,#ffe5e5,#ffffff);
}

/* Animated Card */
.password-card{
    width:420px;
    background:#ffffff;
    padding:35px 30px;
    border-radius:22px;
    box-shadow:0 20px 50px rgba(0,0,0,0.15);
    animation: fadeSlide 0.6s ease;
    transition:0.3s;
}

.password-card:hover{
    transform:translateY(-5px);
    box-shadow:0 25px 60px rgba(0,0,0,0.2);
}

@keyframes fadeSlide{
    from{opacity:0; transform:translateY(40px);}
    to{opacity:1; transform:translateY(0);}
}

.password-card h3{
    font-weight:700;
    margin-bottom:30px;
    color:#dc3545;
    text-align:center;
}

/* Floating Inputs */
.form-floating > .form-control{
    border-radius:12px;
}

.form-control:focus{
    border-color:#dc3545;
    box-shadow:0 0 12px rgba(220,53,69,0.3);
}

/* Button */
.btn-save{
    width:100%;
    padding:12px;
    border-radius:30px;
    font-weight:600;
    background:linear-gradient(120deg,#dc3545,#b02a37);
    color:#fff;
    border:none;
    transition:0.3s;
}

.btn-save:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(220,53,69,0.4);
}

/* Responsive */
@media(max-width:450px){
    .password-card{
        width:100%;
        padding:25px 20px;
    }
}

</style>

<div class="password-wrapper">

    <div class="password-card">

        <h3>Change Password</h3>

        <form class="needs-validation" id="passwordForm" novalidate>

            <!-- Current Password -->
            <div class="form-floating mb-3">
                <input type="password"
                       class="form-control"
                       id="current"
                       placeholder="Current Password"
                       required>
                <label>Current Password</label>
                <div class="invalid-feedback">
                    Please enter your current password.
                </div>
            </div>

            <!-- New Password -->
            <div class="form-floating mb-3">
                <input type="password"
                       class="form-control"
                       id="newpass"
                       placeholder="New Password"
                       minlength="6"
                       required>
                <label>New Password</label>
                <div class="invalid-feedback">
                    Password must be at least 6 characters.
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-floating mb-4">
                <input type="password"
                       class="form-control"
                       id="confirmpass"
                       placeholder="Confirm Password"
                       required>
                <label>Confirm Password</label>
                <div class="invalid-feedback">
                    Passwords must match.
                </div>
            </div>

            <button type="submit" class="btn btn-save">
                Update Password
            </button>

        </form>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
(() => {
    'use strict'

    const form = document.getElementById('passwordForm');

    form.addEventListener('submit', function (event) {

        const newpass = document.getElementById('newpass');
        const confirm = document.getElementById('confirmpass');

        confirm.setCustomValidity("");

        // Check password match
        if (newpass.value !== confirm.value) {
            confirm.setCustomValidity("Passwords do not match");
        }

        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } 
        else {
            event.preventDefault();

            // SweetAlert Success Popup
            Swal.fire({
                title: "Password Changed!",
                text: "Your password has been updated successfully.",
                icon: "success",
                confirmButtonColor: "#dc3545",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../Studentapp/login_view.php";
                }
            });
        }

        form.classList.add('was-validated');

    }, false);
})();
</script>

<?php include 'F_footer.php'; ?>