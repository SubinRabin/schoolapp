<?php
namespace App\Http\Controllers\Backend;
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
        $username = session::get('AdminID');
        $text = $request->text;
        $receiverId = $request->receiverId;
        $type = 'Student';
        $sendFrom = 'Admin';
        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');

        $userDetails =  student::ChatDetails($type,$receiverId);

        if ($userDetails['status']==0) {
            $maildetailssubject = 'You have a chat notification';
            $msg = 'Please check chat box.';
            $mailformat= array('','');
            $emailpersonal = $userDetails['Email'];
            $mail = Mail::sendwithoutview($msg, $mailformat, function ($message) use ($emailpersonal,$maildetailssubject) {
                $message->from('subinrabin444@gmail.com','no-reply');
                $message->to($emailpersonal)->subject($maildetailssubject);
            });
        }
        
        $insert = $ChatMessagetbl;
                $insert = $insert->insert([
                    'AdminID' => $username,
                    'StudentID' => $receiverId,
                    'message' => $text,
                    'sendFrom' => $sendFrom,
                    'CreatedDate' => date('Y-m-d h:i:s'),
                ]);


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

    function isTyping(Request $request)
    {

        
        $username = $request->username;

        $chat = Chat::find(1);
        if ($chat->user1 == $username)
            $chat->user1_is_typing = true;
        else
            $chat->user2_is_typing = true;
        $chat->save();
    }

    function notTyping(Request $request)
    {
        $username = $request->username;

        $chat = Chat::find(1);
        if ($chat->user1 == $username)
            $chat->user1_is_typing = false;
        else
            $chat->user2_is_typing = false;
        $chat->save();
    }
    function allChatMessages(Request $request) {
        $return = array();
        $username = session::get('AdminID');
        $type =  $request->type;
        $receiverId =  $request->receiverId;

        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');
        
        $message = $ChatMessagetbl
            ->where('AdminID', $username)
            ->where('StudentID', $receiverId)
            ->orderBy('id','asc')->get();
        


        if (count($message) > 0)
        {
            foreach ($message as $key => $value) {
                $odd[$key] = '';
                if ($value->sendFrom=="Admin") {
                    $odd[$key] = 'odd';
                    $userId = $value->AdminID;
                } else {
                    $userId = $value->StudentID;;
                }
                $userDetails =  student::ChatDetails($value->sendFrom,$userId);
                $avatar[$key] = $userDetails['Profile'];
                if ($value->sendFrom=="Admin") {
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

        $username = session::get('AdminID');
        $type =  $request->type;
        $receiverId =  $request->receiverId;

        DB::statement(DB::raw('set @rownum=0'));
        $ChatMessagetbl =  DB::table('tbl_chat');

        $message = $ChatMessagetbl
                ->where('sendFrom','student')
                ->where('AdminID', $username)
                ->where('StudentID', $receiverId)
                ->where('AdminRead', 0)
                ->first();

        if (count($message) > 0)
        {
            $read = $ChatMessagetbl
                ->where('AdminID', $username)
                ->where('StudentID', $receiverId)
                ->where('sendFrom', 'student')
                ->update(
                [
                    'AdminRead' => 1,
                ]);
           

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

        $receiverId = $request->receiverId;
        $type = $request->type;

        $return = array();

        if ($type=='Student') {
            $userDetails =  student::ChatDetails('Student',$receiverId);
        }  else {
            if ($request->role=='Teacher') {
                $userDetails =  student::ChatDetails('teacher',$receiverId);
            } else {
                $userDetails =  student::ChatDetails('therapist',$receiverId);
            }
        }
        $return = array('name' => $userDetails['Name'],
                        'id' => $receiverId);
        return $return;
    }
}