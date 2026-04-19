<?php
include 'F_header.php';
include '../database.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location='manage_clube.php';</script>";
    exit();
}

$id = intval($_GET['id']);

$result = mysqli_query($con, "SELECT * FROM clubs WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>window.location='manage_clube.php';</script>";
    exit();
}

// UPDATE
if (isset($_POST['update'])) {

    $clubname = mysqli_real_escape_string($con, $_POST['clubname']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $members = intval($_POST['totalmembers']);
    $status = $_POST['status'];
    $club_paid = $_POST['club_paid'];

    $image = $row['clubimage'];

    if (!empty($_FILES['clubimage']['name'])) {

        $filename = time() . "_" . $_FILES['clubimage']['name'];
        $tmpname = $_FILES['clubimage']['tmp_name'];
        $uploadPath = "../Adminapp/uploads/" . $filename;

        if (move_uploaded_file($tmpname, $uploadPath)) {

            if (!empty($row['clubimage']) && file_exists("../Adminapp/uploads/" . $row['clubimage'])) {
                unlink("../Adminapp/uploads/" . $row['clubimage']);
            }

            $image = $filename;
        }
    }

    $updateQuery = "UPDATE clubs SET 
        clubname='$clubname',
        faculty='$faculty',
        totalmembers='$members',
        status='$status',
        club_paid='$club_paid',
        clubimage='$image'
        WHERE id='$id'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>
            alert('Club Updated Successfully');
            window.location.href='manage_clube.php';
        </script>";
        exit();
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f3f5f9;
    font-family:'Segoe UI',sans-serif;
}

/* MAIN CARD */
.wrapper{
    max-width: 1000px;
    margin: 50px auto;
    display: flex;
    flex-wrap: wrap;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

/* LEFT */
.left{
    flex:1;
    min-width: 300px;
    background: linear-gradient(135deg,#dc3545,#ff5e62);
    color:#fff;
    text-align:center;
    padding:40px;
}

.left img{
    width:140px;
    height:140px;
    border-radius:50%;
    border:4px solid #fff;
    object-fit:cover;
    margin-bottom:15px;
}

.left h4{
    font-weight:700;
}

.left p{
    font-size:14px;
    opacity:0.9;
    margin-bottom:5px;
}

/* RIGHT */
.right{
    flex:2;
    padding:40px;
}

.title{
    font-size:24px;
    font-weight:700;
    color:#dc3545;
    margin-bottom:20px;
}

/* LABEL STYLE */
label{
    font-weight:600;
    margin-bottom:6px;
}

/* INPUT */
.form-control{
    border-radius:10px;
    padding:10px;
}

/* BUTTONS */
.btn-save{
    background:#dc3545;
    color:#fff;
    border-radius:30px;
    padding:10px 25px;
    border:none;
}

.btn-cancel{
    background:#6c757d;
    color:#fff;
    border-radius:30px;
    padding:10px 25px;
}

.section{
    margin-bottom:15px;
}

</style>

<div class="wrapper">

    <!-- LEFT PREVIEW -->
    <div class="left">

        <img src="../Adminapp/uploads/<?php echo $row['clubimage']; ?>">

        <h4><?php echo $row['clubname']; ?></h4>

        <p><b>Faculty:</b> <?php echo $row['faculty']; ?></p>
        <p><b>Members:</b> <?php echo $row['totalmembers']; ?></p>

        <span class="badge bg-light text-dark">
            Status: <?php echo $row['status']; ?>
        </span>

        <br><br>

        <span class="badge bg-warning text-dark">
            Type: <?php echo $row['club_paid']; ?>
        </span>

    </div>

    <!-- RIGHT FORM -->
    <div class="right">

        <div class="title">Update Club Information</div>

        <form method="POST" enctype="multipart/form-data">

            <!-- CLUB NAME -->
            <div class="section">
                <label>Club Name</label>
                <input type="text" name="clubname" class="form-control"
                       value="<?php echo $row['clubname']; ?>" required>
            </div>

            <!-- FACULTY NAME -->
            <div class="section">
                <label>Faculty Name</label>
                <input type="text" name="faculty" class="form-control"
                       value="<?php echo $row['faculty']; ?>" required>
            </div>

            <!-- TOTAL MEMBERS -->
            <div class="section">
                <label>Total Members</label>
                <input type="number" name="totalmembers" class="form-control"
                       value="<?php echo $row['totalmembers']; ?>">
            </div>

            <!-- CLUB TYPE -->
            <div class="section">
                <label>Club Type (Paid / Free)</label>
                <select name="club_paid" class="form-control">
                    <option value="Paid" <?php if($row['club_paid']=="Paid") echo "selected"; ?>>Paid</option>
                    <option value="Free" <?php if($row['club_paid']=="Free") echo "selected"; ?>>Free</option>
                </select>
            </div>

            <!-- STATUS -->
            <div class="section">
                <label>Club Status</label>
                <select name="status" class="form-control">
                    <option value="Active" <?php if($row['status']=="Active") echo "selected"; ?>>Active</option>
                    <option value="Inactive" <?php if($row['status']=="Inactive") echo "selected"; ?>>Inactive</option>
                </select>
            </div>

            <!-- IMAGE -->
            <div class="section">
                <label>Change Club Image</label>
                <input type="file" name="clubimage" class="form-control">
            </div>

            <!-- BUTTONS -->
            <div class="mt-4 d-flex gap-2">

                <button type="submit" name="update" class="btn-save">
                    Update Club
                </button>

                <a href="manage_clube.php" class="btn-cancel">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

<?php include 'F_footer.php'; ?>