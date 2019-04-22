<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Shumua school app">
        <meta name="author" content="Subin Rabin">

        <link rel="shortcut icon" href="{{{ ('../app/resources/assets/common/images/favicon_1.png') }}}">

        <title>Shumua</title>

        <!-- Base Css Files -->
        {!! HTML::style('resources/assets/common/css/bootstrap.min.css') !!}


        <!-- Font Icons -->
        {!! HTML::style('resources/assets/common/assets/font-awesome/css/font-awesome.min.css') !!}
        {!! HTML::style('resources/assets/common/assets/ionicon/css/ionicons.min.css') !!}
        {!! HTML::style('resources/assets/common/css/material-design-iconic-font.min.css') !!}

        <!-- animate css -->
        {!! HTML::style('resources/assets/common/css/animate.css') !!}

        <!-- Waves-effect -->
        {!! HTML::style('resources/assets/common/css/waves-effect.css') !!}

        <!-- Custom Files -->
        {!! HTML::style('resources/assets/common/css/helper.css') !!}
        {!! HTML::style('resources/assets/common/css/style.css') !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        {!! HTML::script('resources/assets/common/js/modernizr.min.js') !!}
        
    </head>
    <body style="background: #d4d3cf;">


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"><img width="50" height="50" src="{{{ ('../app/resources/assets/common/images/favicon_1.png') }}}"><strong> Teacher Login</strong></h3>
                </div> 


                <div class="panel-body">
                <form class="form-horizontal m-t-20" method="post" id="AdminLoginForm" action="{{ url('/TeacherLogin') }}"">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     {{ csrf_field() }}
                        @if(Session::has('error'))
                        <div class="alert-box success" style="text-align: center;color: red;">
                          {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="col-xs-12 form-group">
                        <select name="Role" class="form-control">
                            <option class="Teacher">Teacher</option>
                            <option class="Therapist">Therapist</option>
                        </select>
                    </div>
                    <div class="col-xs-12 form-group{{ $errors->has('Email') ? ' has-error' : '' }}">
                        <!-- <label for="Email" class="control-label">Email</label> -->
                        <input class="form-control input-lg " type="text" name="Email" placeholder="Email" value="{{ old('Email') }}">
                     @if ($errors->has('Email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Email') }}</strong>
                        </span>
                    @endif
                    </div>

                    <div class="col-xs-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <!-- <label for="password" class="control-label">Password</label> -->
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" value="{{ old('password') }}">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                   <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="{{ url('/teacher/forgetPassword') }}"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form> 
                </div>                                 
                
            </div>
        </div>

        
    	<script>
            var resizefunc = [];
        </script>
    	<script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/waves.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="assets/jquery-detectmobile/detect.js"></script>
        <script src="assets/fastclick/fastclick.js"></script>
        <script src="assets/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="assets/jquery-blockui/jquery.blockUI.js"></script>


        <!-- CUSTOM JS -->
        <script src="js/jquery.app.js"></script>
	
	</body>
</html>