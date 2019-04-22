@extends('student.layouts.app')
@section('content')
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_Gallery')</h4>
            <ol class="breadcrumb pull-right">
               
            </ol>
        </div>
    </div>
    <?php
        $files = Storage::disk('ftp')->allFiles('Family_Corner/Student/'.Session::get('StudentID').'/gallery'); 
        // $gallery['image'] = array();
        // $gallery['title'] = array();
        // $gallery['type'] = array();
        //  foreach ($query as $key => $value) {
        //     $explodeId = explode(",", $value->studentId);
        //     foreach ($explodeId as $key1 => $value1) {
        //         if ($value1==session::get('StudentOrgID')) {
        //            $gallery['image'][$key] = $value->image;
        //            $gallery['title'][$key] = $value->title;
        //            $gallery['type'][$key] = $value->type;
        //         }
        //     }
        // }

      ?>
    <div class="row port">
       
        <?php 
        $url = 'http://shumua.edu.sa/app/Family_Corner/Family_Corner/Student/'.Session::get('StudentID').'/gallery/';
        if (count($files)!=0) {
        foreach ($files as $key => $value) { ?>
            <div class="portfolioContainer">
                <div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator">
                    <div class="gal-detail thumb">
                        <a href="<?php echo $url.str_replace("Family_Corner/Student/".Session::get('StudentID')."/gallery/","",$value) ?>" target="_blank"  download class="download image-popup" title="Screenshot-1">
                            <img src="<?php echo $url.str_replace("Family_Corner/Student/".Session::get('StudentID')."/gallery/","",$value) ?>" class="thumb-img" alt="work-thumbnail">
                                <!-- <img src="ftp://developer@schoolapp.citycart.in:^&FL,kDmGWNQ@103.50.163.224/Student/gallery/2.png" class="thumb-img" alt="work-thumbnail"> -->
                        </a>
                        <h4 class="text-center hide"><?php echo str_replace("Family_Corner/Student/".Session::get('StudentID')."/gallery/","",$value);  ?></h4>
                    </div>
                </div>
            </div>
        <?php } }  ?>
        
    </div> <!-- End Row -->
    <div class="row port">
    </div> <!-- End Row -->


</div> <!-- container -->

@endsection                
