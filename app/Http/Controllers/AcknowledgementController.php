<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Models\Feed;
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


  
}
