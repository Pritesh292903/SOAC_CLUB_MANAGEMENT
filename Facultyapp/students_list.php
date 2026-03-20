<?php include 'F_header.php'; ?>
 
<style>

/* Background */
.students-section{
    padding:40px 20px;
    animation: fadePage 0.6s ease-in-out;
}

@keyframes fadePage{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

/* Title */
.page-title{
    font-size:30px;
    font-weight:700;
    background: linear-gradient(120deg,#9b0000,#d90429);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Card Design */
.student-card{
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    padding:30px;
    transition:0.4s ease;
}

.student-card:hover{
    transform: translateY(-5px);
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
}

/* Table */
.table{
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background: linear-gradient(120deg,#9b0000,#d90429);
    color:white;
    font-size:15px;
}

.table tbody tr{
    transition:0.3s ease;
}

.table tbody tr:hover{
    background:#ffe5e5;
    transform: scale(1.01);
}

/* Student Image */
.student-img{
    width:45px;
    height:45px;
    border-radius:50%;
    border:2px solid #d90429;
    transition:0.3s;
}

.student-img:hover{
    transform:scale(1.1);
}

/* Club Badge */
.badge-club{
    background:linear-gradient(120deg,#d90429,#9b0000);
    font-size:13px;
}

/* Status */
.badge{
    padding:6px 10px;
    font-size:13px;
}

/* Search Box */
.search-box{
    max-width:300px;
}

</style>

<div class="container students-section">

    <!-- Title + Search -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">
            <i class="bi bi-people-fill"></i> Students Management
        </h2>

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
                        <th>Enrollment</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Department</th>
                        <th>Year</th>
                        <th>Club</th>
                        <th>Join Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>
                            <img src="assets/images/user.jpg" class="student-img">
                        </td>
                        <td>Rahul Patel</td>
                        <td>22SDSCE01001</td>
                        <td>rahul@gmail.com</td>
                        <td>9876543210</td>
                        <td>BCA</td>
                        <td>2nd Year</td>
                        <td><span class="badge badge-club">Coding Club</span></td>
                        <td>12-02-2026</td>
                        <td><span class="badge bg-success">Approved</span></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            <img src="assets/images/user.jpg" class="student-img">
                        </td>
                        <td>Priya Sharma</td>
                        <td>22SDSCE01002</td>
                        <td>priya@gmail.com</td>
                        <td>9988776655</td>
                        <td>BBA</td>
                        <td>3rd Year</td>
                        <td><span class="badge badge-club">Dance Club</span></td>
                        <td>15-02-2026</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

<?php include 'F_footer.php'; ?>