<?php include 'admin_header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.content { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from { opacity:0; transform:translateY(15px);} to { opacity:1; transform:translateY(0);} }

.card{border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05);}
.form-control, .form-select{border-radius:10px;}

.upload-box{
    border:2px dashed #ddd;
    padding:15px;
    border-radius:12px;
    text-align:center;
    cursor:pointer;
}

.event-img{
    width:100%;
    max-height:250px;
    object-fit:cover;
    border-radius:12px;
}

/* VALIDATION */
.input-error{border:2px solid red;}
.input-success{border:2px solid #28a745;}
.error-text{color:red; font-size:0.8rem;}
.upload-error{border-color:red !important;}
.upload-success{border-color:#28a745 !important;}
</style>

<div class="content">

<h4 class="text-danger mb-4">Add New Event</h4>

<div class="card p-4">

<form id="addEventForm" enctype="multipart/form-data">

<div class="row g-3">

<!-- IMAGE -->
<div class="col-12">
    <label>Event Image *</label>

    <div class="upload-box" id="uploadBox">
        <img src="https://via.placeholder.com/800x250" id="preview" class="event-img">
        <br>
        <input type="file" id="eventImage" name="eventImage" accept="image/*">
        <div class="error-text" id="imageError"></div>
    </div>
</div>

<!-- NAME -->
<div class="col-md-6">
    <label>Event Name *</label>
    <input type="text" id="eventName" name="eventName" class="form-control">
</div>

<!-- DATE -->
<div class="col-md-6">
    <label>Date *</label>
    <input type="date" id="eventDate" name="eventDate" class="form-control">
</div>

<!-- STATUS -->
<div class="col-md-6">
    <label>Status *</label>
    <select id="eventStatus" name="eventStatus" class="form-select">
        <option value="">Select</option>
        <option>Active</option>
        <option>Upcoming</option>
        <option>Closed</option>
    </select>
</div>

<!-- TYPE -->
<div class="col-md-6">
    <label>Event Type *</label>
    <select id="eventType" name="eventType" class="form-select">
        <option value="">Select</option>
        <option value="Paid">Paid</option>
        <option value="Unpaid">Unpaid</option>
    </select>
</div>

<!-- DESC -->
<div class="col-12">
    <label>Description *</label>
    <textarea id="eventDescription" name="eventDescription" class="form-control"></textarea>
</div>

</div>

<div class="mt-4">
    <button type="button" id="submitBtn" class="btn btn-danger">Save</button>
</div>

</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // ✅ IMAGE PREVIEW WORKING FIX
    $("#eventImage").on("change", function(){
        let file = this.files[0];

        if(file){
            let reader = new FileReader();
            reader.onload = function(e){
                $("#preview").attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // LIVE VALIDATION
    $("input, select, textarea").on("input change", function(){
        if($(this).val().trim() !== ""){
            $(this).removeClass("input-error").addClass("input-success");
        } else {
            $(this).removeClass("input-success");
        }
    });

    $("#submitBtn").click(function(){

        let valid = true;

        $(".error-text").text("");
        $("input, select, textarea").removeClass("input-error");
        $("#uploadBox").removeClass("upload-error upload-success");

        function err(el,msg){
            el.addClass("input-error");
            el.after("<div class='error-text'>"+msg+"</div>");
            valid=false;
        }

        let image=$("#eventImage");
        let name=$("#eventName");
        let date=$("#eventDate");
        let status=$("#eventStatus");
        let type=$("#eventType");
        let desc=$("#eventDescription");

        // IMAGE VALIDATION
        if(image.val()==""){
            $("#uploadBox").addClass("upload-error");
            $("#imageError").text("Upload image");
            valid=false;
        }

        if(name.val()=="") err(name,"Enter name");
        if(date.val()=="") err(date,"Select date");
        if(status.val()=="") err(status,"Select status");
        if(type.val()=="") err(type,"Select type");
        if(desc.val()=="") err(desc,"Enter description");

        if(!valid){
            Swal.fire("Error","Fill all fields","error");
            return;
        }

        let formData=new FormData($("#addEventForm")[0]);

        $.ajax({
            url:"add_event_process.php",
            type:"POST",
            data:formData,
            contentType:false,
            processData:false,
            success:function(res){
                if(res.trim()=="success"){
                    Swal.fire("Success","Event Added","success")
                    .then(()=>location.href="all_events_page.php");
                }else{
                    Swal.fire("Error",res,"error");
                }
            }
        });

    });

});
</script>

<?php include 'admin_footer.php'; ?>