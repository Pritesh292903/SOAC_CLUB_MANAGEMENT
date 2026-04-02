<?php
include 'admin_header.php';
include '../database.php';

// GET CLUB ID
$id = $_GET['id'] ?? 0;

// FETCH CLUB DATA
$query = "SELECT * FROM clubs WHERE id='$id'";
$result = mysqli_query($con, $query);
$club = mysqli_fetch_assoc($result);

// FETCH FACULTY DATA
$faculty_query = "SELECT id, name FROM Faculty_register WHERE role='faculty'";
$faculty_result = mysqli_query($con, $faculty_query);

// UPDATE CLUB
if (isset($_POST['update'])) {
    $clubname = trim($_POST['clubname']);
    $faculty = trim($_POST['faculty']);
    $totalmembers = isset($_POST['totalmembers']) && $_POST['totalmembers'] !== "" ? intval($_POST['totalmembers']) : 0;
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);

    // IMAGE UPDATE (optional)
    if (!empty($_FILES['clubimage']['name'])) {
        $filename = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['clubimage']['name']);
        $tempname = $_FILES['clubimage']['tmp_name'];
        move_uploaded_file($tempname, "uploads/" . $filename);
    } else {
        $filename = $club['clubimage']; // keep old image
    }

    $update = "UPDATE clubs SET 
        clubimage='$filename',
        clubname='$clubname',
        faculty='$faculty',
        totalmembers='$totalmembers',
        status='$status',
        clubdescription='$description'
        WHERE id='$id'";

    if (mysqli_query($con, $update)) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Success!',
            html: '<img src=\"uploads/$filename\" style=\"width:100px;height:100px;object-fit:cover;border-radius:12px;\"><br><strong>$clubname</strong><br>Club updated successfully!',
            icon: 'success',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'all_clubes_page.php';
        });
        </script>
        ";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(15px);} to {opacity:1; transform:translateY(0);} }
.club-img { width:150px; height:150px; object-fit:cover; border-radius:12px; margin-bottom:15px; }
.form-label { font-weight:600; }
.is-invalid { border-color:#dc3545 !important; }
.invalid-feedback { color:#dc3545; font-size:0.85rem; }
.btn-effect { border-radius:50px; transition:0.3s; }
.btn-effect:hover { transform:translateY(-2px); }
</style>

<div class="content">
    <div class="page-header mb-4">
        <h4 class="text-danger">Edit Club</h4>
        <small class="text-muted">Update club details and assign faculty</small>
    </div>

    <div class="card p-4">
        <form method="POST" enctype="multipart/form-data" id="editForm">

            <!-- CLUB IMAGE -->
            <div class="text-center mb-3">
                <label class="form-label">Club Image</label><br>
                <img src="uploads/<?php echo $club['clubimage']; ?>" class="club-img" id="preview">
                <input type="file" name="clubimage" id="image" class="form-control mt-2" accept="image/*">
                <small class="text-muted">Optional: JPG, PNG, GIF (Max 5MB)</small>
            </div>

            <div class="row g-3">
                <!-- CLUB NAME -->
                <div class="col-md-6">
                    <label class="form-label">Club Name <span class="text-danger">*</span></label>
                    <input type="text" name="clubname" class="form-control" value="<?php echo htmlspecialchars($club['clubname']); ?>" required>
                    <div class="invalid-feedback">Please enter club name</div>
                </div>

                <!-- FACULTY -->
                <div class="col-md-6">
                    <label class="form-label">Assign Faculty <span class="text-danger">*</span></label>
                    <select name="faculty" class="form-select" required>
                        <option value="">-- Select Faculty --</option>
                        <?php while ($f = mysqli_fetch_assoc($faculty_result)) { ?>
                            <option value="<?php echo htmlspecialchars($f['name']); ?>" <?php if ($club['faculty'] == $f['name']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($f['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">Please select faculty</div>
                </div>

                <!-- TOTAL MEMBERS -->
                <div class="col-md-6">
                    <label class="form-label">Total Members <span class="text-danger">*</span></label>
                    <input type="number" name="totalmembers" class="form-control" value="<?php echo $club['totalmembers']; ?>" min="1" required>
                    <div class="invalid-feedback">Please enter total members</div>
                </div>

                <!-- STATUS -->
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Select Status --</option>
                        <option value="Active" <?php if ($club['status'] == "Active") echo "selected"; ?>>Active</option>
                        <option value="Inactive" <?php if ($club['status'] == "Inactive") echo "selected"; ?>>Inactive</option>
                    </select>
                    <div class="invalid-feedback">Please select status</div>
                </div>

                <!-- DESCRIPTION -->
                <div class="col-12">
                    <label class="form-label">Club Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($club['clubdescription']); ?></textarea>
                    <div class="invalid-feedback">Please enter description</div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="mt-4 text-center">
                <button type="submit" name="update" class="btn btn-danger btn-effect">Update Club</button>
                <a href="all_clubes_page.php" class="btn btn-secondary btn-effect">Cancel</a>
            </div>

        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    // IMAGE PREVIEW ONLY
    $("#image").on("change", function () {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) { $("#preview").attr("src", e.target.result); }
            reader.readAsDataURL(file);
        } else {
            // Restore old image if no new file selected
            $("#preview").attr("src", "uploads/<?php echo $club['clubimage']; ?>");
        }
    });

    // REAL-TIME VALIDATION
    $("input, select, textarea").on("blur change", function() {
        let val = $(this).val().trim();
        if ($(this).attr("name") === "totalmembers") {
            if (val === "" || isNaN(val) || parseInt(val) < 1) {
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid");
            }
        } else {
            if (val === "") {
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid");
            }
        }
    });

    // FORM SUBMIT VALIDATION
    $("#editForm").on("submit", function(e) {
        let valid = true;

        $("input, select, textarea").each(function() {
            let val = $(this).val().trim();
            if ($(this).attr("name") === "totalmembers") {
                if (val === "" || isNaN(val) || parseInt(val) < 1) {
                    $(this).addClass("is-invalid"); valid = false;
                } else { $(this).removeClass("is-invalid"); }
            } else {
                if (val === "") { $(this).addClass("is-invalid"); valid = false; }
                else { $(this).removeClass("is-invalid"); }
            }
        });

        if (!valid) e.preventDefault();
    });

});
</script>

<?php include 'admin_footer.php'; ?>