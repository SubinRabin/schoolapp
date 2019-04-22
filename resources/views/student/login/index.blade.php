<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Shumua school app">
        <meta name="author" content="Subin Rabin">

        <link rel="shortcut icon" href="{{{ ('resources/assets/common/images/favicon_1.png') }}}">

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
                    <h3 class="text-center m-t-10 text-white"><img width="50" height="50" src="{{{ ('resources/assets/common/images/favicon_1.png') }}}"><strong> Login</strong></h3>
                </div> 


                <div class="panel-body" style="padding-bottom:0px;">
                <form class="form-horizontal m-t-20" method="post" id="AdminLoginForm" action="{{ url('/Login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     {{ csrf_field() }}
                        @if(Session::has('error'))
                        <div class="alert-box success" style="text-align: center;color: red;">
                          {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="col-xs-12 form-group">
                        <label for="Email" class="control-label">User Type</label>
                        <select class="form-control" name="usertype" id="usertype">
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Parent" ? 'selected' : ''  ?> value="Parent">Parent</option>
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Teacher" ? 'selected' : ''  ?> value="Teacher">Teacher</option>
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Therapist" ? 'selected' : ''  ?> value="Therapist">Therapist</option>
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Section head" ? 'selected' : ''  ?> value="Section head">Section head</option>
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Public relation" ? 'selected' : ''  ?> value="Public relation">Public relation</option>
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Admin" ? 'selected' : ''  ?> value="Admin">Admin</option>
                            <option <?php echo Session::get('usertype')!="" && Session::get('usertype')=="Registrar" ? 'selected' : ''  ?> value="Registrar">Registrar</option>
                        </select>
                    </div>
                    <div class="col-xs-12 form-group{{ $errors->has('Username') ? ' has-error' : '' }}">
                        <label for="Email" class="control-label">Username</label>
                        <input class="form-control input-lg " type="text" name="Username" placeholder="Username">
                     @if ($errors->has('Username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Username') }}</strong>
                        </span>
                    @endif
                    </div>

                    <div class="col-xs-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">

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

                    <div class="form-group m-t-30 Parent">
                        <div class="col-sm-7">
                            <a href="{{ url('/Student/forgetPassword') }}"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                    <div class="form-group m-t-30 Teacher hide">
                        <div class="col-sm-7">
                            <a href="{{ url('/teacher/forgetPassword') }}"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                    <div class="form-group m-t-30 Admin hide">
                        <div class="col-sm-7">
                            <a href="{{ url('/backend/forgetPassword') }}"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form> 
                </div>   
                <div class="Parent">
                <h5 style="padding-left: 20px;">Features of students portal</h5>             
                <ul style="padding-bottom: 15px;color: gray;">
                 <li>Able to communicate with the teacher and therapist.</li>
                 <li>Able to view the images and videos of the student.</li>
				 <li>Able to download the assessment files.</li>

                </ul>
                </div>
            </div>
        </div>

        

    	<script>
            var resizefunc = [];
        </script>
        {!! HTML::script('resources/assets/common/js/jquery.min.js') !!}
        {!! HTML::script('resources/assets/common/js/bootstrap.min.js') !!}
        {!! HTML::script('resources/assets/common/js/waves.js') !!}
        {!! HTML::script('resources/assets/common/js/wow.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.nicescroll.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.scrollTo.min.js') !!}
        {!! HTML::script('resources/assets/common/assets/jquery-detectmobile/detect.js') !!}
        {!! HTML::script('resources/assets/common/assets/fastclick/fastclick.js') !!}
        {!! HTML::script('resources/assets/common/assets/jquery-slimscroll/jquery.slimscroll.js') !!}
        {!! HTML::script('resources/assets/common/assets/jquery-blockui/jquery.blockUI.js') !!}


        <!-- CUSTOM JS -->
        {!! HTML::script('resources/assets/common/js/jquery.app.js') !!}
	   <script type="text/javascript">
            $(document).ready(function() {
                usertypeChange();
                $("#usertype").change(function() {
                    usertypeChange();
                })
            })
            function usertypeChange() {
                var usertype = $("#usertype").val()
                if (usertype!="Parent") {
                    $(".Parent").addClass("hide");
                }
                if (usertype=="Parent") {
                    $(".Parent").removeClass("hide");
                }

                if (usertype!="Teacher" || usertype!="Therapist") {
                    $(".Teacher").addClass("hide");
                }
                if (usertype=="Teacher" || usertype=="Therapist") {
                    $(".Teacher").removeClass("hide");
                }

                if (usertype!="Section head" || usertype!="Public relation" || usertype!="Admin" || usertype!="Registrar") {
                    $(".Admin").addClass("hide");
                }
                if (usertype=="Section head" || usertype=="Public relation" || usertype=="Admin" || usertype=="Registrar") {
                    $(".Admin").removeClass("hide");
                }
                
            }
        </script>
	</body>
</html>