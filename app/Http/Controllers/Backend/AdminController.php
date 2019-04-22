<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Input;
use Redirect;
use Session;
use Datatables;
use App\Model\admin;
use Illuminate\Support\Facades\Validator;
use Storage;

class AdminController extends Controller
{
	function index(Request $request) {
        if (session::get('AdminID')=="") {
            return Redirect::to('backend');
        }
        $role = admin::AdminRole(session::get('AdminID'));
        if ($role==3) {
            return Redirect::to('backend/dashboard');
        } else {
            return view('backend.admin.index');
        }
	}
	function adminList(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $users = DB::table('tbl_admin')->join('tbl_adminrole', 'tbl_admin.Role', '=', 'tbl_adminrole.id')
            ->select([
            	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            	 'tbl_admin.id',
            	 'tbl_admin.name',
            	 'tbl_admin.email',
            	 'tbl_admin.Mobile',
            	 'tbl_adminrole.RoleName as Role',
            	 'tbl_admin.CreatedDate',
            	 'tbl_admin.AdminFlag'
            	]);
        return Datatables::of($users)
            ->addColumn('Status', function ($user) {
        		$status = 'Inactive';
        		if ($user->AdminFlag==1) {
        			$status = 'Active';
        		}
                return $status;
            })
            ->addColumn('action', function ($user) {
                if ($user->AdminFlag==1) {
                    $permissionBtn = '<a href="#" onclick="adminDeleteModalfun('.$user->id.',0)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                } else {
                    $permissionBtn = '<a href="#" onclick="adminDeleteModalfun('.$user->id.',1)" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i></a>';
                }
                return '<a href="#edit-'.$user->id.'" onclick="adminSubmitModalfun('.$user->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    '.$permissionBtn;
            })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);

	}
    function adminSubmitModal(Request $request) {
        $roles=admin::RolesList($request);
        $details=admin::adminDetails($request);
        return view('backend.admin.adminSubmitModal',[
                                    'details' => $details,
                                    'roles' => $roles,
                                    'request' => $request]);
    }
    function adminSubmitBtnFun(Request $request) {
        $submit=admin::adminSubmitBtnFun($request);
        if ($request->id!="") {
            $file = $request->file('Profile');
            if (isset($file) && $file!="") {
                $newFileName = $file->getClientOriginalName();
                if (!file_exists('Uploads/Admin/'.$request->id)) {
                    mkdir('Uploads/Admin/'.$request->id, 0777, true);
                }
                $destinationPath = 'Uploads/Admin/'.$request->id;
                $file->move($destinationPath,$newFileName);

                $update = DB::table('tbl_admin')
                ->where('id',$request->id)
                ->update([
                        'Profile' =>$newFileName,]);
            }

            // $return['msg'] = 'Updated succefully';
        } else {
            $file = $request->file('Profile');
            if (isset($file) && $file!="") {
                $newFileName = $file->getClientOriginalName();
                if (!file_exists('Uploads/Admin/'.$submit)) {
                    mkdir('Uploads/Admin/'.$submit, 0777, true);
                }
                $destinationPath = 'Uploads/Admin/'.$submit;
                $file->move($destinationPath,$newFileName);
                $update = DB::table('tbl_admin')
                ->where('id',$submit)
                ->update([
                        'Profile' =>$newFileName,]);
            }
            // $return['msg'] = 'Inserted succefully';
        }
        return Redirect::to('backend/admin');
        // $return['status'] = "true";
        // echo json_encode($return);exit;
    }
    function adminDeleteBtnFun(Request $request) {
        $delete=admin::adminDeleteBtnFun($request);
        $return['msg'] = 'Deleted succefully';
        $return['status'] = "true";
        echo json_encode($return);exit;
    }
    function adminExistingUserNameCheck(Request $request) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_admin');
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
