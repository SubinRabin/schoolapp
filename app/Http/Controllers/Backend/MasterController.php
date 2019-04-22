<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\master;
use App\Model\admin;
use DB;
use Input;
use Redirect;
use Session;
use Datatables;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
	function adminRole(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
    	$role = admin::AdminRole(session::get('AdminID'));
		if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
			return view('backend.master.adminRole');
		}
	}
	function ProgramMaster(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
    	$role = admin::AdminRole(session::get('AdminID'));
		if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
			return view('backend.master.ProgramMaster');
		}
	}
	function SectionMaster(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
    	$role = admin::AdminRole(session::get('AdminID'));
		if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
			return view('backend.master.SectionMaster');
		}
	}
	function ClassroomMaster(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
    	$role = admin::AdminRole(session::get('AdminID'));
		if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
			return view('backend.master.ClassroomMaster');
		}
	}
	function TherapytypeMaster(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
    	$role = admin::AdminRole(session::get('AdminID'));
		if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
			return view('backend.master.TherapytypeMaster');
		}
	}
	function adminRoleSubmitModal(Request $request) {
		$details=master::adminRoleDetails($request);
		return view('backend.master.adminRoleSubmitModal',['details' => $details,
                                     'request' => $request]);
	}
	function adminRoleSubmitBtnFun(Request $request) {

		$details=master::adminRoleSubmitBtnFun($request);
		if ($request->id!="") {
			$return['msg'] = 'Updated succefully';
		} else {
			$return['msg'] = 'Inserted succefully';
		}
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function adminRoleList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $roles = DB::table('tbl_adminrole')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'id',
            	 'RoleName',
            	 'CreatedDate',
            	 'UpdatedDate',
            	]);
        return Datatables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="#edit-'.$roles->id.'" onclick="adminRoleSubmitModalfun('.$roles->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                		<a href="#" onclick="adminRoleDeleteModalfun('.$roles->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);

	}
	function adminRoleDeleteBtnFun(Request $request) {
		$details=master::adminRoleDeleteBtnFun($request);
		$return['msg'] = 'Deleted succefully';
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function programSubmitModalfun(Request $request) {
		$details=master::programDetails($request);
		return view('backend.master.programSubmitModal',['details' => $details,
                                     'request' => $request]);
	}
	function programSubmitBtnFun(Request $request) {

		$details=master::programSubmitBtnFun($request);
		if ($request->id!="") {
			$return['msg'] = 'Updated succefully';
		} else {
			$return['msg'] = 'Inserted succefully';
		}
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function programList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $roles = DB::table('tbl_program')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'id',
            	 'Program',
            	 'CreatedDate',
            	 'UpdatedDate',
            	]);
        return Datatables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="#edit-'.$roles->id.'" onclick="programModalfun('.$roles->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                		<a href="#" onclick="programDeleteModalfun('.$roles->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);

	}
	function programDeleteBtnFun(Request $request) {
		$details=master::programDeleteBtnFun($request);
		$return['msg'] = 'Deleted succefully';
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function sectionSubmitModalfun(Request $request) {
		$details=master::sectionDetails($request);
		return view('backend.master.sectionSubmitModal',['details' => $details,
                                     'request' => $request]);
	}
	function sectionList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $roles = DB::table('tbl_section')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'id',
            	 'section',
            	 'CreatedDate',
            	 'UpdatedDate',
            	]);
        return Datatables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="#edit-'.$roles->id.'" onclick="sectionModalfun('.$roles->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
            		<a href="#" onclick="sectionDeleteModalfun('.$roles->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->editColumn('id', '{{$id}}')
            ->make(true);

	}
	function sectionSubmitBtnFun(Request $request) {

		$details=master::sectionSubmitBtnFun($request);
		if ($request->id!="") {
			$return['msg'] = 'Updated succefully';
		} else {
			$return['msg'] = 'Inserted succefully';
		}
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function sectionDeleteBtnFun(Request $request) {
		$details=master::sectionDeleteBtnFun($request);
		$return['msg'] = 'Deleted succefully';
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function classRoomList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $roles = DB::table('tbl_classroom')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'id',
            	 'classRoom',
            	 'CreatedDate',
            	 'UpdatedDate',
            	]);
        return Datatables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="#edit-'.$roles->id.'" onclick="classRoomModalfun('.$roles->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
            		<a href="#" onclick="classRoomDeleteModalfun('.$roles->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->editColumn('id', '{{$id}}')
            ->make(true);

	}
	function classRoomSubmitModalfun(Request $request) {
		$details=master::classRoomDetails($request);
		return view('backend.master.classRoomSubmitModal',['details' => $details,
                                     'request' => $request]);
	}
	function classRoomSubmitBtnFun(Request $request) {

		$details=master::classRoomSubmitBtnFun($request);
		if ($request->id!="") {
			$return['msg'] = 'Updated succefully';
		} else {
			$return['msg'] = 'Inserted succefully';
		}
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function classRoomDeleteModalfun(Request $request) {
		$delete=master::classRoomDeleteFun($request);
		$return['msg'] = 'Deleted succefully';
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function therapyTypeList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $roles = DB::table('tbl_therapytype')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'id',
            	 'therapyType',
            	 'CreatedDate',
            	 'UpdatedDate',
            	]);
        return Datatables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="#edit-'.$roles->id.'" onclick="therapyTypeModalfun('.$roles->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
            		<a href="#" onclick="therapyTypeDeleteModalfun('.$roles->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->editColumn('id', '{{$id}}')
            ->make(true);

	}
	function therapyTypeSubmitModalfun(Request $request) {
		$details=master::therapyTypeDetails($request);
		return view('backend.master.therapyTypeSubmitModal',['details' => $details,
                                     'request' => $request]);
	}
	function therpyTypeSubmitBtnFun(Request $request) {

		$details=master::therpyTypeSubmitBtnFun($request);
		if ($request->id!="") {
			$return['msg'] = 'Updated succefully';
		} else {
			$return['msg'] = 'Inserted succefully';
		}
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
	function therapyTypeDeleteModalfun(Request $request) {
		$delete=master::therapyTypeDeleteFun($request);
		$return['msg'] = 'Deleted succefully';
		$return['status'] = "true";
        echo json_encode($return);exit;
	}
}
