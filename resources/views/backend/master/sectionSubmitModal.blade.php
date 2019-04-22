{!! HTML::script('resources/assets/backend/js/master.js') !!}
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $_REQUEST['id']!="" ? trans('messages.lbl_Edit') : trans('messages.lbl_Add') ?> @lang('messages.lbl_Section')</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <form id="sectionSubmitForm" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="col-md-12 form-group">
            <label for="sectionName">@lang('messages.lbl_SectionName')</label>
            <input type="text" name="sectionName" id="sectionName" class="form-control" placeholder="Enter section" value="<?php echo $_REQUEST['id']!="" ? $details[0]->section : '' ?>">
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.lbl_cancel')</button>
      <button type="button" class="btn btn-success" id="sectionSubmitBtn">@lang('messages.lbl_submit')</button>
    </div>
  </div>

</div>