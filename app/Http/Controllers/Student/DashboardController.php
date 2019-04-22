<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\student;
use DB;
use Input;
use Redirect;
use Session;
use Auth;
use Mail;
use Illuminate\Support\Facades\Validator;
use Zizou86\Unifonic\Unifonic;

class DashboardController extends Controller
{
	function index(Request $request) {
		if (session::get('StudentID')=="") {
            return Redirect::to('/');
        }
        $query = student::gallerylist()->paginate(8);
		return view('student.dashboard.index',['query' => $query]);
	}
	function assessmentDetails(Request $request) {
		if (session::get('StudentID')=="") {
            return Redirect::to('/');
        }
        if (!isset($request->tab)) {
            $filter = 'Admission';
        } else {
            $filter = $request->tab;
        }
        $query = student::assessmentlist($filter)->paginate(8);
		return view('student.dashboard.assessmentDetails',['query' => $query]);
	}
	function studentProfile(Request $request) {
		if (session::get('StudentID')=="") {
            return Redirect::to('/');
        }
        $request->id = session::get('StudentID');
        $countryCode = student::countryCode();
   		$data = student::studentData($request);  
		return view('student.dashboard.studentProfile',['data' => $data,'countryCode' => $countryCode]);
	}
	function studentProfileSubmit(Request $request) {
   		$data = student::studentProfileSubmit($request); 
        $file = $request->file('Profile');
        if (isset($file) && $file!="") {
          $newFileName = $file->getClientOriginalName();
          if (!file_exists('Uploads/Student/'.session::get('StudentID'))) {
              mkdir('Uploads/Student/'.session::get('StudentID'), 0777, true);
          }
          $destinationPath = 'Uploads/Student/'.session::get('StudentID');
          $file->move($destinationPath,$newFileName);

          $update = DB::table('tbl_students')
          ->where('studentId',session::get('StudentID'))
          ->update([
                  'Profile' =>$newFileName,]);
        } 
        return Redirect::to('/studentProfile');
	}
	function studentInbox(Request $request){
        $inboxList = student::inboxList();
        return view('student.chat.inbox',['inboxList' => $inboxList,]);
    }
    function studentChat(Request $request){
    	$details = student::ChatDetails(strtolower($request->type),$request->receiverId);
        return view('student.chat.chat',['details' => $details]);
    }
    function inboxView(Request $request) {
        if (session::get('StudentID')=="") {
            return Redirect::to('/');
        }
        if (isset($request->msgId)) {
            $readmsg = student::readmsg($request->msgId);
        }
        $inboxdata = student::inboxdata($request->msgId);
        if (isset($request->sender) && $request->sender=="You") {
            $sender = $inboxdata[0]->receiver; 
        } else {
            $sender = $inboxdata[0]->sender; 
        }
        
        $relinboxdata = student::relatedinboxdata($request->msgId,$sender);
        return view('student.chat.inboxView',['inboxdata' => $inboxdata,
                                             'relinboxdata' => $relinboxdata]);
    }
    function compose(Request $request) {
        if (session::get('StudentID')=="") {
            return Redirect::to('/');
        }
        $adminList = student::adminList();
        return view('student.chat.compose',['adminList' => $adminList]);
    }
    function composeSend(Request $request) {
        if (session::get('StudentID')=="") {
            return Redirect::to('/');
        }
        $insert = student::composeSend($request);
        return Redirect::to('/studentInbox');
        
    }   
    function notify_count() {
        $notifications = student::notifications(session::get('StudentOrgID'));

        if ($notifications['chat']!=0 || $notifications['mail']!=0) {
           $notify   = $notifications['chat']+$notifications['mail'];
        } else {
            $notify = '';
        }
        echo json_decode($notify);
    }
    function mailChatcount() {
        $notifications = student::notifications(session::get('StudentOrgID'));

        $notify = '';
        if ($notifications['mail']!=0) {
           $notify   .= '<a href="studentInbox" class="list-group-item">
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
    function StudentchatList() {
        $return = '';
        $chatList = student::studentchatList(session::get('StudentOrgID'));
        if (count($chatList)!=0) {
            foreach ($chatList['teacherName'] as $key => $value) { 
                $notificationStatus = student::notificationStatus($chatList['teacherID'][$key],$chatList['teacherType'][$key]);
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
                $profileImg = '../app/resources/assets/common/images/Photo-icon.png';
                if ($chatList['Profile'][$key]!="") {
                    if ($chatList['teacherType'][$key]=='Teacher') {
                        $profileImg  = '../app/Uploads/Teacher/'.$chatList['teacherID'][$key].'/'.$chatList['Profile'][$key];
                    } else if ($chatList['teacherType'][$key]=='Therapist') {
                        $profileImg  = '../app/Uploads/Therapist/'.$chatList['teacherID'][$key].'/'.$chatList['Profile'][$key];
                    } else {
                        $profileImg  = '../app/Uploads/Admin/'.$chatList['teacherID'][$key].'/'.$chatList['Profile'][$key];

                    }
                }
                if ($notificationStatus['chat']>0) {
                $return .='<li class="list-group-item">
                                <a href="studentChat?type='.$chatList['teacherType'][$key].'&receiverId='.$chatList['teacherID'][$key].$req.'" >
                                    <div class="avatar">
                                        <img src="'.$profileImg.'" alt="">';
                                        if ($notificationStatus['chat']!=0) { 
                                            $return .='<span class="chatNot">
                                                    '.$notificationStatus['chat'].'
                                            </span>';
                                        }
                                    $return .='</div>
                                    <span class="name">'.$value.'<br><small>'.$chatList['teacherType'][$key].'</small></span>
                                    <i class="fa fa-circle '.$status[$key].'"></i>
                                </a>
                                <span class="clearfix"></span>
                            </li>';
                }
            } 
        } 
        echo ($return);
    }
    function forgetPassword(Request $request) {
      $countryCode = student::countryCode();
      return view('student.login.forgetPassword',['countryCode' => $countryCode]);
    }
    function resetPassword(Request $request) {
      $otp = rand(1000,9999);
      $url  = '';

      $query = DB::table('tbl_students')
          ->where('Mobile',$request->mobile)
          ->where('studentId',$request->studentId)
          ->where('CountryCode',$request->CountryCode)
          ->where('StudentFlg','1')
          ->get();
      
      if (count($query)!=0) {
        $reset = DB::table('tbl_students')
            ->where('Mobile',$request->mobile)
            ->where('studentId',$request->studentId)
            ->update([
                'otp' => $otp,
              ]);
        
        $mobile = $request->CountryCode.$request->mobile;
        $message = 'Your One-Time Passsword(OTP) for shumua school app forget password is '.$otp.'. Please enter this on our portal.';
        $msg = Unifonic::send($mobile,$message);
        if ($msg->success=='true') {
         
          $url = '?msg=success&st='.$request->studentId;
        } else {
          $url = '?reset=error';
        }
      } else {
        $url = '?reset=failed';
      }
      return Redirect::to('/Student/forgetPassword'.$url);
  }
  function otpverification(Request $request) {
    if (isset($request->studentId)) {
      $query = DB::table('tbl_students')
            ->where('otp',$request->otp)
            ->where('studentId',$request->studentId)
            ->where('studentId','!=','')
            ->where('StudentFlg','1')
            ->get();
      if (count($query)!=0) {
        return view('student.login.changePassword',['data' => $query,]);
      } else {
        $url = '?otperror=true&st='.$request->studentId;
        return Redirect::to('/Student/forgetPassword'.$url);
      }
    } else {
      return Redirect::to('/Student/forgetPassword');
    }
  }
  function changepass(Request $request) {
    $reset = DB::table('tbl_students')
        ->where('id',$request->id)
        ->update([
            'Password' => md5($request->Password),
          ]);
    return Redirect::to('/');
  }
}
