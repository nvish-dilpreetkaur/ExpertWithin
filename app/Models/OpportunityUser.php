<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OpportunityUser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'org_opportunity_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'oid',
      'org_uid',
      'org_id',
      'apply',
      'like',
      'favourite',
      'status',
      'created_at',
      'updated_at'
    ];
    

    public function user_details()
    {
        return $this->hasOne('App\User', "id", "org_uid")->select(["id", "firstName"]);
    }

    public function opportunity()
    {
        return $this->hasOne('App\Models\Opportunity', "id", "oid")->select(["id", "opportunity","opportunity_desc","rewards","org_uid","apply_before","tokens","expert_hrs"]);
    }


    public function profile_image() {
        return $this->hasOne('App\UserProfile', "user_id", "org_uid")->select(["user_id", "image_name as profile_image"]);
    }

  /**
	 * To  Update opportunity user action
	 *
	 * @param  $filters
	 * @return Response
	*/
    public function opportunity_user_update($opportunity_user, $id, $uid, $org_id)
    {
      return DB::table('org_opportunity_users')
        ->where('oid', $id)
        ->where('org_uid', $uid)
        ->where('org_id', $org_id)
        ->update($opportunity_user);
    }

    // Check opportunity user exists
    public function opportunity_user_exists($oid, $uid, $org_id)
    {
     $opportunityuser_exists = OpportunityUser::where('oid', $oid)->where('org_uid', $uid)->where('org_id', $org_id)->count();
     return $opportunityuser_exists;
    }

    /**
	 * To  Opportunity list
	 *
	 * @param  $filters
	 * @return Response
	*/
    public function opportunity_action_list($action, $no_of_pages = 0)
    {  
      $uid = auth()->user()->id;
      $org_id = auth()->user()->org_id;
      $opportunityApply = config('kloves.OPPORTUNITY_APPLY');
      $opportunityLike = config('kloves.OPPORTUNITY_LIKE');
      $opportunityFavourite = config('kloves.OPPORTUNITY_FAVOURITE'); 
      $selected_field = array(
        'org_opportunity.*',
        'users.firstName AS opp_manager',
        'org_opportunity_users.oid',
        'org_opportunity_users.apply',
        'org_opportunity_users.like',
        'org_opportunity_users.favourite',
        'org_opportunity_users.org_uid',
        'org_opportunity_users.org_id', 
        DB::raw("(SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = ".config('kloves.SKILL_AREA')." AND oid = ".DB::getTablePrefix()."org_opportunity_users.oid ) as skills"),
        DB::raw("(SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = ".config('kloves.FOCUS_AREA')." AND oid = ".DB::getTablePrefix()."org_opportunity_users.oid ) as focus_areas")
        , DB::raw("(SELECT action_status FROM ".DB::getTablePrefix()."org_opportunity_user_actions WHERE applicant_id = ".$uid." AND action_type = 1 AND oid = ".DB::getTablePrefix()."org_opportunity_users.oid ORDER BY id DESC LIMIT 1 ) as app_status" )
      );
      $query = DB::table('org_opportunity_users')
        ->leftJoin("org_opportunity","org_opportunity.id" ,'=' ,"org_opportunity_users.oid")
        ->leftJoin("users","users.id" ,'=' ,"org_opportunity.org_uid")
        ->where('org_opportunity_users.org_uid', $uid)
        ->where('org_opportunity_users.org_id', $org_id)
        ->where('org_opportunity.status', 1);
      switch ($action) {
        case $opportunityApply:
          $query->where('org_opportunity_users.apply',1);
          break;
        case $opportunityLike:
          $query->where('org_opportunity_users.like', 1);
          break;
        case $opportunityFavourite:
          $query->where('org_opportunity_users.favourite', 1);
          break;
      }
      if ($no_of_pages) {
       return $query->orderBy('org_opportunity_users.oid', 'DESC')->select($selected_field)->paginate($no_of_pages);
       
      } else{
        return $query->orderBy('org_opportunity_users.oid', 'DESC')->select($selected_field)->get(); 
      }
    }

   /**
	 * To log user action 
	 *
	 * @param  $filters
	 * @return Response
	*/
    function log_opp_user_action($sdata){
      if($sdata){
        if(empty($sdata['approver_id'])){
          $oppRecord = Opportunity::where('id', $sdata['oid'])->first();
          $sdata['approver_id'] =  $oppRecord->org_uid;
        }
        OpportunityUserActions::insert([$sdata]);
        return true;
      }else{
        return false;
      }
    }

     /**
     * To get activities Opportunities.
     *
     * @param  $filters
     * @return Response
    */
    /*
    public function getActivityOpportunities($filters = array()){
      $statusActive = config('kloves.RECORD_STATUS_ACTIVE');
      
      $where[] = " out2.org_id = '". auth()->user()->org_id."' " ;
      $where[] = " out1.org_uid = '". auth()->user()->id."' " ;
      $where[] = " out2.status = '".$statusActive."' " ;
      $where[] = "  (out1.like = 1 OR out1.favourite = 1) " ;
      //$where[] = " DATE(out2.end_date) >= '".date("Y-m-d")."' ";
      
      if( !empty($where) )
        $where = " WHERE ".implode(" AND ", $where );
      else
        $where = " ";
      
        $whereCondRole = "";
        $query = "SELECT out2.id, out2.opportunity, CONCAT(LEFT(out2.opportunity_desc,85),'...') AS opportunity_desc,     out2.rewards, out2.start_date, out2.end_date
          , out1.apply, out1.like, out1.favourite, out2.apply_before
            , (SELECT GROUP_CONCAT(DISTINCT tid) FROM ".DB::getTablePrefix()."org_opportunity_terms_rel WHERE vid = 3 AND oid = out1.oid ) AS focus_areas
            FROM ".DB::getTablePrefix()."org_opportunity_users AS out1
            LEFT JOIN ".DB::getTablePrefix()."org_opportunity AS out2 ON (out2.id = out1.oid)
            $where ";
     
     //echo "<pre>"; print_r($query);  die; 
      $opportunitiesResult = DB::select( DB::raw($query) );  //dd($opportunitiesResult);
      
        return $opportunitiesResult;
      }
    */
    
}
