@extends('teacher.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/select2/select2.css') !!}
{!! HTML::script('resources/assets/common/assets/select2/select2.min.js') !!}

<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">File share</h4>
            <ol class="breadcrumb pull-right">
                
            </ol>
        </div>
    </div>
    <div style="border-bottom: 2px solid grey;margin-bottom: 10px" class="col-md-12"></div>

    <div class="row">
        <div class="col-md-12 form-group">
            <p>Choose receivers</p>
        </div>
        <div class="col-md-6 form-group">
            <label>Class rooms</label>
            <select class="select2" id="ClassRooms" name="ClassRooms[]" multiple="" data-placeholder="Choose a class class room...">
                <option>1</option>
                <option>2</option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label>Subject</label>
            <select class="select2" id="Therapist" name="Therapist[]" multiple="" data-placeholder="Choose a class therapist...">
                <option>1</option>
                <option>2</option>
            </select>
        </div>
        <div class="col-md-12 form-group">
            <p>File Details</p>
        </div>
        <div class="col-md-12 form-group">
            <label>Title</label>
            <input type="text" name="Subject" class="form-control">
        </div>
        <div class="col-md-12 form-group">
            <label>File</label>
            <input type="file" name="">
        </div>
        <div class="col-md-12 form-group">
            <button class="btn btn-primary pull-right">upload</button>
        </div>
    </div> <!-- End Row -->


</div> <!-- container -->
<script type="text/javascript">
  $(document).ready(function() {
    jQuery(".select2").select2({
            width: '100%'
        });
    });
</script>

@endsection                
