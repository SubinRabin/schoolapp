<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Storage;
class student extends Model {
    public static function studentDetail($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
    }
    public static function TeacherList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_teacher');
        $query= $query
            ->select('id','Name')
            ->get();
        return $query; 
    }
    public static function TherapistList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_therapist');
        $query= $query
            ->select('id','Name')
            ->get();
        return $query; 
    }
    public static function studentSubmitBtnFun($request=null) {
        if (!isset($request->Program)) {
            $Program = '';
        } else {
            $Program = implode(",", $request->Program);
        }
        if (!isset($request->Therapy)) {
            $Therapy = '';
        } else {
            $Therapy = implode(",", $request->Therapy);
        }
        if (!isset($request->Therapist)) {
            $Therapist = '';
        } else {
            $Therapist = implode(",", $request->Therapist);
        }
        if (!isset($request->SectionHead)) {
            $SectionHead = '';
        } else {
            $SectionHead = implode(",", $request->SectionHead);
        }
        $db = DB::connection('mysql');
        if ($request->id!="") {
                 $query= $db->table('tbl_students')
                    ->where('id',$request->id);
                if (isset($request->changeapass)) {
                   $query ->update([
                        'Username' => $request->Username,
                        'studentId' => $request->studentId,
                        'Name' => $request->Name,
                        'ParentName' => $request->parentName,
                        'Mobile' => $request->number,
                        'CountryCode' => $request->CountryCode,
                        'Email' => $request->Email,
                        'ClassRoom' => $request->ClassRoom,
                        'Password' => md5($request->Password),
                        // 'section' => $request->section,
                        'Therapist' => $Therapist,
                        'program' => $Program,
                        'Therapy' => $Therapy,
                        'SectionHead' => $SectionHead,
                        'UpdatedDate' => date('Y-m-d'),
                        'UpdatedBy' => Session::get('AdminName'),
                        ]);
                   } else {
                    $query ->update([
                        'Username' => $request->Username,
                        'studentId' => $request->studentId,
                        'Name' => $request->Name,
                        'ParentName' => $request->parentName,
                        'Mobile' => $request->number,
                        'CountryCode' => $request->CountryCode,
                        'Email' => $request->Email,
                        'ClassRoom' => $request->ClassRoom,
                        'Therapist' => $Therapist,
                        'program' => $Program,
                        'Therapy' => $Therapy,
                        'SectionHead' => $SectionHead,
                        'UpdatedDate' => date('Y-m-d'),
                        'UpdatedBy' => Session::get('AdminName'),
                        ]);
                   }

                
               // Storage::disk('ftp');
               // if (!file_exists(Storage::makeDirectory('Student/profiles/'.$request->id))) {
               //      Storage::makeDirectory('Student/profiles/'.$request->id);
               //  }
           $id = $request->studentId;
        } else {
           $id = $request->studentId;
            
            $query=$db->table('tbl_students')
                       ->insert(
                [
                    'Username' => $request->Username,
                    'Name' => $request->Name,
                    'ParentName' => $request->parentName,
                    'Mobile' => $request->number,
                    'Email' => $request->Email,
                    'ClassRoom' => $request->ClassRoom,
                    'Password' => md5($request->Password),
                    'section' => $request->section,
                    'program' => $Program,
                    'Therapy' => $Therapy,
                    'Therapist' => $Therapist,
                    'SectionHead' => $SectionHead,
                    'studentId' => $request->studentId,
                    'CreatedDate' => date('Y-m-d'),
                    'CreatedBy' => Session::get('AdminName'),
                ]);

                // Storage::disk('ftp');
                // if (!file_exists(Storage::makeDirectory('Student/profiles/'.$id))) {
                //     Storage::makeDirectory('Student/profiles/'.$id);
                // }

        }
        return $id;
    }
    public static function studentDeleteBtnFun($request=null) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_students')
          ->where('id',$request->id);
           $query ->update([
                'StudentFlg' => $request->flag,
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('AdminName'),
            ]);
        return $query;
    }
    public static function studentData($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        $query= $query
            ->select('tbl_students.*','tbl_classroom.classRoom as classRoom','tbl_section.section as section');
        $query = $query->leftJoin('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom');
        $query = $query->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_students.section');
        $query= $query->where('tbl_students.studentId',$request->id)
            ->get();
        return $query; 
    }
    public static function studentProfileSubmit($request=null) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_students')
        ->where('studentId',session::get('StudentID'));
        if (isset($request->changeapass)) {
            $query = $query->update([
                'Name' => $request->Name,
                'ParentName' => $request->parentName,
                'Email' => $request->Email,
                'Mobile' => $request->number,
                'CountryCode' => $request->CountryCode,
                'Password' => md5($request->Password),
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('StudentName'),
            ]);
        } else {
            $query = $query->update([
                'Name' => $request->Name,
                'ParentName' => $request->parentName,
                'Email' => $request->Email,
                'Mobile' => $request->number,
                'CountryCode' => $request->CountryCode,
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('StudentName'),
            ]);
        }
        return true;
    }
    public static function therapyList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_therapytype');
        $query= $query
            ->select('id','therapyType')
            ->get();
        return $query; 
    }
    public static function programExplodedata($program) {
        $outVal = array();
        $db = DB::connection('mysql');
        $programVal = explode(",", $program);
        foreach ($programVal as $key => $value) {
            $query = $db->table('tbl_program');
            $query= $query
                ->select('Program')
                ->where('id',$value)
                ->get();
            if (count($query)!=0) {
                $outVal[$key] = $query[0]->Program;
            }
        }
        return implode(",", $outVal);
    }
    public static function TherapyExplodedata($therapyType) {
        $outVal = array();
        $db = DB::connection('mysql');
        $therapyTypeval = explode(",", $therapyType);
        foreach ($therapyTypeval as $key => $value) {
            $query = $db->table('tbl_therapytype');
            $query= $query
                ->select('therapyType')
                ->where('id',$value)
                ->get();
            if (count($query)!=0) {
                $outVal[$key] = $query[0]->therapyType;
            }
        }
        return implode(",", $outVal);
    }
    public static function TherapistExplodedata($therapyType) {
        $outVal = array();
        $db = DB::connection('mysql');
        $therapyTypeval = explode(",", $therapyType);
        foreach ($therapyTypeval as $key => $value) {
            $query = $db->table('tbl_therapist');
            $query= $query
                ->select('Name')
                ->where('id',$value)
                ->get();
            if (count($query)!=0) {
                $outVal[$key] = $query[0]->Name;
            }
        }
        return implode(",", $outVal);
    }
    public static function studentchatList($studentId) {
        $return = array();

        $db = DB::connection('mysql');
        $query= $db->table('tbl_students');
        $query= $query
            ->select('*')
            ->where('id',$studentId)
            ->get();
        
        $ClassRoom = $query[0]->classRoom;
        $Therapist = explode(",", $query[0]->Therapist);
        $SectionHead = explode(",", $query[0]->SectionHead);

        
        $query1 = $db->table('tbl_teacher');
        $query1 = $query1
            ->select('*')
            ->where('TeacherFlg',1)
            ->get();
        
        foreach ($query1 as $key => $value) {
            $explodeClassRoom =   explode(",", $value->ClassRoom);
            foreach ($explodeClassRoom as $ECTkey => $ECTvalue) {
                if ($ECTvalue==$ClassRoom) {
                    $return['teacherName'][] = $value->Name;
                    $return['teacherType'][] = 'Teacher';
                    $return['teacherID'][] = $value->id;
                    $return['status'][] = $value->loginStatus;
                    $return['Profile'][] = $value->Profile;
                }
            }
        }
        

        $query2 = $db->table('tbl_therapist');
        $query2 = $query2
            ->select('*')
            ->whereIn('id', $Therapist)
            ->where('TeacherFlg',1)
            ->get();
        foreach ($query2 as $key => $value) {
            $return['teacherName'][] = $value->Name;
            $return['teacherType'][] = 'Therapist';
            $return['teacherID'][] = $value->id;
            $return['status'][] = $value->loginStatus;
            $return['Profile'][] = $value->Profile;
        }

        $query3 = $db->table('tbl_admin')->leftJoin('tbl_adminrole', 'tbl_adminrole.id', '=', 'tbl_admin.Role');
        $query3 = $query3
            ->select('tbl_admin.Name','tbl_adminrole.RoleName','tbl_admin.id','tbl_admin.loginStatus','tbl_admin.Profile')
            ->where('tbl_admin.AdminFlag',1)
            // ->whereIn('tbl_admin.id', $SectionHead)
            ->get();
        foreach ($query3 as $key => $value) {
            $return['teacherName'][] = $value->Name;
            $return['teacherType'][] = $value->RoleName;
            $return['teacherID'][] = $value->id;
            $return['status'][] = $value->loginStatus;
            $return['Profile'][] = $value->Profile;
        }

        return $return; 
    }
    public static function ChatDetails($type,$userId) {
        $return = array();
        $db = DB::connection('mysql');
        if ($type=='Student') {
            $query= $db->table('tbl_students');
            $query= $query
            ->select('*')
            ->where('id',$userId)
            ->get();
            $return['Name'] = $query[0]->studentId;
            $return['status'] = $query[0]->loginStatus;
            $return['Email'] = $query[0]->Email;
            if ($query[0]->Profile=="") {
                $return['Profile'] = '../app/resources/assets/common/images/Photo-icon.png';
            } else {
                $return['Profile'] = '../app/Uploads/Student/'.$query[0]->studentId.'/'.$query[0]->Profile;
            }
        
        } else if($type=='teacher') {
            $query= $db->table('tbl_teacher');
            $query= $query
            ->select('*')
            ->where('id',$userId)
            ->get();
            $return['Name'] = $query[0]->Name;
            $return['status'] = $query[0]->loginStatus;
            $return['Email'] = $query[0]->Email;
            if ($query[0]->Profile=="") {
                $return['Profile'] = '../app/resources/assets/common/images/Photo-icon.png';
            } else {
                $return['Profile'] = '../app/Uploads/Teacher/'.$query[0]->id.'/'.$query[0]->Profile;
            }
        } else if($type=='therapist') {
            $query= $db->table('tbl_therapist');
            $query= $query
            ->select('*')
            ->where('id',$userId)
            ->get();
            $return['Name'] = $query[0]->Name;
            $return['status'] = $query[0]->loginStatus;
            $return['Email'] = $query[0]->Email;
            if ($query[0]->Profile=="") {
                $return['Profile'] = '../app/resources/assets/common/images/Photo-icon.png';
            } else {
                $return['Profile'] = 'app/Uploads/Therapist/'.$query[0]->id.'/'.$query[0]->Profile;
            }
        } else {
            $query= $db->table('tbl_admin');
            $query= $query
            ->select('*')
            ->where('id',$userId)
            ->get();
            $return['Name'] = $query[0]->Name;
            $return['status'] = $query[0]->loginStatus;
            $return['Email'] = $query[0]->Email;
            if ($query[0]->Profile=="") {
                $return['Profile'] = '../app/resources/assets/common/images/Photo-icon.png';
            } else {
                $return['Profile'] = '../app/Uploads/Admin/'.$query[0]->id.'/'.$query[0]->Profile;
            }
        }
        
        return $return;
    }
    public static function inboxList() {
        $db = DB::connection('mysql');

        $query1 = $db->table('tbl_mail');
        $query1= $query1
                ->select(DB::RAW('max(id) as maxid'))
                ->where('receiver', session::get('StudentID'))
                ->groupby('sender')
                ->get();
        
        $id = array();
        if (count($query1)!=0) {
            foreach ($query1 as $key => $value) {
                $id[$key] = $value->maxid;
            }
        }
        
        $query = $db->table('tbl_mail');
        $query= $query
                ->select('tbl_mail.*','tbl_admin.Name')->leftJoin('tbl_admin', 'tbl_admin.id', '=', 'tbl_mail.sender')
                ->whereIn('tbl_mail.id',$id)
                ->orderby('tbl_mail.id','desc')
                ->get();
        return $query;

    }
    public static function inboxdata($id) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_mail');
        $query= $query
                ->select(DB::RAW('IF(tbl_admin.Name is NULL,"You",tbl_admin.Name) as SendName'), 'tbl_mail.*','tbl_admin.Name','tbl_admin.Role as AdminRole')->leftJoin('tbl_admin', 'tbl_admin.id', '=', 'tbl_mail.sender')
                ->where('tbl_mail.id', $id)
                ->get();

        return $query; 
    }
    public static function relatedinboxdata($msg_id,$sender) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_mail');
        $where  = DB::raw('(tbl_mail.receiver = "'.session::get('StudentID').'" AND tbl_mail.sender = "'.$sender.'") OR (tbl_mail.receiver = "'.$sender.'" AND tbl_mail.sender = "'.session::get('StudentID').'") AND tbl_mail.id != '.$msg_id.'');
        $query= $query
                ->select(DB::RAW('IF(tbl_admin.Name is NULL,"You",tbl_admin.Name) as SendName'), 'tbl_mail.*','tbl_admin.Name')->leftJoin('tbl_admin', 'tbl_admin.id', '=', 'tbl_mail.sender')
                ->whereRAW($where)
                ->orderby('tbl_mail.id','desc')
                ->get();
        return $query; 
    }
    public static function adminList($request = null) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_admin');
        $query= $query
            ->select('*')
            ->where('AdminFlag',1)
            ->get();
        return $query;
    }
    public static function composeSend($request = null) {
        
        $db = DB::connection('mysql');
        $query=$db->table('tbl_mail')
           ->insert([
                'sender' => session::get('StudentID'),
                'receiver' => $request->to,
                'sendertype' => 'Student',
                'receivertype' => 'Admin',
                'Subject' => $request->Subject,
                'Message' => $request->Message,
                'CreatedDate' => date('Y-m-d H:m:s'),
            ]);
        return true;
    }
    public static function readmsg($msgId) {
        $db = DB::connection('mysql');
        $query=$db->table('tbl_mail')
                ->where('id',$msgId)
             ->update([
                        'read' => 1,
                        ]);
        return true;
    }
    public static function gallerylist() {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_gallery');
        $query= $query
            ->select('*')
            ->orderby('id','desc');
        return $query;
    }
    public static function assessmentlist($filter) {
        $return = array();

        $db = DB::connection('mysql');
        $query= $db->table('tbl_assessment');
        $query= $query
            ->select('*')
            ->where('AssessmentType',$filter)
            ->orderby('id','desc');
        return $query;
    }
    public static function notifications($id) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_chat');
        $query= $query
            ->select('*')
            ->where('StudentID',$id)
            ->where('sendFrom','!=' ,'Student')
            ->where('studentRead',0)
            ->get();

        $query1= $db->table('tbl_mail');
        $query1= $query1
            ->select('*')
            ->where('receiver',$id)
            ->where('read',0)
            ->get();


        $return['chat'] = count($query);
        $return['mail'] = count($query1);

        return $return;
    }
    public static function studentsExplodedata($id) {
        $outVal = array();
        $db = DB::connection('mysql');
        $programVal = explode(",", $id);
        foreach ($programVal as $key => $value) {
            $query = $db->table('tbl_students');
            $query= $query
                ->select('Name')
                ->where('id',$value)
                ->get();
            if (count($query)!=0) {
                $outVal[$key] = $query[0]->Name;
            }
        }
        return implode(",", $outVal);
        
    }
    public static function SectionHeaddata($section) {

        $name = array();
        if ($section!="") {
            $explode = explode(",", $section);
            foreach ($explode as $key => $value) {
                $db = DB::connection('mysql');
                $query= $db->table('tbl_admin');
                $query= $query
                    ->select('Name')
                    ->where('id',$value)
                    ->get();

                $name[$key] = $query[0]->Name;
            }
        }
        return implode(",", $name);
    }
    public static function ChatHistoryList() {
        $return = array();

        $db = DB::connection('mysql');
        

        $roleGet = $db->table('tbl_admin')->select('Role')->where('id',session::get('AdminID'))->get();

        // $where = 'FIND_IN_SET("'.session::get('AdminID').'", IFNULL(SectionHead,"")) > 0';

        $SHStudents = DB::select('select `id` from `tbl_students` where FIND_IN_SET("'.session::get('AdminID').'", IFNULL(SectionHead,"")) > 0');

        if (count($SHStudents)!=0) {
            foreach ($SHStudents as $key => $value) {
                $st[$key] = $value->id;
             } 
        } else {
            $st[0] = 0;
        }
        

        $query= $db->table('tbl_chat')->leftJoin('tbl_students', 'tbl_students.id', '=', 'tbl_chat.StudentID');
        $query= $query
            ->select('tbl_chat.*','tbl_students.studentId')
            ->where('tbl_chat.StudentID','!=','');
            if ($roleGet[0]->Role==3) {
                $query= $query->whereIn('tbl_chat.StudentID', $st)
                ->where('tbl_chat.AdminID',NULL);
            }
            $query= $query->groupBy('tbl_chat.StudentID')
            ->get();
        foreach ($query as $key => $value) {
            $return['id'][] = $value->StudentID;
            $return['Name'][] = $value->studentId;
            $return['Type'][] = 'Student';
            $return['Date'][] = $value->CreatedDate;
        }

        if ($roleGet[0]->Role!=3) {
            $query1= $db->table('tbl_chat')->leftJoin('tbl_teacher', 'tbl_teacher.id', '=', 'tbl_chat.TeacherID');
            $query1= $query1
                ->select('tbl_chat.*','tbl_teacher.Name')
                ->where('tbl_chat.TeacherID','!=','')
                ->groupby('tbl_chat.TeacherID')
                ->get();
            foreach ($query1 as $key => $value) {
                $return['id'][] = $value->TeacherID;
                $return['Name'][] = $value->Name;
                $return['Type'][] = 'Teacher';
                $return['Date'][] = $value->CreatedDate;
            }


            $query2= $db->table('tbl_chat')->leftJoin('tbl_therapist', 'tbl_therapist.id', '=', 'tbl_chat.TherapistID');
            $query2= $query2
                ->select('tbl_chat.*','tbl_therapist.Name')
                ->where('tbl_chat.TherapistID','!=','')
                ->groupby('tbl_chat.TherapistID')
                ->get();
            foreach ($query2 as $key => $value) {
                $return['id'][] = $value->TherapistID;
                $return['Name'][] = $value->Name;
                $return['Type'][] = 'Therapist';
                $return['Date'][] = $value->CreatedDate;
            }

            $query3= $db->table('tbl_chat')->leftJoin('tbl_admin', 'tbl_admin.id', '=', 'tbl_chat.AdminID')->leftJoin('tbl_adminrole', 'tbl_adminrole.id', '=', 'tbl_admin.Role');
            $query3= $query3
                ->select('tbl_chat.*','tbl_admin.Name','tbl_adminrole.RoleName')
                ->where('tbl_chat.AdminID','!=','')
                ->groupby('tbl_chat.AdminID')
                ->get();
            foreach ($query3 as $key => $value) {
                $return['id'][] = $value->AdminID;
                $return['Name'][] = $value->Name;
                $return['Type'][] = $value->RoleName;
                $return['Date'][] = $value->CreatedDate;
            }
        }


        return $return;
    }
    public static function SectionHead() {
            $db = DB::connection('mysql');
            $query= $db->table('tbl_admin');
            $query= $query
                ->select('*')
                ->where('Role',3)
                ->get();

        return $query;
    }
    public static function ProfilePic($id)
    {
      $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        $query= $query
            ->select('Profile')
            ->where('id',$id)
            ->get();
        return $query[0]->Profile; 
    }
    public static function notificationStatus($id,$type) {

        $db = DB::connection('mysql');
        $query= $db->table('tbl_chat');
        if ($type=='Teacher') {
            $query= $query
            ->select('*');
            $query->where('StudentID',session::get('StudentOrgID'))
            ->where('sendFrom' ,'!=','Student')
            ->where('TeacherID' ,$id)
            ->where('studentRead',0);
            $query= $query->get();
        } else if($type=='Therapist') {
            $query= $query
            ->select('*');
            $query->where('StudentID',session::get('StudentOrgID'))
            ->where('sendFrom' ,'!=','Student')
            ->where('TherapistID' ,$id)
            ->where('studentRead',0);
            $query= $query->get();
        } else {
            $query= $query
            ->select('*');
            $query->where('StudentID',session::get('StudentOrgID'))
            ->where('sendFrom' ,'!=','Student')
            ->where('AdminID' ,$id)
            ->where('studentRead',0);
            $query= $query->get();
        }
        $return['chat'] = count($query);
        return $return;
    }
    public static function chatLogview($request) {
        $list =array();
        $Output =array();
        $main =array();
        
        $db = DB::connection('mysql');

        if ($request->mainType=='Student') {

            $query4= $db->table('tbl_students');
            $query4= $query4
                ->select('*')
                ->where('id',$request->Main)
                ->get();

            $main['Name'] = $query4[0]->studentId;

            $query= $db->table('tbl_chat')->leftJoin('tbl_students', 'tbl_students.id', '=', 'tbl_chat.StudentID');
            $query= $query
                ->select('tbl_chat.*','tbl_students.studentId');
                if (isset($request->Sub)) {
                    if ($request->SubType=='Teacher') {
                        $query= $query->where('tbl_chat.TeacherID',$request->Sub);
                    } else if($request->SubType=='Therapist') {
                        $query= $query->where('tbl_chat.TherapistID',$request->Sub);
                    } else {
                        $query= $query->where('tbl_chat.AdminID',$request->Sub);
                    }
                }
                $query= $query->where('tbl_chat.StudentID',$request->Main)
                ->groupBy('tbl_chat.StudentID')
                ->get();
            if ($query[0]->TeacherID!="") {
                $return['ID'] = $query[0]->TeacherID;
                $return['Type'] = 'teacher';
            } else if($query[0]->TherapistID!="") {
                $return['ID'] = $query[0]->TherapistID;
                $return['Type'] = 'therapist';
            } else {
                $return['ID'] = $query[0]->AdminID;
                $return['Type'] = 'Admin';
            }

            $query2= $db->table('tbl_chat')->leftJoin('tbl_students', 'tbl_students.id', '=', 'tbl_chat.StudentID');
            $query2= $query2
                ->select('tbl_chat.*','tbl_students.studentId');
                if ($return['Type']=='teacher') {
                    $query2= $query2->where('tbl_chat.TeacherID',$return['ID']);
                } else if($return['Type']=='therapist') {
                    $query2= $query2->where('tbl_chat.TherapistID',$return['ID']);
                } else {
                    $query2= $query2->where('tbl_chat.AdminID',$return['ID']);
                }
                $query2= $query2->where('tbl_chat.StudentID',$request->Main)
                ->get();
            foreach ($query2 as $key => $value) {
                if ($value->sendFrom=='Student') {
                    $out = student::ChatDetails('Student',$request->Main);
                    $Output['Name'][$key] = $value->studentId;
                    $Output['Side'][$key] = 'right';
                    $Output['id'][$key] = $request->Main;
                    $Output['image'][$key] = $out['Profile'];
                } else {
                    $Output['Side'][$key] = 'left';
                    if ($value->sendFrom=='teacher') {
                        $out = student::ChatDetails($value->sendFrom,$value->TeacherID);
                        $Output['Name'][$key] = $out['Name'];
                        $Output['id'][$key] = $value->TeacherID;
                        $Output['image'][$key] = $out['Profile'];
                    } else if($value->sendFrom=='therapist') {
                        $out = student::ChatDetails($value->sendFrom,$value->TherapistID);
                        $Output['Name'][$key] = $out['Name'];
                        $Output['id'][$key] = $value->TherapistID;
                        $Output['image'][$key] = $out['Profile'];
                    } else {
                        $out = student::ChatDetails($value->sendFrom,$value->AdminID);
                        $Output['Name'][$key] = $out['Name'];
                        $Output['id'][$key] = $value->AdminID;
                        $Output['image'][$key] = $out['Profile'];
                    }
                }
                $Output['Text'][$key] = $value->message;
            }


            $query3= $db->table('tbl_chat');
            $query3= $query3
            ->select('tbl_chat.*')->where('tbl_chat.StudentID',$request->Main);
            if ($return['Type']=='teacher') {
                $query3= $query3->groupBy('tbl_chat.StudentID','tbl_chat.TeacherID');
            } else if($return['Type']=='therapist') {
                $query3= $query3->groupBy('tbl_chat.StudentID','tbl_chat.TherapistID');
            } else {
                $query3= $query3->groupBy('tbl_chat.StudentID','tbl_chat.AdminID');
            }
            $query3= $query3
            ->get();

            if (count($query3)!=0) {
                foreach ($query3 as $key => $value) {
                    if ($value->TeacherID!="") {
                        $out = student::ChatDetails('teacher',$value->TeacherID);
                        $list['Name'][$key] = $out['Name'];
                        $list['Id'][$key] = $value->TeacherID;
                        $list['Type'][$key] = 'Teacher';
                    } else if($value->TherapistID!="") {
                        $out = student::ChatDetails('therapist',$value->TherapistID);
                        $list['Name'][$key] = $out['Name'];
                        $list['Id'][$key] = $value->TherapistID;
                        $list['Type'][$key] = 'Therapist';
                    } else {
                        if ($value->AdminID!='') {
                            $out = student::ChatDetails('Admin',$value->AdminID);
                            $list['Name'][$key] = $out['Name'];
                            $list['Id'][$key] = $value->AdminID;
                            $list['Type'][$key] = 'Admin';
                        }
                    }
                }
            }
        } else if($request->mainType=='Teacher') {
            $query4= $db->table('tbl_teacher');
            $query4= $query4
                ->select('*')
                ->where('id',$request->Main)
                ->get();

            $main['Name'] = $query4[0]->Name;

            $query= $db->table('tbl_chat');
            $query= $query
                ->select('*');
                if (isset($request->Sub)) {
                    $query= $query->where('StudentID',$request->Sub);
                }
                $query= $query->where('TeacherID',$request->Main)
                ->groupBy('TeacherID')
                ->get();


            $query2= $db->table('tbl_chat');
            $query2= $query2
                ->select('tbl_chat.*');
                $query2= $query2->where('TeacherID',$query[0]->TeacherID);
                $query2= $query2->where('StudentID',$query[0]->StudentID)
                ->get();
            foreach ($query2 as $key => $value) {
                if ($value->sendFrom=='Student') {
                    $out = student::ChatDetails('Student',$value->StudentID);
                    $Output['Name'][$key] = $out['Name'];
                    $Output['Side'][$key] = 'left';
                    $Output['id'][$key] = $value->StudentID;
                    $Output['image'][$key] = $out['Profile'];
                } else {
                    $Output['Side'][$key] = 'right';
                    $out = student::ChatDetails($value->sendFrom,$value->TeacherID);
                    $Output['Name'][$key] = $out['Name'];
                    $Output['id'][$key] = $value->TeacherID;
                    $Output['image'][$key] = $out['Profile'];
                    
                }
                $Output['Text'][$key] = $value->message;
            }

            $query3= $db->table('tbl_chat');
            $query3= $query3
            ->select('tbl_chat.*')->where('tbl_chat.TeacherID',$request->Main);
            $query3= $query3->groupBy('tbl_chat.StudentID','tbl_chat.TeacherID');
            $query3= $query3
            ->get();

            if (count($query3)!=0) {
                foreach ($query3 as $key => $value) {
                    $out = student::ChatDetails('Student',$value->StudentID);
                    $list['Name'][$key] = $out['Name'];
                    $list['Id'][$key] = $value->StudentID;
                    $list['Type'][$key] = 'Student';
                }
            }

        } else if($request->mainType=='Therapist') {
            $query4= $db->table('tbl_therapist');
            $query4= $query4
                ->select('*')
                ->where('id',$request->Main)
                ->get();

            $main['Name'] = $query4[0]->Name;

            $query= $db->table('tbl_chat');
            $query= $query
                ->select('*');
                if (isset($request->Sub)) {
                    $query= $query->where('StudentID',$request->Sub);
                }
                $query= $query->where('TherapistID',$request->Main)
                ->groupBy('TherapistID')
                ->get();


            $query2= $db->table('tbl_chat');
            $query2= $query2
                ->select('tbl_chat.*');
                $query2= $query2->where('TherapistID',$query[0]->TherapistID);
                $query2= $query2->where('StudentID',$query[0]->StudentID)
                ->get();
            foreach ($query2 as $key => $value) {
                if ($value->sendFrom=='Student') {
                    $out = student::ChatDetails('Student',$value->StudentID);
                    $Output['Name'][$key] = $out['Name'];
                    $Output['Side'][$key] = 'left';
                    $Output['id'][$key] = $value->StudentID;
                    $Output['image'][$key] = $out['Profile'];
                } else {
                    $Output['Side'][$key] = 'right';
                    $out = student::ChatDetails($value->sendFrom,$value->TherapistID);
                    $Output['Name'][$key] = $out['Name'];
                    $Output['id'][$key] = $value->TherapistID;
                    $Output['image'][$key] = $out['Profile'];
                    
                }
                $Output['Text'][$key] = $value->message;
            }

            $query3= $db->table('tbl_chat');
            $query3= $query3
            ->select('tbl_chat.*')->where('tbl_chat.TherapistID',$request->Main);
            $query3= $query3->groupBy('tbl_chat.StudentID','tbl_chat.TherapistID');
            $query3= $query3
            ->get();

            if (count($query3)!=0) {
                foreach ($query3 as $key => $value) {
                    $out = student::ChatDetails('Student',$value->StudentID);
                    $list['Name'][$key] = $out['Name'];
                    $list['Id'][$key] = $value->StudentID;
                    $list['Type'][$key] = 'Student';
                }
            }

        } else {
            $query4= $db->table('tbl_admin');
            $query4= $query4
                ->select('*')
                ->where('id',$request->Main)
                ->get();

            $main['Name'] = $query4[0]->Name;

            $query= $db->table('tbl_chat');
            $query= $query
                ->select('*');
                if (isset($request->Sub)) {
                    $query= $query->where('StudentID',$request->Sub);
                }
                $query= $query->where('AdminID',$request->Main)
                ->groupBy('AdminID')
                ->get();


            $query2= $db->table('tbl_chat');
            $query2= $query2
                ->select('tbl_chat.*');
                $query2= $query2->where('AdminID',$query[0]->AdminID);
                $query2= $query2->where('StudentID',$query[0]->StudentID)
                ->get();
            foreach ($query2 as $key => $value) {
                if ($value->sendFrom=='Student') {
                    $out = student::ChatDetails('Student',$value->StudentID);
                    $Output['Name'][$key] = $out['Name'];
                    $Output['Side'][$key] = 'left';
                    $Output['id'][$key] = $value->StudentID;
                    $Output['image'][$key] = $out['Profile'];
                } else {
                    $Output['Side'][$key] = 'right';
                    $out = student::ChatDetails($value->sendFrom,$value->AdminID);
                    $Output['Name'][$key] = $out['Name'];
                    $Output['id'][$key] = $value->AdminID;
                    $Output['image'][$key] = $out['Profile'];
                    
                }
                $Output['Text'][$key] = $value->message;
            }

            $query3= $db->table('tbl_chat');
            $query3= $query3
            ->select('tbl_chat.*')->where('tbl_chat.AdminID',$request->Main);
            $query3= $query3->groupBy('tbl_chat.StudentID','tbl_chat.AdminID');
            $query3= $query3
            ->get();

            if (count($query3)!=0) {
                foreach ($query3 as $key => $value) {
                    $out = student::ChatDetails('Student',$value->StudentID);
                    $list['Name'][$key] = $out['Name'];
                    $list['Id'][$key] = $value->StudentID;
                    $list['Type'][$key] = 'Student';
                }
            }
        }
        $final['chats'] = $Output;
        $final['related'] = $list;
        $final['main'] = $main;
        return $final;

    }
    public static function deleteAllChat() {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_chat')->delete();
        return true;
    }
    public static function chatLogDelete($request) {
        $db = DB::connection('mysql');
        if ($request->mainType=='Student') {
            $query= $db->table('tbl_chat')->where('StudentID', $request->Main)->delete();
        } else if ($request->mainType=='Teacher') {
            $query= $db->table('tbl_chat')->where('TeacherID', $request->Main)->delete();
        } else if ($request->mainType=='Therapist') {
            $query= $db->table('tbl_chat')->where('TherapistID', $request->Main)->delete();
        } else {
            $query= $db->table('tbl_chat')->where('AdminID', $request->Main)->delete();
        }
        return true;
    }
    public static function countryCode() {
            $db = DB::connection('mysql');
            $query= $db->table('country');
            $query= $query
                ->select('*')
                ->whereIn('CountryCode', [966, 91])
                ->get();
        return $query;
    }
}