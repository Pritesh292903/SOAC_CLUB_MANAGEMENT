<?php 
include 'admin_header.php';
?>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

/* Animation */
.content{
animation:fadeIn .6s ease-in-out;
}
@keyframes fadeIn{
from{opacity:0;transform:translateY(15px);}
to{opacity:1;transform:translateY(0);}
}

/* Card */
.custom-card{
border:none;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.05);
background:#fff;
}

/* Header */
.page-header{
background:#fff;
border-radius:15px;
padding:20px;
box-shadow:0 8px 25px rgba(0,0,0,0.05);
}

/* Image */
.club-img{
width:150px;
height:150px;
object-fit:cover;
border-radius:12px;
box-shadow:0 8px 25px rgba(0,0,0,0.05);
margin-bottom:15px;
}

/* Buttons */
.btn-effect{
border-radius:50px;
transition:.3s;
}
.btn-effect:hover{
transform:translateY(-2px);
}

</style>

<div class="content">

<div class="page-header d-flex justify-content-between align-items-center mb-4">

<div>
<h4 class="fw-bold text-danger mb-0">Add Club</h4>
<small class="text-muted">Create new student club</small>
</div>

<a href="all_clubes_page.php" class="btn btn-outline-danger btn-effect">
Back to Clubs
</a>

</div>


<div class="card custom-card p-4">

<form method="POST" enctype="multipart/form-data" id="addClubForm">
<label class="form-label">Choose image for club</label>
<div class="text-center">

<img src="https://via.placeholder.com/150?text=Club+Image"
class="club-img"
id="clubImagePreview">
<br>
<input type="file" class="form-control mt-2"
id="clubImage"
name="clubImage"
accept="image/*">

</div>


<div class="row g-3 mt-2">

<div class="col-md-6">
<label class="form-label">Club Name *</label>
<input type="text" class="form-control" name="clubName" required>
</div>

<div class="col-md-6">
<label class="form-label">Conducted by *</label>
<input type="text" class="form-control" name="president" required>
</div>

<div class="col-md-6">
<label class="form-label">Total Members *</label>
<input type="number" class="form-control" name="totalMembers" required>
</div>

<div class="col-md-6">
<label class="form-label">Status *</label>
<select class="form-select" name="status" required>
<option value="">Select status</option>
<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
</select>
</div>


<!-- Faculty Dropdown -->
<div class="col-md-6">

<label class="form-label">Assign Faculty *</label>

<select class="form-select" name="faculty" required>

<option value="">Select Faculty</option>

<option value=" 1">Dr. Smith - Computer Science</option>
</select>

</div>


<div class="col-12">
<label class="form-label">Description *</label>
<textarea class="form-control" rows="4" name="description" required></textarea>
</div>

</div>


<div class="mt-4 text-center">

<button type="submit" name="submit" class="btn btn-danger btn-effect">
Create Club
</button>

<a href="all_clubes_page.php" class="btn btn-outline-danger btn-effect">
Cancel
</a>

</div>

</form>

</div>

</div>


<!-- Image Preview Script -->
<script>

$("#clubImage").change(function(){

var reader=new FileReader();

reader.onload=function(e)
{
$("#clubImagePreview").attr("src",e.target.result);
}

reader.readAsDataURL(this.files[0]);

});

</script>


<?php

if(isset($_POST['submit']))
{

$clubName=$_POST['clubName'];
$president=$_POST['president'];
$totalMembers=$_POST['totalMembers'];
$status=$_POST['status'];
$faculty=$_POST['faculty'];
$description=$_POST['description'];

$image=$_FILES['clubImage']['name'];
$tmp=$_FILES['clubImage']['tmp_name'];

move_uploaded_file($tmp,"uploads/".$image);


$query="INSERT INTO clubs
(club_name,president,total_members,status,faculty_id,description,image)
VALUES
('$clubName','$president','$totalMembers','$status','$faculty','$description','$image')";

$result=mysqli_query($con,$query);

if($result)
{
?>

<script>
Swal.fire({
icon:'success',
title:'Club Added Successfully'
}).then(()=>{
window.location='all_clubes_page.php';
});
</script>

<?php
}
else
{
?>

<script>
Swal.fire('Error','Database Error','error');
</script>

<?php
}

}

?>

<?php include 'admin_footer.php'; ?>