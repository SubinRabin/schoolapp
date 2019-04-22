<?php

namespace App\Http\Controllers\Teacher;
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
		return view('teacher.login.index');
	}
	function TeacherLogin(Request $request) {
		$rules = array(
			'Email' => 'required',
			'password' => 'required',
		     );
    	$userdata = array(
		    'Email' => $request->Email,
		    'password' => $request->password
		  );

    	$validator = Validator::make($userdata, $rules);
    	if ($validator->fails()){
	      // If validation falis redirect back to login.
	      return Redirect::to('/teacher')->withInput($userdata)->withErrors($validator);
       } else {
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
		        return Redirect::to('/teacher');
			}
       }
	}
}
