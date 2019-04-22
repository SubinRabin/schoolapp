@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/datatables/jquery.dataTables.min.css') !!}
<?php 
use App\Model\dashboard;
 ?>
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_Filemanager')</h4>
            <ol class="breadcrumb pull-right">
                <span><a class="btn btn-primary" href="{{ url('/backend/AssessmentShare') }}">@lang('messages.lbl_addFile')</a></span>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="FileManagerTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.lbl_id')</th>
                                        <th>@lang('messages.lbl_totstudentId')</th>
                                        <th>@lang('messages.lbl_AssessmentType')</th>
                                        <th>@lang('messages.lbl_view')</th>
                                        <th class="no-sort">@lang('messages.lbl_Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $tab = array('Admission_Assessment/','First_Term/','Second_Term/');
                                    $details = dashboard::gallerylist(); 
                                    foreach ($details as $key => $value) {
                                        foreach ($tab as $key2 => $value2) {
                                            $files = Storage::disk('ftp')->allFiles('Family_Corner/Student/'.$value->studentId.'/assessment/'.$value2);
                                            foreach ($files as $key1 => $value1) {
                                                if (count($files)!=0) {
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $value->studentId; ?></td>
                                                <td>
                                                    <?php 
                                                        if ($value2=='Admission_Assessment/') {
                                                            echo 'Admission Assessment'; 
                                                        } else if($value2=='First_Term/') {
                                                            echo 'First Term'; 
                                                        } else {
                                                            echo 'Second Term'; 
                                                        }


                                                    ?>
                                                </td>
                                                <td><a target="_blank" href="<?php echo 'http://app.shumua.edu.sa/Family_Corner/'.$value1; ?>"><?php echo str_replace("Family_Corner/Student/".$value->studentId."/assessment/".$value2,"",$value1); ?></a></td>
                                                <td><a href="fileManagerDelete?id=<?php echo $value1 ?>" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a></td>
                                            </tr>
                                    <?php } } } } ?>
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
{!! HTML::script('resources/assets/backend/js/admin.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        // FileManagerTable();
       var t =  $('#FileManagerTable').DataTable( {
            "columnDefs": [ {
                  "targets": 'no-sort',
                  "orderable": false,
            } ]
        } );
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    } );
</script>
@endsection                
