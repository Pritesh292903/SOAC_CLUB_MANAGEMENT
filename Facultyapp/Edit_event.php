<?php 
include 'F_header.php';
include '../database.php';

// GET ID
if(!isset($_GET['id'])){
    header("Location: Manage_events.php");
    exit();
}

$id = $_GET['id'];

// FETCH DATA
$result = mysqli_query($con, "SELECT * FROM manage_clubs WHERE Club_id='$id'");
$data = mysqli_fetch_assoc($result);

// UPDATE LOGIC
if(isset($_POST['update'])){

    $name = $_POST['eventName'];
    $club = $_POST['eventClub'];
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $desc = $_POST['eventDescription'];

    // ===== IMAGE UPLOAD =====
    if(!empty($_FILES['eventImage']['name'])){

        $img_name = $_FILES['eventImage']['name'];
        $tmp = $_FILES['eventImage']['tmp_name'];

        // Create unique file name
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $new_name = time() . "_" . rand(1000,9999) . "." . $ext;

        $upload_dir = "../uploads/";

        // Create folder if not exists
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }

        $path = $upload_dir . $new_name;

        // Move file
        if(move_uploaded_file($tmp, $path)){
            // Save relative path in DB
            $db_path = "uploads/" . $new_name;
        } else {
            $db_path = $data['Image'];
        }

    } else {
        $db_path = $data['Image'];
    }

    // UPDATE QUERY
    mysqli_query($con, "UPDATE manage_clubs SET 
        club_name='$name',
        Description='$desc',
        Status='$status',
        Image='$db_path'
        WHERE Club_id='$id'
    ");

    echo "<script>
        alert('Updated Successfully');
        window.location='Manage_events.php';
    </script>";
}
?>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.input-error { border:1.5px solid #dc3545 !important; }
.event-img{
  width:100%;
  max-height:220px;
  object-fit:cover;
  border-radius:12px;
  margin-bottom:15px;
  box-shadow:0 8px 25px rgba(0,0,0,0.05);
}
</style>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="card shadow border-0 rounded-4 p-4">

        <h3 class="fw-bold text-danger mb-4 text-center">
          Edit Event
        </h3>

        <form id="editEventForm" method="POST" enctype="multipart/form-data">

          <!-- Image Preview -->
          <div class="text-center mb-3">
            <img src="../<?php echo $data['Image']; ?>"
                 id="eventImagePreview"
                 class="event-img">

            <label class="form-label fw-semibold">Edit Club Image *</label>
            <input type="file"
                   class="form-control mt-2"
                   id="eventImage"
                   name="eventImage"
                   accept="image/*">

                   
            <small class="text-muted">JPG, PNG or GIF (Max 5MB)</small>
          </div>

          <!-- Event Name -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Event Name *</label>
            <input type="text"
                   class="form-control"
                   name="eventName"
                   id="eventName"
                   value="<?php echo $data['club_name']; ?>">
          </div>

          <!-- Club -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Club *</label>
            <input type="text"
                   class="form-control"
                   name="eventClub"
                   id="eventClub"
                   value="<?php echo $data['Category']; ?>">
          </div>

          <!-- Date -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Event Date *</label>
            <input type="date"
                   class="form-control"
                   name="eventDate"
                   id="eventDate">
          </div>

          <!-- Status -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Status *</label>
            <select class="form-select"
                    name="eventStatus"
                    id="eventStatus">
              <option value="">Select Status</option>
              <option <?php if($data['Status']=="Active") echo "selected"; ?>>Active</option>
              <option <?php if($data['Status']=="Upcoming") echo "selected"; ?>>Upcoming</option>
              <option <?php if($data['Status']=="Closed") echo "selected"; ?>>Closed</option>
            </select>
          </div>

          <!-- Description -->
          <div class="mb-4">
            <label class="form-label fw-semibold">Description *</label>
            <textarea class="form-control"
                      name="eventDescription"
                      id="eventDescription"
                      rows="4"><?php echo $data['Description']; ?></textarea>
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-between">
            <a href="Manage_events.php"
               class="btn btn-secondary rounded-pill px-4">
              Cancel
            </a>

            <button type="submit"
                    name="update"
                    class="btn btn-danger rounded-pill px-4">
              Save Changes
            </button>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// Image Preview
$('#eventImage').change(function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            $('#eventImagePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php include 'F_footer.php'; ?>