{!! HTML::script('resources/assets/backend/js/admin.js') !!}
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $_REQUEST['id']!="" ? trans('messages.lbl_Edit') : trans('messages.lbl_Add') ?> @lang('messages.lbl_User')</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <input type="hidden" id="checkstatus" value="0">
        <form id="adminSubmitForm" method="post" enctype="multipart/form-data" autocomplete="off">
         {{ csrf_field() }}
          <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="col-md-6 form-group">
            <span class="single-upload-img">
              <?php 
              $ProfileImage = '../resources/assets/common/images/Photo-icon.png';
              if ($_REQUEST['id']!="" && $details[0]->Profile!="") {
                $ProfileImage = '../Uploads/Admin/'.$details[0]->id.'/'.$details[0]->Profile;
              } ?>
              <img  id="load_image" src="<?php echo $ProfileImage; ?>">
            </span>
            <input type="file" style="margin-top: 47px;" name="Profile" id="Profile" class="form-control" onchange="return ValidateFileUpload();">
          </div>
          <div class="col-md-6 form-group">
            <label for="roleName">@lang('messages.lbl_Username')</label>
            <input type="text" autocomplete="off" name="Username" id="Username" class="form-control" placeholder="Enter Username" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Username : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="roleName">@lang('messages.lbl_Name')</label>
            <input type="text" autocomplete="off" name="Name" id="Name" class="form-control" placeholder="Enter name" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Name : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="Email">@lang('messages.lbl_email')</label>
            <input type="text" autocomplete="off" name="Email" id="Email" class="form-control" placeholder="Enter email" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Email : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="number">@lang('messages.lbl_Cnumber')</label>
            <input type="number" autocomplete="off" name="number" id="number" class="form-control" placeholder="Enter mobile number" onkeypress ="return numberonly(event)"  value="<?php echo $_REQUEST['id']!="" ? $details[0]->Mobile : '' ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="Role">@lang('messages.lbl_Role')</label>
            <select  class="form-control" id="Role" name="Role">
              <option value="">--Select Role--</option>
              <?php foreach ($roles as $key => $value) { 
                if ($value->id!=1) {
                ?>
                <option <?php echo $_REQUEST['id']!="" && $details[0]->Role==$value->id ? 'selected' : '' ?> value="<?php echo $value->id ?>"><?php echo $value->RoleName ?></option>
              <?php } } ?>
            </select>
          </div>
          <?php if ( $_REQUEST['id']!="") { ?>
            <div class="col-md-12">
              <p><input type="checkbox" name="changeapass" id="changeapass" value="1">
                <label for="changeapass">@lang('messages.lbl_changepassword')</label>
              </p>
            </div>  
          <?php } ?>
          <div class="col-md-6 form-group">
            <label for="Password">@lang('messages.lbl_password')</label>
            <input autocomplete="off" type="password" name="Password" <?php echo $_REQUEST['id']!="" ? 'disabled' : '' ?> id="Password" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label for="CPassword">@lang('messages.lbl_confirmpassword')</label>
            <input autocomplete="off" type="password" <?php echo $_REQUEST['id']!="" ? 'disabled' : '' ?> name="CPassword" id="CPassword" class="form-control">
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.lbl_cancel')</button>
      <button type="button" class="btn btn-success" id="adminSubmitBtn">@lang('messages.lbl_submit')</button>
    </div>
  </div>

</div>
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