@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/select2/select2.css') !!}
{!! HTML::script('resources/assets/common/assets/select2/select2.min.js') !!}
<?php
use App\Model\admin;
$role = admin::AdminRole(session::get('AdminID'));
	
 ?>
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_Announcement')</h4>
            <ol class="breadcrumb pull-right">
                
            </ol>
        </div>
    </div>
    <div style="border-bottom: 2px solid grey;margin-bottom: 10px" class="col-md-12"></div>

    <div class="row">
        <p style="text-align: center;color:red;"><?php echo session::get('err_msg') ?></p>
        <p style="text-align: center;color:green;"><?php echo session::get('success_msg') ?></p>
        <form action="announcementSend" method="post">
          {{ csrf_field() }}
        <div class="col-md-12 form-group">
            <p>@lang('messages.lbl_ChooseReceiver')</p>
        </div>
        <div class="col-md-12 form-group">
            <label>@lang('messages.lbl_Students')</label>
            <p>
            <input type="Checkbox" id="selectAll"><label for="selectAll">@lang('messages.lbl_SelectAll')</label>
            </p>
            <?php if ($role==3) { ?>
	            <select class="select2" id="classRoom" name="classRoom[]" multiple="" data-placeholder="Choose a student...">
	                <?php foreach ($class as $key => $value) { ?>
	                    <option value="<?php echo $value->id ?>"><?php echo $value->studentId ?></option>
	                <?php } ?>
	            </select>
            <?php } else { ?>
            	<select class="select2" id="classRoom" name="classRoom[]" multiple="" data-placeholder="Choose a class room...">
	                <?php foreach ($class as $key => $value) { ?>
	                    <option value="<?php echo $value->id ?>"><?php echo $value->classRoom ?></option>
	                <?php } ?>
	            </select>
            <?php } ?>
        </div>
        <div class="col-md-12 form-group">
            <p>@lang('messages.lbl_Announcement')</p>
        </div>
        <div class="col-md-12 form-group">
            <label>@lang('messages.lbl_Subject')</label>
            <input type="text" name="Subject" class="form-control">
        </div>
        <div class="col-md-12 form-group">
            <label>@lang('messages.lbl_Message')</label>
            <textarea class="form-control" rows="6" name="Message"></textarea>
        </div>
        <div class="col-md-12 form-group">
            <button class="btn btn-primary pull-right">@lang('messages.lbl_Send')</button>
        </div>
        </form>
    </div> <!-- End Row -->


</div> <!-- container -->
<script type="text/javascript">
$(document).ready(function() {
    jQuery(".select2").select2({
            width: '100%'
        });
    $("#selectAll").click(function() {
        if($("#selectAll").is(':checked') ){
            $("#classRoom > option").prop("selected","selected");
            $("#classRoom > option").trigger('change');
        }else{
            $("#classRoom > option").removeAttr("selected");
            $("#classRoom > option").trigger('change');
         }
    });
});
</script>

@endsection                
