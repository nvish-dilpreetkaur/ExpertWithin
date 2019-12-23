<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Auth;
use DB;

class AdminController extends Controller
{
    
  /**
   * Constructor
   */
  public function __construct()
  {
    //parent::__construct();
    $this->user = new User();
  }
  /**
     * Show the manager list to HR admin.
     * @param  none
     * @return Response
  */
  function list_managers(){ 
    $filters = [];
    if(request()->ajax()) {
        $users = $this->user->getManagerList($filters);
        return datatables()->of($users)
        ->addColumn('action', function($users) {
          $colName = 'action';
          return (string) view('admin.datatable-col-view', compact('users','colName'));
        })
        ->addColumn('status', function($users) {
          $colName = 'status';
          return (string) view('admin.datatable-col-view', compact('users','colName'));
        })
        ->rawColumns(['action','status'])
        ->addIndexColumn()
        ->make(true);
    }
    return view('admin.managers');
  }
  
  /**
     * Show the users & manager role list to HR admin.
     * @param  none
     * @return Response
  */
  function list_users(){ 
    $filters = [];
    if(request()->ajax()) {
      
        if( !empty(request()->post('order')) ){  
           $order_posted =  request()->post('order');
           $orderColNumber = $order_posted['0']['column'];
           $order_val = '';  $order_key = '';
           if($orderColNumber >= 0){
             $order_val = $order_posted['0']['dir'];
              switch( $orderColNumber ){
                case 0:
                  $order_key = 'firstName'; 
                  break;
                case 1:
                  $order_key = 'email';
                  break;
              }
            $filters['ordering']['key'] = $order_key;
            $filters['ordering']['val'] = $order_val;
          }
        }

        $users = $this->user->getUserList($filters);
        return datatables()->of($users)
        ->addColumn('is_manager', function($users) {
          $colName = 'is_manager';
          return (string) view('admin.datatable-col-view', compact('users','colName'));
        })
       ->addColumn('action', function($users) {
          $colName = 'action';
          return (string) view('admin.datatable-col-view', compact('users','colName'));
        })/*
        ->addColumn('status', function($users) {
          $colName = 'status';
          return (string) view('admin.datatable-col-view', compact('users','colName'));
        })
        ->rawColumns(['action','status']) */
        ->rawColumns(['action','is_manager'])
        ->addIndexColumn()
        ->make(true);
    }
    return view('admin.users');
  }
   /**
     * To change user status to Approve/Disapprove/Delete
     * @param  Request/Action/id
     * @return Response
  */
  function roleAction(Request $request, $action, $id){ 
    $action = strtoupper($action); 
    $id = Crypt::decrypt($id);
    switch($action){
      case 'NOT_APPROVE':
        $roleStatus = 0;
        $message ="Manager unapproved successfully.";
        $hr_action = "rejected";
        break;
      case 'APPROVE':
        $roleStatus = 1;
        $message ="Manager approved successfully.";
        $hr_action = "approved";
        break;
      case 'REMOVE':
        $status = 0;
        $message ="User deleted successfully.";
        $hr_action = "deleted";
        break;
    }
   
    if($action == 'APPROVE' || $action == 'NOT_APPROVE'){
      DB::table('user_roles')
      ->where('id', $id)
      ->update(['status' => $roleStatus]);
      $userData = $this->user->getUserByRoleId($id);
    }else{
      $userData = User::where('id', $id)->select('firstName AS uname', 'email')->first();
      DB::table('users')
      ->where('id', $id)
      ->update(['status' => $status]);
    }

    /** @send_email : to manager to notify for approval/reject */
 
    $user_name  = auth()->user()->firstName;
    $emaildata['subject'] = "HR Action";
    $emaildata['receiver_name'] = $userData->uname;
    $emaildata['receiver_email'] = $userData->email;
    $emaildata['message'] = $message = 'User account '.$hr_action.' successfully.';
   // $emaildata['sender_name'] = $user_name;
   // $emaildata['sender_email'] = auth()->user()->email;
    $mailResponse =  send_email($emaildata);
    if ($mailResponse) {
     
    }else{
     
    }
     /** @send_email : to manager to notify for approval/reject ENDS*/
    return back()->with('success', $message);
  }
   /**
     * To change user status to Approve/Disapprove/Delete ajax based request
     * @param  Request/Action/id
     * @return Response
  */
	public function hrAction_ajaxbased(Request $request) {
		
		$response = array(
			"type" => NULL,
			"html" => NULL,
		);

		if ($request->ajax()) {
			parse_str($request->post('formData'), $postdata); // print_r($postdata); dd();
			$body = $request->all();
			
			//$request->post('hr_action') = $postdata["hr_action"];
			
			/* $rules = [ 
				"hr_action" => "required",
			];
			$customMessages = [
				'hr_action.required' => 'No action selected.',
			];
		
			$this->validate($request, $rules, $customMessages); */
		
			if ($postdata["hr_action"]=='not_approve') {	
				$st = DB::table("user_roles")
				->where('role',$postdata["role"])
				->where('user_id',$postdata["user_id"])
				->delete();			
				$response["html"] = "Role disapproved successfully.";
			} else {
				$st = DB::table("user_roles")
				->where('role',$postdata["role"])
				->where('user_id',$postdata["user_id"])
				->update(['status' => 1]);
				$response["html"] = "Role approved successfully.";
			}

			$response["type"] = "success";
		} else {
			$response["type"] = "error";
		}

		echo json_encode($response);
		exit();
	}
	/**
     * To change user status to Approve/Disapprove/Delete 
     * @param  Request/Action/id
     * @return Response
  */
	protected function hrAction(Request $request)
	{  
	
		$postdata = $request->post();
		
		if ($postdata["hr_action"]=='not_approve') {	
			$st = DB::table("user_roles")
			->where('role',$postdata["role"])
			->where('user_id',$postdata["user_id"])
			->delete();			
			$msg = "Role disapproved successfully.";
			$act = 'disapproved';
		} else {
			$st = DB::table("user_roles")
			->where('role',$postdata["role"])
			->where('user_id',$postdata["user_id"])
			->update(['status' => 1]);
			$msg = "Role approved successfully.";
			$act = 'approved';
		
		}
			/** send email : start **/
		   $userData = User::where('id', $postdata["user_id"])->select('firstName AS name', 'email')->first();
		   //dd($userData->id);
		   $emaildata['subject'] = "Manager Access Status";
		   $emaildata['receiver_name'] = $userData->name;
		   $emaildata['receiver_email'] = $userData->email;
		   $emaildata['message'] = $message = 'HR Admin has '.$act.' your application to manager role.';
		   $mailResponse =  send_email($emaildata);
		   if ($mailResponse) {
			
		   }else{
			
		   }
			/** send email : end **/
		return  redirect('users')->with('success', $msg);	
	}
  
}
