<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class dashboard extends Model {
    public static function adminCount($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_admin');
        $query= $query
            ->select('*')
            ->where('AdminFlag',1)
            ->get();

        $query1 = $db->table('tbl_admin');
        $query1= $query1
            ->select('*')
            ->where('AdminFlag',0)
            ->get();

        $return['active'] = count($query);
        $return['Inactive'] = count($query1);
        return $return; 
    }
    public static function teacherCount($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_teacher');
        $query= $query
            ->select('*')
            ->where('TeacherFlg',1)
            ->get();

        $query1 = $db->table('tbl_teacher');
        $query1= $query1
            ->select('*')
            ->where('TeacherFlg',0)
            ->get();

        $return['active'] = count($query);
        $return['Inactive'] = count($query1);
        return $return; 
    }
    public static function therapistCount($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_therapist');
        $query= $query
            ->select('*')
            ->where('TeacherFlg',1)
            ->get();

        $query1 = $db->table('tbl_therapist');
        $query1= $query1
            ->select('*')
            ->where('TeacherFlg',0)
            ->get();

        $return['active'] = count($query);
        $return['Inactive'] = count($query1);
        return $return; 
    }
    public static function studentCount($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        $query= $query
            ->select('*')
            ->where('StudentFlg',1)
            ->get();

        $query1 = $db->table('tbl_students');
        $query1= $query1
            ->select('*')
            ->where('StudentFlg',0)
            ->get();

        $return['active'] = count($query);
        $return['Inactive'] = count($query1);
        return $return; 
    }
    public static function adminData($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_admin');
        $query= $query
            ->select('tbl_admin.*','tbl_adminrole.RoleName as RoleName');
        $query = $query->leftJoin('tbl_adminrole', 'tbl_adminrole.id', '=', 'tbl_admin.Role');
        $query= $query->where('tbl_admin.id',$request->id)
            ->get();
        return $query; 
    }
    public static function gallerylist($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        $query= $query
            ->select('*')
            ->get();
        return $query; 
    }
    public static function studentCountForTeacher($request=null) {
        $db = DB::connection('mysql');
        
        if(session::get('TeacherRole')!="Therapist") {
            $query4 = $db->table('tbl_teacher');
            $query4= $query4
                ->select('*')
                ->where('id',session::get('TeacherId'))
                ->get();
    
            $classRoom = explode(",", $query4[0]->ClassRoom);
            $query = $db->table('tbl_students');
            $query= $query
                ->select('*')
                ->where('StudentFlg',1)
                ->whereIn('classRoom', $classRoom)
                ->get();
    
            $query1 = $db->table('tbl_students');
            $query1= $query1
                ->select('*')
                ->where('StudentFlg',0)
                ->whereIn('classRoom', $classRoom)
                ->get();
    
            $return['active'] = count($query);
            $return['Inactive'] = count($query1);
        } else {
            $therapistId =  session::get('TeacherId');
            $query = $db->table('tbl_students');
            $query= $query
                ->select('*')
                ->where('StudentFlg',1)
                ->whereRaw('FIND_IN_SET('.$therapistId.',Therapist)',1)
                ->get();
    
            $query1 = $db->table('tbl_students');
            $query1= $query1
                ->select('*')
                ->where('StudentFlg',0)
                ->whereRaw('FIND_IN_SET('.$therapistId.',Therapist)',1)
                ->get();
    
            $return['active'] = count($query);
            $return['Inactive'] = count($query1);
        }
        return $return; 
    }
    public static function studentCountForAdmin() {
        $db = DB::connection('mysql');
         $query3 = $db->table('tbl_admin')
                    ->select('Role')
                    ->where('id',Session::get('AdminID'))
                    ->get();
        if ($query3[0]->Role==3) { 
            $query = $db->table('tbl_students');
            $query= $query
                ->select('*')
                ->where('StudentFlg',1)
                ->whereRaw('FIND_IN_SET('.Session::get('AdminID').',SectionHead)')
                ->get();

            $query1 = $db->table('tbl_students');
            $query1= $query1
                ->select('*')
                ->where('StudentFlg',0)
                ->whereRaw('FIND_IN_SET('.Session::get('AdminID').',SectionHead)')
                ->get();
        } else {
            $query = $db->table('tbl_students');
            $query= $query
                ->select('*')
                ->where('StudentFlg',1)
                ->get();

            $query1 = $db->table('tbl_students');
            $query1= $query1
                ->select('*')
                ->where('StudentFlg',0)
                ->get();
        }

        $return['active'] = count($query);
        $return['Inactive'] = count($query1);
        return $return; 
    }
}