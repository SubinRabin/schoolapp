{!! HTML::script('resources/assets/backend/js/teacher.js') !!}
{!! HTML::style('resources/assets/common/assets/select2/select2.css') !!}

<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $_REQUEST['id']!="" ? trans('messages.lbl_Edit') : trans('messages.lbl_Add') ?> @lang('messages.lbl_Teacher')</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <input type="hidden" id="checkstatusUname" value="0">
        <form id="teacherSubmitForm" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
          <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="col-md-6 form-group">
            <span class="single-upload-img">
              <?php 
              $ProfileImage = '../resources/assets/common/images/Photo-icon.png';
              if ($_REQUEST['id']!="" && $details[0]->Profile!="") {
                $ProfileImage = '../Uploads/Teacher/'.$details[0]->id.'/'.$details[0]->Profile;
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
            <label for="roleName">@lang('messages.lbl_Name')</label>
            <input type="text" autocomplete="nope" name="Name" id="Name" class="form-control" placeholder="Enter name" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Name : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="Email">@lang('messages.lbl_email')</label>
            <input type="text" autocomplete="nope" name="Email" id="Email" class="form-control" placeholder="Enter email" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Email : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="number">@lang('messages.lbl_MobileNumber')</label>
            <input type="number" autocomplete="nope" name="number" id="number" class="form-control" placeholder="Enter mobile number" value="<?php echo $_REQUEST['id']!="" ? $details[0]->CNumber : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="Qualification">@lang('messages.lbl_Qualification')</label>
            <input type="text" autocomplete="nope" name="Qualification" id="Qualification" class="form-control" placeholder="Enter qualification" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Qualification : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <?php 
              $explodeClassRoom  = array();
              if ($_REQUEST['id']!="") {
                $explodeClassRoom =  explode(",", $details[0]->ClassRoom);
              }
              $selectClassRoom = '';
             ?>
            <label for="ClassRoom">@lang('messages.lbl_Classroom')</label>
            <select class="select2" id="ClassRoom" name="ClassRoom[]" multiple="" data-placeholder="Choose a class room...">
              <?php 
                $i=0;
                foreach ($classRoom as $key => $value) { 
                  if ( isset($explodeClassRoom[$i]) && $explodeClassRoom[$i]==$value->id) {
                    $selectClassRoom = 'selected';
                    $i++;
                  } else {
                    $selectClassRoom = "";
                  }
                ?>
                  <option <?php echo $selectClassRoom; ?> value="<?php echo $value->id ?>"><?php echo $value->classRoom ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <?php 
              $explodeProgram  = array();
              if ($_REQUEST['id']!="") {
                $explodeProgram =  explode(",", $details[0]->Program);
              }
              $selectProgram = '';
             ?>
            <label for="Program">@lang('messages.lbl_Program')</label>
            <select class="select2" id="Program" name="Program[]" multiple="" data-placeholder="Choose a program...">
              <?php
                $i=0;
                foreach ($Program as $key => $value) { 
                  if ( isset($explodeProgram[$i]) && $explodeProgram[$i]==$value->id) {
                    $selectProgram = 'selected';
                    $i++;
                  } else {
                    $selectProgram = "";
                  }
                  ?>
                  <option <?php echo $selectProgram; ?> value="<?php echo $value->id ?>"><?php echo $value->Program ?></option>
              <?php } ?>
            </select>
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
              <input autocomplete="nope" type="password" name="Password" <?php echo $_REQUEST['id']!="" ? 'disabled' : '' ?> id="Password" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label for="CPassword">@lang('messages.lbl_confirmpassword')</label>
              <input autocomplete="nope" type="password" <?php echo $_REQUEST['id']!="" ? 'disabled' : '' ?> name="CPassword" id="CPassword" class="form-control">
            </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.lbl_cancel')</button>
      <button type="button" class="btn btn-success" id="teacherSubmitBtn">@lang('messages.lbl_submit')</button>
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
