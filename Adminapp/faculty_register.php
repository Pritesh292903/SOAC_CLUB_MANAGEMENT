<?php include 'admin_header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

.content{
    animation: fadeIn 0.5s ease-in-out;
}
@keyframes fadeIn{
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}

.page-header{
    background:#fff;
    padding:20px 25px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    margin-bottom:25px;
}
.page-header h4{
    color:#dc3545;
}

.register-card{
    background:#fff;
    padding:35px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.form-group label{
    font-weight:600;
    margin-bottom:6px;
}

.form-control{
    border-radius:10px;
    padding:10px 12px;
    transition:0.3s;
}

.form-control:focus{
    border-color:#dc3545;
    box-shadow:none;
}

.btn-register{
    background:#dc3545;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:10px;
    font-weight:600;
}

.btn-register:hover{
    background:#c82333;
}

.full-width{
    grid-column:span 2;
}

.image-preview{
    width:120px;
    height:120px;
    border-radius:10px;
    object-fit:cover;
    border:2px solid #dc3545;
    margin-top:10px;
    display:none;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
    .full-width{
        grid-column:span 1;
    }
}

</style>

<div class="content">

    <div class="page-header">
        <h4 class="fw-bold mb-0">Faculty Registration</h4>
        <small class="text-muted">Add new faculty member</small>
    </div>

    <div class="register-card">

        <form id="facultyForm" enctype="multipart/form-data">

            <div class="form-grid">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control" name="mobile">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text" class="form-control" name="department">
                </div>

                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" class="form-control" name="designation">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group full-width">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword">
                </div>

                <div class="form-group full-width">
                    <label>Faculty Image</label>
                    <input type="file" class="form-control" name="faculty_image" id="faculty_image" accept="image/*">
                    <img id="previewImage" class="image-preview">
                </div>

                <div class="form-group full-width">
                    <button type="submit" class="btn-register w-100">
                        Register Faculty
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>



<?php include 'admin_footer.php'; ?>