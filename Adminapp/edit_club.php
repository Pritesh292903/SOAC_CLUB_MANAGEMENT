<?php
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;

$query = "SELECT * FROM clubs WHERE id='$id'";
$result = mysqli_query($con, $query);
$club = mysqli_fetch_assoc($result);

$faculty_query = "SELECT id, name FROM Faculty_register WHERE role='faculty'";
$faculty_result = mysqli_query($con, $faculty_query);

if (isset($_POST['update'])) {

    $clubname = trim($_POST['clubname']);
    $faculty_id = intval($_POST['faculty']);
    $totalmembers = intval($_POST['totalmembers']);
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);
    $club_paid = trim($_POST['club_paid']);

    $getFaculty = mysqli_query($con, "SELECT name FROM Faculty_register WHERE id='$faculty_id'");
    $fdata = mysqli_fetch_assoc($getFaculty);
    $faculty_name = $fdata['name'];

    if (!empty($_FILES['clubimage']['name'])) {
        $filename = time() . "_" . $_FILES['clubimage']['name'];
        move_uploaded_file($_FILES['clubimage']['tmp_name'], "uploads/" . $filename);

        $update = "UPDATE clubs SET 
            clubimage='$filename',
            clubname='$clubname',
            faculty_id='$faculty_id',
            faculty='$faculty_name',
            totalmembers='$totalmembers',
            status='$status',
            clubdescription='$description',
            club_paid='$club_paid'
            WHERE id='$id'";
    } else {
        $update = "UPDATE clubs SET 
            clubname='$clubname',
            faculty_id='$faculty_id',
            faculty='$faculty_name',
            totalmembers='$totalmembers',
            status='$status',
            clubdescription='$description',
            club_paid='$club_paid'
            WHERE id='$id'";
    }

    if (mysqli_query($con, $update)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({title:'Updated!',icon:'success'})
        .then(()=>{window.location='all_clubes_page.php';});
        </script>";
    }
}
?>

<style>
html,body{
    height:100%;
    margin:0;
    background:#eef2f7;
    font-family:sans-serif;
    overflow:hidden;
}

/* MOBILE SCROLL FIX */
@media(max-width:768px){
    html,body{overflow:auto;}
}

.wrapper{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:10px;
}

.form-box{
    width:100%;
    max-width:900px;
    max-height:92vh;
    background:#fff;
    border-radius:20px;
    padding:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    overflow:auto;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.full{grid-column:1/-1;}

input, select, textarea{
    width:100%;
    padding:8px;
    border-radius:8px;
    border:1px solid #ccc;
}

label{
    font-size:0.8rem;
    font-weight:600;
}

.img-box{text-align:center;}
.img-box img{
    width:100px;
    height:100px;
    border-radius:10px;
    object-fit:cover;
}

button{
    padding:8px 20px;
    border:none;
    border-radius:20px;
    background:#e63946;
    color:#fff;
}

/* VALIDATION */
.input-success{border:2px solid #28a745 !important;}
.input-error{border:2px solid red !important;}
.error-text{color:red;font-size:0.8rem;}

@media(max-width:600px){
    .form-grid{grid-template-columns:1fr;}
}
</style>

<div class="wrapper">
<div class="form-box">

<h5 style="text-align:center;color:#e63946;">Edit Club</h5>

<form method="POST" enctype="multipart/form-data">

<div class="img-box full">
    <label>Club Image</label><br>
    <img src="uploads/<?php echo $club['clubimage']; ?>" id="preview"><br>
    <input type="file" name="clubimage" id="image">
</div>

<div class="form-grid">

<div>
<label>Club Name</label>
<input type="text" name="clubname" value="<?php echo $club['clubname']; ?>">
</div>

<div>
<label>Faculty</label>
<select name="faculty">
<option value="">Select</option>
<?php while($f=mysqli_fetch_assoc($faculty_result)){ ?>
<option value="<?php echo $f['id']; ?>" <?php if($club['faculty_id']==$f['id']) echo "selected"; ?>>
<?php echo $f['name']; ?>
</option>
<?php } ?>
</select>
</div>

<div>
<label>Members</label>
<input type="number" name="totalmembers" value="<?php echo $club['totalmembers']; ?>">
</div>

<div>
<label>Status</label>
<select name="status">
<option value="">Select</option>
<option value="Active" <?php if($club['status']=="Active") echo "selected"; ?>>Active</option>
<option value="Inactive" <?php if($club['status']=="Inactive") echo "selected"; ?>>Inactive</option>
</select>
</div>

<div>
<label>Club Type</label>
<select name="club_paid">
<option value="">Select</option>
<option value="Paid" <?php if($club['club_paid']=="Paid") echo "selected"; ?>>Paid</option>
<option value="Unpaid" <?php if($club['club_paid']=="Unpaid") echo "selected"; ?>>Unpaid</option>
</select>
</div>

<div class="full">
<label>Description</label>
<textarea name="description" rows="2"><?php echo $club['clubdescription']; ?></textarea>
</div>

</div>

<div style="text-align:center;margin-top:10px;">
<button type="submit" name="update">Update</button>
</div>

</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// IMAGE PREVIEW
$("#image").change(function(){
    let reader=new FileReader();
    reader.onload=e=>$("#preview").attr("src",e.target.result);
    reader.readAsDataURL(this.files[0]);
});

// VALIDATION
$(document).ready(function(){

$("input, select, textarea").not("#image").on("input change", function(){
    if($(this).val().trim() !== ""){
        $(this).removeClass("input-error").addClass("input-success");
        $(this).next(".error-text").remove();
    }
});

$("form").submit(function(e){

    let valid=true;
    $(".error-text").remove();
    $("input, select, textarea").removeClass("input-error");

    function showError(el,msg){
        el.addClass("input-error");
        if(el.next(".error-text").length===0){
            el.after("<div class='error-text'>"+msg+"</div>");
        }
        valid=false;
    }

    let clubname=$("input[name='clubname']");
    let faculty=$("select[name='faculty']");
    let members=$("input[name='totalmembers']");
    let status=$("select[name='status']");
    let type=$("select[name='club_paid']");
    let desc=$("textarea[name='description']");

    if(clubname.val().trim()==="") showError(clubname,"Enter club name");
    if(faculty.val()==="") showError(faculty,"Select faculty");
    if(members.val()==="" || members.val()<=0) showError(members,"Enter valid members");
    if(status.val()==="") showError(status,"Select status");
    if(type.val()==="") showError(type,"Select club type");
    if(desc.val().trim()==="") showError(desc,"Enter description");

    if(!valid){ e.preventDefault(); }

});

});
</script>

<?php include 'admin_footer.php'; ?>