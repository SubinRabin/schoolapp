<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class admin extends Model {
	public static function AdminRole($id)
    {
      $db = DB::connection('mysql');
		$query = $db->table('tbl_admin');
        $query= $query
            ->select('Role')
            ->where('id',$id)
            ->get();
        return $query[0]->Role; 
    }
    public static function RoleName($id)
    {
      $db = DB::connection('mysql');
		$query = $db->table('tbl_adminrole');
        $query= $query
            ->select('RoleName')
            ->where('id',$id)
            ->get();
        return $query[0]->RoleName; 
    }
    public static function adminList($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_admin');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function adminDetails($request=null) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_admin');
        $query= $query
            ->select('*')
            ->where('id',$request->id)
            ->get();
        return $query; 
	}
	public static function RolesList($request=null) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_adminrole');
        $query= $query
            ->select('id','RoleName')
            ->get();
        return $query; 
	}
	public static function adminSubmitBtnFun($request=null) {
		$db = DB::connection('mysql');
    	if ($request->id!="") {
			$query= $db->table('tbl_admin')
                    ->where('id',$request->id);
				if (isset($request->changeapass)) {
                   $query ->update([
                    	'Username' => $request->Username,
                    	'Name' => $request->Name,
	    				'Email' => $request->Email,
	    				'Mobile' => $request->number,
	    				'Role' => $request->Role,
		    			'password' => md5($request->Password),
			            'UpdatedDate' => date('Y-m-d'),
			            'UpdatedBy' => Session::get('AdminName'),
			        ]);
		        } else {
		        	$query ->update([
                    	'Username' => $request->Username,
                    	'Name' => $request->Name,
	    				'Email' => $request->Email,
	    				'Mobile' => $request->number,
	    				'Role' => $request->Role,
			            'UpdatedDate' => date('Y-m-d'),
			            'UpdatedBy' => Session::get('AdminName'),
			        ]);
		        }
            $return = $request->id;
    	} else {
			$query=$db->table('tbl_admin')
					   ->insert([
                    		'Username' => $request->Username,
		    				'Name' => $request->Name,
		    				'Email' => $request->Email,
		    				'Mobile' => $request->number,
		    				'Role' => $request->Role,
		    				'password' => md5($request->Password),
	            			'CreatedDate' => date('Y-m-d'),
            				'CreatedBy' => Session::get('AdminName'),]
	            		);
            $return = DB::getPdo()->lastInsertId();;
    	}
		return $return;
	}
	public static function adminDeleteBtnFun($request=null) {
		$db = DB::connection('mysql');
		$query= $db->table('tbl_admin')
		  ->where('id',$request->id);
	       $query ->update([
				'AdminFlag' => $request->flag,
	            'UpdatedDate' => date('Y-m-d'),
	            'UpdatedBy' => Session::get('AdminName'),
	        ]);
		return $query;
	}
	public static function AdminProfileSubmit($request=null) {
		$db = DB::connection('mysql');
		$query= $db->table('tbl_admin')
                ->where('id',Session::get('AdminID'));
			if (isset($request->changeapass)) {
               $query ->update([
                	'Name' => $request->Name,
    				'Email' => $request->Email,
    				'Mobile' => $request->number,
	    			'password' => md5($request->Password),
		            'UpdatedDate' => date('Y-m-d'),
		            'UpdatedBy' => Session::get('AdminName'),
		        ]);
	        } else {
	        	$query ->update([
                	'Name' => $request->Name,
    				'Email' => $request->Email,
    				'Mobile' => $request->number,
		            'UpdatedDate' => date('Y-m-d'),
		            'UpdatedBy' => Session::get('AdminName'),
		        ]);
	        }
		return $query;
	}
	public static function teachersList($request = null) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_teacher');
        $query= $query
            ->select('*')
            ->get();
        return $query; 
	}
	public static function therapistList($request = null) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_therapist');
        $query= $query
            ->select('*')
            ->get();
        return $query; 
	}
	public static function ClassRelatedMailget($ClassRoom) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_students');
		$query= $query
            	->select('*')
				->whereIn('classRoom', $ClassRoom)
		  		->where('StudentFlg',1)
				->get();
        return $query; 
	}
	public static function TeacherMail($id) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_teacher');
		$query= $query
            	->select('Email')
				->whereIn('id', $id)
		  		->where('TeacherFlg',1)
				->get();
        return $query; 
	}
	public static function TherapistMail($id) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_therapist');
		$query= $query
            	->select('Email')
				->whereIn('id', $id)
		  		->where('TeacherFlg',1)
				->get();
        return $query; 
	}
	public static function studentList($request = null) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_students');
        $query= $query
            ->select('*')
            ->where('StudentFlg',1)
            ->get();
        return $query; 
	}
	public static function StudentsMailget($id) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_students');
		$query= $query
            	->select('*')
				->whereIn('id', $id)
		  		->where('StudentFlg',1)
				->get();
        return $query; 
	}
	public static function composeSend($request = null) {
		
		$db = DB::connection('mysql');
		$query=$db->table('tbl_mail')
		   ->insert([
				'sender' => session::get('AdminID'),
				'receiver' => $request->to,
				'sendertype' => 'Admin',
				'receivertype' => 'Student',
				'Subject' => $request->Subject,
				'Message' => $request->Message,
    			'CreatedDate' => date('Y-m-d H:m:s'),
    		]);
	   	return true;
	}
	public static function inboxList() {
		$db = DB::connection('mysql');

		$query1 = $db->table('tbl_mail');
		$query1= $query1
				->select(DB::RAW('max(id) as maxid'))
				->where('receiver', session::get('AdminID'))
				->groupby('sender')
				->get();
		
		$id = array();
		if (count($query1)!=0) {
			foreach ($query1 as $key => $value) {
				$id[$key] = $value->maxid;
			}
		}
		
		$query = $db->table('tbl_mail');
		$query= $query
            	->select('tbl_mail.*','tbl_students.Name','tbl_students.studentId')->join('tbl_students', 'tbl_students.studentId', '=', 'tbl_mail.sender')
            	->whereIn('tbl_mail.id',$id)
                ->orderby('tbl_mail.id','desc')
				->get();
        return $query; 
	}
	public static function inboxdata($id) {
		$db = DB::connection('mysql');
		$query = $db->table('tbl_mail');
		$query= $query
            	->select(DB::RAW('IF(tbl_students.studentId is NULL,"You",tbl_students.studentId) as SendName'),'tbl_mail.*','tbl_students.Name')->leftJoin('tbl_students', 'tbl_students.studentId', '=', 'tbl_mail.sender')
				// ->where('tbl_mail.receiver', session::get('AdminID'))
				->where('tbl_mail.id', $id)
				->get();
        return $query; 
	}
	public static function readmsg($msgId) {
        $db = DB::connection('mysql');
        $query=$db->table('tbl_mail')
                ->where('id',$msgId)
             ->update([
                        'read' => 1,
                        ]);
        return true;
    }
    public static function composeanouncemenrt($msg,$maildetailssubject,$sender,$receiver) {
    	$db = DB::connection('mysql');
		$query=$db->table('tbl_mail')
		   ->insert([
				'sender' => $sender,
				'receiver' => $receiver,
				'sendertype' => 'Admin',
				'receivertype' => 'Student',
				'Subject' => $maildetailssubject,
				'Message' => $msg,
    			'CreatedDate' => date('Y-m-d H:m:s'),
    		]);
	   	return true;
    }
    public static function notifications($id) {
        $db = DB::connection('mysql');
        $query1= $db->table('tbl_mail');
        $query1= $query1
            ->select('*')
            ->where('receiver',$id)
            ->where('read',0)
            ->get();

        $query= $db->table('tbl_chat');
        $query= $query
            ->select('*')
            ->where('AdminID',$id)
            ->where('sendFrom','Student')
            ->where('AdminRead',0)
            ->get();

        $return['chat'] = count($query);
        $return['mail'] = count($query1);

        return $return;
    }
    public static function classList() {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_classroom');
        $query= $query
            ->select('*')
            ->get();
        return $query; 
    }
    public static function relatedinboxdata($msg_id,$sender) {
    	$db = DB::connection('mysql');
		$query = $db->table('tbl_mail');
		$where  = DB::raw('(tbl_mail.receiver = '.session::get('AdminID').' AND tbl_mail.sender = "'.$sender.'") OR (tbl_mail.receiver = "'.$sender.'" AND tbl_mail.sender = '.session::get('AdminID').') AND tbl_mail.id != '.$msg_id.'');
		$query= $query
            	->select(DB::RAW('IF(tbl_students.studentId is NULL,"You",tbl_students.studentId) as SendName'),'tbl_mail.*','tbl_students.Name','tbl_students.studentId')->leftjoin('tbl_students', 'tbl_students.studentId', '=', 'tbl_mail.sender')
				->whereRAW($where)
				->orderby('tbl_mail.id','desc')
				->get();
        return $query; 
    }
    public static function galleryDelete($request = null) {
        $db = DB::connection('mysql');
		$query= $db->table('tbl_gallery')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
    }
    public static function fileManagerDelete($request = null) {
        $db = DB::connection('mysql');
		$query= $db->table('tbl_assessment')
                    ->where('id',$request->id)
                    ->delete();
        return $query; 
    }
    public static function GalleryDetails($id) {
    	$db = DB::connection('mysql');
		$query= $db->table('tbl_gallery')
                    ->where('id',$id)
                    ->get();
        return $query; 
    }
    public static function AssessmentDetails($id) {
    	$db = DB::connection('mysql');
		$query= $db->table('tbl_assessment')
                    ->where('id',$id)
                    ->get();
        return $query; 
    }
    public static function admintchatList($studentId) {

        $return = array();
        $db = DB::connection('mysql');

        $query1 = $db->table('tbl_students');
        $query1 = $query1
            ->select('*')
            ->where('StudentFlg',1)
            ->get();

        $roleGet = $db->table('tbl_admin')->select('Role')->where('id',session::get('AdminID'))->get();
        if ($roleGet[0]->Role==2) {
            foreach ($query1 as $key => $value) {
                $return['studentName'][] = $value->studentId;
                $return['studentType'][] = 'Student';
                $return['studentID'][] = $value->id;
                $return['status'][] = $value->loginStatus;
                $return['Profile'][] = $value->Profile;
            }
        } else {
            foreach ($query1 as $key => $value) {
                $explodeClassRoom =   explode(",", $value->SectionHead);
                foreach ($explodeClassRoom as $ECTkey => $ECTvalue) {
                    if ($ECTvalue==session::get('AdminID')) {
                        $return['studentName'][] = $value->studentId;
                        $return['studentType'][] = 'Student';
                        $return['studentID'][] = $value->id;
                        $return['status'][] = $value->loginStatus;
                        $return['Profile'][] = $value->Profile;
                    }
                }
            }
        }
        return $return; 
    }
    public static function notificationStatus($StudentId) {
        $db = DB::connection('mysql');
        $query= $db->table('tbl_chat');
        $query= $query
            ->select('*');
            $query->where('AdminID',session::get('AdminID'))
            ->where('sendFrom' ,'Student')
            ->where('StudentID' ,$StudentId)
            ->where('AdminRead',0);
            $query= $query->get();

        $return['chat'] = count($query);
        return $return;
    }
    public static function ProfilePic($id)
    {
      $db = DB::connection('mysql');
        $query = $db->table('tbl_admin');
        $query= $query
            ->select('Profile')
            ->where('id',$id)
            ->get();
        return $query[0]->Profile; 
    }
    public static function AdminPrefferedStudentList($request = null) {
        $db = DB::connection('mysql');

        $query1 = $db->table('tbl_admin')
                    ->select('Role')
                    ->where('id',Session::get('AdminID'))
                    ->get();
        if ($query1[0]->Role==2) {
            $query = $db->table('tbl_students');
            $query= $query
                ->select('*')
                ->where('StudentFlg',1)
                ->get();
        } else {
            $query = DB::select('select * from `tbl_students` where FIND_IN_SET("'.session::get('AdminID').'", IFNULL(SectionHead,"")) > 0');
        }
        return $query; 
    }
}