<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\teacher;
use App\Model\therapist;
use App\Model\admin;
use DB;
use Input;
use Redirect;
use Session;
use Datatables;
use Illuminate\Support\Facades\Validator;

class TeachersController extends Controller
{
	function index(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
        $role = admin::AdminRole(session::get('AdminID'));
        if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
		  return view('backend.teachers.index');
        }
	}
	function teacherSubmitModal(Request $request) {
        $classRoom = therapist::ClassRoomList();
		$section = therapist::sectionList();
		$Program = teacher::ProgramList();
		$details = teacher::teacherDetailget($request);
		return view('backend.teachers.teacherSubmitModal',[
							'details' => $details,
							'Program' => $Program,
							'section' => $section,
							'classRoom' => $classRoom,
							]);
	}
	function teacherSubmitBtnFun(Request $request) {
		$submit=teacher::teacherSubmitBtnFun($request);
		if ($request->id!="") {
            $file = $request->file('Profile');
            if (isset($file) && $file!="") {
                $newFileName = $file->getClientOriginalName();
                if (!file_exists('Uploads/Teacher/'.$request->id)) {
                    mkdir('Uploads/Teacher/'.$request->id, 0777, true);
                }
                $destinationPath = 'Uploads/Teacher/'.$request->id;
                $file->move($destinationPath,$newFileName);

                $update = DB::table('tbl_teacher')
                ->where('id',$request->id)
                ->update([
                        'Profile' =>$newFileName,]);
            }
			// $return['msg'] = 'Updated succefully';
		} else {
            $file = $request->file('Profile');
            if (isset($file) && $file!="") {
                $newFileName = $file->getClientOriginalName();
                if (!file_exists('Uploads/Teacher/'.$submit)) {
                    mkdir('Uploads/Teacher/'.$submit, 0777, true);
                }
                $destinationPath = 'Uploads/Teacher/'.$submit;
                $file->move($destinationPath,$newFileName);
                $update = DB::table('tbl_teacher')
                ->where('id',$submit)
                ->update([
                        'Profile' =>$newFileName,]);
            }
			// $return['msg'] = 'Inserted succefully';
		}
        return Redirect::to('backend/teacher');
		// $return['status'] = "true";
  //       echo json_encode($return);exit;
	}
	function teacherList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $teacher = DB::table('tbl_teacher')
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
        return Datatables::of($teacher)
        ->addColumn('Status', function ($teacher) {
        		$status = 'Inactive';
        		if ($teacher->TeacherFlg==1) {
        			$status = 'Active';
        		}
                return $status;
            })
            ->addColumn('action', function ($teacher) {
            	if ($teacher->TeacherFlg==1) {
                    $permissionBtn = '<a href="#" onclick="teacherDeleteModalfun('.$teacher->id.',0)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                } else {
                    $permissionBtn = '<a href="#" onclick="teacherDeleteModalfun('.$teacher->id.',1)" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i></a>';
                }
                return '<a href="#edit-'.$teacher->id.'" onclick="teacherSubmitModalfun('.$teacher->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                		'.$permissionBtn;
            })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);
	}
	function teacherDeleteBtnFun(Request $request) {
        $delete=teacher::teacherDeleteBtnFun($request);
        $return['msg'] = 'Deleted succefully';
        $return['status'] = "true";
        echo json_encode($return);exit;
    }
    function TeacherExistingStudentUsernameCheck(Request $request) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_teacher');
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
