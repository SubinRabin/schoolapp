<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Shumua school app">
        <meta name="author" content="Subin Rabin">

        <link rel="shortcut icon" href="{{{ ('../resources/assets/common/images/favicon_1.png') }}}"/>

        <title>Shumua</title>

        <!-- Base Css Files -->
        {!! HTML::style('resources/assets/common/css/bootstrap.min.css') !!}


        <!-- Font Icons -->
        {!! HTML::style('resources/assets/common/assets/font-awesome/css/font-awesome.min.css') !!}
        {!! HTML::style('resources/assets/common/assets/ionicon/css/ionicons.min.css') !!}
        {!! HTML::style('resources/assets/common/css/material-design-iconic-font.min.css') !!}

        {!! HTML::style('resources/assets/common/css/toast.style.min.css') !!}
        <!-- animate css -->
        {!! HTML::style('resources/assets/common/css/animate.css') !!}

        <!-- Waves-effect -->
        {!! HTML::style('resources/assets/common/css/waves-effect.css') !!}

        <!-- Custom Files -->
        {!! HTML::style('resources/assets/common/css/helper.css') !!}
        {!! HTML::style('resources/assets/common/css/style.css') !!}


        {!! HTML::script('resources/assets/common/js/modernizr.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.min.js') !!}
        {!! HTML::script('resources/assets/backend/js/login.js') !!}
        {!! HTML::script('resources/assets/common/js/toast.script.js') !!}
        
    </head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-heading bg-img1"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"> Reset Password </h3>
                </div> 

                <div class="panel-body">
                    <?php if (isset($_REQUEST['st'])) { ?>
                        <?php if (!isset($_REQUEST['otperror'])) { ?>
                        <p class="text-success">Please check your mobile</p>
                        <?php } ?>
                        <form method="post" action="{{ url('/Student/otpverification') }}" role="form" class="text-center">
                                {{ csrf_field() }}
                                <?php if (isset($_REQUEST['otperror'])) { ?>
                                   <p class="text-danger text-left">Incorrect OTP</p>
                                <?php } ?>
                                <input type="hidden" name="studentId" value="<?php echo $_REQUEST['st'] ?>">
                                <div class="form-group m-b-0"> 
                                    <input type="text" pattern="\d*" <?php if(isset($_REQUEST['otperror'])) { ?> style="border: 1px solid red;" <?php } ?>  name="otp" class="form-control input-lg" placeholder="Enter OTP" required=""  maxlength="4"> 
                                    <br>
                                    <button type="submit" class="btn pull-right btn-lg btn-primary waves-effect waves-light">Submit</button> 
                                </div>
                            </form>
                    <?php } ?>
                    <!-- Technical error -->
                    <?php if (isset($_REQUEST['reset']) && $_REQUEST['reset']=='error') { ?>
                        <p class="text-danger text-center">Something is technically wrong.</p>
                        <p class="text-center"><a href="{{ url('/Student/forgetPassword') }}">Try again</a></p>
                    <?php } ?>
                    <?php if (isset($_REQUEST['reset']) && $_REQUEST['reset']=='failed') { ?>
                        <p class="text-danger text-center">Incorrect student id / mobile number</p>
                        <p class="text-center"><a href="{{ url('/Student/forgetPassword') }}">Try again</a></p>
                    <?php } ?>

                    <?php if(!isset($_REQUEST['st']) && !isset($_REQUEST['reset'])) { ?>
                        <form method="post" action="{{ url('/Student/resetPassword') }}" role="form" class="text-center"> 
                            {{ csrf_field() }}
                            <div class="form-group m-b-0"> 
                                <input type="text" name="studentId" class="form-control input-lg" placeholder="Enter student id" required=""> 
                                <br>
                                <select class="form-control pull-left input-lg" name="CountryCode" style="width: 35%;">
                                  <?php foreach ($countryCode as $key => $value) { ?>
                                      <option  value="<?php echo $value->CountryCode ?>"><?php echo $value->CountryCode ?></option>
                                  <?php } ?>
                                </select>
                                <input type="mobile" name="mobile" class="form-control input-lg" style="width: 65%;" placeholder="Enter mobile number" required=""> 
                                <br>
                                <button type="submit" class="btn pull-right btn-lg btn-primary waves-effect waves-light">Reset</button> 
                            </div> 
                        </form>
                    <?php } ?>
                </div>                                 
            </div>
        </div>
        <script>
            var resizefunc = [];
        </script>
        {!! HTML::script('resources/assets/common/js/bootstrap.min.js') !!}
        {!! HTML::script('resources/assets/common/js/waves.js') !!}
        {!! HTML::script('resources/assets/common/js/wow.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.nicescroll.js') !!}
        <!-- CUSTOM JS -->
    
    </body>
</html>