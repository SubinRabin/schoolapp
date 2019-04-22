<?php
namespace App\Http\Controllers\Teacher;
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
class ChatController extends Controller
{

    function sendMessage(Request $request)
    {
        $username = session::get('TeacherId');
        $text = $request->text;
        $receiverId = $request->receiverId;
        $type = $request->type;
        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');

        $userDetails =  student::ChatDetails($type,$receiverId);

        if ($userDetails['status']==0) {
            $maildetailssubject = 'You have a chat notification';
            $msg = 'Please check chat box.';
            $mailformat= array('','');
            $emailpersonal = $userDetails['Email'];
            // $mail = Mail::sendwithoutview($msg, $mailformat, function ($message) use ($emailpersonal,$maildetailssubject) {
            //     $message->from('subinrabin444@gmail.com','no-reply');
            //     $message->to($emailpersonal)->subject($maildetailssubject);
            // });
        }

        if ($request->role=='Therapist') {
            $sendFrom = 'therapist';
            $insert = $ChatMessagetbl;
                    $insert = $insert->insert([
                        'TherapistID' => $username,
                        'StudentID' => $receiverId,
                        'message' => $text,
                        'sendFrom' => $sendFrom,
                        'CreatedDate' => date('Y-m-d h:i:s'),
                    ]);
        } else {
            $sendFrom = 'teacher';
            $insert = $ChatMessagetbl;
                    $insert = $insert->insert([
                        'TeacherID' => $username,
                        'StudentID' => $receiverId,
                        'message' => $text,
                        'sendFrom' => $sendFrom,
                        'CreatedDate' => date('Y-m-d h:i:s'),
                    ]);
        }
        $userDetails =  student::ChatDetails($sendFrom,$username);
                
                $return = '<li class="clearfix odd">
                                <div class="chat-avatar">
                                    <img src="'.$userDetails['Profile'].'" alt="male">
                                    <i></i>
                                </div>
                                <div class="conversation-text">
                                    <div class="ctext-wrap">
                                        <i>'.$userDetails['Name'].'</i>
                                        <p>
                                            '.$request->text.'
                                        </p>
                                    </div>
                                </div>
                            </li>';


        echo json_encode($return);

        
    }

    // function isTyping(Request $request)
    // {
    //     $username = $request->username;

    //     $chat = Chat::find(1);
    //     if ($chat->user1 == $username)
    //         $chat->user1_is_typing = true;
    //     else
    //         $chat->user2_is_typing = true;
    //     $chat->save();
    // }

    // function notTyping(Request $request)
    // {
    //     $username = $request->username;

    //     $chat = Chat::find(1);
    //     if ($chat->user1 == $username)
    //         $chat->user1_is_typing = false;
    //     else
    //         $chat->user2_is_typing = false;
    //     $chat->save();
    // }
    function allChatMessages(Request $request) {
        $username = session::get('TeacherId');

        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');

        if ($request->role=='Therapist') {
            $message = $ChatMessagetbl
                ->where('TherapistID', $username)
                ->where('StudentID', $request->receiverId)
                ->orderBy('id','asc')->get();
        } else {
            $message = $ChatMessagetbl
                ->where('TeacherID', $username)
                ->where('StudentID', $request->receiverId)
                ->orderBy('id','asc')->get();
        }
        if (count($message) > 0)
        {   
            if ($request->role=='Therapist') {
                $read = $ChatMessagetbl
                    ->where('TherapistID', $username)
                    ->where('StudentID', $request->receiverId)
                    ->where('sendFrom', '!=', 'teacher')
                    ->update(
                    [
                        'TherapistRead' => 1,
                    ]);
            } else {
                $read = $ChatMessagetbl
                    ->where('TeacherID', $username)
                    ->where('StudentID', $request->receiverId)
                    ->where('sendFrom', 'Student')
                    ->update(
                    [
                        'TeacherRead' => 1,
                    ]);
            }
            foreach ($message as $key => $value) {
                $odd[$key] = '';
                if ($value->sendFrom=="Student") {            
                    $userId = $value->StudentID;
                } else if($value->sendFrom=="Admin")  {
                    $userId = $value->AdminID;
                } else if($value->sendFrom=="teacher")  {
                    $odd[$key] = 'odd';
                    $userId = $value->TeacherID;
                } else {
                    $odd[$key] = 'odd';
                    $userId = $value->TherapistID;
                }

                $userDetails =  student::ChatDetails($value->sendFrom,$userId);
                $avatar[$key] = $userDetails['Profile'];
                if ($value->sendFrom=="teacher" || $value->sendFrom=="therapist") {
                    $profileDetails =  student::ChatDetails($value->sendFrom,$userId);
                    $avatar[$key] = $profileDetails['Profile'];
                }

                // if ($value->sendFrom!="Student" && $value->studentRead==1) {
                    $return[$key] = '<li class="clearfix '.$odd[$key].'">
                                <div class="chat-avatar">
                                    <img src="'.$avatar[$key].'" alt="male">
                                    <i></i>
                                </div>
                                <div class="conversation-text">
                                    <div class="ctext-wrap">
                                        <i>'.$userDetails['Name'].'</i>
                                        <p>
                                            '.$value->message.'
                                        </p>
                                    </div>
                                </div>
                            </li>';
                // }
            }

            echo json_encode($return);
        }
    }
    function retrieveChatMessages(Request $request)
    {

        $username = session::get('TeacherId');

        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');

        if ($request->role=='Therapist') {
            $message = $ChatMessagetbl
                    ->where('sendFrom', 'Student')
                    ->where('StudentID', $request->receiverId)
                    ->where('TherapistID', $username)
                    ->where('TherapistRead', 0)
                    ->first();
        } else {
            $message = $ChatMessagetbl
                    ->where('sendFrom', '!=', 'teacher')
                    ->where('StudentID', $request->receiverId)
                    ->where('TeacherID', $username)
                    ->where('TeacherRead', 0)
                    ->first();
        }

        if (count($message) > 0)
        {
            if ($request->role=='Therapist') {
                $read = $ChatMessagetbl
                    ->where('TherapistID', $username)
                    ->where('StudentID', $request->receiverId)
                    ->where('sendFrom', '!=', 'teacher')
                    ->update(
                    [
                        'TherapistRead' => 1,
                    ]);
            } else {
                $read = $ChatMessagetbl
                    ->where('TeacherID', $username)
                    ->where('StudentID', $request->receiverId)
                    ->where('sendFrom', 'Student')
                    ->update(
                    [
                        'TeacherRead' => 1,
                    ]);
            }
            $userId = $message->StudentID;
            $userDetails =  student::ChatDetails($message->sendFrom,$userId);


             $return = '<li class="clearfix">
                                <div class="chat-avatar">
                                    <img src="'.$userDetails['Profile'].'" alt="male">
                                    <i></i>
                                </div>
                                <div class="conversation-text">
                                    <div class="ctext-wrap">
                                        <i>'.$userDetails['Name'].'</i>
                                        <p>
                                            '.$message->message.'
                                        </p>
                                    </div>
                                </div>
                            </li>';

            echo json_encode($return);
        }
    }

    function retrieveTypingStatus(Request $request)
    {
        $username = $request->username;

        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');

        $chat = $ChatMessagetbl
                ->find(1);
        if ($chat->StudentID == $username)
        {
            if ($chat->TeacherID)
                return $chat->StudentID;
        }
        else
        {
            if ($chat->StudentID)
                return $chat->StudentID;
        }
    }
}