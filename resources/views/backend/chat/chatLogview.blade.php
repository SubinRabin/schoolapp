@extends('backend.layouts.app')
@section('content')
<!-- DataTables -->
{!! HTML::style('resources/assets/common/assets/datatables/jquery.dataTables.min.css') !!}
<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>
<div class="container">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">@lang('messages.lbl_ChatLogView')</h4>
            <ol class="breadcrumb pull-right">
                <span><button onclick="goBack();" class="btn btn-primary pull-right"> Back</button></span>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="ChatHistory" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.lbl_Name')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($details['related']['Name'] as $key => $value) { ?>
                                        <tr>
                                            <td><a href="chatLogview?mainType=<?php echo $_REQUEST['mainType'] ?>&Main=<?php echo $_REQUEST['Main'] ?>&SubType=<?php echo $details['related']['Type'][$key] ?>&Sub=<?php echo $details['related']['Id'][$key] ?>"><?php echo $value.' ('.$details['related']['Type'][$key]; ?>)</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h3 class="panel-title"><?php echo $details['main']['Name'] ?></h3> 
                    
                </div> 
                <div class="panel-body"> 
                    <div class="chat-conversation">
                        <ul class="conversation-list nicescroll" id="chat-window">
                            <?php foreach ($details['chats']['Name'] as $key => $value) { 
                                $odd[$key] = '';
                                if ($details['chats']['Side'][$key]!='left') {
                                    $odd[$key] = 'odd';
                                }
                                ?>
                                <li class="clearfix <?php echo $odd[$key] ?>">
                                    <div class="chat-avatar">
                                        <img src="<?php echo $details['chats']['image'][$key]; ?>" alt="male">
                                        <i></i>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <i><?php echo $value; ?></i>
                                            <p>
                                                <?php echo $details['chats']['Text'][$key]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="row">
                            <div class="col-sm-9 chat-inputbar">
                                
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>
        </div>
        
    </div> <!-- End Row -->


</div> <!-- container -->
<div id="sectionModal" class="modal fade" role="dialog">
</div>
{!! HTML::script('resources/assets/common/assets/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('resources/assets/common/assets/datatables/dataTables.bootstrap.js') !!}


</script>
@endsection                
