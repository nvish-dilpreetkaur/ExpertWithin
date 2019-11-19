<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
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
		
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";
		
		// echo "<pre>"; print_r($where); 
		// die;
		if(!empty($filters['loggedUserID'])){
			$whereCondRole = "";
			$query = "SELECT  out2.id, out2.opportunity, out2.rewards, out2.tokens
					, (SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = 3 AND oid = out1.oid ) AS focus_areas
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

	
	
}
