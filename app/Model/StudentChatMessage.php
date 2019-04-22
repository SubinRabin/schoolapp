<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class StudentChatMessage extends Model {
	public static function StudentMsg($id)
    {
      $db = DB::connection('mysql');
		$query = $db->table('tbl_chat');
        $query= $query
            ->select('*')
            ->get();
        return $query; 
    }
}