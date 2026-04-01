<?php
include 'admin_header.php';
include '../database.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete = "DELETE FROM clubs WHERE id='$id'";
    mysqli_query($con, $delete);

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        title: 'Deleted!',
        text: 'Club has been deleted successfully.',
        icon: 'success'
    }).then(() => {
        window.location.href='all_clubes_page.php';
    });
    </script>
    ";
}
