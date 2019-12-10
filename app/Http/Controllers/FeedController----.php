<?php

namespace App\Http\Controllers;
use App\Models\Feed;
//use App\User;
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
	  //$this->user = new User;
	  $this->feed = new Feed();
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
		if($request->ajax()){ 
			$feed_id = $request->post('feed_id'); 
			if (DB::table('feeds_user_action')->where('feed_pk_id',$feed_id)->where('user_id',$loggedInUserID)->exists()) {
				$updateData = [
					'updated_by' => $loggedInUserID,
					'updated_at' => 'Y-m-d H:i:s',
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
	
}
