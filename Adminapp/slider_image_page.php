<?php
include 'admin_header.php';
include '../database.php';

$upload_dir = "slider_images/";

// Create folder if not exists
if(!is_dir($upload_dir)){
    mkdir($upload_dir, 0777, true);
}

// ===== Upload Images =====
if(isset($_POST['save_images'])) {
    $images = $_FILES['slider_images']['name'];
    $tmp_names = $_FILES['slider_images']['tmp_name'];

    if(!empty($images[0])) {
        $uploaded_count = 0;
        foreach($images as $key => $image) {
            $tmp_file = $tmp_names[$key];
            if(!empty($tmp_file) && is_uploaded_file($tmp_file)){
                $unique_name = time().'_'.rand(1000,9999).'_'.$image;
                $upload_path = $upload_dir . $unique_name;

                if(move_uploaded_file($tmp_file, $upload_path)) {
                    mysqli_query($con, "INSERT INTO slider_images(image) VALUES('$unique_name')");
                    $uploaded_count++;
                }
            }
        }
        $success_msg = "$uploaded_count images uploaded successfully!";
    } else {
        $error_msg = "Please select images to upload.";
    }
}

// Fetch All Images
$all_images = mysqli_query($con, "SELECT * FROM slider_images ORDER BY id DESC");
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
.content{animation: fadeIn 0.6s ease-in-out;padding:30px 0;}
@keyframes fadeIn{from{opacity:0; transform:translateY(15px);} to{opacity:1; transform:translateY(0);}}
.custom-card{border:none;border-radius:15px;box-shadow:0 10px 25px rgba(0,0,0,0.05);background:#fff;padding:30px;max-width:700px;margin:auto;}
.preview-img, .slider-img{width:150px;height:150px;object-fit:cover;border-radius:10px;border:2px dashed #dc3545;padding:5px;margin:5px;transition:0.3s;position: relative;}
.preview-img:hover, .slider-img:hover{transform:scale(1.05);}
.slider-gallery{display:flex;flex-wrap:wrap;justify-content:center;margin-top:30px;}
.slider-gallery h5{width:100%;text-align:center;margin-bottom:15px;color:#dc3545;}
.delete-btn{position:absolute;top:5px;right:5px;background:rgba(220,53,69,0.8);border:none;color:white;border-radius:50%;width:25px;height:25px;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;}
.delete-btn:hover{background:rgba(220,53,69,1);}
.btn-custom{border-radius:50px;padding:10px 20px;font-weight:500;}
</style>

<div class="content">
    <div class="page-header text-center mb-4">
        <h4 class="fw-bold">Student Panel - Add Slider Images</h4>
        <small>Select multiple images for your property slider</small>
    </div>

    <div class="custom-card text-center">
        <?php
        if(isset($success_msg)){
            echo "<script>Swal.fire('Success','$success_msg','success');</script>";
        }
        if(isset($error_msg)){
            echo "<script>Swal.fire('Error','$error_msg','error');</script>";
        }
        ?>

        <form method="post" enctype="multipart/form-data">
            <div id="preview-container" class="d-flex flex-wrap justify-content-center mb-3"></div>
            <input type="file" id="sliderImages" name="slider_images[]" accept="image/*" multiple class="form-control mb-3 mx-auto" style="max-width:400px;">
            <div class="d-flex justify-content-center gap-3 mt-3">
                <button type="submit" name="save_images" class="btn btn-danger btn-custom">
                    <i class="bi bi-save me-2"></i> Save Images
                </button>
                <button type="button" id="cancelImageBtn" class="btn btn-secondary btn-custom">
                    <i class="bi bi-x-circle me-2"></i> Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Slider Images -->
    <div class="slider-gallery">
        <h5>All Slider Images</h5>
        <div id="image-container">
            <?php
            if(mysqli_num_rows($all_images) > 0){
                while($img = mysqli_fetch_assoc($all_images)){
                    echo '<div style="position:relative; display:inline-block;" id="img_'.$img['id'].'">
                            <img src="slider_images/'.$img['image'].'" class="slider-img">
                            <button class="delete-btn" data-id="'.$img['id'].'"><i class="bi bi-trash"></i></button>
                          </div>';
                }
            } else {
                echo "<p>No slider images uploaded yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function(){
    // Preview Images
    $('#sliderImages').on('change', function(){
        $('#preview-container').html('');
        const files = this.files;
        if(files.length === 0) return;
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e){
                $('#preview-container').append('<img src="'+e.target.result+'" class="preview-img">');
            }
            reader.readAsDataURL(file);
        });
    });

    // Cancel Selection
    $('#cancelImageBtn').click(function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Your selected images will be cleared!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed){
                $('#sliderImages').val('');
                $('#preview-container').html('');
                Swal.fire('Cancelled','Your selection has been cleared.','info');
            }
        });
    });

    // AJAX Delete
    $('.delete-btn').click(function(){
        const id = $(this).data('id');
        const parent = $('#img_' + id);

        Swal.fire({
            title: 'Are you sure?',
            text: "This image will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: 'delete_slider_ajax.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(resp){
                        parent.remove();
                        Swal.fire('Deleted!','The image has been deleted.','success');
                    },
                    error: function(){
                        Swal.fire('Error','Something went wrong!','error');
                    }
                });
            }
        });
    });
});
</script>