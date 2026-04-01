<?php 
include 'F_header.php';
include '../database.php';

// INSERT LOGIC
if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($con, $_POST['eventName']);
    $club = mysqli_real_escape_string($con, $_POST['clubName']);
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $desc = mysqli_real_escape_string($con, $_POST['eventDescription']);
    $members = $_POST['clubMembers'];

    // VALIDATION
    if(empty($name) || empty($club) || empty($date) || empty($status) || empty($desc) || empty($members)){
        echo "<script>alert('All fields are required');</script>";
    } else {

        // ================= IMAGE UPLOAD =================
        $db_path = "";

        if(isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == 0){

            $img_name = $_FILES['eventImage']['name'];
            $tmp = $_FILES['eventImage']['tmp_name'];

            $ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

            // Allowed types
            $allowed = ['jpg','jpeg','png','gif'];

            if(in_array($ext, $allowed)){

                $new_name = time() . "_" . rand(1000,9999) . "." . $ext;

                $upload_dir = "../uploads/";

                // Create folder if not exists
                if(!is_dir($upload_dir)){
                    mkdir($upload_dir, 0777, true);
                }

                $full_path = $upload_dir . $new_name;

                if(move_uploaded_file($tmp, $full_path)){
                    $db_path = "uploads/" . $new_name;
                } else {
                    echo "<script>alert('Image Upload Failed');</script>";
                }

            } else {
                echo "<script>alert('Only JPG, JPEG, PNG, GIF allowed');</script>";
            }

        } else {
            echo "<script>alert('Please select an image');</script>";
        }

        // INSERT ONLY IF IMAGE UPLOADED
        if($db_path != ""){
            mysqli_query($con, "INSERT INTO manage_clubs 
            (club_name, Category, Status, Description, Club_member, Image)
            VALUES 
            ('$name','$club','$status','$desc','$members','$db_path')
            ");

            echo "<script>
                Swal.fire({
                    title: 'Event Created!',
                    text: 'Your event has been added successfully',
                    icon: 'success'
                }).then(() => {
                    window.location='Manage_events.php';
                });
            </script>";
        }
    }
}
?>

<div class="container my-5">

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            <h2 class="fw-bold text-danger mb-4">
                <i class="bi bi-calendar-plus me-2"></i>Add New Event
            </h2>

            <!-- ✅ FORM START (IMPORTANT FIX) -->
            <form id="addEventForm" method="POST" enctype="multipart/form-data">

            <div class="row">

                <!-- IMAGE -->
                <div class="col-md-4 text-center mb-4">
                    <label class="form-label fw-semibold">Event Image *</label>

                    <img src="https://via.placeholder.com/400x250?text=Preview"
                         id="eventImagePreview"
                         class="img-fluid rounded-4 shadow-sm"
                         style="height:220px; object-fit:cover;">
                    
                    <input type="file"
                           class="form-control mt-3"
                           id="eventImage"
                           name="eventImage"
                           accept="image/*"
                           required>
                </div>

                <!-- FORM FIELDS -->
                <div class="col-md-8">

                    <div class="mb-3">
                        <label class="form-label">Event Name *</label>
                        <input type="text" class="form-control" name="eventName" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Club Name *</label>
                        <select class="form-select" name="clubName" required>
                            <option value="">Select Club</option>
                            <?php
                            $clubs = mysqli_query($con, "SELECT DISTINCT Category FROM manage_clubs");
                            while($c = mysqli_fetch_assoc($clubs)){
                                echo "<option>".$c['Category']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Club Members *</label>
                        <input type="number" class="form-control" name="clubMembers" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date *</label>
                        <input type="date" class="form-control" name="eventDate" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-select" name="eventStatus" required>
                            <option value="">Select</option>
                            <option>Active</option>
                            <option>Upcoming</option>
                            <option>Closed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea class="form-control" name="eventDescription" required></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-danger">
                        Save Event
                    </button>

                </div>

            </div>

            </form>
            <!-- ✅ FORM END -->

        </div>
    </div>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// IMAGE PREVIEW
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