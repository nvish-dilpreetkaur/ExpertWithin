<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Models\Feed;
use App\User;
use DB;

class AcknowledgementController extends Controller
{
    
  /**
   * Constructor
   */
  public function __construct()
  {
    //parent::__construct();
    //$this->opportunity = new Opportunity();
    $this->feed = new Feed();
    $this->user = new User;
  }
  
	/**
	 * Display a list of opportunity.
	 * @param  Request
	 * @return Response
	*/
  function acknowledge(Request $request,$id = null)
  {   //dd($request->post());
      $response = array( 
          "type" => NULL,
          "errors" => NULL,
      );
      $loggedInUserID = $roleId = '';
      $user = \Auth::user();  
     
      if($request->ajax()){ 
		  
		   $messages = [
				'user_id.required' => 'This field is required',     
				'message.required' => 'This field is required.',
				'message.max' => 'The message may not be greater than 2000 characters.'
			  ];
		   
          $validator = \Validator::make($request->all(), [
              'user_id' => 'required',
              'message' => 'required|max:2000'
          ],$messages);
          
          if ($validator->fails())
          {
              $response["type"] = "error";
              $response["errors"] = $validator->errors()->all();
              $response["keys"] = $validator->errors()->keys();
          }else{
              $user_id = auth()->user()->id; 
              /** add 'acknoledgement' ... */
              $last_insert_id = DB::table('acknoledgement')->insertGetId([
                  'user_id'       => $request->post('user_id'),
                  'message'       => $request->post('message'),
                  'status'        => config('kloves.ACK_ACTIVE'),
                  'created_by'    => $user_id,
              ]);
              $feed_data = [
                            'key_id' => $last_insert_id,
                            'feed_type' => 'new_ack_added',
              ];
              $this->feed->add_feed($feed_data); /** Add new feed */

                /** add notification : start */
                $notification_data['type_of_notification'] = config('kloves.NOTI_NEW_ACK_ADDED');
                $notification_data['key_value'] = $last_insert_id;
                $notification_data['sender_id'] = $user_id;
                $notification_data['recipient_id'] = $request->post('user_id');
                $notification_data['status'] = config('kloves.RECORD_STATUS_ACTIVE');
                DB::table('notifications')->insert($notification_data);
                /** add notification : end */
              
              $success_message = '<p>That\'s All</p><br>You have brigthen someone\'s day!';
              $response["success_html"] = view("common.thumbup-pop") //render view
              ->with("success_message", $success_message)
              ->render();
              $response["type"] = "success"; 
          }  
      }
      echo json_encode($response);
      exit();
  }

/**
	 * render acknoledgement view
	 * @param  Request
	 * @return Response
	*/
	public function ackForm(Request $request){
		$response = array( 
			"type" => NULL,
			"errors" => NULL,
			"message" => NULL,
		);

    $page_title = "";
    $user = \Auth::user(); 
		if(!empty($user)){
			$loggedInUserID = $user->id;
		}
    $all_users = $user->where('id', '<>', $loggedInUserID)->where('status', '=', config('kloves.RECORD_STATUS_ACTIVE'))->get(); //prd($all_users);
		$response["html"] = view('home.common.ack-form', compact(['all_users']))->render();
		$response["type"] = "success";
		echo json_encode($response);
		exit();
	}
  
}
