<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class therapist extends Model {
	public static function therapistDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_therapist');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
    public static function TherapyTypeList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_therapytype');
        $query= $query
            ->select('id','therapyType')
            ->get();
        return $query; 
    }
    public static function ClassRoomList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_classroom');
        $query= $query
            ->select('id','classRoom')
            ->get();
        return $query; 
    }
    public static function sectionList($request=null) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_section');
        $query= $query
            ->select('id','section')
            ->get();
        return $query; 
    }
    public static function therapySubmitBtnFun($request=null) {
        if (!isset($request->TherapyType)) {
            $request->TherapyType = array();
        }
        if (!isset($request->ClassRoom)) {
            $request->ClassRoom = array();
        }
        $TherapyType = implode(",", $request->TherapyType);
        $ClassRoom = implode(",", $request->ClassRoom);
        
        $db = DB::connection('mysql');
        if ($request->id!="") {
            $id = $request->id;
                 $query= $db->table('tbl_therapist')
                    ->where('id',$request->id);
                if (isset($request->changeapass)) {
                   $query ->update([
                        'Username' => $request->Username,
                        'Name' => $request->Name,
                        'Email' => $request->Email,
                        'CNumber' => $request->number,
                        // 'Qualification' => $request->Qualification,
                        'therapyType' => $TherapyType,
                        'ClassRoom' => $ClassRoom,
                        'Password' => md5($request->Password),
                        'UpdatedDate' => date('Y-m-d'),
                        'UpdatedBy' => Session::get('AdminName'),
                        ]);
                   } else {
                    $query ->update([
                        'Username' => $request->Username,
                        'Name' => $request->Name,
                        'Email' => $request->Email,
                        'CNumber' => $request->number,
                        // 'Qualification' => $request->Qualification,
                        'therapyType' => $TherapyType,
                        'ClassRoom' => $ClassRoom,
                        'UpdatedDate' => date('Y-m-d'),
                        'UpdatedBy' => Session::get('AdminName'),
                        ]);
                   }
        } else {
            $query=$db->table('tbl_therapist')
                       ->insert(
                [
                'Username' => $request->Username,
                'Name' => $request->Name,
                'Email' => $request->Email,
                'CNumber' => $request->number,
                // 'Qualification' => $request->Qualification,
                'therapyType' => $TherapyType,
                'ClassRoom' => $ClassRoom,
                'Password' => md5($request->Password),
                'CreatedDate' => date('Y-m-d'),
                'CreatedBy' => Session::get('AdminName'),
                ]);
            $id = DB::getPdo()->lastInsertId();;
        }
        return $id;
    }
    public static function therapistDeleteBtnFun($request=null) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_therapist')
          ->where('id',$request->id);
           $query ->update([
                'TeacherFlg' => $request->flag,
                'UpdatedDate' => date('Y-m-d'),
                'UpdatedBy' => Session::get('AdminName'),
            ]);
        return $query;
    }
}