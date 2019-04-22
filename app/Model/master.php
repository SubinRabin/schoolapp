<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class master extends Model {
    public static function adminRoleSubmitBtnFun($request=null) {
    	$db = DB::connection('mysql');
    	if ($request->id!="") {
				$query= $db->table('TBL_AdminRole')
                    ->where('id',$request->id)
                    ->update(['RoleName' => $request->roleName,
	            'UpdatedDate' => date('Y-m-d'),
	            'UpdatedBy' => Session::get('AdminName'),]);
    	} else {
			$query=$db->table('TBL_AdminRole')
					   ->insert(
			    ['RoleName' => $request->roleName,
	            'CreatedDate' => date('Y-m-d'),
	            'CreatedBy' => Session::get('AdminName'),]
	            );
    	}
		return $query;
	}
	public static function adminRoleDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('TBL_AdminRole');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function adminRoleDeleteBtnFun($request=null) {
    	$db = DB::connection('mysql');
		$query= $db->table('TBL_AdminRole')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
	}
	public static function programDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_program');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function programSubmitBtnFun($request=null) {
    	$db = DB::connection('mysql');
    	if ($request->id!="") {
			$query= $db->table('tbl_program')
                    ->where('id',$request->id)
                    ->update(['Program' => $request->programName,
	            'UpdatedDate' => date('Y-m-d'),
	            'UpdatedBy' => Session::get('AdminName'),]);
    	} else {
			$query=$db->table('tbl_program')
					   ->insert(
			    ['Program' => $request->programName,
	            'CreatedDate' => date('Y-m-d'),
	            'CreatedBy' => Session::get('AdminName'),]
	            );
    	}
		return $query;
	}
	public static function programDeleteBtnFun($request=null) {
    	$db = DB::connection('mysql');
		$query= $db->table('tbl_program')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
	}
	public static function sectionDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_section');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function sectionSubmitBtnFun($request=null) {
    	$db = DB::connection('mysql');
    	if ($request->id!="") {
			$query= $db->table('tbl_section')
                    ->where('id',$request->id)
                    ->update(['section' => $request->sectionName,
	            'UpdatedDate' => date('Y-m-d'),
	            'UpdatedBy' => Session::get('AdminName'),]);
    	} else {
			$query=$db->table('tbl_section')
					   ->insert(
			    ['section' => $request->sectionName,
	            'CreatedDate' => date('Y-m-d'),
	            'CreatedBy' => Session::get('AdminName'),]
	            );
    	}
		return $query;
	}
	public static function sectionDeleteBtnFun($request=null) {
    	$db = DB::connection('mysql');
		$query= $db->table('tbl_section')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
	}
	public static function classRoomDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_classroom');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function classRoomSubmitBtnFun($request=null) {
    	$db = DB::connection('mysql');
    	if ($request->id!="") {
			$query= $db->table('tbl_classroom')
                    ->where('id',$request->id)
                    ->update(['classRoom' => $request->classRoom,
	            'UpdatedDate' => date('Y-m-d'),
	            'UpdatedBy' => Session::get('AdminName'),]);
    	} else {
			$query=$db->table('tbl_classroom')
					   ->insert(
			    ['classRoom' => $request->classRoom,
	            'CreatedDate' => date('Y-m-d'),
	            'CreatedBy' => Session::get('AdminName'),]
	            );
    	}
		return $query;
	}
	public static function classRoomDeleteFun($request=null) {
    	$db = DB::connection('mysql');
		$query= $db->table('tbl_classroom')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
	}
	public static function therapyTypeDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_therapytype');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function therpyTypeSubmitBtnFun($request=null) {
    	$db = DB::connection('mysql');
    	if ($request->id!="") {
			$query= $db->table('tbl_therapytype')
                    ->where('id',$request->id)
                    ->update(['therapyType' => $request->therapyType,
	            'UpdatedDate' => date('Y-m-d'),
	            'UpdatedBy' => Session::get('AdminName'),]);
    	} else {
			$query=$db->table('tbl_therapytype')
					   ->insert(
			    ['therapyType' => $request->therapyType,
	            'CreatedDate' => date('Y-m-d'),
	            'CreatedBy' => Session::get('AdminName'),]
	            );
    	}
		return $query;
	}
	public static function therapyTypeDeleteFun($request=null) {
    	$db = DB::connection('mysql');
		$query= $db->table('tbl_therapytype')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
	}
}