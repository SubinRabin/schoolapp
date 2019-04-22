<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class teacher extends Model {
	public static function ProgramList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_program');
        $query= $query
            ->select('id','Program')
            ->get();
        return $query; 
    }
    public static function teacherSubmitBtnFun($request=null) {
        if (!isset($request->ClassRoom)) {
            $request->ClassRoom = array();
        }
        if (!isset($request->Program)) {
            $request->Program = array();
        }
        $ClassRoom = implode(",", $request->ClassRoom);
        // $section = implode(",", $request->section);
        $Program = implode(",", $request->Program);


        $db = DB::connection('mysql');
        if ($request->id!="") {
                $id = $request->id;
                
                 $query= $db->table('tbl_teacher')
                    ->where('id',$request->id);
                if (isset($request->changeapass)) {
                   $query ->update([
                        'Username' => $request->Username,
                        'Name' => $request->Name,
                        'Email' => $request->Email,
                        'CNumber' => $request->number,
                        'Qualification' => $request->Qualification,
                        'Password' => md5($request->Password),
                        'ClassRoom' => $ClassRoom,
                        // 'section' => $section,
                        'Program' => $Program,
                        'UpdatedDate' => date('Y-m-d'),
                        'UpdatedBy' => Session::get('AdminName'),
                        ]);
                   } else {
                    $query ->update([
                        'Username' => $request->Username,
                        'Name' => $request->Name,
                        'Email' => $request->Email,
                        'CNumber' => $request->number,
                        'Qualification' => $request->Qualification,
                        'ClassRoom' => $ClassRoom,
                        // 'section' => $section,
                        'Program' => $Program,
                        'UpdatedDate' => date('Y-m-d'),
                        'UpdatedBy' => Session::get('AdminName'),
                        ]);
                   }
        } else {
            $query=$db->table('tbl_teacher')
                       ->insert(
                [
                'Username' => $request->Username,
                'Name' => $request->Name,
                'Email' => $request->Email,
                'CNumber' => $request->number,
                'Qualification' => $request->Qualification,
                'ClassRoom' => $ClassRoom,
                // 'section' => $section,
                'Program' => $Program,
                'Password' => md5($request->Password),
                'CreatedDate' => date('Y-m-d'),
                'CreatedBy' => Session::get('AdminName'),
                ]);
            $id = DB::getPdo()->lastInsertId();;
        }
        return $id;
    }
    public static function teacherDetail($request= null) {
        $db = DB::connection('mysql');
        if (session::get('TeacherRole')=='Therapist') {
          $query = $db->table('tbl_therapist');
        } else {
		  $query = $db->table('tbl_teacher');
        }
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
    }
    public static function teacherDeleteBtnFun($request=null) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_teacher')
          ->where('id',$request->id);
           $query ->update([
                'TeacherFlg' => $request->flag,
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('AdminName'),
            ]);
        return $query;
    }
    public static function TeacherProfileSubmit($request=null)
    {
         $db = DB::connection('mysql');
        if (session::get('TeacherRole')=='Therapist') {
            $query= $db->table('tbl_therapist')
            ->where('id',$request->id);
        } else {
            $query= $db->table('tbl_teacher')
            ->where('id',$request->id);
        }
        if (isset($request->changeapass)) {
           $query ->update([
                'Name' => $request->Name,
                'Email' => $request->Email,
                'CNumber' => $request->number,
                'Qualification' => $request->Qualification,
                'Password' => md5($request->Password),
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('TeacherName'),
                ]);
           } else {
            $query ->update([
                'Name' => $request->Name,
                'Email' => $request->Email,
                'CNumber' => $request->number,
                'Qualification' => $request->Qualification,
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('TeacherName'),
                ]);
           }
           return true;
    }
    public static function teacherchatList($TeacherId) {
        $query1 = array();
        $db = DB::connection('mysql');
        if (session::get('TeacherRole')=='Teacher') {
            $query= $db->table('tbl_teacher');
            $query= $query
                ->select('*')
                ->where('id',$TeacherId)
                ->get();

            $ClassRoom = explode(",", $query[0]->ClassRoom); 
            $query1 = $db->table('tbl_students');
            $query1 = $query1
                ->select('tbl_students.*','tbl_classroom.classRoom as classRoomName')->join('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')
                ->whereIn('tbl_students.classRoom', $ClassRoom)
                ->where('tbl_students.StudentFlg',1)
                ->get();
        } else {
            $query2 = $db->table('tbl_students');
            $query2 = $query2
                ->select('tbl_students.*','tbl_classroom.classRoom as classRoomName')->join('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')
                ->where('tbl_students.StudentFlg',1)
                ->get();

            foreach ($query2 as $key => $value) {
                $explode = explode(",", $value->Therapist);
                foreach ($explode as $key1 => $value1) {
                    if ($value1==$TeacherId) {
                        $query1[$key] = $value;
                    }
                }
            }    
        }
        return $query1; 
    }
    public static function notifications($id) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_chat');
        $query= $query
            ->select('*');
            if (session::get('TeacherRole')=='Teacher') {
                $query->where('TeacherID',$id)
                ->where('sendFrom' ,'Student');
                $query= $query->where('TeacherRead',0);
            } else {
                $query->where('TherapistID',$id)
                ->where('sendFrom' ,'Student');
                $query= $query->where('TherapistRead',0);
            }
            $query= $query->get();

        $return['chat'] = count($query);
        return $return;
    }
    public static function notificationStatus($StudentId) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_chat');
        $query= $query
            ->select('*');
            if (session::get('TeacherRole')=='Teacher') {
                $query->where('TeacherID',session::get('TeacherId'))
                ->where('sendFrom' ,'Student')
                ->where('StudentID' ,$StudentId)
                ->where('TeacherRead',0);
            } else {
                $query->where('TherapistID',session::get('TeacherId'))
                ->where('sendFrom' ,'Student')
                ->where('StudentID' ,$StudentId)
                ->where('TherapistRead',0);
            }
            $query= $query->get();

        $return['chat'] = count($query);
        return $return;
    }
    public static function teacherDetailget($request= null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_teacher');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
    }
    public static function ProfilePic($id) {
        $db = DB::connection('mysql');
        if (session::get('TeacherRole')=='Teacher') {
            $query= $db->table('tbl_teacher');
            $query= $query
            ->select('Profile')
            ->where('id',$id)
            ->get();
        } else {
            $query= $db->table('tbl_therapist');
            $query= $query
            ->select('Profile')
            ->where('id',$id)
            ->get();
        }
        return $query[0]->Profile;
    }
    public static function teacherProfile() {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_teacher');
        $query= $query
            ->select('*')
            ->where('id',session::get('TeacherId'))
            ->get();
        return $query;
    }
}