<?php

namespace App\Http\Controllers;
use App\Models\Feed;
//use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

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
			"success" => NULL,
		);
		$loggedInUserID = $roleId = '';
		$user = \Auth::user();  
		$loggedInUserID = $user->id;
		$roleId = $user->role;
		if($request->ajax()){  
			if($request->post('removed_feed')){
				$saveData['feed_pk_id'] = $request->post('feed_id');
				$saveData['removed_feed'] = 1;
				$saveData['created_by'] = $loggedInUserID;
				$this->feed->record_feeds_user_action($saveData);
				/* $oppForCanFilters['loggedUserID'] = $loggedInUserID;
				$oppForCanFilters['orderByTop'] = 'true';
				$oppForCanFilters['orderBy'] = $request->post('sortby');
				$myOppForCandidates = $this->opportunity->myOppForCandidates($oppForCanFilters);
				$response["success_html"] = view("home.opp-for-candidate") //render view
				->with("myOppForCandidates", $myOppForCandidates)
				->render();
				$response["type"] = "success";  */
			}
		}
		echo json_encode($response);
		exit();
	} 
	
}
