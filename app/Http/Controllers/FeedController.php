<?php

namespace App\Http\Controllers;
use App\Models\Feed;
use App\User;
use Illuminate\Support\Facades\Crypt;
use App\Models\OpportunityUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use DB;

class FeedController extends Controller
{
     /**
     * Create a new controller instance...
     *
     * @return void
     */

    public function __construct()
    {
	  $this->middleware('auth');
	  $this->user = new User;
	  $this->feed = new Feed();
	  $this->opportunity_user = new OpportunityUser();
    }
	
    /**
	 * To perform some actions of feeds 
	 * @param  none
	 * @return Response
 	*/
	public function feedAction(Request $request)
	{ 
		$response = array( 
			"type" => NULL,
			"errors" => NULL,
			"message" => NULL,
		);
		$loggedInUserID = $roleId = '';
		$user = \Auth::user();  
		$loggedInUserID = $user->id;
		$roleId = $user->role;
   		$org_id = $user->org_id;
		if($request->ajax()){ 
			$feed_id = $request->post('feed_id'); 
			$feedData = Feed::where('id',$feed_id)->first(); //dd($feedData->feed_type);
			if (DB::table('feeds_user_action')->where('feed_pk_id',$feed_id)->where('user_id',$loggedInUserID)->exists()) {
				$updateData = [
					'updated_by' => $loggedInUserID,
					'updated_at' => date('Y-m-d H:i:s'),
				];
			}else{  
				$saveData = [
					'user_id' => $loggedInUserID,
					'feed_pk_id' => $request->post('feed_id'),
					'liked_feed' => 0,
					'marked_as_fav' => 0,
					'removed_feed' => 0,
					'created_by' => $loggedInUserID,
				];
				$this->feed->record_feeds_user_action($saveData);
			}  //prd($request->post());

			/** record action if opportunity related */
			if($feedData->feed_type=='new_published_opp' && $request->post('action') <> 'remove_feed'){
				$actionstatus = 1;  $actionstatus_rollback = 0;
				if($request->post('action')=='like'){
					$opp_action = 'like'; 
					$opportunity_user['like'] = $actionstatus; 
				}elseif($request->post('action')=='unlike'){
					$opp_action = 'like'; 
					$opportunity_user['like'] = $actionstatus_rollback; 
				}elseif($request->post('action')=='fav'){
					$opp_action = 'favourite'; 
					$opportunity_user['favourite'] = $actionstatus; 
				}elseif($request->post('action')=='unfav'){
					$opp_action = 'favourite'; 
					$opportunity_user['favourite'] = $actionstatus_rollback; 
				}
				$oid = $feedData->key_id;
				$opportunityuser_exists = $this->opportunity_user->opportunity_user_exists($oid, $loggedInUserID, $org_id); 
				if ($opportunityuser_exists) {
				   $opportunity_user_data = $this->opportunity_user->opportunity_user_update($opportunity_user, $oid, $loggedInUserID, $org_id);
				}else{
				  $opportunity_user_new = new OpportunityUser;
				  $opportunity_user_new->oid = $oid;
				  $opportunity_user_new->org_uid = $loggedInUserID;
				  $opportunity_user_new->org_id = $org_id;
				  $opportunity_user_new->$opp_action = $actionstatus;
				  $opportunity_user_data = $opportunity_user_new->save();
				}
			}
			/** record action if opportunity related : ENDS */
			if($request->post('action')=='like'){
				$updateData['liked_feed'] = 1; 
				$response["action"] = "like"; 
			}elseif($request->post('action')=='unlike'){
				$updateData['liked_feed'] = 0; 
				$response["action"] = "unlike"; 
			}elseif($request->post('action')=='fav'){
				$updateData['marked_as_fav'] = 1; 
				$response["action"] = "fav"; 
			}elseif($request->post('action')=='unfav'){
				$updateData['marked_as_fav'] = 0; 
				$response["action"] = "unfav"; 
			}elseif($request->post('action')=='remove_feed'){
				$updateData['removed_feed'] = 1; 
				$response["action"] = "remove_feed";  
				$response["feed_html"] = view("home.common.removed-feed-section") //render view
				//->with("myOppForCandidates", $myOppForCandidates)
				->render();
			}
			DB::table('feeds_user_action')
			->where('user_id', $loggedInUserID)
			->where('feed_pk_id', $feed_id)
			->update($updateData);
			$response["type"] = "success";
		}
		echo json_encode($response);
		exit();
	} 

	
	/**
	 * render share external view
	 * @param  Request
	 * @return Response
	*/
	public function feedShare(Request $request,$id = null){
		$response = array( 
			"type" => NULL,
			"errors" => NULL,
			"message" => NULL,
		);
		$user_id = \Auth::user()->id;  
		$key_id = Crypt::decrypt($id);
		$share_type = $request->post('share_type');
		$status = config('kloves.RECORD_STATUS_ACTIVE');
		$page_title = "";
		$response["html"] = view('home.common.share-feed', compact(['key_id','share_type']))->render();
		$response["type"] = "success";
		echo json_encode($response);
		exit();
	}
	
	
	/**
	 * render share external view
	 * @param  Request
	 * @return Response
	*/
	function postFeed(Request $request)
	{  
	    $response = array( 
		  "type" => NULL,
		  "errors" => NULL,
	    );
	    $loggedInUserID = $roleId = '';
	    $user = \Auth::user();  
	   
	    if($request->ajax()){ 
			
			 $messages = [
				    'checkedUsers.required' => 'Please choose atleast one expert', 
				];
			 
		  $validator = \Validator::make($request->all(), [
			'checkedUsers' => 'required'
		  ],$messages);
		  
		  if ($validator->fails())
		  {
			$response["type"] = "error";
			$response["errors"] = $validator->errors()->all();
			$response["keys"] = $validator->errors()->keys();
		  }else{
			$user_id = auth()->user()->id; 
			$post_users = explode(",",$request->post('checkedUsers')); 
			$share_type = $request->post('share_type');
			$key_id = $request->post('key_id'); 
			if($share_type == 'feed'){
				$feed_data = $this->feed->find($key_id); //prd($feed_data);
				if($feed_data->feed_type==config('kloves.FEED_TYPE_NEW_OPP')){
					$share_type = 'OPP';
					$type_of_notification = config('kloves.NOTI_SHARED_OPP');
				}else if($feed_data->feed_type==config('kloves.FEED_TYPE_NEW_ACK')){
					$share_type = 'ACK';
					$type_of_notification = config('kloves.NOTI_SHARED_ACK');
				}
				$key_id = $feed_data->key_id;
			}elseif($share_type == 'OPP'){
				$share_type = 'OPP';
				$type_of_notification = config('kloves.NOTI_SHARED_OPP');
			}
			/** add 'share' ... */
			$share_post_multidata = []; $notification_multidata = [];
			$batch_id = time();
			$status = config('kloves.RECORD_STATUS_ACTIVE');
			foreach($post_users as $ukey => $uval){ 
				$udata = $this->user->where('id', '=', $uval)->select('id','firstName','email')->first()->toArray();
				// prd($udata);

				$share_post_multidata[$ukey]['batch_id'] = $batch_id;
				$share_post_multidata[$ukey]['user_id'] = trim($uval);
				$share_post_multidata[$ukey]['key_id'] = $key_id;
				$share_post_multidata[$ukey]['share_type'] = $share_type;
				$share_post_multidata[$ukey]['status'] = $status;
				$share_post_multidata[$ukey]['created_by'] = $user_id;

				/** add notification */
				$notification_multidata[$ukey]['type_of_notification'] = $type_of_notification;
				$notification_multidata[$ukey]['key_value'] = $key_id;
				$notification_multidata[$ukey]['sender_id'] = $user_id;
				$notification_multidata[$ukey]['recipient_id'] = $uval;
				$notification_multidata[$ukey]['status'] = $status;

				/** @send_email : to notify */
				$sender_name  = auth()->user()->firstName;
				$emaildata['subject'] = $sender_name." has shared something with you!";
				$emaildata['receiver_name'] = $udata['firstName']; 
				$emaildata['receiver_email'] = $udata['email'];
				if($share_type == 'OPP'){
					$message = $sender_name.' has shared an opportunity with you.';
				}elseif($share_type == 'ACK'){
					$message = $sender_name.' has shared an acknowledgement with you.';
				}
				$emaildata['message'] = $message;
				$emaildata['sender_name'] = $sender_name;
				$emaildata['sender_email'] = auth()->user()->email;
				$mailResponse =  send_email($emaildata);
				/** @send_email : to manager to notify ENDS*/
			}
			//prd($share_post_multidata);
			DB::table('share_feed')->insert($share_post_multidata);
			DB::table('notifications')->insert($notification_multidata);

			$success_message = '<p>That\'s All</p><br> Thanks for sharing!';
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
