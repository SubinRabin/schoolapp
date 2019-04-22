<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\dashboard;
use App\Model\admin;
use App\Model\student;
use App\Model\therapist;
use DB;
use Input;
use Redirect;
use Session;
use Mail;
use Datatables;
use Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
	function index(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
		$admin=dashboard::adminCount();
        $teacher=dashboard::teacherCount();
        $therapist=dashboard::therapistCount();
        $student=dashboard::studentCountForAdmin();
		return view('backend.dashboard.index' ,[
											'admin' => $admin,
											'teacher' => $teacher,
											'therapist' => $therapist,
											'student' => $student,
												]);
	}
	function profile(Request $request) {
		if (session::get('AdminID')=="") {
            return Redirect::to('/');
        }
        $request->id = session::get('AdminID');
   		$data = dashboard::adminData($request);  
		return view('backend.dashboard.profile',['data' => $data]);
	}
	function AdminProfileSubmit(Request $request) {
    $submit=admin::AdminProfileSubmit($request);
    $file = $request->file('Profile');
    if (isset($file) && $file!="") {
      $newFileName = $file->getClientOriginalName();
      if (!file_exists('Uploads/Admin/'.session::get('AdminID'))) {
          mkdir('Uploads/Admin/'.session::get('AdminID'), 0777, true);
      }
      $destinationPath = 'Uploads/Admin/'.session::get('AdminID');
      $file->move($destinationPath,$newFileName);

      $update = DB::table('tbl_admin')
      ->where('id',session::get('AdminID'))
      ->update([
              'Profile' =>$newFileName,]);
    }
        
    return Redirect::to('/backend/profile');

	}
	function announcement(Request $request) {
    $role = admin::AdminRole(session::get('AdminID'));
    if ($role==3) {
      $class = admin::AdminPrefferedStudentList();
    } else {
      $class = admin::classList();
    }
		return view('backend.dashboard.announcement',[
								'class' => $class,
							]);
	}
	function announcementSend(Request $request)
	{	
		if (!isset($request->classRoom) && $request->classRoom=="") {
			session::flash('err_msg' ,'Must select a class room');
		} else if($request->Subject=="") {
			session::flash('err_msg' ,'subject field is required!');
		} else if($request->Message=="") {
			session::flash('err_msg' ,'Message field is required!');
		} else {
      $role = admin::AdminRole(session::get('AdminID'));

      if ($role==3) {
        $student = admin::StudentsMailget($request->classRoom);
      } else {
        foreach ($request->classRoom as $key => $CRvalue) {
          $student = admin::ClassRelatedMailget($request->classRoom);
        }
      }

			foreach ($student as $key => $value) {
				$msg= $request->Message;
				$maildetailssubject = $request->Subject;
				$insertMail = admin::composeanouncemenrt($msg,$maildetailssubject,session::get('AdminID'),$value->studentId);

				$mailformat= array('','');
				$emailpersonal = $value->Email;
				 $mail = Mail::sendwithoutview($msg, $mailformat, function ($message) use ($emailpersonal,$maildetailssubject) {
		        	$message->from('subinrabin444@gmail.com','no-reply');
		        	$message->to($emailpersonal)->subject($maildetailssubject);
    			});
			}
			session::flash('success_msg' ,'Mail send successfully');
		}
    	return Redirect::to('backend/announcement');
	}
	function inbox(Request $request) {
		if (session::get('AdminID')=="") {
            return Redirect::to('/');
        }
        $inboxList = admin::inboxList();
		return view('backend.chat.inbox',['inboxList' => $inboxList, ]);
	}
	function inboxView(Request $request) {
		if (session::get('AdminID')=="") {
            return Redirect::to('/');
        }
        if (isset($request->msgId)) {
            if (!isset($request->sender) || $request->sender!="You") {
                $readmsg = admin::readmsg($request->msgId);
            }
        }
        $inboxdata = admin::inboxdata($request->msgId);
        
        if (isset($request->sender) && $request->sender=="You") {
            $sender = $inboxdata[0]->receiver; 
        } else {
            $sender = $inboxdata[0]->sender; 
        }
        
        $relinboxdata = admin::relatedinboxdata($request->msgId,$sender);
		return view('backend.chat.inboxView',['inboxdata' => $inboxdata,
                                              'relinboxdata' => $relinboxdata]);
	}
	function compose(Request $request) {
		if (session::get('AdminID')=="") {
            return Redirect::to('/');
        }
		$studentList = admin::studentList();
		return view('backend.chat.compose',['studentList' => $studentList]);
	}
	function composeSend(Request $request) {
		if (session::get('AdminID')=="") {
            return Redirect::to('/');
        }
		$insert = admin::composeSend($request);
        return Redirect::to('/backend/inbox');
		
	}	
	function FileShare(Request $request) {
        $student = admin::studentList();
        $details = array();
        if (isset($_REQUEST['id'])) {
            $details = admin::GalleryDetails($_REQUEST['id']);
        }
        return view('backend.dashboard.FileShare',['student' => $student, 'details' => $details]);
    }
    function AssessmentShare(Request $request) {
		$student = admin::studentList();
        $details = array();
        if (isset($_REQUEST['id'])) {
            $details = admin::AssessmentDetails($_REQUEST['id']);
        }
        return view('backend.dashboard.AssessmentShare',['student' => $student, 'details' => $details]);
    }
    function galleryFileUpload(Request $request) {
        $context = stream_context_create(array(
                'ftp'=>array(
                        'overwrite' => true
                )
            )
        );

        $file = $request->file('galleryFiles');
        $newFileName = $file->getClientOriginalName();
        $newFileName = $request->Title.'.'.$file->getClientOriginalExtension();
        $mime = explode("/", $file->getMimeType());

        foreach ($request->Students as $key => $value) {
        	if (!Storage::disk('ftp')->exists('Family_Corner/Student/'.$value.'/gallery')) {
                Storage::disk('ftp')->makeDirectory('Family_Corner/Student/'.$value.'/gallery', 0777, true);
            }
            $file = $file;
            $dest = fopen("ftp://app@shumua.edu.sa:t7xWEVBrZvs@162.144.78.200/Family_Corner/Student/".$value."/gallery/".$newFileName, "wb", false, $context);
            $src = file_get_contents($file);
            fwrite($dest, $src, strlen($src));
            fclose($dest); 
        	
        }
      	

     //    if (isset($_REQUEST['id']) && $_REQUEST['id']!="") {
     //        $insert = DB::table('tbl_gallery')
     //        ->where('id',$_REQUEST['id'])
     //        ->update([
     //                'image' =>$newFileName,
     //                'studentId' => implode(',', $request->Students),
     //                'title' => $request->Title,
     //                'type' => $mime[0],
     //                'createdDate' => date('Y-m-d H:m:i'),
     //                'CreatedBy' => session::get('AdminName'),  ]);
     //    } else {
     //  	    $insert = DB::table('tbl_gallery')
  			// ->insert([
  			// 		'image' =>$newFileName,
  			// 		'studentId' => implode(',', $request->Students),
     //                'title' => $request->Title,
     //                'type' => $mime[0],
  			// 		'createdDate' => date('Y-m-d H:m:i'),
  			// 		'CreatedBy' => session::get('AdminName'),  ]);
     //    }
        return Redirect::to('backend/FileShare');
    }
    function assessmentFileUpload(Request $request) {
        $context = stream_context_create(array(
                'ftp'=>array(
                        'overwrite' => true
                )
            )
        );
        $file = $request->file('assessmentFiles');
        $newFileName = $file->getClientOriginalName();
    	$newFileName = $request->Title.'.'.$file->getClientOriginalExtension();
        $mime = explode("/", $file->getMimeType());

        foreach ($request->Students as $key => $value) {
        	if (!Storage::disk('ftp')->exists('Family_Corner/Student/'.$value.'/assessment/'.$request->AssessmentType)) {
                Storage::disk('ftp')->makeDirectory('Family_Corner/Student/'.$value.'/assessment/'.$request->AssessmentType, 0777, true);
            }
	        // $destinationPath = 'Family_Corner/Student/'.$value.'/assessment/'.$request->AssessmentType.'/'.$newFileName;
	        // Storage::disk('ftp')->put($destinationPath, fopen($request->file('assessmentFiles'), 'r+'));
            $file = $file;
            $dest = fopen("ftp://app@shumua.edu.sa:t7xWEVBrZvs@162.144.78.200/Family_Corner/Student/".$value."/assessment/".$request->AssessmentType."/".$newFileName, "wb", false, $context);
            $src = file_get_contents($file);
            fwrite($dest, $src, strlen($src));
            fclose($dest); 
        	
        }



        // if ($_REQUEST['id']!="") {
        //     $insert = DB::table('tbl_assessment')
        //         ->where('id',$_REQUEST['id'])
        //         ->update([
        //                 'image' =>$newFileName,
        //                 'studentId' => implode(',', $request->Students),
        //                 'title' => $request->Title,
        //                 'AssessmentType' => $request->AssessmentType,
        //                 'createdDate' => date('Y-m-d H:m:i'),
        //                 'CreatedBy' => session::get('AdminName'),  ]);
        // } else {
      	 //     $insert = DB::table('tbl_assessment')
      		// 	->insert([
      		// 			'image' =>$newFileName,
      		// 			'studentId' => implode(',', $request->Students),
        //                 'title' => $request->Title,
        //                 'AssessmentType' => $request->AssessmentType,
      		// 			'createdDate' => date('Y-m-d H:m:i'),
      		// 			'CreatedBy' => session::get('AdminName'),  ]);
        // }
        return Redirect::to('backend/AssessmentShare');
    }
    function Gallery(Request $request) {
        return view('backend.dashboard.Gallery');
    }
    function gallerylist(Request $request) {
        DB::statement(DB::raw('set @rownum=0'));
        $student = DB::table('tbl_gallery')
        // ->leftJoin('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')->leftJoin('tbl_therapytype', 'tbl_therapytype.id', '=', 'tbl_students.Therapy')
            ->select([
                 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                 'id',
                 'image',
                 'title',
                 'studentId',
                 'createdDate',
                ]);
        return Datatables::of($student)
            ->addColumn('students', function ($student) {
                $details=student::studentsExplodedata($student->studentId);
                return $details;
            })
            ->addColumn('view', function ($student) {
                $url = 'ftp://app@shumua.edu.sa:t7xWEVBrZvs@162.144.78.200/Student/gallery/';
                return '<a href="'.$url.$student->image.'" download target="_blank" >'.$student->image.'</a>';
            })
            ->addColumn('action', function ($student) {
                $permissionBtn = '<a href="#" onclick="galleryDeleteModalfun('.$student->id.',0)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                return '
                    <a href="../backend/FileShare?id='.$student->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>
                        '.$permissionBtn;
            })
            ->rawColumns(['view','action'])
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);
    }
    function galleryDelete(Request $request) {
        unlink('ftp://app@shumua.edu.sa:t7xWEVBrZvs@162.144.78.200/'.$request->id);
        return Redirect::to('backend/Gallery');
    }
    function fileManager(Request $request) {
        return view('backend.dashboard.fileManager');
    }
    function fileManagerlist(Request $request) {
        DB::statement(DB::raw('set @rownum=0'));
        $student = DB::table('tbl_assessment')
        // ->leftJoin('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')->leftJoin('tbl_therapytype', 'tbl_therapytype.id', '=', 'tbl_students.Therapy')
            ->select([
                 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                 'id',
                 'image',
                 'title',
                 'studentId',
                 'createdDate',
                 'AssessmentType',
                ]);
        return Datatables::of($student)
            ->addColumn('students', function ($student) {
                $details=student::studentsExplodedata($student->studentId);
                return $details;
            })
            ->addColumn('view', function ($student) {
                $url = 'ftp://app@shumua.edu.sa:t7xWEVBrZvs@162.144.78.200/Student/assessment/'.$student->AssessmentType.'/';
                return '<a href="'.$url.$student->image.'" download target="_blank" >'.$student->image.'</a>';
            })
            ->addColumn('action', function ($student) {
                $permissionBtn = '<a href="#" onclick="fileManagerDeleteModalfun('.$student->id.',0)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                return '
                    <a href="../Student/assessment/'.$student->image.'"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="../backend/AssessmentShare?id='.$student->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>
                        '.$permissionBtn;
            })
            ->rawColumns(['view','action'])
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);
    }
    function fileManagerDelete(Request $request) {
        unlink('ftp://app@shumua.edu.sa:t7xWEVBrZvs@162.144.78.200/'.$request->id);
        return Redirect::to('backend/fileManager');
    }
    function adminChat(Request $request){
        $details = student::ChatDetails('Student',$request->receiverId);
        return view('backend.chat.chat',['details' => $details]);
    }
    function notify_count() {
        $notifications = admin::notifications(session::get('AdminID'));

        if ($notifications['chat']!=0 || $notifications['mail']!=0) {
           $notify   = $notifications['chat']+$notifications['mail'];
        } else {
            $notify = '';
        }
        echo json_decode($notify);
    }
    function mailChatcount() {
        $notifications = admin::notifications(session::get('AdminID'));

        $notify = '';
        if ($notifications['mail']!=0) {
           $notify   .= '<a href="inbox" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left">
                                                    <em class="fa fa-envelope fa-2x text-info"></em>
                                                 </div>
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">New mail</div>
                                                    <p class="m-0">
                                                       <small>You have '.$notifications['mail'].' unread messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>';
        } else if($notifications['chat']!=0) {
            $notify .= '<a href="#" class="list-group-item right-bar-toggle" onclick="trigChat()">
                                              <div class="media">
                                                 <div class="pull-left">
                                                    <em class="fa  fa-comment-o fa-2x text-primary"></em>
                                                 </div>
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">New message</div>
                                                    <p class="m-0">
                                                       <small>You have '.$notifications['chat'].' messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                            </a>';
        }
        echo ($notify);
    }
    function AdminchatList() {
        $return = '';
        $chatList = admin::admintchatList(session::get('AdminID'));
        if (count($chatList)!=0) {
            foreach ($chatList['studentName'] as $key => $value) {
                 $notificationStatus = admin::notificationStatus($chatList['studentID'][$key]); 
                if ($chatList['status'][$key]==1) {
                   $status[$key] = 'online';
                } else {
                   $status[$key] = 'offline';
                }
                if ($notificationStatus['chat']!=0) {
                    $req = '';
                } else {
                    $req = '';
                }
                $profileImg = '../resources/assets/common/images/Photo-icon.png';
                if ($chatList['Profile'][$key]!="") {
                    $profileImg  = '../Uploads/Student/'.$chatList['studentName'][$key].'/'.$chatList['Profile'][$key];
                }
                $return .='<li class="list-group-item">
                                <a href="adminChat?type='.$chatList['studentType'][$key].'&receiverId='.$chatList['studentID'][$key].$req.'" >
                                    <div class="avatar">
                                        <img src="'.$profileImg.'" alt="">';
                                        if ($notificationStatus['chat']!=0) { 
                                            $return .='<span class="chatNot">
                                                    '.$notificationStatus['chat'].'
                                            </span>';
                                        }
                                    $return .='</div>
                                    <span class="name">'.$value.'<br><small>'.$chatList['studentType'][$key].'</small></span>
                                    <i class="fa fa-circle '.$status[$key].'"></i>
                                </a>
                                <span class="clearfix"></span>
                            </li>';
            } 
        } 
        echo ($return);
    }
    function ChatLog(Request $request){
        $details = student::ChatHistoryList();
        return view('backend.chat.chatHistory',['details' => $details]);
    }
    function chatLogview(Request $request){
        $details = student::chatLogview($request);
        return view('backend.chat.chatLogview',['details' => $details]);
    }
    function deleteAllChat(Request $request) {
      student::deleteAllChat();
      return Redirect::to('backend/ChatLog');
    }
    function chatLogDelete(Request $request) {
      student::chatLogDelete($request);
      return Redirect::to('backend/ChatLog');
    }
}
