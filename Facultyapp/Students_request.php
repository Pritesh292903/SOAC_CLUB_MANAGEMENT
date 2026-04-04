<?php 
include 'F_header.php'; 
include '../database.php';
mysqli_select_db($con, "SOAE_CLUB");
?>

<div class="container my-5">

    <!-- Page Heading -->
    <div class="mb-5">
        <h2 class="fw-bold text-danger">Pending Requests</h2>
        <p class="text-muted">Manage students requesting to join clubs or events</p>
    </div>

    <!-- ===== Club Join Requests ===== -->
    <h4 class="text-primary mb-3">Club Requests</h4>

    <?php
    $requests = mysqli_query($con, "SELECT * FROM club_join_requests WHERE status='pending' ORDER BY created_at DESC");

    if($requests && mysqli_num_rows($requests) > 0):
        while($req = mysqli_fetch_assoc($requests)):

        // SAFE VALUES (No errors even if column missing)
        $name  = htmlspecialchars($req['name'] ?? $req['student_name'] ?? 'N/A');
        $club  = htmlspecialchars($req['club_name'] ?? $req['club'] ?? 'N/A');
        $email = htmlspecialchars($req['email'] ?? 'N/A');
        $phone = htmlspecialchars($req['phone'] ?? $req['mobile'] ?? 'N/A');
        $msg   = htmlspecialchars($req['message'] ?? '');
        $date  = !empty($req['created_at']) ? date("d M Y", strtotime($req['created_at'])) : '';
        $time  = !empty($req['created_at']) ? date("h:i A", strtotime($req['created_at'])) : '';
    ?>
        <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom py-3 flex-wrap">

                    <div>
                        <h6 class="fw-bold mb-1"><?= $name ?></h6>

                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i> <?= $date ?>
                            <i class="bi bi-clock ms-2 me-1"></i> <?= $time ?>
                        </small>

                        <div><small class="text-muted">Club: <?= $club ?></small></div>
                        <div><small class="text-muted">Email: <?= $email ?> | Phone: <?= $phone ?></small></div>

                        <?php if(!empty($msg)): ?>
                            <div><small class="text-muted">Message: <?= $msg ?></small></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <button class="btn btn-sm btn-success approve-btn" data-id="<?= $req['id'] ?>" data-type="club">Approve</button>
                        <button class="btn btn-sm btn-danger reject-btn" data-id="<?= $req['id'] ?>" data-type="club">Reject</button>
                    </div>

                </div>
            </div>
        </div>
    <?php 
        endwhile;
    else: 
    ?>
        <p class="text-muted">No pending club requests.</p>
    <?php endif; ?>


    <!-- ===== Event Join Requests ===== -->
    <h4 class="text-primary mb-3 mt-5">Event Requests</h4>

    <?php
    $event_requests = mysqli_query($con, "SELECT * FROM event_join_requests WHERE status='pending' ORDER BY created_at DESC");

    if($event_requests && mysqli_num_rows($event_requests) > 0):
        while($req = mysqli_fetch_assoc($event_requests)):

        $name  = htmlspecialchars($req['name'] ?? $req['student_name'] ?? 'N/A');
        $event = htmlspecialchars($req['event_name'] ?? $req['event'] ?? 'N/A');
        $email = htmlspecialchars($req['email'] ?? 'N/A');
        $phone = htmlspecialchars($req['phone'] ?? $req['mobile'] ?? 'N/A');
        $msg   = htmlspecialchars($req['message'] ?? '');
        $date  = !empty($req['created_at']) ? date("d M Y", strtotime($req['created_at'])) : '';
        $time  = !empty($req['created_at']) ? date("h:i A", strtotime($req['created_at'])) : '';
    ?>
        <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom py-3 flex-wrap">

                    <div>
                        <h6 class="fw-bold mb-1"><?= $name ?></h6>

                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i> <?= $date ?>
                            <i class="bi bi-clock ms-2 me-1"></i> <?= $time ?>
                        </small>

                        <div><small class="text-muted">Event: <?= $event ?></small></div>
                        <div><small class="text-muted">Email: <?= $email ?> | Phone: <?= $phone ?></small></div>

                        <?php if(!empty($msg)): ?>
                            <div><small class="text-muted">Message: <?= $msg ?></small></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <button class="btn btn-sm btn-success approve-btn" data-id="<?= $req['id'] ?>" data-type="event">Approve</button>
                        <button class="btn btn-sm btn-danger reject-btn" data-id="<?= $req['id'] ?>" data-type="event">Reject</button>
                    </div>

                </div>
            </div>
        </div>
    <?php 
        endwhile;
    else: 
    ?>
        <p class="text-muted">No pending event requests.</p>
    <?php endif; ?>

</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll('.approve-btn, .reject-btn').forEach(btn => {

        btn.addEventListener('click', () => {

            const requestId = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            const action = btn.classList.contains('approve-btn') ? 'approve' : 'reject';

            fetch('handle_request.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=${action}&id=${requestId}&type=${type}`
            })
            .then(res => res.text())
            .then(data => {
                alert(data);
                location.reload();
            });

        });

    });

});
</script>

<?php include 'F_footer.php'; ?>