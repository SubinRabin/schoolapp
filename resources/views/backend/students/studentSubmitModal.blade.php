{!! HTML::script('resources/assets/backend/js/student.js') !!}
{!! HTML::style('resources/assets/common/assets/select2/select2.css') !!}
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $_REQUEST['id']!="" ? trans('messages.lbl_Edit') : trans('messages.lbl_Add') ?> @lang('messages.lbl_Student')</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <input type="hidden" id="checkstatus" value="0">
        <input type="hidden" id="checkstatusUname" value="0">
        <form id="studentSubmitForm" method="post" enctype="multipart/form-data" autocomplete="nope">
         {{ csrf_field() }}
          <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="col-md-6 form-group">
            <span class="single-upload-img">
              <?php 
              $ProfileImage = '../resources/assets/common/images/Photo-icon.png';
              if ($_REQUEST['id']!="" && $details[0]->Profile!="") {
                $ProfileImage = '../Uploads/Student/'.$details[0]->studentId.'/'.$details[0]->Profile;
              } ?>
              <img  id="load_image" src="<?php echo $ProfileImage; ?>">
            </span>
            <input type="file" style="margin-top: 47px;" name="Profile" id="Profile" class="form-control" onchange="return ValidateFileUpload();">
          </div>
          <div class="col-md-6 form-group">
            <label for="roleName">@lang('messages.lbl_LoginName')</label>
            <input type="text" autocomplete="nope" name="Username" id="Username" class="form-control" placeholder="Enter name" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Username : '' ?>">
          </div>
           <div class="col-md-6 form-group">
            <label for="roleName">@lang('messages.lbl_totstudentId')</label>
            <input type="text" autocomplete="nope" name="studentId" id="studentId" class="form-control" placeholder="Enter student id" value="<?php echo $_REQUEST['id']!="" ? $details[0]->studentId : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="roleName">@lang('messages.lbl_StudentName')</label>
            <input type="text" autocomplete="nope" name="Name" id="Name" class="form-control" placeholder="Enter name" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Name : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="parentName">@lang('messages.lbl_ParentName')</label>
            <input type="text" autocomplete="nope" name="parentName" id="parentName" class="form-control" placeholder="Enter parent name" value="<?php echo $_REQUEST['id']!="" ? $details[0]->ParentName : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="number">@lang('messages.lbl_email')</label>
            <input  type="text" autocomplete="nope" name="Email" id="Email" class="form-control" placeholder="Enter email" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Email : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="number" class="pull-left" style="width: 100%;">@lang('messages.lbl_MobileNumber')</label>
            <select class="form-control pull-left" name="CountryCode" style="width: 35%;">
              <?php foreach ($countryCode as $key => $value) { ?>
                  <option <?php echo $_REQUEST['id']!="" && $details[0]->CountryCode==$value->CountryCode ? 'selected' : '' ?> value="<?php echo $value->CountryCode ?>"><?php echo $value->CountryCode ?></option>
              <?php } ?>
            </select>
            <input type="number" autocomplete="nope" name="number" id="number" class="form-control pull-left" style="width: 65%;" placeholder="Enter mobile number" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Mobile : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="ClassRoom">@lang('messages.lbl_Classroom')</label>
            <select class="form-control" id="ClassRoom" name="ClassRoom">
              <option value="">--Select class room--</option>
              <?php foreach ($classRoom as $key => $value) { ?>
                  <option <?php echo $_REQUEST['id']!="" && $details[0]->classRoom==$value->id ? 'selected' : '' ?> value="<?php echo $value->id ?>"><?php echo $value->classRoom ?></option>
              <?php } ?>
            </select>
          </div>
          <!-- <div class="col-md-6 form-group">
            <label for="section">Section</label>
            <select class="form-control" id="section" name="section">
              <option value="">--Select section--</option>
              <?php foreach ($section as $key => $value) { ?>
                  <option <?php echo $_REQUEST['id']!="" && $details[0]->section==$value->id ? 'selected' : '' ?> value="<?php echo $value->id ?>"><?php echo $value->section ?></option>
              <?php } ?>
            </select>
          </div> -->
          <div class="col-md-6 form-group">
            <?php 
              $explodeprogram  = array();
              if ($_REQUEST['id']!="") {
                $explodeprogram =  explode(",", $details[0]->program);
              }
              $selectprogram = '';
             ?>
            <label for="Program">@lang('messages.lbl_Programn')</label>
            <select class="select2" autocomplete="nope" id="Program" name="Program[]" multiple="" data-placeholder="Choose a class program...">
              <?php 
              $i=0;
              foreach ($Program as $key => $value) {
                if ( isset($explodeprogram[$i]) && $explodeprogram[$i]==$value->id) {
                    $selectprogram = 'selected';
                    $i++;
                  } else {
                    $selectprogram = "";
                  }
               ?>
                  <option <?php echo $selectprogram; ?> value="<?php echo $value->id ?>"><?php echo $value->Program ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-6 form-group">
             <?php 
              $explodeTherapy  = array();
              if ($_REQUEST['id']!="") {
                $explodeTherapy =  explode(",", $details[0]->Therapy);
              }
              $selectTherapy = '';
             ?>
            <label for="Therapist">@lang('messages.lbl_Therapy')</label>
            <select class="select2" autocomplete="nope" id="Therapy" name="Therapy[]" multiple="" data-placeholder="Choose a class therapy...">
              <?php 
               $i=0;
              foreach ($Therapy as $key => $value) { 
                if ( isset($explodeTherapy[$i]) && $explodeTherapy[$i]==$value->id) {
                    $selectTherapy = 'selected';
                    $i++;
                  } else {
                    $selectTherapy = "";
                  }
                ?>
                  <option <?php echo $selectTherapy; ?> value="<?php echo $value->id ?>"><?php echo $value->therapyType ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="row col-md-12">
          <div class="col-md-6 form-group">
            <?php 
              $explodeTherapist  = array();
              if ($_REQUEST['id']!="") {
                $explodeTherapist =  explode(",", $details[0]->Therapist);
              }
              $selectTherapist = '';
             ?>
            <label for="Therapist">@lang('messages.lbl_Therapist')</label>
            <select class="select2" autocomplete="nope" id="Therapist" name="Therapist[]" multiple="" data-placeholder="Choose a class therapist...">
              <?php
                $i=0;
               foreach ($Therapist as $key => $value) {
                if ( isset($explodeTherapist[$i]) && $explodeTherapist[$i]==$value->id) {
                    $selectTherapist = 'selected';
                    $i++;
                  } else {
                    $selectTherapist = "";
                  }
                ?>
                  <option <?php echo $selectTherapist; ?> value="<?php echo $value->id ?>"><?php echo $value->Name ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <?php 
              $explodeSectionHead  = array();
              if ($_REQUEST['id']!="") {
                $explodeSectionHead =  explode(",", $details[0]->SectionHead);
              }
              $selectSectionHead = '';
             ?>
            <label for="SectionHead">@lang('messages.lbl_SectionHead')</label>
            <select class="select2" autocomplete="nope" id="SectionHead" name="SectionHead[]" multiple="" data-placeholder="Choose a class Section head...">
              <?php
                $i=0;
               foreach ($SectionHead as $key => $value) {
                if ( isset($explodeSectionHead[$i]) && $explodeSectionHead[$i]==$value->id) {
                    $selectSectionHead = 'selected';
                    $i++;
                  } else {
                    $selectSectionHead = "";
                  }
                ?>
                  <option <?php echo $selectSectionHead; ?> value="<?php echo $value->id ?>"><?php echo $value->Name ?></option>
              <?php } ?>
            </select>
          </div>
          </div>
          <div class="clearfix"></div>
            <?php if ( $_REQUEST['id']!="") { ?>
              <div class="col-md-12">
                <p><input type="checkbox" name="changeapass" id="changeapass" value="1">
                  <label for="changeapass">@lang('messages.lbl_changepassword')</label>
                </p>
              </div>  
            <?php } ?>
            <div class="col-md-6 form-group">
              <label for="Password">@lang('messages.lbl_password')</label>
              <input type="password" autocomplete="off" name="Password" <?php echo $_REQUEST['id']!="" ? 'disabled' : '' ?> id="Password" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label for="CPassword">@lang('messages.lbl_confirmpassword')</label>
              <input type="password" <?php echo $_REQUEST['id']!="" ? 'disabled' : '' ?> name="CPassword" id="CPassword" autocomplete="off" class="form-control">
            </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.lbl_cancel')</button>
      <button type="button" class="btn btn-success" id="studentSubmitBtn">@lang('messages.lbl_submit')</button>
    </div>
  </div>

</div>
{!! HTML::script('resources/assets/common/assets/select2/select2.min.js') !!}
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