<?php
    use App\Model\admin;
    // $menuActive = substr(class_basename(Route::current()->controller), 0, -10);
    $menuActive = '';
    $role = admin::AdminRole(session::get('AdminID'));
    $roleName = admin::RoleName($role);
    $notifications = admin::notifications(session::get('AdminID'));
    $chatList = admin::admintchatList(session::get('AdminID'));
    $ProfilePic = admin::ProfilePic(session::get('AdminID'));
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Shumua school app">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{{ ('../resources/assets/common/images/favicon_1.png') }}}">

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

        <!-- sweet alerts -->
        {!! HTML::style('resources/assets/common/assets/sweet-alert/sweet-alert.min.css') !!}

        <!-- Custom Files -->
        {!! HTML::style('resources/assets/common/css/helper.css') !!}
        {!! HTML::style('resources/assets/common/css/style.css') !!}
        {!! HTML::style('resources/assets/common/css/toast.style.min.css') !!}
        <!-- {!! HTML::style('resources/assets/backend/css/extra.css') !!} -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        {!! HTML::script('resources/assets/common/js/modernizr.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.min.js') !!}
        {!! HTML::script('resources/assets/common/js/toast.script.js') !!}
        <!-- {!! HTML::script('resources/assets/backend/js/extra.js') !!} -->
        
    </head>
        <body class="fixed-left">
         <style>
        .toast-top-center {
            left: 50%;
            padding: 10px !important;
            text-align: center;
            transform: translate(-50%,0);
        }
    </style>
    <style type="text/css">
    .chatNot {
        top: -34px;
        left: -17px;
        display: block;
        background: red;
        border-radius: 37px;
        text-align: center;
        color: white;
        position: relative;
        width: 20px;
        font-size: 12px;
        height: 20px;
        line-height: 20px;
    }
</style>
    <script type="text/javascript">
        function changeLanguage(lang) {
            $.ajax({
              dataType: "json",
              // type: 'POST',
              url: 'changelanguage?langvalue='+lang,
              success: function (response) {
                window.location.reload();
              }
            });
        }
        function numberonly(e) {
          e=(window.event) ? event : e;
          return (/[0-9]/.test(String.fromCharCode(e.keyCode))); 
        }
    </script>
        <script type="text/javascript">
    var myTimer = setInterval(notify_list, 2000);
    var myTimer1 = setInterval(mailChatcount, 2000);
    var myTimer3 = setInterval(AdminchatList, 2000);

    notify_list();
    mailChatcount();
    AdminchatList();
    function notify_list() {
        $.ajax({
          // type: 'post',
          url: 'notify_count',
          cache: false,
          success: function (response) {
            $(".notify_count").html(response);
          },        
        });
    }
    function mailChatcount() {
        $.ajax({
          // type: 'post',
          url: 'mailChatcount',
          cache: false,
          success: function (response) {
            $(".mailChatcount").html(response);
          },        
        });
    }
    function AdminchatList() {
        $.ajax({
          // type: 'post',
          url: 'AdminchatList',
          cache: false,
          success: function (response) {
            $(".AdminchatList").html(response);
          },        
        });
    }
    function trigChat() {
        $(".chatSlideScreen").trigger('click');
    }
