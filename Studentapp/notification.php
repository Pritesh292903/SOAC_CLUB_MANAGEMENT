<?php 
session_start();
include 'header.php';
include '../database.php';

$user_id = $_SESSION['user_id'] ?? 0;

// SESSION FOR HIDDEN
if(!isset($_SESSION['hidden_notifications'])){
    $_SESSION['hidden_notifications'] = [];
}

// DELETE HANDLER
if(isset($_GET['delete'])){
    $_SESSION['hidden_notifications'][] = $_GET['delete'];
    exit();
}

// ================= QUERY =================
$qry = mysqli_query($con, "

    SELECT 
        CONCAT('club_', id) AS nid,
        clubname AS title,
        'New Club Added' AS message,
        'club' AS type,
        id AS sort_id,
        NULL AS created_at
    FROM clubs

    UNION ALL

    SELECT 
        CONCAT('event_', id) AS nid,
        name AS title,
        'New Event Added' AS message,
        'event' AS type,
        id AS sort_id,
        created_at
    FROM events

    UNION ALL

    SELECT 
        CONCAT('cjr_', cjr.id) AS nid,
        c.clubname AS title,
        'Your club request approved 🎉' AS message,
        'approval' AS type,
        cjr.id AS sort_id,
        cjr.created_at
    FROM club_join_requests cjr
    JOIN clubs c ON cjr.club_id = c.id
    WHERE cjr.user_id='$user_id' AND cjr.status='approved'

    UNION ALL

    SELECT 
        CONCAT('ejr_', ejr.id) AS nid,
        e.name AS title,
        'Your event request approved 🎉' AS message,
        'approval' AS type,
        ejr.id AS sort_id,
        ejr.created_at
    FROM event_join_requests ejr
    JOIN events e ON ejr.event_id = e.id
    WHERE ejr.user_id='$user_id' AND ejr.status='approved'

    ORDER BY sort_id DESC
");

// FILTER HIDDEN
$notifications = [];
while($row = mysqli_fetch_assoc($qry)){
    if(!in_array($row['nid'], $_SESSION['hidden_notifications'])){
        $notifications[] = $row;
    }
}

$count = count($notifications);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- 🔥 MAIN CONTENT -->
<main class="container my-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-danger">🔔 Notifications</h2>
        <span class="badge bg-danger rounded-pill px-3 py-2" id="notify-count">
            <?php echo $count; ?>
        </span>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card premium-card p-3" id="notify-container">

                <?php if($count > 0): ?>

                    <?php foreach($notifications as $row): 

                        if($row['type']=='club'){
                            $icon="🏆"; $border="#0d6efd";
                        } elseif($row['type']=='event'){
                            $icon="🎉"; $border="#0dcaf0";
                        } else {
                            $icon="✅"; $border="#198754";
                        }
                    ?>

                    <div class="notify-item mb-2" 
                         style="border-left:4px solid <?php echo $border; ?>" 
                         id="<?php echo $row['nid']; ?>">

                        <div class="d-flex justify-content-between">

                            <div>
                                <h6 class="fw-bold mb-1">
                                    <?php echo $icon . " " . htmlspecialchars($row['title']); ?>
                                </h6>

                                <p class="text-muted small mb-1">
                                    <?php echo $row['message']; ?>
                                </p>

                                <small class="text-secondary">
                                    <?php 
                                    echo !empty($row['created_at']) 
                                        ? date('d M, h:i A', strtotime($row['created_at'])) 
                                        : "Just now";
                                    ?>
                                </small>
                            </div>

                            <!-- DELETE -->
                            <button class="btn btn-sm btn-light delete-btn" 
                                    data-id="<?php echo $row['nid']; ?>">
                                ✖
                            </button>

                        </div>

                    </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="text-center py-5">
                        <h5 class="text-muted">You're all caught up 🎉</h5>
                    </div>

                <?php endif; ?>

            </div>

        </div>
    </div>

</main>

<style>
/* 🔥 FIX HEADER FOOTER */
html, body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg,#fdfbfb,#ebedee);
    font-family: 'Segoe UI', sans-serif;
}

main {
    flex: 1;
}

/* CARD */
.premium-card {
    border-radius: 16px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* ITEM */
.notify-item {
    padding: 15px;
    border-radius: 10px;
    background: #fff;
    transition: 0.3s;
}

.notify-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* DELETE BUTTON */
.delete-btn {
    border-radius: 50%;
    width: 30px;
    height: 30px;
}

.delete-btn:hover {
    background: #ff4d4d;
    color: white;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// 🔥 DELETE + COUNT UPDATE
$(".delete-btn").click(function(){

    let id = $(this).data("id");
    let el = $("#"+id);

    el.fadeOut(300, function(){
        $(this).remove();

        // UPDATE COUNT
        let badge = $("#notify-count");
        let count = parseInt(badge.text());

        if(count > 0){
            badge.text(count - 1);
        }

        // EMPTY STATE
        if($(".notify-item:visible").length === 0){
            $("#notify-container").html(`
                <div class="text-center py-5">
                    <h5 class="text-muted">You're all caught up 🎉</h5>
                </div>
            `);
        }
    });

    $.get("notification.php?delete="+id);
});
</script>

<?php include 'footer.php'; ?>