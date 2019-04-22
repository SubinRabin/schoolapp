@extends('teacher.layouts.app')
@section('content')
<style type="text/css">
    .online {
        line-height: 34px;
        color: green;
    }
    .offline {
        line-height: 34px;
        color: red;
    }
</style>
<script>
    $(document).ready(function() {
        $("body").css('overflow','hidden');
    });
    function goBack() {
        window.history.back();
    }
    function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
            param,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
    }
    <?php if (isset($_REQUEST['not'])) { ?> 
        var originalURL = window.location.href;
        var alteredURL = removeParam("not", originalURL);

        setTimeout(reloaded, 1000);


        function reloaded() {
            window.location = alteredURL;
        }
    <?php } ?>

</script>
<div class="container">
    <div class="row">
        <!-- CHAT -->
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-md-12">
                    <button onclick="goBack();" class="btn btn-primary pull-right"> Back</button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h3 class="panel-title"><?php echo $details['Name'] ?> <i class="pull-right fa fa-circle <?php echo $details['status']==1 ? 'online' : 'offline' ?>"></i></h3> 
                    
                </div> 
                <div class="panel-body"> 
                    <input type="hidden" id="username" value="<?php echo session::get('TeacherId'); ?>">
                    <input type="hidden" id="type" value="Student">
                    <input type="hidden" id="receiverId" value="<?php echo $_REQUEST['receiverId'] ?>">
                    <input type="hidden" id="role" value="<?php echo session::get('TeacherRole') ?>">
                    <div class="chat-conversation">
                        <ul class="conversation-list nicescroll" id="chat-window">
                        </ul>
                        <div class="row">
                            <div class="col-sm-9 chat-inputbar">
                                
                                <input type="text" class="form-control chat-inpust" id="text" placeholder="Enter your text">
                            </div>
                            <div class="col-sm-3 chat-sends">
                                <button type="submit" class="chat-send-btn  btn btn-info btn-block waves-effect waves-light">Send</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div> <!-- end col-->
    </div>
</div> <!-- container -->
{!! HTML::script('resources/assets/teacher/js/chat.js') !!}
{!! HTML::script('resources/assets/common/js/chat.js') !!}
@endsection   