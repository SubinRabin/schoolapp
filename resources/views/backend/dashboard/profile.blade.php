@extends('backend.layouts.app')
@section('content')
{!! HTML::script('resources/assets/backend/js/admin.js') !!}
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_Profile')</h4>
            <ol class="breadcrumb pull-right">
               
            </ol>
        </div>
    </div>
    <div style="border-bottom: 2px solid grey;margin-bottom: 10px" class="col-md-12"></div>
    <div class="row">
        <form method="post" id="AdminProfileSubmitForm" action="AdminProfileSubmit" enctype="multipart/form-data">
          {{ csrf_field() }}
        <div class="col-md-6 form-group">
            <span class="single-upload-img">
                <?php 
                $ProfileImage = '../resources/assets/common/images/Photo-icon.png';
                if (session::get('AdminID')!="" && $data[0]->Profile!="") {
                    $ProfileImage = '../Uploads/Admin/'.$data[0]->id.'/'.$data[0]->Profile;
                } ?>
                <img  id="load_image" src="<?php echo $ProfileImage; ?>">
            </span>
            <input type="file" style="margin-top: 47px;" name="Profile" id="Profile" class="form-control" onchange="return ValidateFileUpload();">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_Name')</label>
            <input type="text" value="<?php echo $data[0]->Name; ?>" class="form-control" id="Name" name="Name">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_email')</label>
            <input type="text" value="<?php echo $data[0]->Email; ?>" class="form-control" id="Email" name="Email" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_Cnumber')</label>
            <input type="number" value="<?php echo $data[0]->Mobile; ?>" class="form-control" id="number" name="number">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_AdminRole')</label>
            <input type="text" value="<?php echo $data[0]->RoleName; ?>" class="form-control" readonly>
        </div>
        <div class="col-md-12">
            <p><input type="checkbox" name="changeapass" id="changeapass" value="1">
              <label for="changeapass">@lang('messages.lbl_changepassword')</label>
            </p>
        </div>  
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_password')</label>
            <input type="Password" value="" class="form-control" id="Password" disabled="" id="Password" name="Password">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_confirmpassword')</label>
            <input type="Password" value="" class="form-control" id="CPassword" disabled="" id="CPassword" name="CPassword">
        </div>
        <div class="col-md-12 form-group">
            <button type="button" class="btn btn-primary pull-right" id="AdminProfileSubmitBtn">@lang('messages.lbl_update')</button>
        </div>
        </form>
    </div> <!-- End Row -->


</div> <!-- container -->
<script type="text/javascript">
    function ValidateFileUpload() {
        var fuData = document.getElementById('Profile');
        var FileUploadPath = fuData.value;

//To check if user upload any file
      
        var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

if (Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

// To Display
          if (fuData.files && fuData.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  $('#load_image').attr('src', e.target.result);
              }

              reader.readAsDataURL(fuData.files[0]);
          }

      } 
//The file upload is NOT an image
else {
      error = "Photo only allows file types of JPG, JPEG and BMP. ";
      color = "red";
      $("#Profile").val("");
      $("#load_image").attr("src","");
      addToast(error,color);
      }
}
</script>
@endsection                
