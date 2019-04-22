@extends('teacher.layouts.app')
@section('content')
{!! HTML::script('resources/assets/teacher/js/teacher.js') !!}
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
        <form method="post" id="TeacherProfileSubmitForm" action="TeacherProfileSubmit" enctype="multipart/form-data">
          {{ csrf_field() }}
        <div class="col-md-6 form-group">
            <span class="single-upload-img">
              <?php 
              $ProfileImage = '../app/resources/assets/common/images/Photo-icon.png';
              if ($details[0]->Profile!="") {
                if (session::get('TeacherRole')=='Teacher') {
                  $ProfileImage = '../app/Uploads/Teacher/'.$details[0]->id.'/'.$details[0]->Profile;
                } else {
                  $ProfileImage = '../app/Uploads/Therapist/'.$details[0]->id.'/'.$details[0]->Profile;
                }
              } ?>
              <img  id="load_image" src="<?php echo $ProfileImage; ?>">
            </span>
            <input type="file" style="margin-top: 47px;" name="Profile" id="Profile" class="form-control" onchange="return ValidateFileUpload();">
        </div>
        <div class="col-md-6 form-group">
            <label for="roleName">@lang('messages.lbl_Name')</label>
            <input type="text" name="Name" id="Name" class="form-control" placeholder="Enter name" value="<?php echo $details[0]->Name;?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="Email">@lang('messages.lbl_email')</label>
            <input type="text" name="Email" id="Email" class="form-control" placeholder="Enter email" value="<?php echo $details[0]->Email ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="number">@lang('messages.lbl_MobileNumber')</label>
            <input type="number" name="number" id="number" class="form-control" placeholder="Enter mobile number" value="<?php echo $details[0]->CNumber ?>">
          </div>
          <?php if (session::get('TeacherRole')!='Therapist') { ?>
          <div class="col-md-6 form-group">
            <label for="Qualification">@lang('messages.lbl_Qualification')</label>
            <input type="text" name="Qualification" id="Qualification" class="form-control" placeholder="Enter qualification" value="<?php echo $details[0]->Qualification ?>">
          </div>
          <?php } ?>
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
            <button type="button" class="btn btn-primary pull-right" id="TeacherProfileBtn">@lang('messages.lbl_update')</button>
        </div>
        </form>
    </div> <!-- End Row -->


</div> <!-- container -->
<script type="text/javascript">
  $(document).ready(function() {
    jQuery(".select2").select2({
            width: '100%'
        });
    });
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
