<?php
include 'admin_header.php';
include '../database.php';
?>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    .content { animation: fadeIn .6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .custom-card { border:none; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05); background:#fff; }
    .page-header { background:#fff; border-radius:15px; padding:20px; box-shadow:0 8px 25px rgba(0,0,0,0.05); }
    .club-img { width:150px; height:150px; object-fit:cover; border-radius:12px; box-shadow:0 8px 25px rgba(0,0,0,0.05); margin-bottom:15px; }
    .btn-effect { border-radius:50px; transition:.3s; }
    .btn-effect:hover { transform:translateY(-2px); }
    .form-label { font-weight:600; }
</style>

<div class="content">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-danger mb-0">Add Club</h4>
            <small class="text-muted">Create new student club</small>
        </div>
        <a href="all_clubes_page.php" class="btn btn-outline-danger btn-effect">Back to Clubs</a>
    </div>

    <div class="card custom-card p-4">
        <form method="POST" enctype="multipart/form-data" id="addClubForm">

            <label class="form-label">Choose image for club</label>
            <div class="text-center">
                <img src="https://via.placeholder.com/150?text=Club+Image" class="club-img" id="clubImagePreview">
                <br>
                <input type="file" class="form-control mt-2" id="clubImage" name="clubImage" accept="image/*">
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="form-label">Club Name *</label>
                    <input type="text" class="form-control" name="clubName" id="clubName">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Assign Faculty *</label>
                    <select class="form-select" name="faculty" id="faculty">
                        <option value="">Select Faculty</option>
                        <?php
                        $q = mysqli_query($con, "SELECT * FROM faculty_register");
                        while ($row = mysqli_fetch_assoc($q)) {
                            echo "<option value='".$row['id']."'>".$row['name']." - ".$row['department']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Total Members *</label>
                    <input type="number" class="form-control" name="totalMembers" id="totalMembers">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="status" id="status">
                        <option value="">Select status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description *</label>
                    <textarea class="form-control" rows="4" name="description" id="description"></textarea>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" name="submit" class="btn btn-danger btn-effect">Create Club</button>
            </div>
        </form>
    </div>
</div>

<!-- Image Preview -->
<script>
$("#clubImage").change(function(){
    let reader = new FileReader();
    reader.onload = function(e){
        $("#clubImagePreview").attr("src", e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
});
</script>

<!-- jQuery Validation -->
<script>
$("#addClubForm").submit(function(e){
    let name = $("#clubName").val();
    let faculty = $("#faculty").val();
    let members = $("#totalMembers").val();
    let status = $("#status").val();
    let desc = $("#description").val();

    if(name=="" || faculty=="" || members=="" || status=="" || desc==""){
        e.preventDefault();
        Swal.fire({ icon:'warning', title:'All fields are required!' });
    }
});
</script>

<?php
if(isset($_POST['submit'])){
    $clubName = mysqli_real_escape_string($con,$_POST['clubName']);
    $totalMembers = mysqli_real_escape_string($con,$_POST['totalMembers']);
    $status = mysqli_real_escape_string($con,$_POST['status']);
    $faculty = mysqli_real_escape_string($con,$_POST['faculty']);
    $description = mysqli_real_escape_string($con,$_POST['description']);

    $image = $_FILES['clubImage']['name'];
    $tmp = $_FILES['clubImage']['tmp_name'];

    if(!is_dir("uploads")){ mkdir("uploads",0777,true); }
    move_uploaded_file($tmp,"uploads/".$image);

    $query = "INSERT INTO student_clubs (clubimage, clubname, faculty_id, totalmembers, status, description)
              VALUES ('$image','$clubName','$faculty','$totalMembers','$status','$description')";

    $result = mysqli_query($con,$query);

    if($result){
        echo "<script>
            Swal.fire({ icon:'success', title:'Club Added Successfully' })
            .then(()=>{ window.location='all_clubes_page.php'; });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Error','".mysqli_error($con)."','error');
        </script>";
    }
}
?>

<?php include 'admin_footer.php'; ?>