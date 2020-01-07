<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Models\TaxonomyTerm;
use App\Models\Opportunity;
use App\User;
use DB;
use Storage;
use Auth;

class SearchController extends Controller
{

     /**
     * Create a new controller instance...
     *
     * @return void
     */

    public function __construct()
    {
	  $this->user = new User;
      $this->opportunity = new Opportunity();
    }

    protected function getFocusAreas(Request $request) {
        try {
            $focusAreaData = TaxonomyTerm::select(["tid", "name"])
                ->where("vid", config('kloves.FOCUS_AREA'))
                ->where("status", config('kloves.RECORD_STATUS_ACTIVE'))
                ->get();

            $result = array('status' => true, 'response' => array(
                "focusArea" => $focusAreaData
            ));
            return response()->json($result, Config::get('constants.STATUS_OK'));
        } catch(Exception $e){
            $result = array('status' => false, 'message' => $e->getMessage());
            return response()->json($result, STATUS_OK);
        }
    }

    protected function searchOpportunityList($searchText="", $focusArea=[], $page=1, $limit=0) {
        if($limit == 0) {
            $limit = config('kloves.SEARCH_OPR_LIMIT');
        }
        
        $offset = ($page - 1) * $limit;

        $profileImagePath = Storage::disk('public_uploads')->url('/thumbnail/');

        $searchSql = "SELECT * FROM (
            SELECT o.id, o.org_uid, o.opportunity, o.opportunity_desc, o.incentives, o.rewards, o.tokens, o.expert_qty, o.expert_hrs, o.start_date, o.end_date, o.apply_before, o.status, 
            (SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = 1 AND oid = o.id ) AS skills,
            (SELECT GROUP_CONCAT(name) FROM ".DB::getTablePrefix()."taxonomy_term_data WHERE tid IN (SELECT DISTINCT tid FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = 1 AND oid = o.id )) as skills_names, 
            (SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = 3 AND oid = o.id ) AS focus_areas,
            (SELECT COUNT(id) FROM ".DB::getTablePrefix()."org_opportunity_users WHERE oid=o.id AND apply=1 AND approve=1) as approved_users,
            u.firstName,
            IFNULL(CONCAT('$profileImagePath', dp.image_name), '') as image_name,
            dp.department,
            IFNULL(ou.apply,0) as apply, 
            IFNULL(ou.approve,0) as approve, 
            IFNULL(ou.like,0) as opr_like, 
            IFNULL(ou.favourite,0) as favourite,
            o.job_start_date, o.job_complete_date
            FROM ".DB::getTablePrefix()."org_opportunity as o
            LEFT JOIN ".DB::getTablePrefix()."users as u ON o.org_uid = u.id
            LEFT JOIN ".DB::getTablePrefix()."user_profiles as dp ON o.org_uid = dp.user_id
            LEFT JOIN ".DB::getTablePrefix()."org_opportunity_users as ou ON ou.oid = o.id AND ou.org_uid=".Auth::user()->id."
        ) AS t1
        WHERE 
        t1.status = 1";
        if(!empty($searchText)) {
            $searchTextArr = explode(" ",$searchText);
            $searchSql .= " AND (";
            foreach($searchTextArr as $k => $srchTxt) {
                if($k==0) {
                    $searchSql .= "t1.opportunity LIKE '%".$srchTxt."%'";
                } else {
                    $searchSql .= " OR t1.opportunity LIKE '%".$srchTxt."%'";
                }
                $searchSql .= " OR t1.opportunity_desc LIKE '%".$srchTxt."%'";
                $searchSql .= " OR t1.skills_names LIKE '%".$srchTxt."%'";
            }
            $searchSql .= ") ";
        }
        if(!empty($focusArea) && count($focusArea) > 0) {
            $searchSql .= " AND (";
            foreach($focusArea as $k=>$fa) {
                if($k!=0) {
                    $searchSql .= " OR ";
                }
                $searchSql .= " FIND_IN_SET (t1.focus_areas, $fa)";
            }
            $searchSql .= ")";
        }
        $searchSql .= " LIMIT  $offset, $limit ";

        $opportunities = DB::select( DB::raw($searchSql) );
        return $opportunities;
    }

    protected function searchOpportunity(Request $request) {
        try {
            $limit = config('kloves.SEARCH_OPR_LIMIT');
            $searchText = $request->post("search_text");
            $focusArea = $request->post("focus_area");
            $page = $request->post("page");
            $action = "search";
            if($request->has("action") && !empty($request->post("action"))) {
                $action = $request->post("action");
            }
           
            $opportunities = $this->searchOpportunityList($searchText, $focusArea, $page, $limit);

             /** share feed : start */
            $status = config('kloves.RECORD_STATUS_ACTIVE');
            $shareUserList['all'] = $this->user->where('status','=', $status)->where('id', '<>', \Auth::user()->id)->select('id','firstName')->get()->toArray(); 
            $shareUserJsonList = json_encode($shareUserList['all']);
              /** share feed : end */
        
            $result = array('status' => true);
            if($action == "search") {
                $result["html"] = view(
                    'common.search-opportunity', 
                    compact(['opportunities', 'page','shareUserJsonList'])
                    )->render();
            } else {
                $result["html"] = view(
                    'opportunity.list-opportunity-item', 
                    compact(['opportunities', 'page','shareUserJsonList'])
                    )->render();
            }
            

            $result["hasMoreData"] = (count($opportunities)<$limit)?false:true;

            return response()->json($result, Config::get('constants.STATUS_OK'));
        } catch(Exception $e){
            $result = array('status' => false, 'message' => $e->getMessage());
            return response()->json($result, STATUS_OK);
        }
    }

    protected function listOpportunity(Request $request) {
        $oppForCanFilters = [];
        $appliedOppFilters = [];
		$user = \Auth::user(); 
		if(!empty($user)){
			$loggedInUserID = $user->id;
			$roleId = $user->role;
			$oppForCanFilters['loggedUserID'] = $loggedInUserID;
			$appliedOppFilters['loggedUserID'] = $loggedInUserID;
        }
        
        $myOppForCandidates = $this->opportunity->myOppForCandidates($oppForCanFilters);
        $myAppliedOpp = $this->opportunity->myAppliedOpp($appliedOppFilters);
        $userRoles = $this->userRoles();

        $opportunities = $this->searchOpportunityList();

        return view('opportunity.opportunity-list', compact(
            [
                'myAppliedOpp', 'myOppForCandidates', 'userRoles', 'opportunities'
            ]
        ));
    }
}
