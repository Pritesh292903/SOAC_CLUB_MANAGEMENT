<?php include 'admin_header.php'; ?>

<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Modal CSS (already included if using Bootstrap 5) -->
    
    <style>
        /* ===== PAGE ANIMATION ===== */
        .content {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== HEADER SECTION ===== */
        .page-header {
            background: #fff;
            border-radius: 15px;
            padding: 20px 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        }

        .page-header h4 {
            color: #dc3545;
        }

        .btn-effect {
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-effect:hover {
            transform: translateY(-2px);
        }

        /* ===== CONTACT CARD ===== */
        .contact-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
            border-left: 4px solid #dc3545;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .contact-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .contact-header h5 {
            font-weight: 600;
            color: #dc3545;
            margin-bottom: 5px;
        }

        .contact-meta {
            font-size: 13px;
            color: #666;
        }

        .contact-meta i {
            color: #dc3545;
            margin-right: 4px;
        }

        .contact-message {
            margin-top: 10px;
            color: #333;
            line-height: 1.6;
        }

        /* ===== ACTION BUTTONS ===== */
        .action-btn {
            border-radius: 30px;
            padding: 5px 12px;
            font-size: 13px;
            transition: 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width:768px) {
            .contact-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>

<div class="content">

    <!-- Header Section -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0 text-danger">Contact Messages</h4>
            <small class="text-muted">Manage user inquiries and feedback</small>
        </div>

        <a href="admin_dashboard.php" class="btn btn-outline-danger btn-effect">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Messages -->
    <div class="contact-card">
        <div class="contact-header">
            <div>
                <h5>Marmik Kalariya</h5>
                <div class="contact-meta">
                    <i class="bi bi-envelope-fill"></i> marmik@example.com |
                    <i class="bi bi-tag-fill"></i> Event Inquiry |
                    <i class="bi bi-clock-fill"></i> 2 mins ago
                </div>
            </div>
            <div>
                <button class="btn btn-outline-danger btn-sm action-btn reply-btn" data-name="Marmik Kalariya"
                    data-email="marmik@example.com">
                    <i class="bi bi-reply-fill me-1"></i>Reply
                </button>
                <button class="btn btn-outline-secondary btn-sm action-btn delete-btn">
                    <i class="bi bi-trash-fill me-1"></i>Delete
                </button>
            </div>
        </div>
        <div class="contact-message">
            Hello Admin, I want to know more about the upcoming Tech Club event.
        </div>
    </div>

    <div class="contact-card">
        <div class="contact-header">
            <div>
                <h5>yashgirir Gauswami</h5>
                <div class="contact-meta">
                    <i class="bi bi-envelope-fill"></i> yashgirir@example.com |
                    <i class="bi bi-tag-fill"></i> Membership |
                    <i class="bi bi-clock-fill"></i> 1 hour ago
                </div>
            </div>
            <div>
                <button class="btn btn-outline-danger btn-sm action-btn reply-btn" data-name="yashgirir Gauswami"
                    data-email="yashgirir@example.com">
                    <i class="bi bi-reply-fill me-1"></i>Reply
                </button>
                <button class="btn btn-outline-secondary btn-sm action-btn delete-btn">
                    <i class="bi bi-trash-fill me-1"></i>Delete
                </button>
            </div>
        </div>
        <div class="contact-message">
            Hi, I would like to join the Sports Club. How can I register?
        </div>
    </div>

    <div class="contact-card">
        <div class="contact-header">
            <div>
                <h5>Pritesh B</h5>
                <div class="contact-meta">
                    <i class="bi bi-envelope-fill"></i> pritesh@example.com |
                    <i class="bi bi-tag-fill"></i> Feedback |
                    <i class="bi bi-clock-fill"></i> Yesterday
                </div>
            </div>
            <div>
                <button class="btn btn-outline-danger btn-sm action-btn reply-btn" data-name="Pritesh B"
                    data-email="pritesh@example.com">
                    <i class="bi bi-reply-fill me-1"></i>Reply
                </button>
                <button class="btn btn-outline-secondary btn-sm action-btn delete-btn">
                    <i class="bi bi-trash-fill me-1"></i>Delete
                </button>
            </div>
        </div>
        <div class="contact-message">
            The dashboard is great, but I suggest adding a notification filter option.
        </div>
    </div>

</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="replyForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipientName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="recipientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="recipientEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="recipientEmail" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="replyMessage" rows="5" placeholder="Type your reply here..."
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Send Reply</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        // Delete confirmation
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let card = $(this).closest('.contact-card');

            Swal.fire({
                title: 'Are you sure?',
                text: "This message will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    card.remove();
                    Swal.fire('Deleted!', 'The message has been deleted.', 'success')
                }
            });
        });

        // Reply button click
        $('.reply-btn').click(function () {
            let name = $(this).data('name');
            let email = $(this).data('email');

            $('#recipientName').val(name);
            $('#recipientEmail').val(email);
            $('#replyMessage').val('');

            var replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
            replyModal.show();
        });

        // Send reply
        $('#replyForm').submit(function (e) {
            e.preventDefault();
            let message = $('#replyMessage').val().trim();
            if (message === '') {
                alert('Please enter a reply message!');
                return;
            }

            // Here you can use AJAX to send the reply to your server
            // $.post('reply_user.php', {email: $('#recipientEmail').val(), message: message}, function(data){ ... });

            Swal.fire('Sent!', 'Your reply has been sent successfully.', 'success');
            $('#replyModal').modal('hide');
        });
    });
</script>

<?php include 'admin_footer.php'; ?>