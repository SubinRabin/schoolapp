<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class login extends Model {
	public static function adminLogin($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_admin');
        $query= $query
            ->select('*')
            ->where('Email',$request->Email)
            ->where('password',md5($request->password))
            ->get();
        return $query; 
	}
    public static function StudentData($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        $query= $query
            ->select('*')
            ->where('Username',$request->Username)
            ->where('password',md5($request->password))
            ->get();
        return $query; 
    }
    public static function TeachersData($request=null) {
        $db = DB::connection('mysql');
        if ($request->Role=="Teacher") {
            $query = $db->table('tbl_teacher');
        } else {
            $query = $db->table('tbl_therapist');
        }
        $query= $query
            ->select('*')
            ->where('Username',$request->Username)
            ->where('Password',md5($request->password))
            ->get();
        return $query; 
    }
    public static function StudentLoginStatusUpdate($studentId) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students')
            ->where('studentId',$studentId)
            ->update([
                    'loginStatus' => 1,
                ]);
        return true;
    }
    public static function teacherLoginStatusUpdate($id,$Role) {
        $db = DB::connection('mysql');
        if ($Role=="Teacher") {
            $query = $db->table('tbl_teacher');
        } else {
            $query = $db->table('tbl_therapist');
        }
            $query->where('id',$id)
            ->update([
                    'loginStatus' => 1,
                ]);
        return true;
    }
    public static function AdminLoginStatusUpdate($adminId) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_admin')
            ->where('id',$adminId)
            ->update([
                    'loginStatus' => 1,
                ]);
        return true;
    }
    public static function AdminData($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_admin');
        $query= $query
            ->select('*')
            ->where('Username',$request->Username)
            ->where('password',md5($request->password))
            ->get();
        return $query; 
    }
}