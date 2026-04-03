<?php 
include 'F_header.php'; 
include '../database.php';
mysqli_select_db($con, "SOAE_CLUB");
?>

<style>
/* Keep your previous CSS as-is, no changes needed */
.students-section{padding:40px 20px;animation:fadePage 0.6s ease-in-out;}
@keyframes fadePage{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
.page-title{font-size:30px;font-weight:700;background:linear-gradient(120deg,#9b0000,#d90429);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.student-card{background: rgba(255,255,255,0.95);backdrop-filter: blur(10px);border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.1);padding:30px;transition:0.4s ease;}
.student-card:hover{transform: translateY(-5px);box-shadow:0 15px 40px rgba(0,0,0,0.15);}
.table{border-radius:15px;overflow:hidden;}
.table thead{background: linear-gradient(120deg,#9b0000,#d90429);color:white;font-size:15px;}
.table tbody tr{transition:0.3s ease;}
.table tbody tr:hover{background:#ffe5e5;transform: scale(1.01);}
.student-img{width:45px;height:45px;border-radius:50%;border:2px solid #d90429;transition:0.3s;}
.student-img:hover{transform:scale(1.1);}
.badge-club{background:linear-gradient(120deg,#d90429,#9b0000);font-size:13px;}
.badge{padding:6px 10px;font-size:13px;}
.search-box{max-width:300px;}
</style>

<div class="container students-section">

    <!-- Title + Search -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-people-fill"></i> Students Management</h2>
        <input type="text" class="form-control search-box" placeholder="Search Student...">
    </div>

    <div class="student-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Club / Event</th>
                        <th>Join Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch club join requests
                    $club_requests = mysqli_query($con, "SELECT * FROM club_join_requests ORDER BY created_at DESC");
                    // Fetch event join requests
                    $event_requests = mysqli_query($con, "SELECT * FROM event_join_requests ORDER BY created_at DESC");

                    $i = 1;

                    // Function to convert status to badge
                    function statusBadge($status){
                        switch($status){
                            case 'approved': return '<span class="badge bg-success">Approved</span>'; 
                            case 'pending': return '<span class="badge bg-warning text-dark">Pending</span>'; 
                            case 'rejected': return '<span class="badge bg-danger">Rejected</span>'; 
                            default: return '<span class="badge bg-secondary">Unknown</span>';
                        }
                    }

                    // Display club requests
                    while($req = mysqli_fetch_assoc($club_requests)){
                        echo '<tr>
                                <td>'.$i++.'</td>
                                <td><img src="assets/images/user.jpg" class="student-img"></td>
                                <td>'.htmlspecialchars($req['name']).'</td>
                                <td>'.htmlspecialchars($req['email']).'</td>
                                <td>'.htmlspecialchars($req['phone']).'</td>
                                <td><span class="badge badge-club">'.htmlspecialchars($req['club_name']).'</span></td>
                                <td>'.date("d-m-Y", strtotime($req['created_at'])).'</td>
                                <td>'.statusBadge($req['status']).'</td>
                              </tr>';
                    }

                    // Display event requests
                    while($req = mysqli_fetch_assoc($event_requests)){
                        echo '<tr>
                                <td>'.$i++.'</td>
                                <td><img src="assets/images/user.jpg" class="student-img"></td>
                                <td>'.htmlspecialchars($req['name']).'</td>
                                <td>'.htmlspecialchars($req['email']).'</td>
                                <td>'.htmlspecialchars($req['phone']).'</td>
                                <td><span class="badge badge-club">'.htmlspecialchars($req['event_name']).'</span></td>
                                <td>'.date("d-m-Y", strtotime($req['created_at'])).'</td>
                                <td>'.statusBadge($req['status']).'</td>
                              </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include 'F_footer.php'; ?>