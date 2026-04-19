<?php 
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;

// FETCH EVENT DATA
$result = mysqli_query($con, "SELECT * FROM events WHERE id='$id'");
$data = mysqli_fetch_assoc($result);

$name = $data['name'] ?? '';
$date = $data['date'] ?? '';
$status = $data['status'] ?? '';
$description = $data['description'] ?? '';
$event_type = $data['event_type'] ?? '';
$image = !empty($data['image']) ? $data['image'] : 'default.png';

// UPDATE EVENT
if(isset($_POST['update']))
{
    $name = trim($_POST['eventName']);
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $description = trim($_POST['eventDescription']);
    $event_type = $_POST['eventType'];

    // IMAGE UPDATE
    if(!empty($_FILES['eventImage']['name'])){
        $image = time() . "_" . $_FILES['eventImage']['name'];
        move_uploaded_file($_FILES['eventImage']['tmp_name'], "../uploads/".$image);

        $sql = "UPDATE events SET 
                name='$name',
                date='$date',
                status='$status',
                description='$description',
                event_type='$event_type',
                image='$image'
                WHERE id='$id'";
    } else {
        $sql = "UPDATE events SET 
                name='$name',
                date='$date',
                status='$status',
                description='$description',
                event_type='$event_type'
                WHERE id='$id'";
    }

    mysqli_query($con, $sql);

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({title:'Updated!',icon:'success'})
    .then(()=>{window.location='all_events_page.php';});
    </script>";
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

/* BUTTON */
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

<h5 style="text-align:center;color:#e63946;">Edit Event</h5>

<form method="POST" enctype="multipart/form-data">

<!-- IMAGE -->
<div class="img-box full">
    <label>Event Image</label><br>
    <img src="../uploads/<?php echo $image; ?>" id="preview"><br>
    <input type="file" name="eventImage" id="image">
</div>

<div class="form-grid">

<!-- NAME -->
<div>
<label>Event Name</label>
<input type="text" name="eventName" value="<?php echo $name; ?>">
</div>

<!-- DATE -->
<div>
<label>Date</label>
<input type="date" name="eventDate" value="<?php echo $date; ?>">
</div>

<!-- STATUS -->
<div>
<label>Status</label>
<select name="eventStatus">
<option value="">Select</option>
<option value="Active" <?php if($status=="Active") echo "selected"; ?>>Active</option>
<option value="Upcoming" <?php if($status=="Upcoming") echo "selected"; ?>>Upcoming</option>
<option value="Closed" <?php if($status=="Closed") echo "selected"; ?>>Closed</option>
</select>
</div>

<!-- EVENT TYPE -->
<div>
<label>Event Type</label>
<select name="eventType">
<option value="">Select</option>
<option value="Paid" <?php if($event_type=="Paid") echo "selected"; ?>>Paid</option>
<option value="Unpaid" <?php if($event_type=="Unpaid") echo "selected"; ?>>Unpaid</option>
</select>
</div>

<!-- DESCRIPTION -->
<div class="full">
<label>Description</label>
<textarea name="eventDescription" rows="2"><?php echo htmlspecialchars($description); ?></textarea>
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
    if(this.files && this.files[0]){
        let reader=new FileReader();
        reader.onload=function(e){
            $("#preview").attr("src", e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

// LIVE VALIDATION (IGNORE IMAGE)
$("input, select, textarea").not("#image").on("input change", function(){
    if($(this).val().trim() !== ""){
        $(this).removeClass("input-error").addClass("input-success");
        $(this).next(".error-text").remove();
    }
});

// FORM VALIDATION
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

    let name=$("input[name='eventName']");
    let date=$("input[name='eventDate']");
    let status=$("select[name='eventStatus']");
    let type=$("select[name='eventType']");
    let desc=$("textarea[name='eventDescription']");

    if(name.val().trim()==="") showError(name,"Enter event name");
    if(date.val()==="") showError(date,"Select date");
    if(status.val()==="") showError(status,"Select status");
    if(type.val()==="") showError(type,"Select event type");
    if(desc.val().trim()==="") showError(desc,"Enter description");

    if(!valid){ e.preventDefault(); }

});
</script>

<?php include 'admin_footer.php'; ?>