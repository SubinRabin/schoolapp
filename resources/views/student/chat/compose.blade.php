@extends('student.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <!-- INBOX -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4 class="panel-title">
                            <?php echo isset($_REQUEST['msgId']) ? trans('messages.lbl_ComposeMessage') : trans('messages.lbl_ComposeMessage'); ?> 
                        </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="inbox-widget nicescroll mx-box">
                        <form method="post" action="{{ url('composeSend') }}">
                     {{ csrf_field() }}
                        <?php if (isset($_REQUEST['msgId'])) { ?>
                            <input type="hidden" name="to" value="<?php echo $_REQUEST['replyId'] ?>">
                        <?php } else { ?>
                            <div class="col-md-12">
                            <br>
                                <label>@lang('messages.lbl_To')</label>
                                <select name="to" class="form-control">
                                    <?php foreach ($adminList as $key => $value) { 
                                        if ($value->Role==3) {
                                        ?>
                                        <option value="<?php echo $value->id ?>"><?php echo $value->Name ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-md-12">
                        <br>
                            <label>@lang('messages.lbl_Subject')</label>
                            <input type="text" name="Subject" class="form-control" required="">
                        </div>
                        <br>
                        <div class="col-md-12">
                        <br>
                            <label>@lang('messages.lbl_Message')</label>
                            <textarea class="form-control" name="Message" rows="5" required=""></textarea>
                        </div>
                        <div class="col-md-12">
                        <br>
                        <button class="btn btn-primary pull-right">@lang('messages.lbl_Send')</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div> <!-- container -->
@endsection   