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
$image = !empty($data['image']) ? $data['image'] : 'default.png';


// UPDATE EVENT
if(isset($_POST['update']))
{
    $name = $_POST['eventName'];
    $date = $_POST['eventDate'];
    $status = $_POST['eventStatus'];
    $description = $_POST['eventDescription'];

    // IMAGE UPDATE (optional)
    if(!empty($_FILES['eventImage']['name'])){
        $image = $_FILES['eventImage']['name'];
        move_uploaded_file($_FILES['eventImage']['tmp_name'], "../uploads/".$image);

        $sql = "UPDATE events SET 
                name='$name',
                date='$date',
                status='$status',
                description='$description',
                image='$image'
                WHERE id='$id'";
    } else {
        $sql = "UPDATE events SET 
                name='$name',
                date='$date',
                status='$status',
                description='$description'
                WHERE id='$id'";
    }

    mysqli_query($con, $sql);

    echo "<script>
        alert('Event Updated Successfully');
        window.location='all_events_page.php';
    </script>";
}
?>

<style>
.content { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn {
    from { opacity:0; transform:translateY(15px);}
    to { opacity:1; transform:translateY(0);}
}
.card { border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05);}
.event-img {
    width:100%;
    max-height:250px;
    object-fit:cover;
    border-radius:10px;
    margin-bottom:10px;
}
</style>

<div class="content">

    <h4 class="text-danger mb-3">Edit Event</h4>

    <div class="card p-4">
        <form method="POST" enctype="multipart/form-data">

            <!-- IMAGE -->
            <div class="text-center mb-3">
                <img src="../uploads/<?php echo $image; ?>" class="event-img">
                <input type="file" name="eventImage" class="form-control mt-2">
            </div>

            <!-- NAME -->
            <div class="mb-3">
                <label>Event Name</label>
                <input type="text" name="eventName" class="form-control" value="<?= $name; ?>" required>
            </div>

            <!-- DATE -->
            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="eventDate" class="form-control" value="<?= $date; ?>" required>
            </div>

            <!-- STATUS -->
            <div class="mb-3">
                <label>Status</label>
                <select name="eventStatus" class="form-control">
                    <option <?= ($status=='Active')?'selected':''; ?>>Active</option>
                    <option <?= ($status=='Upcoming')?'selected':''; ?>>Upcoming</option>
                    <option <?= ($status=='Closed')?'selected':''; ?>>Closed</option>
                </select>
            </div>

            <!-- ✅ DESCRIPTION FIELD (FIXED PROPERLY) -->
            <div class="mb-3">
                <label>Description</label>
                <textarea name="eventDescription" class="form-control" rows="4" required><?= htmlspecialchars($description); ?></textarea>
            </div>

            <!-- BUTTON -->
            <button type="submit" name="update" class="btn btn-danger">Update Event</button>

        </form>
    </div>

</div>

<?php include 'admin_footer.php'; ?>