@extends('backend.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <!-- INBOX -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4 class="panel-title">Inbox <span class="pull-right">
                        <?php if ($inboxdata[0]->sender==session::get('AdminID')) {
                             $sender =   $inboxdata[0]->receiver; 
                        } else {
                             $sender =   $inboxdata[0]->sender; 
                        }

                        ?>
                        <a href="{{ url('/backend/compose?msgId='.$inboxdata[0]->id.'&replyId='.$sender) }}">Reply</a></span></h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="inbox-widget nicescroll mx-box">
                        <a href="">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="{{ ('../resources/assets/common/images/users/avatar-1.jpg') }}" class="img-circle" alt=""></div>
                                <p class="inbox-item-author"><?php echo $inboxdata[0]->SendName ?></p>
                              <!--   <p class="inbox-item-text">Hey! there I'm available...</p>
                                <p class="inbox-item-date">13:40 PM</p> -->
                            </div>

                        </a>
                        <div class="col-md-12">
                        <br>
                            <label>Subject</label>
                            <p class="col-md-12"><?php echo $inboxdata[0]->Subject ?></p>
                        </div>
                        <br>
                        <div class="col-md-12">
                        <br>
                            <label>Message</label>
                            <p class="col-md-12"><?php echo $inboxdata[0]->Message ?></p>
                        </div>
                    </div>
                    <?php if (count($relinboxdata)!=0) { ?>
                        <p>Related mails </p>
                    <div class="inbox-widget nicescroll mx-box">
                        <?php foreach ($relinboxdata as $key => $value) {
                            if ($_REQUEST['msgId']!=$value->id) {
                         ?>
                            <a href="{{ url('/backend/inboxView?msgId='.$value->id.'&sender='.$value->SendName) }}">
                                <div class="inbox-item <?php echo $value->SendName!="You" && $value->read=='0' ? 'dark' : ''; ?>">
                                    <div class="inbox-item-img"><img src="{{ ('../resources/assets/common/images/users/avatar-1.jpg') }}" class="img-circle" alt=""></div>
                                    <p class="inbox-item-author"><?php echo $value->SendName ?></p>
                                    <p class="inbox-item-text"><?php echo $value->Subject ?></p>
                                    <!-- <p class="inbox-item-date">13:40 PM</p> -->
                                </div>
                            </a>
                        <?php } } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div> <!-- container -->
@endsection   