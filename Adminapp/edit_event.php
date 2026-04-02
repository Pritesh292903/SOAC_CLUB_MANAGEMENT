<?php
include 'admin_header.php';
include '../database.php';

$id = $_GET['id'] ?? 0;
$res = mysqli_query($con, "SELECT * FROM events WHERE id='$id'");
$event = mysqli_fetch_assoc($res);

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    
    $image = $event['image'];
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $imgName = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$imgName);
        $image = $imgName;
    }

    $stmt = mysqli_prepare($con, "UPDATE events SET name=?, date=?, status=?, image=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $date, $status, $image, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<script>
            alert('Event updated successfully');
            window.location.href='all_events_page.php';
          </script>";
}
?>

<div class="content p-4">
    <h4 class="text-danger">Edit Event</h4>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="<?= $event['name']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" value="<?= $event['date']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Active" <?= $event['status']=='Active'?'selected':''; ?>>Active</option>
                <option value="Closed" <?= $event['status']=='Closed'?'selected':''; ?>>Closed</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Image (Optional)</label>
            <input type="file" name="image" class="form-control">
            <img src="../uploads/<?= $event['image'] ?: 'default.png'; ?>" style="width:100px; margin-top:10px;">
        </div>
        <button type="submit" name="submit" class="btn btn-danger">Save Changes</button>
        <a href="all_events_page.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'admin_footer.php'; ?>