<?php

namespace App\Http\Controllers;
use App\Models\Opportunity;
use App\Models\Feed;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class IndexController extends Controller
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
	  $this->opportunity = new Opportunity();
	  $this->feed = new Feed();
    }
	
    	/**
	 * To Show index page
	 * @param  none
	 * @return Response
 	*/
	public function index(Request $request)
	{ 
		$limit = config('kloves.searchResultLimit');
		$loggedInUserID = $roleId = '';  $offset = 0;
		$topMatchedFilter = [];  $oppForCanFilters = [];
		$user = \Auth::user(); 
		if(!empty($user)){
			$loggedInUserID = $user->id;
			$roleId = $user->role;
			$topMatchedFilter['loggedUserID'] = $loggedInUserID;
			$oppForCanFilters['loggedUserID'] = $loggedInUserID;
			$appliedOppFilters['loggedUserID'] = $loggedInUserID;
			$feedFilters['loggedUserID'] = $loggedInUserID;
		}
		//prd($request->post());
		if($request->post('page_no')){
			$page_no = $request->post('page_no');
			$offset = ($page_no - 1) * $limit;
		} 
		$totalPages = ($request->post('totalPages') ? $request->post('totalPages') : '') ; 
		$feedData = $this->feed->getfeedData($feedFilters, $offset , $limit); //prd($feedData);
		if($request->ajax()){ 
			$response["feed"] = true;
			$response["html"] = view('home.home-feeds', compact(['feedData','page_no','totalPages']))->render();
			$response["type"] = "success";
			if(!$feedData) {
				$response["feed"] = false;
			}
			echo json_encode($response);
			exit();
		}else{
			//do nothing, proceed ahead
		}
		
		$topMatchedOpportunities = $this->opportunity->getTopMatchedOpportunities($topMatchedFilter);
		$myOppForCandidates = $this->opportunity->myOppForCandidates($oppForCanFilters);
		$myAppliedOpp = $this->opportunity->myAppliedOpp($appliedOppFilters);

		$ufilters['not_in_users'] = $loggedInUserID;
		$all_users = $this->user->getAllUserDdlList($ufilters); 
		$current_user_detail = $user->getUserProfileDataById($loggedInUserID);
		$page_no = 1;
		$feedCount = $this->feed->getfeedCount($feedFilters);
		$totalPages = ceil($feedCount / $limit);
		return view('home.index', compact(
		[
			'topMatchedOpportunities','loggedInUserID','myOppForCandidates','myAppliedOpp','all_users','feedData','page_no','totalPages', 'current_user_detail'
		]) );
		
	} 
	/**
	 * Sort homepage widgets by action fired by user
	 * @param  Request
	 * @return Response
	*/
	function sortWidget(Request $request){
		$response = array( 
			"type" => NULL,
			"errors" => NULL,
		);
		$loggedInUserID = $roleId = '';
		$user = \Auth::user();  
		$loggedInUserID = $user->id;
		$roleId = $user->role;
		if($request->ajax()){  
			if($request->post('slug')=='opp-for-candidate'){
				$oppForCanFilters['loggedUserID'] = $loggedInUserID;
				$oppForCanFilters['orderByTop'] = 'true';
				$oppForCanFilters['orderBy'] = $request->post('sortby');
				$myOppForCandidates = $this->opportunity->myOppForCandidates($oppForCanFilters);
				$response["success_html"] = view("home.opp-for-candidate") //render view
				->with("myOppForCandidates", $myOppForCandidates)
				->render();
				$response["type"] = "success"; 
			}
		}
		echo json_encode($response);
		exit();
	}
	

	
}
