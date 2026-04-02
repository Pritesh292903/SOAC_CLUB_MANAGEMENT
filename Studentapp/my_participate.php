<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';
include "../database.php";

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('⚠️ Please login first!');
        window.location.href='login_view.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH CLUBS JOINED BY USER
$clubQuery = "SELECT * FROM club_join_requests WHERE user_id='$user_id' ORDER BY id DESC";
$clubResult = mysqli_query($con, $clubQuery);

// FETCH EVENTS JOINED BY USER
$eventQuery = "SELECT * FROM event_join_requests WHERE user_id='$user_id' ORDER BY id DESC";
$eventResult = mysqli_query($con, $eventQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Participate</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
html, body {
    height: 100%;
}
body {
    display: flex;
    flex-direction: column;
    background-color: #fff5f5;
}
.container {
    flex: 1; /* Makes container take remaining space */
    padding-bottom: 30px;
}
.section-title { font-weight: 700; color: #c62828; margin-bottom: 20px; }
.card { margin-bottom: 20px; }
.card-header { font-weight: 600; background-color: #e53935; color: #fff; }
.card-body { background-color: #fff; }
</style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center text-danger mb-5">My Participations</h2>

    <div class="row">
        <!-- LEFT COLUMN: Clubs -->
        <div class="col-lg-6">
            <h4 class="section-title">Clubs Joined</h4>
            <?php if(mysqli_num_rows($clubResult) > 0): ?>
                <?php while($club = mysqli_fetch_assoc($clubResult)): ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <?php echo htmlspecialchars($club['club_name']); ?>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($club['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($club['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($club['phone']); ?></p>
                            <p><strong>Message:</strong> <?php echo htmlspecialchars($club['message']); ?></p>
                            <p><small class="text-muted">Joined on: <?php echo date('d M Y', strtotime($club['created_at'] ?? $club['id'])); ?></small></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">You have not joined any clubs yet.</p>
            <?php endif; ?>
        </div>

        <!-- RIGHT COLUMN: Events -->
        <div class="col-lg-6">
            <h4 class="section-title">Events Joined</h4>
            <?php if(mysqli_num_rows($eventResult) > 0): ?>
                <?php while($event = mysqli_fetch_assoc($eventResult)): ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <?php echo htmlspecialchars($event['event_name']); ?>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($event['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($event['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($event['phone']); ?></p>
                            <p><strong>Message:</strong> <?php echo htmlspecialchars($event['message']); ?></p>
                            <p><small class="text-muted">Joined on: <?php echo date('d M Y', strtotime($event['created_at'] ?? $event['id'])); ?></small></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">You have not joined any events yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>