<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset; 
use DB;
use Config;
use Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        /*'firstName', 'lastName', 'email', 'password', 'role'*/
        'firstName', 'email', 'password'
    ];

   /* protected $fillable = [
        'name', 'email', 'password',
    ];
*/
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = [ 'roles' ];
  	 function __construct() {
        //$this->dbPrefix = DB::getTablePrefix();
		}
		
	public function role(){
		return $this->belongsTo('App\Models\UserRoles', "id", "user_id");
	}


	/**
	 * To get user role by id
	 *
	 * @param  $filters
	 * @return Response
	*/    
   	public function getRolesAttribute()
	{
		return auth()->user()->role->where("user_id", auth()->user()->id)->where("status", 1)->pluck("role")->toArray();
	}

	public function profile_image() {
        return $this->hasOne('App\UserProfile', "user_id", "id")->select(["user_id", "image_name", "image_name as profile_image", "image_name as image_url"]);
    }
	
	 /**
     * User Profile Relationships.
     *
     * @var array
     */
     public function profile()
    {
        return $this->hasOne('App\UserProfile')->select(array('user_id','about','designation', 'image_name','image_name as image_url','department'));
    }
    
    
	/**
     * User Notification Relationships.
     *
     * @var array
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'recipient_id', 'id')->orderBy('id','DESC');
    }

   	/**
    	* OpportunityInvites Relationships.
     	* @var array
     	*/
    	public function opportunity_invites()
	{
	    return $this->hasMany('App\Models\OpportunityInvites', 'user_id', 'id');
	}
    
	
	function getUserProfileDataById($user_id = null){
		$file_path = Storage::disk('public_uploads')->url('/thumbnail/');
		$status = config('kloves.RECORD_STATUS_ACTIVE');
		$query = " SELECT u1.id, u1.firstName, u1.status, u1.mobile, u1.linkedin_id, u1.org_id
		, u2.designation, u2.aspirations, u2.availability, u2.notes, u2.status, u2.activities, u2.certificate, u2.about, u2.manager, u2.department, 
		CASE
            WHEN u2.image_name != '' THEN CONCAT('".$file_path."',  u2.image_name)
            ELSE ''
        END AS image_name, u2.image_name as img_name
		FROM ".DB::getTablePrefix()."users AS u1
		LEFT JOIN  ".DB::getTablePrefix()."user_profiles AS u2 ON (u1.id = u2.user_id)
		WHERE u1.id = '".$user_id."' AND u1.status = '".$status."' "; 

		//echo "<pre>"; print_r($query);  die; 
		$users = DB::select( DB::raw($query) ); 
		return $users[0];
	}
	/**
	 * To update user by id
	 *
	 * @param  $user_id, Request
	 * @return Response
	*/
	function updateUserProfile($user_id,$request){  
		if($request->post('firstname')){
			$uid = DB::table('users')->where(['id'=> $user_id])->update(['firstName'=> $request->post('firstname')]);
		}
		/** update profile **/
		$this->add_profile_resource($user_id,$request);

		/** update user manager  **/
		if($request->post('manager')){
	 	  $this->add_user_manager($user_id,$request);
		}
		/** update user interests  **/
		$this->add_user_interests($user_id,$request);
		   
	  	 return true;
	}
	/**
	 * To add profile details
	 *
	 * @param  $user_id, Request
	 * @return Response
	*/
	function add_profile_resource($user_id,$request){
        $userRow = DB::table('user_profiles')->where(['user_id' => $user_id,'status'=>config('kloves.RECORD_STATUS_ACTIVE')])->count();

		if($userRow > 0){ 

				$updateData['updated_at'] = now();
			if($request->post('aspirations'))
				$updateData['aspirations'] = $request->post('aspirations');

			if($request->post('availability'))
				$updateData['availability'] = $request->post('availability');

			if($request->post('notes'))
				$updateData['notes'] = $request->post('notes');

			if($request->post('activities'))
				$updateData['activities'] = $request->post('activities');

			if($request->post('designation'))
				$updateData['designation'] = $request->post('designation');

			$profile_id=  DB::table('user_profiles')
			->where(['user_id'=> $user_id,'status'=>config('kloves.RECORD_STATUS_ACTIVE')])
			->update($updateData);
		}else{ 
			$insertData['user_id'] = $user_id;
			if($request->post('aspirations'))
				$insertData['aspirations'] = $request->post('aspirations');

			if($request->post('availability'))
				$insertData['availability'] = $request->post('availability');

			if($request->post('notes'))
				$insertData['notes'] = $request->post('notes');
			
			if($request->post('activities'))
				$insertData['activities'] = $request->post('activities');
			
			if($request->post('designation'))
				$insertData['designation'] = $request->post('designation');

			$profile_id = DB::table('user_profiles')
						->insert($insertData);
		}

		return $profile_id;
               
    } 

    	/**
	 * To update user's manager
	 *
	 * @param  $user_id, Request
	 * @return Response
	*/
	function add_user_manager($user_id,$request){
        $managerRow = DB::table('user_managers')->where(['user_id' => $user_id,'status'=>config('kloves.RECORD_STATUS_ACTIVE')])->count();

		if($managerRow > 0){ 
			$mg_id=  DB::table('user_managers')
			->where(['user_id'=> $user_id,'status'=>config('kloves.RECORD_STATUS_ACTIVE')])
			->update([
						'manager_id'=> $request->post('manager'), 
						'updated_at'=> now()
					]);
		}else{ 
			$mg_id = DB::table('user_managers')
						->insert([
							'user_id'=> $user_id, 
							'manager_id'=> $request->post('manager')
						]);
		}

		return $mg_id;
               
    } 

    	/**
	 * To update user's interests
	 *
	 * @param  $user_id, Request
	 * @return Response
	*/
	function add_user_interests($user_id,$request){
		/** update skills **/
		if(($request->post('skills') != null) && count($request->post('skills')) > 0){
			$postedskills = $request->post('skills');
			$newskills  = []; $newfocus  = []; 
			$skilsExists = DB::table('user_interests')->where(['user_id' => $user_id,'vid'=>config('kloves.SKILL_AREA')])->exists();

			if($skilsExists){ 
				$skilsRow = DB::table('user_interests')->where(['user_id' => $user_id,'vid'=>config('kloves.SKILL_AREA')])->pluck('tid');
				$skilsRow = $skilsRow->toArray();
				$removeSkills = array_diff($skilsRow, $postedskills); 
				$addSkills = array_diff($postedskills, $skilsRow); 
				//print_r($skilsRow); print_r($removeSkills); print_r($addSkills); dd();
				if(!empty($removeSkills) && count($removeSkills) > 0){
					DB::table('user_interests')->whereIn('tid',$removeSkills)->where(['user_id' => $user_id,'vid'=>config('kloves.SKILL_AREA')])->delete();
				}
				if(!empty($addSkills) && count($addSkills) > 0){
					$newskills = $addSkills;
				}
			}else{
				$newskills = $postedskills;
			}
			if(!empty($newskills) && count($newskills) > 0){
				foreach ($newskills as $val1){
					$saveSkill[] = [
						'tid' => $val1,
						'vid' => config('kloves.SKILL_AREA'),
						'user_id' => $user_id
					];
				}
				DB::table('user_interests')->insert($saveSkill);
			}
		}

		/** update focus **/
		if(($request->post('focus') != null) && count($request->post('focus')) > 0){
			$postedfocus = $request->post('focus');

			$focusExists = DB::table('user_interests')->where(['user_id' => $user_id,'vid'=>config('kloves.FOCUS_AREA')])->exists();
			
			if($focusExists){ 
				$focusRow = DB::table('user_interests')->where(['user_id' => $user_id,'vid'=>config('kloves.FOCUS_AREA')])->pluck('tid');
				$focusRow = $focusRow->toArray();
				$removeFocus = array_diff($focusRow, $postedfocus); 
				$addFocus = array_diff($postedfocus, $focusRow); 
				//print_r($focusRow); print_r($removeFocus); print_r($addFocus); dd();
				if(!empty($removeFocus) && count($removeFocus) > 0){
					DB::table('user_interests')->whereIn('tid',$removeFocus)->where(['user_id' => $user_id,'vid'=>config('kloves.FOCUS_AREA')])->delete();
				}
				if(!empty($addFocus) && count($addFocus) > 0){
					$newfocus = $addFocus;
				}
			}else{
				$newfocus = $postedfocus;
			}
			if(!empty($newfocus) && count($newfocus) > 0){
				foreach ($newfocus as $val1){
					$savefOCUS[] = [
						'tid' => $val1,
						'vid' => config('kloves.FOCUS_AREA'),
						'user_id' => $user_id
					];
				}
				DB::table('user_interests')->insert($savefOCUS);
			}

		} 
		return true;
	}
	/**
	 * To get manager lists
	 *
	 * @param  $filters
	 * @return Response
	*/
	function getManagerList($filters = array()){
		$query = DB::table('users AS u1')
		->select('u1.*','u2.id AS roleID','u2.status AS role_status')
		->leftJoin("user_roles AS u2","u2.user_id" ,'=' ,"u1.id")
		->where('u2.role', config('kloves.ROLE_MANAGER'));

		if (!empty($filters['no_of_pages'])) {
		return $query->orderBy('u1.firstName', 'ASC')->paginate($filters['no_of_pages']);
		}else{
		return $query->orderBy('u1.firstName', 'ASC')->get(); 
		}
	}
	/**
	 * To get manager lists
	 *
	 * @param  $user_id
	 * @return Response
	*/
	function getManagerDdlList($user_id = null){
		if(!empty($user_id))
			$where[] = "  u1.id <> '".$user_id."' ";
		
		if( !empty($where) )
			$where = " AND ".implode(" AND ", $where );
		else
			$where = " ";

		$query = " SELECT firstName AS mname, id 
			FROM ".DB::getTablePrefix()."users AS u1
			LEFT JOIN ".DB::getTablePrefix()."vw_user_roles AS r1 ON (r1.user_id = u1.id)
			WHERE ( FIND_IN_SET('".config('kloves.ROLE_MANAGER')."', r1.roles) OR FIND_IN_SET('".config('kloves.ROLE_ADMIN')."', r1.roles) )  " 
			.$where
			." ORDER BY u1.firstName ASC  ";
		 $managerResult = DB::select( DB::raw($query) );
		 return $managerResult;
	}
	/**
	 * To get user lists
	 *
	 * @param  $filters
	 * @return Response
	*/
	function getUserList($filters = array()){
		$where[] = " kl_u1.status = 1 ";
		$where[] = " vw_roles.cur_active_role !=  '".config('kloves.ROLE_ADMIN')."' ";
		if(!empty($filters['ordering']['key'])){
			$orderBy = " order by ".$filters['ordering']['key']." ".$filters['ordering']['val']." ";
		}else{
			$orderBy = " order by firstName asc ";
		}
		
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";
		

		$query = " select kl_u1.id, kl_u1.firstName, kl_u1.email, vw_roles.cur_active_role, vw_roles.requested_role
		FROM ".DB::getTablePrefix()."users as kl_u1 
		LEFT JOIN ".DB::getTablePrefix()."vw_user_cur_role_status AS vw_roles ON (vw_roles.user_id = kl_u1.id)"
		.$where
		.$orderBy;
		//echo $query; die;
		$reResult = DB::select( DB::raw($query) );
		return $reResult;
	}
	/**
	 * To get users by roleid
	 *
	 * @param  $role_id
	 * @return Response
	*/
	function getUserByRoleId($role_id){
		$query = "	SELECT tb2.firstName AS uname, tb2.email 
		FROM ".DB::getTablePrefix()."user_roles AS tb1 
		LEFT JOIN ".DB::getTablePrefix()."users AS tb2 ON tb1.user_id = tb2.id
		WHERE tb1.id = $role_id";

		$dataResult = DB::select( DB::raw($query) );
		return $dataResult[0];
	}
	
	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
	$this->notify(new PasswordReset($token));
	}

	function get_user_highest_role($user_id){
		$query = "	SELECT tb1.role, tb1.status
		FROM ".DB::getTablePrefix()."user_roles AS tb1 
		WHERE tb1.user_id = $user_id 
		ORDER BY tb1.role ASC LIMIT 1";

		$dataResult = DB::select( DB::raw($query) ); //dd($dataResult[0]->role);
		return $dataResult[0];
	}
	/**
	 * Get User Manager of specified for user_id
	 * @param  $user_id
	 * @return result array
	 */
	function get_user_manager($user_id){
		$query = " SELECT manager_id, u2.firstName AS mname 
		FROM ".DB::getTablePrefix()."user_managers AS u1
		LEFT JOIN ".DB::getTablePrefix()."users AS u2 ON (u2.id = u1.manager_id)
		WHERE u1.status = 1 AND u1.user_id = $user_id ";

		$dataResult = DB::select( DB::raw($query) ); //dd($dataResult[0]->role);
		return $dataResult[0];
	}
	/**
	 * Get All User List For Dropdown
	 * @param  $filters
	 * @return result array
	 */
	function getAllUserDdlList($filters = array()){
		$where[] = " u1.status = 1 ";
	
		if(!empty($filters['not_in_users'])){
			$where[] = " u1.id NOT IN (".$filters['not_in_users'].")  ";
		}
		
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";

		$query = " SELECT u1.id, u1.firstName AS mname 
		FROM ".DB::getTablePrefix()."users AS u1 "
		.$where
		." ORDER BY u1.firstName ASC";
			
		$dataResult = DB::select( DB::raw($query) );  //prd($dataResult);
		return $dataResult;
	}
	
	
	

}	
