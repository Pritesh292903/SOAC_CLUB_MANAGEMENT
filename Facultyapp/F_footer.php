<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Faculty Panel | Club Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f5f5;
        }

        .page-content {
            flex: 1;
            padding: 40px 0;
        }

        /* ===== SIMPLE RED THEME FOOTER (LIKE YOUR OLD ONE) ===== */
        .simple-footer {
            background: linear-gradient(120deg, #9b0000, #d90429);
            color: white;
            padding: 18px 0;
            margin-top: auto;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.25);
        }

        .simple-footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }

        .simple-footer a:hover {
            text-decoration: underline;
        }

        .simple-footer .footer-text {
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <!-- ===== SIMPLE FOOTER (YOUR THEME) ===== -->
    <footer class="simple-footer">
        <div class="container text-center">
            <div class="mb-2">
                <a href="faculty_dashboard.php">Dashboard</a> |
                <a href="manage_clube.php">Clubs</a> |
                <a href="Manage_events.php">Events</a> |
                <a href="students_list.php.">Students</a> |
                <a href="Students_request.php">Requests</a>

            </div>

            <div class="footer-text">
                © 2026 Club Management System | Faculty Panel
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>