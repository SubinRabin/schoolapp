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
                 <form method="post" action="{{ url('/teacher/resetPassword') }}" role="form" class="text-center"> 
                     {{ csrf_field() }}
                    <?php if(session::get('reset')!="") {
                        if (session::get('reset')=='success') { ?>
                            <p class="text-success">Please check your mail</p>
                        <?php } else { ?>
                            <p class="text-danger">Incorrect mail id</p>
                            <a href="{{ url('/teacher/forgetPassword') }}">Try again</a>
                       <?php } ?>
                    <?php } else { ?>
                        <div class="form-group m-b-0"> 
                                <select name="Role" class="form-control">
                                    <option class="Teacher">Teacher</option>
                                    <option class="Therapist">Therapist</option>
                                </select>
                                <br>
                                <input type="email" name="email" class="form-control input-lg" placeholder="Enter Email" required=""> 
                                <br>
                                <button type="submit" class="btn pull-right btn-lg btn-primary waves-effect waves-light">Reset</button> 
                        </div> 
                    <?php } ?>
                    
                </form>

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