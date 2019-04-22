<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; // using controller class

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\login;
use DB;
use Input;
use Redirect;
use Session;
use Auth;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class LoginController extends Controller
{
	function index(Request $request) {
		return view('backend.login.index');
	}
	function AdminLogin(Request $request) {
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
	      // If validation falis redirect back to login.
	      return Redirect::to('/backend')->withInput($userdata)->withErrors($validator);
	    } else {
	    	if (Auth::validate($userdata)) {
		        if (Auth::attempt($userdata)) {
		        	$update = login::AdminLoginStatusUpdate(Auth::user()->id); 
	    			Session::put('AdminName',Auth::user()->Name);
		        	Session::put('AdminID',Auth::user()->id);
		        	Session::put('AdminEmail',Auth::user()->Email);
		        	Session::put('languageval','en');
		           	return Redirect::to('backend/dashboard');
	        	}
        	} else {
		        // if any error send back with message.
		        Session::flash('error', 'This Credential Does Not Match'); 
		        return Redirect::to('/backend');
	      	}
	    }
	}
	function forgetPassword(Request $request) {
		return view('backend.forgetPassword');
	}
	function resetPassword(Request $request) {
		$pwd = 'temp'.rand(1000,9999);
		

		$query = DB::table('tbl_admin')
				->where('Email',$request->email)
				->where('AdminFlag','1')
				->get();
		
		if (count($query)!=0) {
			# code...
			$reset = DB::table('tbl_admin')
					->where('Email',$request->email)
					->update([
							'password' => md5($pwd),
						]);
			session::flash('reset','success');

			$maildetailssubject = 'Your password changed';
			$mailformat= array('','');
			$emailpersonal = $request->email;
			$msg = 'Your temporary password is : '.$pwd.'
					                                  
																		
					Click this link '.url('/backend').'
					';
			$mail = Mail::sendwithoutview($msg, $mailformat, function ($message) use ($emailpersonal,$maildetailssubject) {
	        	$message->from('subinrabin444@gmail.com','no-reply');
	        	$message->to($emailpersonal)->subject($maildetailssubject);
			});
		} else {
			session::flash('reset','failed');
		}

        return Redirect::to('/backend/forgetPassword');
	}
	function changeLanguage(Request $request) {
		Session::put('languages',$request->lang);
		echo json_encode(true);
	}
}
