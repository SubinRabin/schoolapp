<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\login;
use DB;
use Input;
use Redirect;
use Session;
use Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
	function index(Request $request) {
		return view('student.login.index');
	}
	function Login(Request $request) {
		$rules = array(
			'Username' => 'required',
			'password' => 'required',
		     );
    	$userdata = array(
		    'Username' => $request->Username,
		    'password' => $request->password
		  );

    	$validator = Validator::make($userdata, $rules);
    	if ($validator->fails()){
			return Redirect::to('/')->withInput($userdata)->withErrors($validator);
        } else {
			if ($request->usertype=="Parent") {
		   		$studentData = login::StudentData($request);      	
				if (count($studentData)!=0) {
		   			$update = login::StudentLoginStatusUpdate($studentData[0]->studentId);      	
					Session::put('StudentID',$studentData[0]->studentId);
		        	Session::put('StudentName',$studentData[0]->Name);
		        	Session::put('StudentOrgID',$studentData[0]->id);
		        	Session::put('languages','en');
		           	return Redirect::to('gallery');
				}	else {
					session::flash('usertype',$request->usertype);
			        Session::flash('error', 'This Credential Does Not Match'); 
			        return Redirect::to('/');
				}
	        } else if($request->usertype=="Teacher" || $request->usertype=="Therapist") {
	        	$TeachersData = login::TeachersData($request);      	
	   			if (count($TeachersData)!=0) {
	       			$update = login::teacherLoginStatusUpdate($TeachersData[0]->id,$request->Role);      	
	   				Session::put('TeacherId',$TeachersData[0]->id);
	   				Session::put('TeacherEmail',$TeachersData[0]->Email);
		        	Session::put('TeacherName',$TeachersData[0]->Name);
		        	Session::put('TeacherRole',$request->Role);
		        	Session::put('languages','en');
		           	return Redirect::to('teacherDashboard');
				}	else {
			        Session::flash('error', 'This Credential Does Not Match'); 
			        return Redirect::to('/');
				}
	        } else if($request->usertype=="Section head" || $request->usertype=="Public relation" || $request->usertype=="Admin" || $request->usertype=="Registrar") {
	        		$AdminData = login::AdminData($request);      
		       if (count($AdminData)!=0) {
					$update = login::AdminLoginStatusUpdate($AdminData[0]->id); 
					Session::put('AdminName',$AdminData[0]->Name);
					Session::put('AdminID',$AdminData[0]->id);
					Session::put('AdminEmail',$AdminData[0]->Email);
					Session::put('languageval','en');
					return Redirect::to('backend/dashboard');
	        	} else {
			        // if any error send back with message.
			        Session::flash('error', 'This Credential Does Not Match'); 
			        return Redirect::to('/');
		      	}
	        }
        }
	}
}
