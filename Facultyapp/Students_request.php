<?php include 'F_header.php'; ?>

<div class="container my-5">

    <!-- Page Heading -->
    <div class="mb-5">
        <h2 class="fw-bold text-danger">Pending Student Requests</h2>
        <p class="text-muted">Manage students requesting to join your clubs</p>
    </div>

    <!-- Club 1 -->
    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-header bg-light fw-bold fs-5">
            Coding Club
        </div>

        <div class="card-body">

            <!-- Student Row -->
            <div class="d-flex justify-content-between align-items-center border-bottom py-3 flex-wrap student-row">
                <div>
                    <h6 class="fw-bold mb-1 student-name">Yashgiri Gauswami</h6>
                    <small class="text-muted">
                        <i class="bi bi-calendar-event me-1"></i> 20 Aug 2026
                        <i class="bi bi-clock ms-2 me-1"></i> 02:15 PM
                    </small>
                </div>

                <div class="d-flex gap-2 mt-2 mt-md-0">
                    <button class="btn btn-sm btn-success rounded-pill px-3 approve-btn">
                        <i class="bi bi-check-circle me-1"></i> Approve
                    </button>
                    <button class="btn btn-sm btn-danger rounded-pill px-3 reject-btn">
                        <i class="bi bi-x-circle me-1"></i> Reject
                    </button>
                </div>
            </div>

            <!-- Student Row -->
            <div class="d-flex justify-content-between align-items-center py-3 flex-wrap student-row">
                <div>
                    <h6 class="fw-bold mb-1 student-name">Pritesh Bharadwa</h6>
                    <small class="text-muted">
                        <i class="bi bi-calendar-event me-1"></i> 21 Aug 2026
                        <i class="bi bi-clock ms-2 me-1"></i> 09:00 AM
                    </small>
                </div>

                <div class="d-flex gap-2 mt-2 mt-md-0">
                    <button class="btn btn-sm btn-success rounded-pill px-3 approve-btn">
                        <i class="bi bi-check-circle me-1"></i> Approve
                    </button>
                    <button class="btn btn-sm btn-danger rounded-pill px-3 reject-btn">
                        <i class="bi bi-x-circle me-1"></i> Reject
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Club 2 -->
    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-header bg-light fw-bold fs-5">
            Sports Club
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center py-3 flex-wrap student-row">
                <div>
                    <h6 class="fw-bold mb-1 student-name">Marmik Kalariya</h6>
                    <small class="text-muted">
                        <i class="bi bi-calendar-event me-1"></i> 22 Aug 2026
                        <i class="bi bi-clock ms-2 me-1"></i> 04:45 PM
                    </small>
                </div>

                <div class="d-flex gap-2 mt-2 mt-md-0">
                    <button class="btn btn-sm btn-success rounded-pill px-3 approve-btn">
                        <i class="bi bi-check-circle me-1"></i> Approve
                    </button>
                    <button class="btn btn-sm btn-danger rounded-pill px-3 reject-btn">
                        <i class="bi bi-x-circle me-1"></i> Reject
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    // Approve buttons
    const approveButtons = document.querySelectorAll('.approve-btn');
    approveButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const studentName = btn.closest('.student-row').querySelector('.student-name').innerText;
            alert(studentName + ' request approved successfully');
        });
    });

    // Reject buttons
    const rejectButtons = document.querySelectorAll('.reject-btn');
    rejectButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const studentName = btn.closest('.student-row').querySelector('.student-name').innerText;
            alert(studentName + ' request rejected successfully');
        });
    });
</script>

<?php include 'F_footer.php'; ?>
