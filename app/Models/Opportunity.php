<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use App\Http\Controllers\Auth;

class Opportunity extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'org_opportunity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opportunity',
        'opportunity_desc',
        'rewards',
        'org_uid',
        'org_id',
        'department_id',
        'status',
        'start_date',
        'end_date',
        'apply_before',
        'created_at',
        'updated_at'        
	];
	
	function user_actions() {
		return $this->hasOne('App\Models\OpportunityUser', "oid", "id")->where("org_uid", auth()->user()->id);
	}
	
	public function creator()
	{
	    return $this->belongsTo('App\User', 'org_uid', 'id');
	}
    
    /**
     * get top matched Opportunities.
     *
     * @param  $filters
     * @return Response
     */
    public function getTopMatchedOpportunities($filters = array()){
		$statusDeleted = config('kloves.OPP_DELETE');

		$where[] = " out1.user_id = '".$filters['loggedUserID']."' " ;
		$where[] = " out2.org_id = '". auth()->user()->org_id."' " ;
		$where[] = " out2.org_uid != '". auth()->user()->id."' " ;
		$where[] = " out2.status != '".$statusDeleted."' " ;
		$where[] = " DATE(out2.end_date) >= '".date("Y-m-d")."' ";
		$where[] = " out2.status = 1 ";
		
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";
		
		// echo "<pre>"; print_r($where); 
		// die;
		if(!empty($filters['loggedUserID'])){
			$whereCondRole = "";
			$query = "SELECT  out2.id, out2.opportunity, out2.rewards, out2.tokens
					FROM ".DB::getTablePrefix()."vw_user_matched_opp AS out1
					LEFT JOIN ".DB::getTablePrefix()."org_opportunity AS out2 ON (out2.id = out1.oid) "
					.$where; 
		}else{
			$query = " ";
	  } //echo "<pre>"; print_r($query);  die; 
	  $opportunitiesResult = DB::select( DB::raw($query) );  //prd($opportunitiesResult);
	  
      return $opportunitiesResult;
    }
	/**
     * get data for "My opportunities for candidates" section homepage.
     *
     * @param  $filters
     * @return Response
     */
    function myOppForCandidates($filters = array()){

		$where[] = " t1.org_uid = '".$filters['loggedUserID']."' " ;
		$where[] = " t1.status != '".config('kloves.OPP_DELETE')."' " ;
		
		if(@$filters['orderByTop']){
			$orderby = " ORDER BY t1.status = '".$filters['orderBy']."' DESC ";
		}else{
			$orderby = " ORDER BY t1.id DESC ";
		}

		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";

		$query = " SELECT t1.id , t1.opportunity, t1.status
		FROM ".DB::getTablePrefix()."org_opportunity AS t1 "
		.$where
		.$orderby
		." LIMIT 3";
		//prd($query);
		$opportunitiesResult = DB::select( DB::raw($query) );  //prd($opportunitiesResult);
	  
      	return $opportunitiesResult;

    }

    /**
     * get data for "My applied opportunities" section homepage.
     *
     * @param  $filters
     * @return Response
     */
    function myAppliedOpp($filters = array()){

		$where[] = " t2.org_uid = '".$filters['loggedUserID']."' " ;
		$where[] = " t2.apply = '1' " ;
		$where[] = " t1.status != '".config('kloves.OPP_DELETE')."' " ;

		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";

		$query = "SELECT t1.id , t1.opportunity, t1.status, t2.apply
		, ( SELECT action_status FROM ".DB::getTablePrefix()."org_opportunity_user_actions
		WHERE id IN (SELECT MAX(id) FROM ".DB::getTablePrefix()."org_opportunity_user_actions WHERE applicant_id = '".$filters['loggedUserID']."' AND action_type = 1 AND oid = t1.id GROUP BY oid)  ) AS application_status
		FROM ".DB::getTablePrefix()."org_opportunity AS t1
		LEFT JOIN ".DB::getTablePrefix()."org_opportunity_users AS t2 
		ON (t2.oid = t1.id AND t2.org_uid = '".$filters['loggedUserID']."') "
		.$where
		." ORDER BY t1.id DESC"
		." LIMIT 3";

		$opportunitiesResult = DB::select( DB::raw($query) );  //prd($opportunitiesResult);
	
		return $opportunitiesResult;

	}

	/**
	 * get data for opportunity by ID .
	 *
	 * @param  $filters
	 * @return Response
	 */
	function getOpportunityDetailsByID($filters = array()){
		$file_path = url('/uploads/');
		$where[] = " t1.org_id = '".auth()->user()->org_id."' " ;
		$where[] = " t1.id = '".$filters['id']."' " ;

		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";

		$query = "SELECT t1.id AS opp_id, t1.opportunity, t1.opportunity_desc, t1.rewards, t1.tokens
		, t1.incentives, t1.start_date, t1.end_date, t1.apply_before, t2.firstName AS uname, t3.department,
		CASE
            WHEN t3.image_name != '' THEN CONCAT('".$file_path."', '".Config('constants.DS')."', t3.image_name)
            ELSE ''
        END AS image_name, t21.like, t21.favourite, t21.apply, t1.org_uid
		FROM ".DB::getTablePrefix()."org_opportunity AS t1 
		LEFT JOIN  ".DB::getTablePrefix()."org_opportunity_users AS  t21 ON (t21.oid = t1.id AND t21.org_uid = '".auth()->user()->id."')
		LEFT JOIN  ".DB::getTablePrefix()."users AS  t2 ON (t2.id = t1.org_uid)
		LEFT JOIN   ".DB::getTablePrefix()."user_profiles AS  t3 ON (t3.user_id = t1.org_uid)"
		.$where;

		//prd($query);
		$opportunitiesResult = DB::select( DB::raw($query) )[0]; 

		/** get skills */
		$skillQuery = "SELECT t1.tid , t2.name  
		FROM ".DB::getTablePrefix()."org_opportunity_terms_rel AS t1
		LEFT JOIN ".DB::getTablePrefix()."taxonomy_term_data AS t2 ON (t2.tid = t1.tid) 
		WHERE t1.oid = '".$filters['id']."' AND t1.vid = '".config('kloves.SKILL_AREA')."' ";
		$skillResult = DB::select( DB::raw($skillQuery) );  //prd($skillResult);

		/** get skills */
		$focusQuery = "SELECT t1.tid , t2.name  
		FROM ".DB::getTablePrefix()."org_opportunity_terms_rel AS t1
		LEFT JOIN ".DB::getTablePrefix()."taxonomy_term_data AS t2 ON (t2.tid = t1.tid) 
		WHERE t1.oid = '".$filters['id']."' AND t1.vid = '".config('kloves.FOCUS_AREA')."' ";
		$focusResult = DB::select( DB::raw($focusQuery) );  //prd($focusQuery);

		$opportunitiesResult->skills = $skillResult;
		$opportunitiesResult->focus = $focusResult; //prd($opportunitiesResult);
		return $opportunitiesResult;

	}


	 /**
	 * get you may also like Opportunities.
	 *
	 * @param  $filters
	 * @return Response
	 */
    public function getYouMayLikeOpportunities($filters = array()){
		$file_path = url('/uploads/');
		$statusDeleted = config('kloves.OPP_DELETE');
		$opp_feed_type = config('kloves.FEED_TYPE_NEW_OPP');

		$where[] = " out2.id NOT IN (".$filters['doNotIncludeList'].") " ;
		$where[] = " out1.user_id = '".$filters['loggedUserID']."' " ;
		$where[] = " out2.org_id = '". auth()->user()->org_id."' " ;
		$where[] = " out2.org_uid != '". auth()->user()->id."' " ;
		$where[] = " out2.status != '".$statusDeleted."' " ;
		$where[] = " DATE(out2.end_date) >= '".date("Y-m-d")."' ";
		
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";
		
		if( !empty($filters['limit']) )
			$limit = " LIMIT ".$filters['limit'];
		// echo "<pre>"; print_r($where); 
		// die;
		if(!empty($filters['loggedUserID'])){
			$whereCondRole = "";
			$query = "SELECT t001.*, COALESCE(t002.removed_feed,0) AS removed_feed  FROM (SELECT  out2.id, out2.opportunity, out2.rewards, out2.tokens, out2.opportunity_desc
			, t2.firstName AS uname, t3.department,
			CASE
				WHEN t3.image_name != '' THEN CONCAT('".$file_path."', '".Config('constants.DS')."', t3.image_name)
				ELSE ''
			END AS image_name,
			 t21.like, t21.favourite
			, (SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = 3 AND oid = out1.oid ) AS focus_areas
			, (SELECT id FROM ".DB::getTablePrefix()."feeds WHERE feed_type = '".$opp_feed_type."' AND key_id = out2.id) AS feed_id
			FROM ".DB::getTablePrefix()."vw_user_matched_opp AS out1
			LEFT JOIN ".DB::getTablePrefix()."org_opportunity AS out2 ON (out2.id = out1.oid) 
			LEFT JOIN  ".DB::getTablePrefix()."org_opportunity_users AS  t21 ON (t21.oid = out2.id AND t21.org_uid = '".$filters['loggedUserID']."')
			LEFT JOIN  ".DB::getTablePrefix()."users AS  t2 ON (t2.id = out2.org_uid)
			LEFT JOIN   ".DB::getTablePrefix()."user_profiles AS  t3 ON (t3.user_id = out2.org_uid)"
			.$where." ) AS t001 
			LEFT JOIN ".DB::getTablePrefix()."feeds_user_action AS t002 ON (t001.feed_id = t002.feed_pk_id)
			WHERE COALESCE(t002.removed_feed,0) <> 1 "
			.$limit; 
		}else{
			$query = " ";
		} //echo "<pre>"; print_r($query);  die; 
		$opportunitiesResult = DB::select( DB::raw($query) );  //prd($opportunitiesResult);
	
	return $opportunitiesResult;
	}
	
	
}
