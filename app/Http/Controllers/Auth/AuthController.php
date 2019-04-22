<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Session;
use Redirect;
use DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authenticatio90n of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username = 'Emp_ID'; 
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function Adminlogout() {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_admin')
        ->where('id',Session::get('AdminID'))
            ->update([
                    'loginStatus' =>0,
                ]);
        Session::forget('AdminName');
        Session::forget('AdminID');
        Session::forget('AdminEmail');
        return Redirect::to('/');
    }
    function Studentlogout() {
        $db = DB::connection('mysql');
        $query = $db->table('tbl_students')
        ->where('studentId',Session::get('StudentID'))
            ->update([
                    'loginStatus' =>0,
                ]);
        Session::forget('StudentID');
        Session::forget('StudentName');
        

        return Redirect::to('/');
    }
    function teacherLogout() {
        $db = DB::connection('mysql');
        if (Session::get('TeacherRole')=='Teacher') {
            $query = $db->table('tbl_teacher')
            ->where('id',Session::get('TeacherId'))
                ->update([
                        'loginStatus' =>0,
                    ]);
        } else {
            $query = $db->table('tbl_therapist')
            ->where('id',Session::get('TeacherId'))
                ->update([
                        'loginStatus' =>0,
                    ]);
        }
        Session::forget('TeacherEmail');
        Session::forget('TeacherName');
        Session::forget('TeacherRole');
        return Redirect::to('/');
    }
}
