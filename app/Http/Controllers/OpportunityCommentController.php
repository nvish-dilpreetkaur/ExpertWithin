<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use App\Http\Requests\AddOpportunityRequest;
use App\Http\Requests\StoreOpportunityRequest;
use App\Models\Opportunity;
use App\Models\OpportunityComments;
use App\Models\TaxonomyTerm;
use App\Models\Feed;
use App\User;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;

class OpportunityCommentController extends Controller
{

    /**
     * Constructor
     *
     * @param OpportunityRepository $opportunityRepository
     * @param OpportunityTransformer $opportunityTransformer
     */
    public function __construct()
    {
       
        $this->opportunity = new Opportunity();
        $this->taxonomyterm = new TaxonomyTerm();
    }

    /**
     * Display a list of opportunity.
     * @param  none
     * @return Response
     */
    public function add_comment(Request $request)
    {
		$response['status'] = false;	
        if (request()->ajax()) {
		   $type = $request->post('type');
		   $comment = $request->post('comment');
           $org_id = $request->post('org_id');
           $ptype = $request->post('ptype');
           $user = \Auth::user();
           $terms = array();
           if(!empty($user)){
				$loggedInUserID = $user->id;
				$pdata = array(
					'user_id' => $loggedInUserID,
					'org_id' => $org_id,
					'comment' => $comment,
					'type' => $ptype,
					'parent_id' => 0
				);
				switch($type) {
				  case 'comment':
					OpportunityComments::create($pdata);
				  break;
				  case 'reply':
				    $parent_id = $request->post('id');
					$pdata['parent_id'] = $request->post('id');
					$reply_id = OpportunityComments::create($pdata);
					$opp_comments = OpportunityComments::with(['user', 'user.profile'])
												->where('id',$reply_id->id)
												->get()
												->toArray();
											
					if($opp_comments) {
						 $response["comments"] = view('home.common.opportunity-comment-reply',compact(['opp_comments','parent_id','ptype']))->render();	
					}	
				  break;
			   }
			}
		   
			$response['status'] = true;		
        }
        return json_encode($response);
    }
    
  
    
    public function get_comment(Request $request) {
		$response['status'] = false;
		$response['comments'] = $opp_comments = array();	
        if (request()->ajax()) {
           $org_id = $request->post('org_id');
           $type = $request->post('type');
           $user = \Auth::user();
		   $terms = array();
		   if(!empty($user)){	
			    $opp_comment_count = OpportunityComments::where('org_id',$org_id)->where('parent_id',0)->count();		
				$opp_comments = OpportunityComments::with(['replies', 'replies.user', 'replies.user.profile', 'user', 'user.profile'])  
													->withCount('replies')
													->where('org_id',$org_id)
													->where('parent_id',0)
													->where('type',$type)
													->limit(2,0)
													->get()
													->toArray();
											
				if($opp_comments) {
					$response["comments"] = view('home.common.opportunity-comment',compact(['opp_comments','opp_comment_count','org_id','type']))->render();
				}
			}
			
			$response['status'] = true;	
        }
        return json_encode($response);
	}
	
	public function get_more_reply(Request $request) {
		$response['status'] = false;
		$response['last_key'] = 0;
		$ptype = $request->post('type');
		$response['comments'] = $opp_comments = array();	
        if (request()->ajax()) {
			$org_id = $request->post('org_id');
			$parent_id = $request->post('parent_id');
			$prev_id = $request->post('prev_id');
			$opp_comments = OpportunityComments::with(['user', 'user.profile'])
												->where('parent_id',$parent_id)
												->where('org_id',$org_id)
												->where('id','<',$prev_id)
												->where('type',$ptype)
												->orderBy('id','desc')
												->limit(4,0)
												->get()
												->toArray();
											
			if($opp_comments) {
				sort($opp_comments);
				$response['last_key'] = $opp_comments[0]['id'];
				$response["comments"] = view('home.common.opportunity-comment-reply',compact(['opp_comments','parent_id','ptype']))->render();
				$response['count'] = 1;
				$response['status'] = true;	
			} else {
				$response['count'] = 0;
				$response['status'] = true;	
			}											
		}
        return json_encode($response);
	}
	
	public function get_more_comment(Request $request) {
		$response['status'] = false;
		$response['comments'] = $opp_comments = array();	
        if (request()->ajax()) {
			$org_id = $request->post('org_id');
			$prev_id = $request->post('prev_id');
			$type = $request->post('type');
			$opp_comment_count = OpportunityComments::where('org_id',$org_id)->where('parent_id',0)->count();
			$opp_comments = OpportunityComments::with(['replies', 'replies.user', 'replies.user.profile', 'user', 'user.profile'])
												->withCount('replies')
												->where('org_id',$org_id)
												->where('parent_id',0)
												->where('type',$type)
												->where('id','>',$prev_id)
												->limit(5,0)
												->get()
												->toArray();
			if($opp_comments) {
				$response["comments"] = view('home.common.opportunity-comment',compact(['opp_comments','opp_comment_count','org_id','type']))->render();
				$response['count'] = 1;
				$response['status'] = true;
			} else {
				$response['count'] = 0;
				$response['status'] = true;	
			}
		}
        return json_encode($response);
	}
 }
