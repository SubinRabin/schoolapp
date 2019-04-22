@extends('teacher.layouts.app')
@section('content')
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_welcome') !</h4>
            <ol class="breadcrumb pull-right">
                <li class="active">@lang('messages.lbl_Dashboard')</li>
            </ol>
        </div>
    </div>

    <!-- Start Widget -->
    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-3">
            <div class="mini-stat clearfix bx-shadow">
                <span class="mini-stat-icon bg-primary"><i class="md md-school"></i></span>
                <div class="mini-stat-info text-right text-muted">
                    <span class="counter"><?php echo $student['active']+$student['Inactive'] ?></span>
                    @lang('messages.lbl_totstudents')
                </div>
                <div class="tiles-progress">
                    <div class="m-t-20">
                        <!-- <h5 class="text-uppercase">Users <span class="pull-right">57%</span></h5>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%;">
                                <span class="sr-only">57% Complete</span>
                            </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!-- End row-->

</div> <!-- container -->
@endsection                