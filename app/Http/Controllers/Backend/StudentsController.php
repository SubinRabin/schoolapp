<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\therapist;
use App\Model\teacher;
use App\Model\student;
use App\Model\admin;
use DB;
use Input;
use Redirect;
use Session;
use File;
use Datatables;
use Storage;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
	function index(Request $request) {
		if (session::get('AdminID')=="") {
        	return Redirect::to('backend');
		}
		return view('backend.students.index');
	}
	function studentSubmitModal(Request $request) {
		$classRoom = therapist::ClassRoomList();
		$section = therapist::sectionList();
		$Program = teacher::ProgramList();
		$Therapy = student::therapyList();
        $Therapist = student::TherapistList();
		$details = student::studentDetail($request);
        $SectionHead = student::SectionHead();
        $countryCode = student::countryCode();
		return view('backend.students.studentSubmitModal',[
							'details' => $details,
							'Therapy' => $Therapy,
							'Program' => $Program,
                            'section' => $section,
							'Therapist' => $Therapist,
							'classRoom' => $classRoom,
                            'SectionHead' => $SectionHead,
                            'countryCode' => $countryCode,
							]);
	}
	function studentSubmitBtnFun(Request $request) {
		$id=student::studentSubmitBtnFun($request);
            // if (!Storage::disk('ftp')->exists('Family_Corner/Student/'.$id.'/gallery')) {
            //     Storage::disk('ftp')->makeDirectory('Family_Corner/Student/'.$id.'/gallery', 0777, true);
            // }
            // if (!Storage::disk('ftp')->exists('Family_Corner/Student/'.$id.'/assessment/Admission_Assessment')) {
            //     Storage::disk('ftp')->makeDirectory('Family_Corner/Student/'.$id.'/assessment/Admission_Assessment', 0777, true);
            // }
            // if (!Storage::disk('ftp')->exists('Family_Corner/Student/'.$id.'/assessment/First_Term')) {
            //     Storage::disk('ftp')->makeDirectory('Family_Corner/Student/'.$id.'/assessment/First_Term', 0777, true);
            // }
            // if (!Storage::disk('ftp')->exists('Family_Corner/Student/'.$id.'/assessment/Second_Term')) {
            //     Storage::disk('ftp')->makeDirectory('Family_Corner/Student/'.$id.'/assessment/Second_Term', 0777, true);
            // }
		// if ($request->id!="") {
  //           $file = $request->file('Profile');
  //           if (isset($file) && $file!="") {
  //               $newFileName = $file->getClientOriginalName();
  //               if (!file_exists('Uploads/Student/'.$id)) {
  //                   mkdir('Uploads/Student/'.$id, 0777, true);
  //               }
  //               $destinationPath = 'Uploads/Student/'.$id;
  //               $file->move($destinationPath,$newFileName);

  //               $update = DB::table('tbl_students')
  //               ->where('studentId',$id)
  //               ->update([
  //                       'Profile' =>$newFileName,]);
  //           }
		// 	// $return['msg'] = 'Updated succefully';
		// } else {
  //           $file = $request->file('Profile');
  //           if (isset($file) && $file!="") {
  //               $newFileName = $file->getClientOriginalName();
  //               if (!file_exists('Uploads/Student/'.$id)) {
  //                   mkdir('Uploads/Student/'.$id, 0777, true);
  //               }
  //               $destinationPath = 'Uploads/Student/'.$id;
  //               $file->move($destinationPath,$newFileName);
  //               $update = DB::table('tbl_students')
  //               ->where('studentId',$id)
  //               ->update([
  //                       'Profile' =>$newFileName,]);
  //           }
		// 	// $return['msg'] = 'Inserted succefully';
		// }
        return Redirect::to('backend/student');
		// $return['status'] = "true";
        // echo json_encode($return);exit;
	}
	function studentlist(Request $request) {
		DB::statement(DB::raw('set @rownum=0'));
        $student = DB::table('tbl_students')->leftJoin('tbl_classroom', 'tbl_classroom.id', '=', 'tbl_students.classRoom')->leftJoin('tbl_therapytype', 'tbl_therapytype.id', '=', 'tbl_students.Therapy');
        $db = DB::connection('mysql');

        $query1 = $db->table('tbl_admin')
                    ->select('Role')
                    ->where('id',Session::get('AdminID'))
                    ->get();
        if ($query1[0]->Role==3) { 
            $student->select([
                	 DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                     'tbl_students.Username',
                     'tbl_students.studentId',
                     'tbl_students.id',
                	 'tbl_students.Name',
                	 'tbl_students.ParentName',
                	 'tbl_students.CountryCode',
                     'tbl_students.Mobile',
                     'tbl_students.program as pro',
                     'tbl_students.Therapy as thrp',
                     'tbl_students.Therapist as thrpst',
                	 'tbl_classroom.classRoom as classRoom',
                	 'tbl_students.SectionHead',
                	 'tbl_students.CreatedDate',
                	 'tbl_students.StudentFlg',
                	])
                    ->whereRaw('FIND_IN_SET('.Session::get('AdminID').',tbl_students.SectionHead)');
        } else {
            $student->select([
                     DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                     'tbl_students.Username',
                     'tbl_students.studentId',
                     'tbl_students.id',
                     'tbl_students.Name',
                     'tbl_students.ParentName',
                     'tbl_students.Mobile',
                     'tbl_students.CountryCode',
                     'tbl_students.program as pro',
                     'tbl_students.Therapy as thrp',
                     'tbl_students.Therapist as thrpst',
                     'tbl_classroom.classRoom as classRoom',
                     'tbl_students.SectionHead',
                     'tbl_students.CreatedDate',
                     'tbl_students.StudentFlg'
                    ]);
        }
        return Datatables::of($student)
            ->addColumn('Status', function ($student) {
        		$status = 'Inactive';
        		if ($student->StudentFlg==1) {
        			$status = 'Active';
        		}
                return $status;
            })
            ->addColumn('Mobile', function ($student) {
                $details= $student->CountryCode.' '.$student->Mobile;
                return $details;
            })
            ->addColumn('Program', function ($student) {
                $details=student::programExplodedata($student->pro);
                return $details;
            })
            ->addColumn('Therapy', function ($student) {
                $details=student::TherapyExplodedata($student->thrp);
                return $details;
            })
            ->addColumn('Therapist', function ($student) {
                $details=student::TherapistExplodedata($student->thrpst);
                return $details;
            })
            ->addColumn('SectionHeadData', function ($student) {
                $details=student::SectionHeaddata($student->SectionHead);
                return $details;
            })
            ->addColumn('action', function ($student) {
            	if ($student->StudentFlg==1) {
                    $permissionBtn = '<a href="#" onclick="studentDeleteModalfun('.$student->id.',0)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
                } else {
                    $permissionBtn = '<a href="#" onclick="studentDeleteModalfun('.$student->id.',1)" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i></a>';
                }
                $role = admin::AdminRole(session::get('AdminID'));
                $edit  = '<a href="#edit-'.$student->id.'" onclick="studentSubmitModalfun('.$student->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                        ';
                if ($role==3) {
                    $edit = '';
                    $permissionBtn = '';
                } 
                return $edit.$permissionBtn;
            })
            // ->order(function ($query) {
            //     $query->orderBy('rownum', 'desc');

            // })
            ->editColumn('id', '{{$id}}')
            // ->removeColumn('password')
            ->make(true);
	}
	function studentDeleteBtnFun(Request $request) {
        $delete=student::studentDeleteBtnFun($request);
        $return['msg'] = 'Deleted succefully';
        $return['status'] = "true";
        echo json_encode($return);exit;
    }
    function dummy(Request $request) {
        if (!file_exists('Student/profiles/'.$id)) {
            mkdir('path/to/directory'.$id, 0777, true);
        }
    }
    function StudentExistingStudentIdCheck(Request $request) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
        if ($request->id!="") {
            $query= $query
                ->select('*')
                ->where('id','!=',$request->id)
                ->where('studentId',$request->studentId)
                ->get();
        } else{
            $query= $query
                ->select('*')
                ->where('studentId',$request->studentId)
                ->get();
        }
        return count($query); 
    }
    function StudentExistingStudentUsernameCheck(Request $request) {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students');
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
