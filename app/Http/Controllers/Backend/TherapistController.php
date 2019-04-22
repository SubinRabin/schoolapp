<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\therapist;
use App\Model\admin;
use DB;
use Input;
use Redirect;
use Session;
use Datatables;
use Illuminate\Support\Facades\Validator;

class TherapistController extends Controller
{
	function index(Request $request) {
		if (session::get('AdminID')=="") {
            return Redirect::to('backend');
        }
        $role = admin::AdminRole(session::get('AdminID'));
        if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
		  return view('backend.therapist.index');
        }
	}
	function therapistList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $therapist = DB::table('tbl_therapist')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'id',
                 'Username',
            	 'Name',
            	 'Email',
            	 'CNumber',
            	 'Qualification',
            	 'Name',
            	 'CreatedDate',
            	 'TeacherFlg'
            	]);
        return Datatables::of($therapist)
        ->addColumn('Status', function ($therapist) {
        		$status = 'Inactive';
        		if ($therapist->TeacherFlg==1) {
        			$status = 'Active';
        		}
                return $status;
            })
            ->addColumn('action', function ($therapist) {
            	if ($therapist->TeacherFlg==1) {
                    $permissionBtn = '<a href="#" onclick="therapistDeleteModalfun('.$therapist->id.',0)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                } else {
                    $permissionBtn = '<a href="#" onclick="therapistDeleteModalfun('.$therapist->id.',1)" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i></a>';
                }
                return '<a href="#edit-'.$therapist->id.'" onclick="therapistSubmitModalfun('.$therapist->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                		'.$permissionBtn;
            })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);
	}
	function therapistSubmitModal(Request $request) {
		$TherapyType = therapist::TherapyTypeList();
		$classRoom = therapist::ClassRoomList();
		$section = therapist::sectionList();
        $details = therapist::therapistDetails($request);
        return view('backend.therapist.therapistSubmitModal',[
                                    'TherapyType' => $TherapyType,
                                    'classRoom' => $classRoom,
                                    'section' => $section,
                                    'details' => $details,
                                    'request' => $request]);
	}
	function therapySubmitBtnFun(Request $request) {
		$submit=therapist::therapySubmitBtnFun($request);
		if ($request->id!="") {
            $file = $request->file('Profile');
            if (isset($file) && $file!="") {
                $newFileName = $file->getClientOriginalName();
                if (!file_exists('Uploads/Therapist/'.$request->id)) {
                    mkdir('Uploads/Therapist/'.$request->id, 0777, true);
                }
                $destinationPath = 'Uploads/Therapist/'.$request->id;
                $file->move($destinationPath,$newFileName);

                $update = DB::table('tbl_therapist')
                ->where('id',$request->id)
                ->update([
                        'Profile' =>$newFileName,]);
            }
			// $return['msg'] = 'Updated succefully';
		} else {
            $file = $request->file('Profile');
            if (isset($file) && $file!="") {
                $newFileName = $file->getClientOriginalName();
                if (!file_exists('Uploads/Therapist/'.$submit)) {
                    mkdir('Uploads/Therapist/'.$submit, 0777, true);
                }
                $destinationPath = 'Uploads/Therapist/'.$submit;
                $file->move($destinationPath,$newFileName);
                $update = DB::table('tbl_therapist')
                ->where('id',$submit)
                ->update([
                        'Profile' =>$newFileName,]);
            }
			// $return['msg'] = 'Inserted succefully';
		}
        return Redirect::to('backend/therapist');
		// $return['status'] = "true";
  //       echo json_encode($return);exit;
	}
	function therapistDeleteBtnFun(Request $request) {
        $delete=therapist::therapistDeleteBtnFun($request);
        $return['msg'] = 'Deleted succefully';
        $return['status'] = "true";
        echo json_encode($return);exit;
    }
    function TherapistExistingStudentUsernameCheck(Request $request) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_therapist');
        if ($request->id!="") {
            $query= $query
                ->select('*')
                ->where('id','!=',$request->id)
                ->where('Username',$request->Username)
                ->get();
        } else{
            $query= $query
                ->select('*')
                ->where('Username',$request->Username)
                ->get();
        }
        return count($query); 
    }
}
