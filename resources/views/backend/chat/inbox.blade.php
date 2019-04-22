@extends('backend.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <!-- INBOX -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Inbox <span><a style="line-height: 12px;" class="btn btn-primary btn-sm pull-right" href="{{ url('/backend/compose') }}">Compose</a></span></h4>
                </div>
                <div class="panel-body">
                    <div class="inbox-widget nicescroll mx-box">
                        <?php foreach ($inboxList as $key => $value) { ?>
                            <a href="{{ url('/backend/inboxView?msgId='.$value->id) }}">
                                <div class="inbox-item <?php echo $value->read=='0' ? 'dark' : ''; ?>">
                                    <div class="inbox-item-img"><img src="{{ ('../resources/assets/common/images/users/avatar-1.jpg') }}" class="img-circle" alt=""></div>
                                    <p class="inbox-item-author"><?php echo $value->studentId ?></p>
                                    <p class="inbox-item-text"><?php echo $value->Subject ?></p>
                                    <!-- <p class="inbox-item-date">13:40 PM</p> -->
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div> <!-- container -->
@endsection   