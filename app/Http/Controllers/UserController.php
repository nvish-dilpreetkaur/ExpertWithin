<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;
use App\Models\UserInterest;
use App\Models\TaxonomyTerm;
use App\Http\Requests;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Opportunity;
use App\Models\Acknoledgement;
use DB;
use Exception;
use Config;
use Storage;
use Image;

class UserController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
         $this->opportunity = new Opportunity();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User; 
        $user_id = auth()->user()->id; 
	    $focus = TaxonomyTerm::where('vid', config('kloves.FOCUS_AREA'))->where('status',config('kloves.RECORD_STATUS_ACTIVE'))->select('name', 'tid')->orderBy('name')->get();
        $skills = TaxonomyTerm::where('vid', config('kloves.SKILL_AREA'))->where('status',config('kloves.RECORD_STATUS_ACTIVE'))
        ->select('name', 'tid')->orderBy('name')->get();
        $managers = $user->getManagerDdlList($user_id); 
	  
	    return view('users.create-user', compact(['skills', 'focus','managers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'firstname' => 'required',
            'password' => 'required|min:8',
            'availability' => 'required',
            'manager' => 'required',
            'focus' => 'required|array',
            'skills' => 'required|array',
         ]);
        $user = new User;
        $data = $request->post(); //dd($data);
        $user_id = DB::table('users')->insertGetId([
            'firstName'       => $data['firstname'],
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
        ]);
       
        //insert user basic 'expert' role to roles table
        DB::table('user_roles')->insert([
            'user_id'       => $user_id,
            'role'          => config('kloves.ROLE_EXPERT'),
            'status'        => 1,
        ]);

        if($request->role==config('kloves.ROLE_MANAGER')){
            DB::table('user_roles')->insert([
                'user_id'       => $user_id,
                'role'          => $data['role'],
                'status'        => 0,
            ]);
        }
        $user->updateUserProfile($user_id,$request);

        return redirect('users')->with('success','User created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {   
		$topMatchedFilter = [];  $oppForCanFilters = [];
        if ($id) {
            $user_id = Crypt::decrypt($id);
            $action_type = 'HR-EDIT';
        }else{
            $user_id = auth()->user()->id; 
            $action_type = 'SELF-EDIT';
            $loggedInUserID = $user_id;
			$roleId = auth()->user()->role;
			$topMatchedFilter['loggedUserID'] = $loggedInUserID;
			$oppForCanFilters['loggedUserID'] = $loggedInUserID;
			$appliedOppFilters['loggedUserID'] = $loggedInUserID;
			$feedFilters['loggedUserID'] = $loggedInUserID;
        }
        $user = new User;
	    $users = $user->getUserProfileDataById($user_id);
	    //pre( $users); exit;  
        $focus = TaxonomyTerm::where('vid', config('kloves.FOCUS_AREA'))->where('status',config('kloves.RECORD_STATUS_ACTIVE'))->select('name', 'tid')->orderBy('name')->get();
        $skills = TaxonomyTerm::where('vid', config('kloves.SKILL_AREA'))->where('status',config('kloves.RECORD_STATUS_ACTIVE'))
        ->select('name', 'tid')->orderBy('name')->get()->toArray();
        $managers = $user->getManagerDdlList($user_id);
        $user_skills = UserInterest::with(["term_data"])->where('user_id',$user_id)->where('vid',1)->get()->toArray();
        $user_focus = UserInterest::with(["term_data"])->where('user_id',$user_id)->where('vid',3)->get()->toArray();
        $topMatchedOpportunities = $this->opportunity->getTopMatchedOpportunities($topMatchedFilter);
	    $acknowledgement = Acknoledgement::with(["ack_by.profile","ack_to.profile"])->where('user_id',$user_id)->get()->toArray();
        $acknoledgement_count = count($acknowledgement);
	    return view('users.profile', compact(['users', 'skills', 'focus','managers','user_skills','user_focus','action_type','topMatchedOpportunities','acknowledgement','acknoledgement_count']));
    }

   

    /**
     * Update user
     */
    public function update_bak8oct(Request $request,$id = null)
    {  //print_r($id); dd($request->post());
        if ($id) {
            $user_id = Crypt::decrypt($id);
            $redirection_url = 'users';
            $success_message = 'User is updated';
        }else{
            $user_id = auth()->user()->id; 
            $redirection_url = '/';
            $success_message = 'Profile is updated';
        }
		$user = new User;
		$user->getUserProfileDataById($user_id); 

        $this->validate($request, [
             'firstname' => 'required',
             'availability' => 'required',
             'manager' => 'required',
             'focus' => 'required|array',
             'skills' => 'required|array',
          ]);
	
        $user->updateUserProfile($user_id,$request);

        return redirect($redirection_url)->with('success',$success_message);
    }


        /**
     * Update user
     */
    public function update(Request $request,$id = null)
    {   //dd($request->post());
        $response = array( 
			"type" => NULL,
            "errors" => NULL, 
            "success_html" => NULL, 
		);
		$loggedInUserID = $roleId = '';
        $user = \Auth::user();  
       
        if($request->ajax()){  
            $validator = \Validator::make($request->all(), [
                'activities' => 'sometimes|required',
                'aspirations' => 'sometimes|required',
                'notes' => 'sometimes|required',
                'firstname' => 'sometimes|required',
                'availability' => 'sometimes|required',
                'manager' => 'sometimes|required',
                'designation' => 'sometimes|required|max:255',
            ]);
            
            if ($validator->fails())
            {
               
                $response["type"] = "error";
                $response["errors"] = $validator->errors()->all();
                $response["keys"] = $validator->errors()->keys();
            }else{
                $user_id = auth()->user()->id; 
                $user->updateUserProfile($user_id,$request);
                $userData = $user->getUserProfileDataById($user_id);  //prd($userData);
                $response["type"] = "success"; 
                $response["res_data"] = $userData; 

                if($request->post('action_slug')=='activities'){
                        $response["success_html"] = view("users.profile.activities-section") //render view
                        ->with("users", $userData)
                        ->render();
                }
            }  
        }
        echo json_encode($response);
		exit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
	 * Show the manager dashboard.
	 */
	function dashboard(){
        return view('users.dashboard', compact([]));
    }
	
	
	function save_user_interests(ProfileRequest $request) {
		$response['status'] = false;
		if($request->ajax()){
			$user = \Auth::user();
			$terms = array();
			if(!empty($user)){
				$loggedInUserID = $user->id;
				$action = $request->post('action');
				if($action == 1) {
					$skills = $request->post('skills');
				} else {
					$skills = $request->post('focus');
				}	
				if($skills) {
					foreach($skills as $skill) {
						$chk_taxonomy_term = TaxonomyTerm::where('tid', '=', $skill)->where('vid', '=', $action)->count();
						if ($chk_taxonomy_term > 0) {
							$chkskill = UserInterest::where('tid', '=', $skill)->where('vid', '=', $action)->where('user_id', '=', $loggedInUserID)->first();							
							if ($chkskill === null) {
								$pdata = array(
									'tid' => $skill,
									'vid' => $action,
									'user_id' => $loggedInUserID
								);
								UserInterest::create($pdata);
							}
							$terms[] = $skill;
						} else {
							$chkskill = TaxonomyTerm::where('name', '=', $skill)->where('vid', '=', $action)->first();
							if ($chkskill === null) {
								$taxmony_data = array(
									'vid' => $action,
									'name' => $skill,
									'description' => $skill,
									'status' => 1
								);
								$term_id = TaxonomyTerm::create($taxmony_data);
								if($term_id->tid > 0) {
									$pdata = array(
										'tid' => $term_id->tid,
										'vid' => $action,
										'user_id' => $loggedInUserID
									);
									UserInterest::create($pdata);
								}
								$terms[] = $term_id->tid;
							} else {
								TaxonomyTerm::where('tid', '=', $chkskill->tid)->update(['status' => 1]);
								$chskill = UserInterest::where('tid', '=', $chkskill->tid)->where('user_id', '=', $loggedInUserID)->first();							
								if ($chskill === null) {
									$pdata = array(
										'tid' => $chkskill->tid,
										'vid' => $action,
										'user_id' => $loggedInUserID
									);
									UserInterest::create($pdata);
								}
								$terms[] = $chkskill->tid;
							}
						}
					}
					$user_taxonomy = TaxonomyTerm::where('vid',$action)->get()->toArray();
					if($user_taxonomy) {
						foreach($user_taxonomy as $taxonomy) {
							$terms_taxonomy[] = $taxonomy['tid'];
						}
					}					
					$result = array_diff($terms_taxonomy, $terms);
					if($result) {
						UserInterest::where('user_id',$loggedInUserID)->whereIn('tid',$result)->delete();
					}
					$user_interest = UserInterest::with(["term_data"])->where('user_id',$loggedInUserID)->where('vid',$action)->get()->toArray();
					if($user_interest) {
						$term_data = [];
						foreach($user_interest as $interest) {
							if($interest['term_data']) {
								$term_data[] = $interest['term_data'];
							}
						}	
						$response['status'] = true;					
						$response['term_data'] = $term_data;
					}
				} else {
					$response['status'] = false;
					$response['term_data'] = array();
				}
			} else {
				$response['status'] = false;
				$response['term_data'] = array();
			}
		}
		return json_encode($response);
	}
	
	function save_user_profile(ProfileRequest $request) {
		$response['status'] = false;
		if($request->ajax()){
			$user = \Auth::user();
			$terms = array();
			if(!empty($user)){
				$loggedInUserID = $user->id;
				$action = $request->post('action');
				if(!empty($action)) {
					$chk_profile = UserProfile::where('user_id', '=', $loggedInUserID)->first();	
					switch($action) {
						case 'activity':
							$details = $request->post('activity');						
							if ($chk_profile === null) {
								UserProfile::insert(['user_id' => $loggedInUserID, 'activities' => $details]);	
							} else {
								UserProfile::where('user_id', '=', $loggedInUserID)->update(['activities' => $details]);
							}
							$response['details'] = $request->post();
						break;
						case 'certificate':
							$details = $request->post('certificate');							
							if ($chk_profile === null) {
								UserProfile::insert(['user_id' => $loggedInUserID, 'certificate' => $details]);	
							} else {
								UserProfile::where('user_id', '=', $loggedInUserID)->update(['certificate' => $details]);
							}	
							$response['details'] = $request->post();
						break;
						case 'profile':
							$details = $request->post();
							$details['image_name'] = '';
								if($profile_image = $request->file('profile_images')){
									if($chk_profile !== null && isset($chk_profile->image_name)) {
										if (Storage::disk('public_uploads')->exists($chk_profile->image_name)){
											Storage::disk('public_uploads')->delete($chk_profile->image_name);
											Storage::disk('public_uploads')->delete('thumbnail/'.$chk_profile->image_name);
										}
									}
									$file_name =  substr(preg_replace('/[^a-zA-Z0-9\']/', '', $profile_image->getClientOriginalName()),0,10);
									$ext = pathinfo($profile_image->getClientOriginalName(), PATHINFO_EXTENSION);
									$filename = $file_name . "_" . time() . "." . $ext;
									//$profile_image->move(public_path('uploads'), $filename);
									Storage::disk('public_uploads')->put($filename,file_get_contents($profile_image));
									$height = Image::make($profile_image)->height();
									$width = Image::make($profile_image)->width();
									$this->resizeImage($filename,'thumbnail');
									
									$details['image_name'] = Storage::disk('public_uploads')->url('/thumbnail/'.$filename);
								} else {
									 $users = $user->getUserProfileDataById($loggedInUserID);
									 $filename = $users->img_name;
									  if(!empty($filename)) {
										$details['image_name'] = Storage::disk('public_uploads')->url('/thumbnail/'.$filename);
									 }
								}						
							if ($chk_profile === null) {
								UserProfile::insert(['user_id' => $loggedInUserID, 'image_name' => $filename, 'designation' => $details['designation'],'department' => $details['dept'],'aspirations' => $details['aspirations'],'availability' => $details['availability'],'about' => $details['about'],'manager' => $details['manager']]);
								User::where('id', '=', $loggedInUserID)->update(['firstName' => $details['uname']]);	
							} else {		
								UserProfile::where('user_id', '=', $loggedInUserID)->update(['image_name' => $filename, 'designation' => $details['designation'],'department' => $details['dept'],'aspirations' => $details['aspirations'],'availability' => $details['availability'],'about' => $details['about'],'manager' => $details['manager']]);
								User::where('id', '=', $loggedInUserID)->update(['firstName' => $details['uname']]);
							}	
							 $response['details'] = $details;	
						break;
					}
					$response['status'] = true;			
				}
			}	
		}
		return json_encode($response);
	}
	
}
