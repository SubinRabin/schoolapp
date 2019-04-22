<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\dashboard;
use App\Model\student;
use App\Model\teacher;
use DB;
use Input;
use Redirect;
use Session;
use Datatables;
use Mail;
class DashboardController extends Controller
{
    function index(Request $request) {
        if (session::get('TeacherEmail')=="") {
            return Redirect::to('teacher');
        }
        $student=dashboard::studentCountForTeacher();
        return view('teacher.dashboard.index',[
                                            'student' => $student,
                                                ]);
    }
    function StudentList(Request $request) {
        if (session::get('TeacherEmail')=="") {
            return Redirect::to('teacher');
        }
        return view('teacher.dashboard.StudentList');
    }
    function TshowStudentlist(Request $request) {
        if(session::get('TeacherRole')!="Therapist") {
        $classRoom = array();
        $teacherProfile = teacher::teacherProfile();
        $classRoom = explode(",", $teacherProfile[0]->ClassRoom);
        DB::statement(DB::raw('set @rownum=0'));
        $student = DB::table('tbl_students')->leftJoin('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')
            ->select([
                 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                 'tbl_students.id',
                 'tbl_students.studentId',
                 'tbl_students.Name',
                 'tbl_students.ParentName',
                 'tbl_students.Mobile',
                 'tbl_classroom.classRoom as classRoom',
                 // 'tbl_section.section as section',
                 'tbl_students.program as pro',
                 'tbl_students.Therapy as thrp',
                 'tbl_students.CreatedDate',
                 'tbl_students.StudentFlg'
                ])->whereIn('tbl_students.classRoom', $classRoom);
       } else {
        DB::statement(DB::raw('set @rownum=0'));
        $student = DB::table('tbl_students')->leftJoin('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')
            ->select([
                 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                 'tbl_students.id',
                 'tbl_students.studentId',
                 'tbl_students.Name',
                 'tbl_students.ParentName',
                 'tbl_students.Mobile',
                 'tbl_classroom.classRoom as classRoom',
                 // 'tbl_section.section as section',
                 'tbl_students.program as pro',
                 'tbl_students.Therapy as thrp',
                 'tbl_students.CreatedDate',
                 'tbl_students.StudentFlg'
                ])->whereRaw('FIND_IN_SET('.session::get('TeacherId').',Therapist)',1);
       }
        return Datatables::of($student)
        ->addColumn('Status', function ($student) {
                $status = 'Inactive';
                if ($student->StudentFlg==1) {
                    $status = 'Active';
                }
                return $status;
            })
            ->addColumn('Program', function ($student) {
                $details=student::programExplodedata($student->pro);
                return $details;
            })
            ->addColumn('Therapy', function ($student) {
                $details=student::TherapyExplodedata($student->thrp);
                return $details;
            })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);
    }
    function teacherProfile(Request $request) {
        if (session::get('TeacherEmail')=="") {
            return Redirect::to('teacher');
        }
        $request->id = session::get('TeacherId');
        $details = teacher::teacherDetail($request);
        return view('teacher.dashboard.teacherProfile',['details' => $details]);
    }
    function TeacherProfileSubmit(Request $request) {
        $request->id = session::get('TeacherId');
        $insert = teacher::TeacherProfileSubmit($request);

        $file = $request->file('Profile');
        if (isset($file) && $file!="") {
            if (session::get('TeacherRole')=='Teacher') {
              $newFileName = $file->getClientOriginalName();
              if (!file_exists('Uploads/Teacher/'.session::get('TeacherId'))) {
                  mkdir('Uploads/Teacher/'.session::get('TeacherId'), 0777, true);
              }
              $destinationPath = 'Uploads/Teacher/'.session::get('TeacherId');
              $file->move($destinationPath,$newFileName);

              $update = DB::table('tbl_teacher')
              ->where('id',session::get('TeacherId'))
              ->update([
                      'Profile' =>$newFileName,]);
            } else {
                $newFileName = $file->getClientOriginalName();
                  if (!file_exists('Uploads/Therapist/'.session::get('TeacherId'))) {
                      mkdir('Uploads/Therapist/'.session::get('TeacherId'), 0777, true);
                  }
                  $destinationPath = 'Uploads/Therapist/'.session::get('TeacherId');
                  $file->move($destinationPath,$newFileName);

                  $update = DB::table('tbl_therapist')
                  ->where('id',session::get('TeacherId'))
                  ->update([
                          'Profile' =>$newFileName,]);
            }
        }
        return Redirect::to('teacherProfile');
        
    }
    function teacherInbox(Request $request){
        return view('teacher.chat.inbox');
    }
    function teacherChat(Request $request){
        $type = 'Student';
        $details = student::ChatDetails($type,$request->receiverId);
        return view('teacher.chat.chat',['details' => $details]);
    }
    function Teachernotify_count() {
        $notifications = teacher::notifications(session::get('TeacherId'));

        if ($notifications['chat']!=0) {
           $notify   = $notifications['chat'];
        } else {
            $notify = '';
        }
        echo json_decode($notify);
    }
    function TeachermailChatcount() {
        $notifications = teacher::notifications(session::get('TeacherId'));

        $notify = '';
        if($notifications['chat']!=0) {
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
    function TeacherchatList() {
        $return = '';
        $chatList = teacher::teacherchatList(session::get('TeacherId'));
        if (count($chatList)!=0) {
                foreach ($chatList as $key => $value) {
                    $profileImg = '../app/resources/assets/common/images/Photo-icon.png';
                    if ($value->Profile!="") {
                        $profileImg  = '../app/Uploads/Student/'.$value->studentId.'/'.$value->Profile;
                    }
                    $notificationStatus = teacher::notificationStatus($value->id);
                    if ($value->loginStatus==1) {
                        $status= 'online';
                    } else {
                        $status= 'offline';
                    }
                if ($notificationStatus['chat']!=0) {
                    $req = '';
                } else {
                    $req = '';
                }
                $return .='<li class="list-group-item">
                                <a href="teacherChat?receiverId='.$value->id.$req.'" >
                                    <div class="avatar">
                                        <img src="'.$profileImg.'" alt="">';
                                        if ($notificationStatus['chat']!=0) { 
                                            $return .='<span class="chatNot">
                                                    '.$notificationStatus['chat'].'
                                            </span>';
                                        }
                                    $return .='</div>
                                    <span class="name">'.$value->studentId.'<br><small>'.$value->classRoomName.'</small></span>
                                    <i class="fa fa-circle '.$status.'"></i>
                                </a>
                                <span class="clearfix"></span>
                            </li>';
            } 
        } 
        echo ($return);
    }
    function forgetPassword(Request $request) {
      return view('teacher.login.forgetPassword');
    }
    function resetPassword(Request $request) {
      $pwd = 'temp'.rand(1000,9999);
      
      if ($request->Role=='Teacher') {
        $query = DB::table('tbl_teacher')
          ->where('Email',$request->email)
          ->where('TeacherFlg','1')
          ->get();
      } else {
        $query = DB::table('tbl_therapist')
          ->where('Email',$request->email)
          ->where('TeacherFlg','1')
          ->get();
      }
      
      if (count($query)!=0) {
        if ($request->Role=='Teacher') {
          $reset = DB::table('tbl_students')
              ->where('Email',$request->email)
              ->update([
                  'Password' => md5($pwd),
                ]);
        } else {
          $reset = DB::table('tbl_therapist')
              ->where('Email',$request->email)
              ->update([
                  'Password' => md5($pwd),
                ]);
        }  
        session::flash('reset','success');

        $maildetailssubject = 'Your password changed';
        $mailformat= array('','');
        $emailpersonal = $request->email;
        $msg = 'Your temporary password is : '.$pwd.'
                                              
                                      
            Click this link '.url('/teacher').'
            ';
        $mail = Mail::sendwithoutview($msg, $mailformat, function ($message) use ($emailpersonal,$maildetailssubject) {
              $message->from('subinrabin444@gmail.com','no-reply');
              $message->to($emailpersonal)->subject($maildetailssubject);
        });
      } else {
        session::flash('reset','failed');
      }

        return Redirect::to('/teacher/forgetPassword');
  }
}
