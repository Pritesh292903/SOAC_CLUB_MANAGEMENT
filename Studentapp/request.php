<?php
session_start();
include '../database.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login_view.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// ================= QUERY =================
$stmt = $con->prepare("

    SELECT 
        cjr.id,
        c.clubname AS title,
        c.clubimage AS image,
        'Club' AS type,
        cjr.created_at,
        cjr.status
    FROM club_join_requests cjr
    JOIN clubs c ON cjr.club_id = c.id
    WHERE cjr.user_id = ?

    UNION ALL

    SELECT 
        ejr.id,
        e.name AS title,
        e.image AS image,
        'Event' AS type,
        ejr.created_at,
        ejr.status
    FROM event_join_requests ejr
    JOIN events e ON ejr.event_id = e.id
    WHERE ejr.user_id = ?

    ORDER BY created_at DESC
");

$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5 flex-grow-1">

    <h2 class="mb-4 text-center fw-bold">My Requests</h2>

    <?php if ($result->num_rows > 0): ?>

        <div class="table-responsive shadow rounded">
            <table class="table align-middle mb-0">

                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $count = 1;
                    while ($row = $result->fetch_assoc()): 

                        // ✅ IMAGE PATH FIX
                        $basePath = ($row['type'] == 'Club') 
                                    ? "../Adminapp/uploads/" 
                                    : "../uploads/";

                        $img = !empty($row['image']) ? $basePath . $row['image'] : "";

                        // ✅ INITIAL + COLOR
                        $initial = strtoupper(substr($row['title'], 0, 1));
                        $hash = md5($row['title']);
                        $bgColor = "#" . substr($hash, 0, 6);

                        // STATUS
                        $status = $row['status'] ?? 'pending';

                        if ($status == 'pending') {
                            $badge = "<span class='badge bg-warning text-dark'>Pending</span>";
                        } elseif ($status == 'approved') {
                            $badge = "<span class='badge bg-success'>Approved</span>";
                        } elseif ($status == 'rejected') {
                            $badge = "<span class='badge bg-danger'>Rejected</span>";
                        } else {
                            $badge = "<span class='badge bg-secondary'>Unknown</span>";
                        }
                    ?>

                    <tr>

                        <td class="text-center"><?php echo $count++; ?></td>

                        <!-- TYPE -->
                        <td class="text-center">
                            <?php if($row['type'] == 'Club'): ?>
                                <span class="badge bg-primary">🏆 Club</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark">🎉 Event</span>
                            <?php endif; ?>
                        </td>

                        <!-- DETAILS -->
                        <td>
                            <div class="d-flex align-items-center gap-3">

                                <?php if($img && file_exists($img)): ?>
                                    <div class="img-box">
                                        <img src="<?php echo $img; ?>" class="req-img">
                                    </div>
                                <?php else: ?>
                                    <!-- 🎨 COLORED AVATAR -->
                                    <div class="avatar-box" style="background: <?php echo $bgColor; ?>;">
                                        <?php echo $initial; ?>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <div class="fw-bold text-dark">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo $row['type']; ?> Request
                                    </small>
                                </div>

                            </div>
                        </td>

                        <!-- DATE -->
                        <td class="text-center">
                            <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                            <br>
                            <small class="text-muted">
                                <?php echo date('h:i A', strtotime($row['created_at'])); ?>
                            </small>
                        </td>

                        <!-- STATUS -->
                        <td class="text-center">
                            <?php echo $badge; ?>
                        </td>

                    </tr>

                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>

    <?php else: ?>

        <div class="text-center py-5">
            <img src="../assets/empty.png" width="150" class="mb-3">
            <h5 class="text-muted">No requests found</h5>
        </div>

    <?php endif; ?>

</div>

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
}

h2 {
    color: #b71c1c;
}

.table-responsive {
    background: #fff;
}

/* IMAGE BOX */
.img-box {
    width: 55px;
    height: 55px;
    overflow: hidden;
    border-radius: 10px;
}

.req-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.3s;
}

/* 🔥 HOVER ZOOM */
.img-box:hover .req-img {
    transform: scale(1.2);
}

/* 🎨 COLORED AVATAR */
.avatar-box {
    width: 55px;
    height: 55px;
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    text-transform: uppercase;
}

/* Hover row */
.table tbody tr:hover {
    background-color: #f1f3f5;
    transform: scale(1.01);
}

.badge {
    font-size: 12px;
    padding: 6px 10px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>