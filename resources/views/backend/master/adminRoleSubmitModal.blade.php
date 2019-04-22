{!! HTML::script('resources/assets/backend/js/master.js') !!}
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $_REQUEST['id']!="" ? 'Edit' : 'Add' ?> admin role</h4>
    </div>
      <form id="adminRoleSubmitForm" method="post">
    <div class="modal-body">
      <div class="row">
          <input type="hidden" name="_method" value="PUT">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="col-md-12 form-group">
            <label for="roleName">Role Name</label>
            <input type="text" name="roleName" id="roleName" class="form-control" placeholder="Enter role name" value="<?php echo $_REQUEST['id']!="" ? $details[0]->RoleName : '' ?>">
          </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-success" id="adminRoleSubmitBtn">Submit</button>
    </div>
    </form>
  </div>

</div>