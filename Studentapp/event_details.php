<?php 
include 'header.php'; 
include "../database.php";

// GET EVENT ID
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// FETCH EVENT
if($event_id > 0){
    $query = mysqli_query($con, "SELECT * FROM events WHERE id = $event_id");
    $event = mysqli_fetch_assoc($query);
}else{
    $query = mysqli_query($con, "SELECT * FROM events ORDER BY id ASC LIMIT 1");
    $event = mysqli_fetch_assoc($query);
}

// SAFE DATA
$event_name = $event['name'] ?? 'No Event';
$event_date = $event['date'] ?? 'N/A';
$status     = $event['status'] ?? 'N/A';
$desc       = $event['description'] ?? 'No Description';
$image      = $event['image'] ?? 'default.jpg';
$type       = $event['event_type'] ?? 'Free'; // ✅ PAID/FREE FIELD SAFE
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f6f7fb;
    font-family:'Segoe UI',sans-serif;
}

.event-card{
    max-width:900px;
    margin:40px auto;
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.3s;
}

.event-card:hover{
    transform:translateY(-5px);
}

/* IMAGE */
.event-img{
    width:100%;
    height:380px;
    object-fit:cover;
}

/* BODY */
.event-body{
    padding:30px;
}

/* TITLE */
.event-title{
    font-size:28px;
    font-weight:700;
    color:#dc3545;
    margin-bottom:15px;
}

/* INFO BOX */
.info-box{
    background:#fff5f5;
    border-left:5px solid #dc3545;
    padding:20px;
    border-radius:12px;
}

/* BADGES */
.badge-custom{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    color:#fff;
}

.badge-active{background:#28a745;}
.badge-inactive{background:#6c757d;}
.badge-paid{background:#dc3545;}
.badge-free{background:#198754;}

.back-btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 25px;
    border-radius:30px;
    border:2px solid #dc3545;
    color:#dc3545;
    text-decoration:none;
    transition:0.3s;
}

.back-btn:hover{
    background:#dc3545;
    color:#fff;
}
</style>

<div class="container">

<div class="event-card">

    <!-- IMAGE -->
    <img src="../uploads/<?php echo $image; ?>" class="event-img">

    <div class="event-body">

        <div class="event-title">
            <?php echo $event_name; ?>
        </div>

        <div class="info-box">

            <p><strong>Date:</strong> <?php echo $event_date; ?></p>

            <p>
                <strong>Status:</strong>
                <span class="badge-custom <?php echo ($status=='Active')?'badge-active':'badge-inactive'; ?>">
                    <?php echo $status; ?>
                </span>
            </p>

            <!-- ✅ PAID / FREE TAG -->
            <p>
                <strong>Type:</strong>
                <?php if($type == 'Paid'){ ?>
                    <span class="badge-custom badge-paid">Paid Event</span>
                <?php } else { ?>
                    <span class="badge-custom badge-free">Free Event</span>
                <?php } ?>
            </p>

            <p>
                <strong>Description:</strong><br>
                <?php echo $desc; ?>
            </p>

        </div>

        <div class="text-center">
            <a href="events_view.php" class="back-btn">← Back to Events</a>
        </div>

    </div>
</div>

</div>

<?php include 'footer.php'; ?>