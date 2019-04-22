@extends('teacher.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/datatables/jquery.dataTables.min.css') !!}
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_StudentList')</h4>
            <ol class="breadcrumb pull-right">
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
                                        <th>@lang('messages.lbl_id')</th>
                                        <th>@lang('messages.lbl_totstudentId')</th>
                                        <th>@lang('messages.lbl_Name')</th>
                                        <th>@lang('messages.lbl_ParentName')</th>
                                        <th>@lang('messages.lbl_Cnumber')</th>
                                        <th>@lang('messages.lbl_Classroom')</th>
                                        <th>@lang('messages.lbl_Program')</th>
                                        <!-- <th>Section</th> -->
                                        <th>@lang('messages.lbl_Therapy')</th>
                                        <th>@lang('messages.lbl_Status')</th>
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
{!! HTML::script('resources/assets/teacher/js/student.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        studentTable();
    } );
</script>
@endsection                
