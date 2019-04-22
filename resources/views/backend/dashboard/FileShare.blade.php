@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/select2/select2.css') !!}
{!! HTML::script('resources/assets/common/assets/select2/select2.min.js') !!}

<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_FileShare')</h4>
            <ol class="breadcrumb pull-right">
                
            </ol>
        </div>
    </div>
    <div style="border-bottom: 2px solid grey;margin-bottom: 10px" class="col-md-12"></div>

    <div class="row">
        <form method="post" enctype="multipart/form-data" action="{{ url('backend/galleryFileUpload') }}" files="true">
          {{ csrf_field() }}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 form-group">
                <p>@lang('messages.lbl_ChooseReceiver')</p>
            </div>
            <div class="col-md-12 form-group">
                <label>@lang('messages.lbl_Students')</label>
                <select class="select2" id="Students" name="Students[]" multiple="" data-placeholder="Choose a class students..." required="">
                    <?php foreach ($student as $key => $value) { ?>
                        <option value="<?php echo $value->studentId ?>"><?php echo $value->studentId ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <p>@lang('messages.lbl_FileDetails') </p>
            </div>
            <div class="col-md-12 form-group">
                <label>@lang('messages.lbl_Title')</label>
                <input type="text" name="Title" class="form-control" required="">
            </div>
            <div class="col-md-12 form-group">
                <label>@lang('messages.lbl_File')</label>
                <input type="file" name="galleryFiles" id="galleryFiles" onchange="return ValidateFileUpload();" required="">
            </div>
            <div class="col-md-12 form-group">
                <button class="btn btn-primary pull-right">@lang('messages.lbl_Upload')</button>
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
        var fuData = document.getElementById('galleryFiles');
        var FileUploadPath = fuData.value;

//To check if user upload any file
        
        var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

    if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {

            if (typeof ($("#galleryFiles")[0].files) != "undefined") {
                // if ($("#galleryFiles")[0].files[0].size > 8388608) {
                //       error = "Max size of file 8MB ";
                //       color = "red";
                //       $("#galleryFiles").val("");
                //       addToast(error,color);
                // }
            } 
// To Display
          // if (fuData.files && fuData.files[0]) {
          //     var reader = new FileReader();
          //     reader.onload = function(e) {
          //     }

          //     reader.readAsDataURL(fuData.files[0]);
          // }

      } 
//The file upload is NOT an image
        else {
              error = "Only allows file types of JPG, JPEG ,PNG. ";
              color = "red";
              $("#galleryFiles").val("");
              addToast(error,color);
        }
}
</script>

@endsection                
