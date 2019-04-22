{!! HTML::script('resources/assets/backend/js/master.js') !!}
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $_REQUEST['id']!="" ? trans('messages.lbl_Edit') : trans('messages.lbl_Add') ?> @lang('messages.lbl_Program')</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <form id="programSubmitForm" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="col-md-12 form-group">
            <label for="programName">@lang('messages.lbl_ProgramName')</label>
            <input type="text" name="programName" id="programName" class="form-control" placeholder="Enter program" value="<?php echo $_REQUEST['id']!="" ? $details[0]->Program : '' ?>">
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.lbl_cancel')</button>
      <button type="button" class="btn btn-success" id="programSubmitBtn">@lang('messages.lbl_Add')</button>
    </div>
  </div>

</div>