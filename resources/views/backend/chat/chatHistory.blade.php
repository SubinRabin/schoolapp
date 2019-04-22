<?php
    use App\Model\admin;
    // $menuActive = substr(class_basename(Route::current()->controller), 0, -10);
    $menuActive = '';
    $role = admin::AdminRole(session::get('AdminID'));
?>
@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/datatables/jquery.dataTables.min.css') !!}
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_ChatLog')</h4>
            <ol class="breadcrumb pull-right">
                <?php if ($role==1) { ?>
                    <span><a href="{{ url('/backend/deleteAllChat') }}" class="btn btn-primary"  >@lang('messages.lbl_DeleteAll')</a></span>
                <?php } ?>
            </ol>
        </div>
    </div>
    <?php if (!isset($details['Name'])) {
        $details['Name'] = array();
    } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="ChatHistory" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.lbl_SNo')</th>
                                        <th>@lang('messages.lbl_Username')</th>
                                        <th>@lang('messages.lbl_UserRole')</th>
                                        <th>@lang('messages.lbl_CreateDate')</th>
                                        <th>@lang('messages.lbl_Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($details['Name'] as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key+1 ?></td>
                                            <td><?php echo $value; ?></td>
                                            <td><?php echo $details['Type'][$key]; ?></td>
                                            <td><?php echo $details['Date'][$key]; ?></td>
                                            <td>
                                                <?php if ($role!=1) { ?>
                                                <a href="chatLogview?mainType=<?php echo $details['Type'][$key]; ?>&Main=<?php echo $details['id'][$key]; ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a>
                                                <?php } ?>
                                                <?php if ($role==1) { ?>
                                                <a href="chatLogDelete?mainType=<?php echo $details['Type'][$key]; ?>&Main=<?php echo $details['id'][$key]; ?>" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- End Row -->


</div> <!-- container -->
<div id="sectionModal" class="modal fade" role="dialog">
</div>
{!! HTML::script('resources/assets/common/assets/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('resources/assets/common/assets/datatables/dataTables.bootstrap.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        $("#ChatHistory").DataTable();
    } );
</script>
</script>
@endsection                
