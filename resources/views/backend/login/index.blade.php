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
    <body style="background: #d4d3cf;">


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"><img width="50" height="50" src="{{{ ('../app/resources/assets/common/images/favicon_1.png') }}}"><strong> Admin Login</strong></h3>
                </div> 


                <div class="panel-body">
                <form class="form-horizontal m-t-20" method="post" id="AdminLoginForm" action="{{ url('backend/AdminLogin') }}"">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     {{ csrf_field() }}
                        @if(Session::has('error'))
                        <div class="alert-box success" style="text-align: center;color: red;">
                          {{ Session::get('error') }}
                        </div>
                        @endif
                    <div class="col-xs-12 form-group{{ $errors->has('Username') ? ' has-error' : '' }}">
                            <label for="Username" class="control-label">Username</label>

                            <input id="Username" type="Username" class="form-control" name="Username" value="{{ old('Username') }}" autofocus>

                            @if ($errors->has('Username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-xs-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox"  {{ old('remember') ? 'checked' : ''}}>
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit" id="AdminLoginFormBtn">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="{{ url('/backend/forgetPassword') }}"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
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