@extends('student.layouts.app')
@section('content')
{!! HTML::script('resources/assets/student/js/student.js') !!}
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
        <!-- <form method="post" id="studentSubmitForm" action="studentProfileSubmit" enctype="multipart/form-data"> -->
          {{ csrf_field() }}
        <div class="col-md-6 form-group">
            <span class="single-upload-img">
              <?php 
              $ProfileImage = '../app/resources/assets/common/images/Photo-icon.png';
              if ($data[0]->Profile!="") {
                $ProfileImage = '../app/Uploads/Student/'.$data[0]->studentId.'/'.$data[0]->Profile;
              } ?>
              <img  id="load_image" src="<?php echo $ProfileImage; ?>">
            </span>
            <!-- <input type="file" style="margin-top: 47px;" name="Profile" id="Profile" class="form-control" onchange="return ValidateFileUpload();"> -->
          </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_LoginName')</label>
            <input type="text" readonly="" value="<?php echo $data[0]->Username; ?>" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_totstudentId')</label>
            <input type="text" readonly="" value="<?php echo $data[0]->studentId; ?>" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_Name')</label>
            <input type="text" readonly="" value="<?php echo $data[0]->Name; ?>" readonly="" class="form-control" id="Name" name="Name">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_ParentName')</label>
            <input type="text" readonly="" value="<?php echo $data[0]->ParentName; ?>" readonly="" class="form-control" id="parentName" name="parentName">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_email')</label>
            <input type="text" readonly="" value="<?php echo $data[0]->Email; ?>" class="form-control" id="Email" name="Email">
        </div>
        <div class="col-md-6 form-group">
            <label class="pull-left" style="width: 100%;">@lang('messages.lbl_Cnumber')</label>
            <select class="form-control pull-left" readonly="" name="CountryCode" style="width: 20%;">
              <?php foreach ($countryCode as $key => $value) { ?>
                  <option <?php echo $data[0]->CountryCode==$value->CountryCode ? 'selected' : '' ?> value="<?php echo $value->CountryCode ?>"><?php echo $value->CountryCode ?></option>
              <?php } ?>
            </select>
            <input type="number"  readonly="" value="<?php echo $data[0]->Mobile; ?>" class="form-control pull-left" style="width: 80%;" id="number" name="number">
        </div>
        <div class="col-md-6 form-group">
            <label>@lang('messages.lbl_Classroom')</label>
            <input type="text" value="<?php echo $data[0]->classRoom; ?>" readonly class="form-control">
        </div>
        <!-- <div class="col-md-6 form-group">
            <label>Section</label>
            <input type="text" value="<?php echo $data[0]->section; ?>" readonly class="form-control">
        </div> -->
        <!-- <div class="col-md-12">
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
            <button type="button" class="btn btn-primary pull-right" id="studentSubmitBtn">@lang('messages.lbl_update')</button>
        </div> -->
        <!-- </form> -->
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