</script>
        <!-- Begin page -->
        <div id="wrapper">
        
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="{{ url('/backend/dashboard') }}" class="logo"><img width="60" height="60" src="{{ ('../resources/assets/common/images/favicon_1.png') }}"> <span>ADMIN PANEL</span></a>
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                            <!-- <form class="navbar-form pull-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control search-bar" placeholder="Type here for search...">
                                </div>
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </form> -->

                            <ul class="nav navbar-nav navbar-right pull-right">
                            	<li class="hidden-xs">
                                    <?php if (session::get('languageval')=="en") { ?>
                                        <a href="#" onclick="changeLanguage('ar')" class="waves-effect waves-light">العَرَبِيَّة</a>
                                    <?php } else { ?>
                                        <a href="#" onclick="changeLanguage('en')" class="waves-effect waves-light">English</a>
                                    <?php } ?>
                                </li>
                                <?php if ($role!=1) {

                                 ?>
                                <li class="dropdown hidden-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <i class="md md-notifications"></i> <span class="badge badge-xs badge-danger notify_count"><?php  echo $notifications['mail']!=0 || $notifications['chat']!=0 ? $notifications['mail']+$notifications['chat'] : ''
                                         ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">Notification</li>
                                        <li class="list-group mailChatcount">
                                        <?php if ($role!=2) { ?>
	                                           <!-- list item-->
	                                           <?php if ($notifications['mail']!=0) { ?>
	                                           <a href="{{ url('/backend/inbox') }}" class="list-group-item">
	                                              <div class="media">
	                                                 <div class="pull-left">
	                                                    <em class="fa fa-envelope fa-2x text-info"></em>
	                                                 </div>
	                                                 <div class="media-body clearfix">
	                                                    <div class="media-heading">New mail</div>
	                                                    <p class="m-0">
	                                                       <small>You have <?php echo $notifications['mail'] ?> unread messages</small>
	                                                    </p>
	                                                 </div>
	                                              </div>
	                                           </a>
	                                           <?php } ?>
                                    	<?php } ?>
                                        <?php if ($role!=1) {  ?>
                                        	<a href="#" class="list-group-item right-bar-toggle">
                                              <div class="media">
                                                 <div class="pull-left">
                                                    <em class="fa  fa-comment-o fa-2x text-primary"></em>
                                                 </div>
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">New message</div>
                                                    <p class="m-0">
                                                       <small>You have <?php echo $notifications['chat'] ?> messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                    	<?php } ?>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="md md-crop-free"></i></a>
                                </li>
                                <!-- <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="md md-chat"></i></a>
                                </li> -->
                                <li class="dropdown hide">
                                    
                                    <?php 
                                        $ProfileImage = '../resources/assets/common/images/Photo-icon.png';
                                        if ($ProfilePic!="") {
                                            $ProfileImage = '../Uploads/Admin/'.session::get('AdminID') .'/'.$ProfilePic;
                                        } ?>
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo $ProfileImage; ?>" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <!-- <li><a href="{{ url('/backend/profile') }}"><i class="md md-face-unlock"></i> @lang('messages.lbl_Profile')</a></li> -->
                                        <!-- <li><a href="javascript:void(0)"><i class="md md-settings"></i> Settings</a></li> -->
                                        <!-- <li><a href="{{ url('/backend/logout') }}"><i class="md md-settings-power"></i> @lang('messages.lbl_Logout')</a></li> -->
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <div class="user-details">
                        <div class="pull-left">
                            <img src="<?php echo $ProfileImage; ?>" alt="" class="thumb-md img-circle">
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo Session::get('AdminName'); ?><!-- <span class="caret"></span> --></a>
                                <!-- <ul class="dropdown-menu"> -->
                                    <!-- <li><a href="{{ url('/backend/profile') }}"><i class="md md-face-unlock"></i> @lang('messages.lbl_Profile')<div class="ripple-wrapper"></div></a></li> -->
                                    <!-- <li><a href="javascript:void(0)"><i class="md md-settings"></i> Settings</a></li> -->
                                    <!-- <li><a href="{{ url('/backend/logout') }}"><i class="md md-settings-power"></i> @lang('messages.lbl_Logout')</a></li> -->
                                <!-- </ul> -->
                            </div>
                            
                            <p class="text-muted m-0"><?php echo $roleName; ?></p>
                        </div>
                    </div>
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li>
                                <a href="{{ url('/backend/dashboard') }}" class="waves-effect <?php echo $menuActive=='Dashboard' ? 'active' : '' ?>"><i class="md md-home"></i><span> @lang('messages.lbl_Dashboard') </span></a>
                            </li>
                            <?php 
                                if ($role!=1) {
                             ?>
                            <li>
                                <a href="#" class="waves-effect right-bar-toggle chatSlideScreen"><i class="md md-chat"></i><span> @lang('messages.lbl_Message') </span></a>
                            </li>
                        	<?php } ?>
                            <?php if ($role!=3 && $role!=2) {
                                if ($role==1) {
                             ?>
                            <li>
                                <a href="{{ url('/backend/admin') }}" class="waves-effect <?php echo $menuActive=='Admin' ? 'active' : '' ?>"><i class="md md-person"></i><span> @lang('messages.lbl_Users') </span></a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="{{ url('/backend/teacher') }}" class="waves-effect <?php echo $menuActive=='Teachers' ? 'active' : '' ?>"><i class="md md-people"></i><span> @lang('messages.lbl_Teachers') </span></a>
                            </li>
                             <li>
                                <a href="{{ url('/backend/therapist') }}" class="waves-effect <?php echo $menuActive=='Therapist' ? 'active' : '' ?>"><i class="md md-healing"></i><span> @lang('messages.lbl_Therapists') </span></a>
                            </li>
                            <?php } ?>
                            <?php if ($role!=2) { ?>
                            <li>
                                <a href="{{ url('/backend/student') }}" class="waves-effect <?php echo $menuActive=='Students' ? 'active' : '' ?>"><i class="md md-school"></i><span> @lang('messages.lbl_Student') </span></a>
                            </li>
                            <?php } ?>
                            <?php if ($role!=3 && $role!=2) { ?>
                            <li class="has_sub">
                                <a href="#" class="waves-effect"><i class="md md-now-widgets"></i><span> @lang('messages.lbl_Master') </span><span class="pull-right"><i class="md md-add"></i></span></a>
                                <ul class="list-unstyled">
                                    <!-- <li><a href="{{ url('/backend/adminRole') }}">Admin Roles</a></li> -->
                                    <li><a href="{{ url('/backend/ProgramMaster') }}">@lang('messages.lbl_Program')</a></li>
                                    <li><a href="{{ url('/backend/ClassroomMaster') }}">@lang('messages.lbl_Classroom')</a></li>
                                    <li><a href="{{ url('/backend/TherapytypeMaster') }}">@lang('messages.lbl_TherapyType')</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php if ($role==2) { ?>
                                <li>
                                    <a href="{{ url('/backend/announcement') }}" class="waves-effect "><i class="md md-speaker"></i><span> @lang('messages.lbl_Announcement') </span></a>
                                </li>
                            <?php  } ?>
                            <?php if ($role==3) { ?>
                            <li>
                                <a href="{{ url('/backend/inbox') }}" class="waves-effect"><i class="md md-mail"></i><span> @lang('messages.lbl_Inbox') </span></a>
                            </li>
                            <li>
                                <a href="{{ url('/backend/announcement') }}" class="waves-effect "><i class="md md-speaker"></i><span> @lang('messages.lbl_Announcement') </span></a>
                            </li>
                             <li>
                                <a href="{{ url('backend/FileShare') }}" class="waves-effect <?php echo $menuActive=='Admin' ? 'active' : '' ?>"><i class="md md-image"></i><span> @lang('messages.lbl_Gallery') </span></a>
                            </li>
                            <li>
                                <a href="{{ url('backend/AssessmentShare') }}" class="waves-effect <?php echo $menuActive=='Admin' ? 'active' : '' ?>"><i class="fa fa-file"></i><span> @lang('messages.lbl_Filemanager') </span></a>
                            </li>
                            <li>
                                <a href="{{ url('backend/ChatLog') }}" class="waves-effect"><i class="fa fa-comments"></i><span> @lang('messages.lbl_ChatLog') </span></a>
                            </li>
                            <?php } ?>
                            <?php if ($role==1) { ?>
                             <li>
                                <a href="{{ url('backend/Gallery') }}" class="waves-effect <?php echo $menuActive=='Admin' ? 'active' : '' ?>"><i class="md md-image"></i><span> @lang('messages.lbl_Gallery') </span></a>
                            </li>
                            <li>
                                <a href="{{ url('backend/fileManager') }}" class="waves-effect <?php echo $menuActive=='Admin' ? 'active' : '' ?>"><i class="fa fa-file"></i><span> @lang('messages.lbl_Filemanager') </span></a>
                            </li>
                            <li>
                                <a href="{{ url('backend/ChatLog') }}" class="waves-effect"><i class="fa fa-comments"></i><span> @lang('messages.lbl_ChatLog') </span></a>
                            </li>
                            <?php } ?>
                            

                            <li>
                                <a href="{{ url('/backend/profile') }}" class="waves-effect"><i class="fa fa-user"></i><span> @lang('messages.lbl_Profile') </span></a>
                            </li>
                            <li>
                                <a href="{{ url('/backend/logout') }}" class="waves-effect"><i class="fa fa-sign-out"></i><span> @lang('messages.lbl_Logout') </span></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End --> 

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">


                @yield('content') 


                </div> <!-- content -->

                <footer class="footer text-right">
                    <!-- 2018 @ Subin Rabin. -->
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <h4 class="text-center">Chat</h4>
                <div class="contact-list nicescroll">
                    <ul class="list-group contacts-list AdminchatList">
                        <?php 
                        if (count($chatList)!=0) {
                            foreach ($chatList['studentName'] as $key => $value) {
                                 $notificationStatus = admin::notificationStatus($chatList['studentID'][$key]); 
                                if ($chatList['status'][$key]==1) {
                                   $status[$key] = 'online';
                                } else {
                                   $status[$key] = 'offline';
                                }
                                ?>
                            <li class="list-group-item">

                                <a href="adminChat?type=<?php echo $chatList['studentType'][$key] ?>&receiverId=<?php echo $chatList['studentID'][$key] ?><?php echo $notificationStatus['chat']!=0 ? '&not=1' : '' ?>" >
                                    <div class="avatar">
                                        <?php 
                                            $profileImg = '../resources/assets/common/images/Photo-icon.png';
                                            if ($chatList['Profile'][$key]!="") {
                                                $profileImg  = '../Uploads/Student/'.$chatList['studentName'][$key].'/'.$chatList['Profile'][$key];
                                            } ?>
                                        <img src="<?php echo $profileImg; ?>" alt="">
                                        <?php if ($notificationStatus['chat']!=0) { ?>
                                        <span class="chatNot">
                                        <?php echo $notificationStatus['chat'] ?>
                                        </span>
                                        <?php } ?>
                                    </div>
                                    <span class="name"><?php echo $value ?><br><small><?php echo $chatList['studentType'][$key] ?></small></span>
                                    <i class="fa fa-circle <?php echo $status[$key] ?>"></i>
                                </a>
                                <span class="clearfix"></span>
                            </li>
                        <?php } } ?>
                    </ul> 
                </div>
            </div>
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->


    
        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        {!! HTML::script('resources/assets/common/js/bootstrap.min.js') !!}
        {!! HTML::script('resources/assets/common/js/waves.js') !!}
        {!! HTML::script('resources/assets/common/js/wow.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.nicescroll.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.scrollTo.min.js') !!}
        {!! HTML::script('resources/assets/common/js/jquery.nicescroll.js') !!}
        {!! HTML::script('resources/assets/common/assets/chat/moment-2.2.1.js') !!}

        {!! HTML::script('resources/assets/common/assets/jquery-sparkline/jquery.sparkline.min.js') !!}
        {!! HTML::script('resources/assets/common/assets/jquery-detectmobile/detect.js') !!}
        {!! HTML::script('resources/assets/common/assets/fastclick/fastclick.js') !!}
        {!! HTML::script('resources/assets/common/assets/jquery-slimscroll/jquery.slimscroll.js') !!}
        {!! HTML::script('resources/assets/common/assets/jquery-blockui/jquery.blockUI.js') !!}

        <!-- sweet alerts -->
        {!! HTML::script('resources/assets/common/assets/sweet-alert/sweet-alert.min.js') !!}
        {!! HTML::script('resources/assets/common/assets/sweet-alert/sweet-alert.init.js') !!}

        <!-- flot Chart -->
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.js') !!}
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.time.js') !!}

        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.tooltip.min.js') !!}
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.resize.js') !!}
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.pie.js') !!}
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.selection.js') !!}
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.stack.js') !!}
        {!! HTML::script('resources/assets/common/assets/flot-chart/jquery.flot.crosshair.js') !!}

        <!-- Counter-up -->
        {!! HTML::script('resources/assets/common/assets/counterup/waypoints.min.js') !!}
        {!! HTML::script('resources/assets/common/assets/counterup/jquery.counterup.min.js') !!}
        
        <!-- CUSTOM JS -->
        {!! HTML::script('resources/assets/common/js/jquery.app.js') !!}

        <!-- Dashboard -->
        {!! HTML::script('resources/assets/common/js/jquery.dashboard.js') !!}

        <!-- Chat -->
        {!! HTML::script('resources/assets/common/js/jquery.chat.js') !!}

        <!-- Todo -->
        {!! HTML::script('resources/assets/common/js/jquery.todo.js') !!}

        <script type="text/javascript">
            /* ==============================================
            Counter Up
            =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
    
    </body>
</html>
