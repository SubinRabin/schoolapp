@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/datatables/jquery.dataTables.min.css') !!}
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_StudentList')</h4>
            <ol class="breadcrumb pull-right">
                <span><button class="btn btn-primary" onclick="studentSubmitModalfun('')" >@lang('messages.lbl_AddStudent')</button></span>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="studentTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">@lang('messages.lbl_id')</th>
                                        <th>@lang('messages.lbl_LoginName')</th>
                                        <th>@lang('messages.lbl_totstudentId')</th>
                                        <th width="10%">@lang('messages.lbl_StudentName')</th>
                                        <th width="10%">@lang('messages.lbl_ParentName')</th>
                                        <th width="10%">@lang('messages.lbl_Cnumber')</th>
                                        <th width="5%">@lang('messages.lbl_Classroom')</th>
                                        <th width="10%">@lang('messages.lbl_Programn')</th>
                                        <!-- <th>Section</th> -->
                                        <!-- <th>@lang('messages.lbl_Therapy')</th> -->
                                        <th width="15%">@lang('messages.lbl_Therapist')</th>
                                        <th width="15%">@lang('messages.lbl_SectionHead')</th>
                                        <th width="5%">@lang('messages.lbl_Status')</th>
                                        <th width="5%">@lang('messages.lbl_Action')</th>
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
<div id="myModal" class="modal fade" role="dialog">
</div>
{!! HTML::script('resources/assets/common/assets/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('resources/assets/common/assets/datatables/dataTables.bootstrap.js') !!}
{!! HTML::script('resources/assets/backend/js/student.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        studentTable();
    } );
function studentTable() {
   $('#studentTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'studentlist',
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
                {data: 'Username', name: 'Username'},
                {data: 'studentId', name: 'studentId'},
                {data: 'Name', name: 'Name'},
                {data: 'ParentName', name: 'ParentName'},
                {data: 'Mobile', name: 'Mobile'},
                {data: 'classRoom', name: 'tbl_classroom.classRoom'},
                {data: 'Program', name: 'Program'},
                // {data: 'Therapy', name: 'Therapy'},
                {data: 'Therapist', name: 'Therapist'},
                {data: 'SectionHeadData', name: 'SectionHeadData'},
                {data: 'Status', name: 'Status'},
                {data: 'action', name: 'action',targets: 'no-sort', orderable: false}
            ]
    });
}
</script>
@endsection                
