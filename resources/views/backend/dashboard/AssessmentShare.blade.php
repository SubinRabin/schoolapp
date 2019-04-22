@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/select2/select2.css') !!}
{!! HTML::script('resources/assets/common/assets/select2/select2.min.js') !!}
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_Assessment')</h4>
            <ol class="breadcrumb pull-right">
                
            </ol>
        </div>
    </div>
    <div style="border-bottom: 2px solid grey;margin-bottom: 10px" class="col-md-12"></div>

    <div class="row">
        <form method="post" action="{{ url('backend/assessmentFileUpload') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : '' ?>">
        <div class="col-md-12 form-group">
            <p>@lang('messages.lbl_ChooseReceiver')</p>
        </div>
        <div class="col-md-12 form-group">
            <?php
                $selected = '';
                $explode = array();
                 if (isset($details[0]->studentId)) {
                    $explode = explode(",", $details[0]->studentId);
                }
             ?>
            <label>@lang('messages.lbl_Students')</label>
            <select class="select2" id="Students" name="Students[]" multiple="" data-placeholder="Choose a class students..." required="">
                <?php 
                    $i = 0;
                    foreach ($student as $key => $value) {
                        if (isset($explode[$i]) && $explode[$i]==$value->studentId) {
                            $selected = 'selected';
                            $i++;
                        } else {
                            $selected = "";
                        }
                         ?>
                        <option <?php echo $selected ?> value="<?php echo $value->studentId ?>"><?php echo $value->studentId ?></option>
                    <?php } ?>
            </select>
        </div>
        <div class="col-md-12 form-group">
            <p>@lang('messages.lbl_AssessmentDetails')</p>
        </div>
        <div class="col-md-12 form-group">
            <label>Title</label>
            <input type="text" name="Title" class="form-control" required="" value="<?php echo isset($details[0]->title) ? $details[0]->title : '' ?>">
        </div>
        <div class="col-md-12 form-group">
            <label>@lang('messages.lbl_AssessmentType')</label>
            <select class="form-control" name="AssessmentType">
              <option <?php echo isset($details[0]->AssessmentType) && $details[0]->AssessmentType=='Admission_Assessment' ? 'selected' : '' ?> value="Admission_Assessment">@lang('messages.lbl_FirstAssessment')</option>
              <option <?php echo isset($details[0]->AssessmentType) && $details[0]->AssessmentType=='First_Term' ? 'selected' : '' ?> value="First_Term">@lang('messages.lbl_FirstTerm')</option>
              <option <?php echo isset($details[0]->AssessmentType) && $details[0]->AssessmentType=='Second_Term' ? 'selected' : '' ?> value="Second_Term">@lang('messages.lbl_SecondTerm')</option>
            </select>
        </div>
        <div class="col-md-12 form-group">
            <label>@lang('messages.lbl_File')</label>
            <input type="file" name="assessmentFiles" id="assessmentFiles" onchange="return ValidateFileUpload1();" required="">
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
        var fuData = document.getElementById('assessmentFiles');
        var FileUploadPath = fuData.value;

//To check if user upload any file
        
        var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

    if (Extension == "xltx" || Extension == "xls" || Extension == "pdf" || Extension == "ppsx" || Extension == "docx" || Extension == "xlsx" || Extension == "doc" || Extension == "ods") {

            if (typeof ($("#assessmentFiles")[0].files) != "undefined") {
                if ($("#assessmentFiles")[0].files[0].size > 8388608) {
                      error = "Max size of file 8MB ";
                      color = "red";
                      $("#assessmentFiles").val("");
                      addToast(error,color);
                }
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
              error = "Only allows file types of XLTX, xlx ,pdf ,PPSX ,DOCX ,XLSX ,ODS and DOC. ";
              color = "red";
              $("#assessmentFiles").val("");
              addToast(error,color);
        }
}
</script>

@endsection                
