<?php 
include 'F_header.php'; 
include '../database.php';
mysqli_select_db($con, "SOAE_CLUB");

/* SAFE FUNCTION */
function safe($value, $default = 'N/A'){
    return isset($value) && $value !== null && $value !== '' 
        ? htmlspecialchars($value) 
        : $default;
}
?>

<div class="container my-5">

    <h2 class="fw-bold text-danger mb-4">Pending Requests</h2>

    <!-- ================= CLUB REQUESTS ================= -->
    <h4 class="text-primary mb-3">Club Requests</h4>

    <?php
    $requests = mysqli_query($con, "
        SELECT r.*, u.fullname, u.email, u.mobile, c.clubname AS club_name
        FROM club_join_requests r
        JOIN user u ON r.user_id = u.id
        LEFT JOIN clubs c ON r.club_id = c.id
        WHERE r.status='pending'
        ORDER BY r.created_at DESC
    ");

    if($requests && mysqli_num_rows($requests) > 0):
        while($req = mysqli_fetch_assoc($requests)):
    ?>

    <div class="card shadow mb-3">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">

            <div>
                <h6 class="fw-bold"><?= safe($req['fullname']) ?></h6>

                <small class="text-muted">
                    <?= !empty($req['created_at']) ? date("d M Y, h:i A", strtotime($req['created_at'])) : '' ?>
                </small>

                <!-- ✅ FIXED CLUB -->
                <div>
                    <small>Club: <?= safe($req['club_name']) ?></small>
                </div>

                <div>
                    <small>
                        Email: <?= safe($req['email']) ?> | 
                        Phone: <?= safe($req['mobile']) ?>
                    </small>
                </div>

                <?php if(!empty($req['message'])): ?>
                    <div>
                        <small>Message: <?= safe($req['message']) ?></small>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-2">
                <button class="btn btn-success btn-sm approve-btn" 
                        data-id="<?= $req['id'] ?>" data-type="club">
                    Approve
                </button>

                <button class="btn btn-danger btn-sm reject-btn" 
                        data-id="<?= $req['id'] ?>" data-type="club">
                    Reject
                </button>
            </div>

        </div>
    </div>

    <?php endwhile; else: ?>
        <p class="text-muted">No pending club requests.</p>
    <?php endif; ?>


    <!-- ================= EVENT REQUESTS ================= -->
    <h4 class="text-primary mt-5 mb-3">Event Requests</h4>

    <?php
    $event_requests = mysqli_query($con, "
        SELECT r.*, u.fullname, u.email, u.mobile, e.name AS event_name
        FROM event_join_requests r
        JOIN user u ON r.user_id = u.id
        LEFT JOIN events e ON r.event_id = e.id
        WHERE r.status='pending'
        ORDER BY r.created_at DESC
    ");

    if($event_requests && mysqli_num_rows($event_requests) > 0):
        while($req = mysqli_fetch_assoc($event_requests)):
    ?>

    <div class="card shadow mb-3">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">

            <div>
                <h6 class="fw-bold"><?= safe($req['fullname']) ?></h6>

                <small class="text-muted">
                    <?= !empty($req['created_at']) ? date("d M Y, h:i A", strtotime($req['created_at'])) : '' ?>
                </small>

                <div>
                    <small>Event: <?= safe($req['event_name']) ?></small>
                </div>

                <div>
                    <small>
                        Email: <?= safe($req['email']) ?> | 
                        Phone: <?= safe($req['mobile']) ?>
                    </small>
                </div>
            </div>

            <div class="mt-2">
                <button class="btn btn-success btn-sm approve-btn" 
                        data-id="<?= $req['id'] ?>" data-type="event">
                    Approve
                </button>

                <button class="btn btn-danger btn-sm reject-btn" 
                        data-id="<?= $req['id'] ?>" data-type="event">
                    Reject
                </button>
            </div>

        </div>
    </div>

    <?php endwhile; else: ?>
        <p class="text-muted">No pending event requests.</p>
    <?php endif; ?>

</div>

<!-- JS -->
<script>
document.querySelectorAll('.approve-btn, .reject-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        const id = btn.dataset.id;
        const type = btn.dataset.type;
        const action = btn.classList.contains('approve-btn') ? 'approve' : 'reject';

        fetch('handle_request.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=${action}&id=${id}&type=${type}`
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            location.reload();
        });

    });

});
</script>

<?php include 'F_footer.php'; ?>