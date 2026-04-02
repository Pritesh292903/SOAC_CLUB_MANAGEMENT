<?php include 'admin_header.php'; ?>
<?php
include '../database.php';

// Fetch messages
$query = "SELECT * FROM contact_us ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
?>

<style>
/* ===== MAIN CONTAINER ===== */
.main-content {
    max-width: 900px;
    margin: 100px auto;
    padding: 0 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    min-height: 80vh;
}

/* ===== HEADER ===== */
.page-header {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
.page-header h3 {
    color: #dc3545;
}
.page-header a {
    border: 1px solid #dc3545;
    color: #dc3545;
    padding: 6px 16px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
}
.page-header a:hover {
    background: #dc3545;
    color: #fff;
}

/* ===== CONTACT CARD ===== */
.contact-card {
    margin-bottom: 25px;
    padding: 20px;
    border-radius: 15px;
    border-left: 6px solid #dc3545;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(220, 53, 69, 0.2);
}

.contact-card h5 {
    margin: 0 0 6px 0;
    color: #dc3545;
    font-weight: 700;
}
.contact-card p {
    margin: 0;
    color: #555;
    font-size: 14px;
}
.contact-message {
    margin-top: 10px;
    color: #333;
    white-space: pre-wrap;
    line-height: 1.5;
}

/* ===== ACTION BUTTONS ===== */
.contact-actions {
    margin-top: 15px;
}
.btn-action {
    border-radius: 30px;
    padding: 6px 12px;
    font-size: 14px;
    cursor: pointer;
    margin-right: 10px;
    transition: 0.3s;
}
.btn-reply {
    border: 1px solid #dc3545;
    color: #dc3545;
    background: transparent;
}
.btn-reply:hover {
    background: #dc3545;
    color: #fff;
}
.btn-delete {
    border: 1px solid #6c757d;
    color: #6c757d;
    background: transparent;
}
.btn-delete:hover {
    background: #6c757d;
    color: #fff;
}

/* ===== RESPONSIVE ===== */
@media(max-width: 600px){
    .contact-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
}
</style>

<div class="main-content">

    <div class="page-header">
        <h3>Contact Messages</h3>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="contact-card" data-id="<?php echo $row['id']; ?>">
                <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                <p><i class="bi bi-envelope-fill"></i> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><i class="bi bi-tag-fill"></i> <?php echo htmlspecialchars($row['subject']); ?></p>
                <div class="contact-message"><?php echo nl2br(htmlspecialchars($row['message'])); ?></div>
                <div class="contact-actions">
                    <button class="btn-action btn-reply reply-btn" 
                        data-name="<?php echo htmlspecialchars($row['name']); ?>"
                        data-email="<?php echo htmlspecialchars($row['email']); ?>">
                        Reply
                    </button>
                    <button class="btn-action btn-delete delete-btn" data-id="<?php echo $row['id']; ?>">
                        Delete
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center text-muted py-5">No messages found.</p>
    <?php endif; ?>

</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="replyForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="recipientName" class="form-control mb-2" readonly>
                    <input type="email" id="recipientEmail" class="form-control mb-2" readonly>
                    <textarea id="replyMessage" class="form-control" rows="5" placeholder="Type your reply..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Send</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Delete button
    $('.delete-btn').click(function(){
        let card = $(this).closest('.contact-card');
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This message will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result)=>{
            if(result.isConfirmed){
                $.post('delete_message.php',{id:id}, function(response){
                    if(response.trim() === 'success'){
                        card.fadeOut(400, function(){ $(this).remove(); });
                        Swal.fire('Deleted!','Message deleted.','success');
                    }else{
                        Swal.fire('Error!','Delete failed.','error');
                    }
                });
            }
        });
    });

    // Reply button
    $('.reply-btn').click(function(){
        $('#recipientName').val($(this).data('name'));
        $('#recipientEmail').val($(this).data('email'));
        $('#replyMessage').val('');
        new bootstrap.Modal(document.getElementById('replyModal')).show();
    });

    // Send reply form
    $('#replyForm').submit(function(e){
        e.preventDefault();
        let msg = $('#replyMessage').val().trim();
        if(msg === ''){
            alert('Please type a reply!');
            return;
        }
        Swal.fire('Sent!','Reply sent successfully.','success');
        $('#replyModal').modal('hide');
    });

});
</script>

<?php include 'admin_footer.php'; ?>