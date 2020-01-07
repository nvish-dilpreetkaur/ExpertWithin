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
		//$feedData = $this->feed->getfeedData($feedFilters, $offset , $limit); //prd($feedData);
		$feedData = Feed::with([
                  "opportunity" => function($q){
                     $q->where('status', '<>', config('kloves.OPP_APPLY_REJECTED'));
                     $q->where('apply_before', '>=', \Carbon\Carbon::now());
                     $q->whereNull('job_complete_date');
			},
			"opportunity.user_actions",
			"opportunity.skills",
			"opportunity.focus_areas",
			"opportunity.creator.profile",
			"opportunity.approved_applicants",  
			"feed_user_action",
			"acknoledgement" => function($q1){
				$q1->where('status', '=', config('kloves.ACK_ACTIVE'));
			 },
			"acknoledgement.ack_by",
			"acknoledgement.ack_by.profile",
			"acknoledgement.ack_to"
               ])
		->doesntHave('feed_user_action')
		->orwhereHas('feed_user_action', function($q2)
		   {
			   $q2->where('feeds_user_action.removed_feed', '<>', 1)
			  ->where('feeds_user_action.user_id', '=', \Auth::user()->id);
		 })
		->offset($offset)
		->limit($limit)
		->orderBy('feeds.updated_at','desc')
		->get()->toArray();
		
		//prd($feedData);

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
		$userRoles = $this->userRoles();

		$ufilters['not_in_users'] = $loggedInUserID;
		$all_users = $this->user->getAllUserDdlList($ufilters); 
		$current_user_detail = $user->where('id', '=', $loggedInUserID)->with(['profile','notifications'=> function($q) { $q->take(3);
		},'notifications.sender','notifications.opportunity'])->first()->toArray();
		//$current_user_detail = $user->getUserProfileDataById($loggedInUserID); //prd($current_user_detail);
		$page_no = 1;
		$feedCount = $this->feed->getfeedCount($feedFilters);
		$totalPages = ceil($feedCount / $limit);
		
		$status = config('kloves.RECORD_STATUS_ACTIVE');
		$shareUserList['all'] = $this->user->where('status','=', $status)->where('id', '<>', $loggedInUserID)->with(['profile',])->select('id','firstName')->get()->toArray();  //prd($shareUserList['all']);
		$shareUserJsonList = json_encode($shareUserList['all']);

		return view('home.index', compact(
		[
			'topMatchedOpportunities','loggedInUserID','myOppForCandidates','myAppliedOpp','all_users','feedData','page_no','totalPages', 'current_user_detail', 'userRoles', 'shareUserJsonList'
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
