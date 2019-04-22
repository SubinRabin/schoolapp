@extends('student.layouts.app')
@section('content')
<style type="text/css">
    .custom-nav li {
        background: lightblue;
        height: 30px;
    }
    .custom-nav li a {
        height: 30px;
        line-height: 30px;
    }
    .custom-nav li a:hover {
        background: #337ab7;
    }
</style>
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_Assessment')</h4>
            <ol class="breadcrumb pull-right">
               
            </ol>
        </div>
    </div>
    <?php 
        if (!isset($_REQUEST['tab']) || (isset($_REQUEST['tab']) && $_REQUEST['tab']!= "First" && $_REQUEST['tab']!= "Second")) {
            $tab = 'Admission_Assessment/';
        } else if(isset($_REQUEST['tab']) && $_REQUEST['tab']== "First") {
            $tab = 'First_Term/';
        } else {
            $tab = 'Second_Term/';
        }
        $files = Storage::disk('ftp')->allFiles('Family_Corner/Student/'.Session::get('StudentID').'/assessment/'.$tab); 
        
        $allowed_extensions = array("flv", "mp4", "mov", "3gp", "avi", "ogg");
        $pattern = implode ($allowed_extensions, "|");
     ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills custom-nav">
              <li class="<?php echo !isset($_REQUEST['tab']) || (isset($_REQUEST['tab']) && $_REQUEST['tab']!= "First" && $_REQUEST['tab']!= "Second") ? 'active' : '' ?>"><a href="{{ ('assessmentDetails?tab=Admission') }}">Admission assessment</a></li>
              <li class="<?php echo isset($_REQUEST['tab']) && $_REQUEST['tab']== "First" ? 'active' : '' ?>"><a href="{{ ('assessmentDetails?tab=First') }}">First term</a></li>
              <li class="<?php echo isset($_REQUEST['tab']) && $_REQUEST['tab']== "Second" ? 'active' : '' ?>"><a href="{{ ('assessmentDetails?tab=Second') }}">Second term</a></li>
            </ul>
        </div>
        <?php 
        $url = 'http://app.shumua.edu.sa/Family_Corner/Family_Corner/Student/'.Session::get('StudentID').'/assessment/'.$tab;
        if (count($files)!=0) {
        foreach ($files as $key => $value) { ?>
            <div class="portfolioContainer">
                <div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator">
                    <div class="gal-detail thumb">
                        <?php if (preg_match("/({$pattern})$/i", str_replace("Family_Corner/Student/".Session::get('StudentID')."/assessment/".$tab,"",$value))) {  ?>
                        <video width="100%" height="100%" controls>
                          <source src="<?php echo $url.str_replace("Family_Corner/Student/".Session::get('StudentID')."/assessment/".$tab,"",$value);  ?>">
                        </video>
                        <h4 class="text-center"><?php echo str_replace("Family_Corner/Student/".Session::get('StudentID')."/assessment/".$tab,"",$value);  ?></h4>
                        <?php } else { ?>
                        <a  href="<?php echo $url.str_replace("Family_Corner/Student/".Session::get('StudentID')."/assessment/".$tab,"",$value);  ?>" target="_blank"  download class="image-popup" title="Screenshot-1">
                            <img src="{{ ('resources/assets/common/images/document.png') }}" style="height: 20%;width: 56%;margin-left: 22%;" class="thumb-img" alt="work-thumbnail">
                        </a>
                        <h4 class="text-center"><?php echo str_replace("Family_Corner/Student/".Session::get('StudentID')."/assessment/".$tab,"",$value);  ?></h4>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div> <!-- End Row -->
    <div class="row port">
    </div> <!-- End Row -->

</div> <!-- container -->

@endsection                
