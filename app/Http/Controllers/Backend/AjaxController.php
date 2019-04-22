<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Session;

class AjaxController extends Controller {
   public function index(Request $request) {
	   	 
	   	if ($request->langvalue == "ar") {
	   		Session::put('languageval', 'ar');
	   		Session::put('locale', 'ar');
	   	} else {
	   		Session::put('languageval', 'en');
	   		Session::put('locale', 'en');
	   	}
		echo json_encode(true);
    }
}