@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/datatables/jquery.dataTables.min.css') !!}
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_ClassRoomList')</h4>
            <ol class="breadcrumb pull-right">
                <span><button class="btn btn-primary" onclick="classRoomModalfun('')" >@lang('messages.lbl_AddClassRoom')</button></span>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="classRoomtable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.lbl_id')</th>
                                        <th>@lang('messages.lbl_ClassRoomName')</th>
                                        <th>@lang('messages.lbl_CreateDate')</th>
                                        <th>@lang('messages.lbl_UpdateDate')</th>
                                        <th>@lang('messages.lbl_Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- End Row -->


</div> <!-- container -->
<div id="classRoomModal" class="modal fade" role="dialog">
</div>
{!! HTML::script('resources/assets/common/assets/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('resources/assets/common/assets/datatables/dataTables.bootstrap.js') !!}

{!! HTML::script('resources/assets/backend/js/master.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        classroomTable();
    } );
function  classroomTable() {
    $('#classRoomtable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'master/classRoomList',
"language": {
              "paginate": {
                "next": "<?php echo trans('messages.lbl_DTnext') ?>",
                "previous": "<?php echo trans('messages.lbl_DTPrevious') ?>"
              },
              "search":"<?php echo trans('messages.lbl_DTSearch') ?>",
              "lengthMenu": "<?php echo trans('messages.lbl_DTShoW') ?> _MENU_ <?php echo trans('messages.lbl_DTentries') ?>",
              "zeroRecords": "<?php echo trans('messages.lbl_DTNomatchingrecordsfound') ?>",
              "info": "<?php echo trans('messages.lbl_DTShowing') ?> _PAGE_ <?php echo trans('messages.lbl_DTto') ?> _PAGES_ <?php echo trans('messages.lbl_DTof') ?> _MAX_ <?php echo trans('messages.lbl_DTentries') ?>",
              "infoEmpty": "<?php echo trans('messages.lbl_DTNomatchingrecordsfound') ?>",
              "infoFiltered": "(_MAX_ <?php echo trans('messages.lbl_DTtotalentries') ?>)",
               
             },
                columns: [
                {data: 'rownum', name: 'rownum', "searchable": false},
                {data: 'classRoom', name: 'classRoom'},
                {data: 'CreatedDate', name: 'CreatedDate'},
                {data: 'UpdatedDate', name: 'UpdatedDate'},
                {data: 'action', name: 'action',targets: 'no-sort', orderable: false}
            ]
    });
}
</script>
</script>
@endsection                
