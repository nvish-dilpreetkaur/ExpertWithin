<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use App\Http\Requests\AddOpportunityRequest;
use App\Http\Requests\StoreOpportunityRequest;
use App\Models\Opportunity;
use App\Models\OpportunityTermsRelationship;
use App\Models\TaxonomyTerm;
use App\Models\Feed;
use App\Models\OpportunityUser;
use App\Models\OpportunityUserActions;
use App\Models\OpportunityInvites;
use App\Models\UserComment;
use App\Models\Notification;
use App\User;
use App\UserInterest;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;

class OpportunityController extends Controller
{

    /**
     * Constructor
     *
     * @param OpportunityRepository $opportunityRepository
     * @param OpportunityTransformer $opportunityTransformer
     */
    public function __construct()
    {
        //parent::__construct();
        $this->opportunity = new Opportunity();
        $this->taxonomyterm = new TaxonomyTerm();
        $this->user_comment = new UserComment();
		$this->user = new User();
    }

    /**
     * Display a list of opportunity.
     * @param  none
     * @return Response
     */
    public function opportunities()
    {

        return view('opportunity.opportunity-list');
    }

    /**
     * To show a form to create a new opportunity.
     * @param  Request
     * @return Response
     */
    protected function formOpportunity(Request $request, $id = "")
    {
        $user = new User;
        $user_id = auth()->user()->id;

        $opportunity_form_action = route('new-opportunity');
        $opportunity_page_title = "Create Opportunity";
        $opportunity_page_action = "add";
        $opportunity_data = array();
        $opportunity_skills_vid = config('kloves.SKILL_AREA');
        $opportunity_focus_areas_vid = config('kloves.FOCUS_AREA');
        $opportunity_locations_vid = config('kloves.LOCATION_AREA');
        $location_options = $this->taxonomyterm->getTaxonomyTermDataByVid($opportunity_locations_vid);
        $skill_options = $this->taxonomyterm->getTaxonomyTermDataByVid($opportunity_skills_vid);
        $focus_area_options = $this->taxonomyterm->getTaxonomyTermDataByVid($opportunity_focus_areas_vid);
        // $managers = User::where('role', config('kloves.ROLE_MANAGER'))->select('firstName AS mname', 'id')->orderBy('firstName')->get();
        $managers = $user->getManagerDdlList();
        if ($id) {
            $id = Crypt::decrypt($id);
            $opportunity_exists = Opportunity::find($id);
            if ($opportunity_exists) {

                $opportunity_array = $this->opportunity->opportunity_list($id);
                $opportunity_data = $opportunity_array[0];
                $opportunity_form_action = route('update-opportunity', ['id' => $id]);
                $opportunity_page_title = "Update Opportunity";
                $opportunity_page_action = "update";
            }
        }
        $data = [
            'skill_options' => $skill_options,
            'focus_area_options' => $focus_area_options,
            'location_options' => $location_options,
            'opportunity_data' => $opportunity_data,
            'opportunity_form_action' => $opportunity_form_action,
            'opportunity_page_title' => $opportunity_page_title,
            'opportunity_page_action' => $opportunity_page_action,
            'managers' => $managers,
        ];
        return view('opportunity.opportunity-form')->with($data);
    }

    protected function addOpportunity(AddOpportunityRequest $request)
    {
        try {
            $opportunity = Opportunity::create([
                'opportunity' => $request->post('otitle'),
                'opportunity_desc' => $request->post('odesc'),
                'status' => Config::get("constants.INACTIVE_STATUS"),
                'org_uid' => auth()->user()->id,
                'org_id' => auth()->user()->org_id,
            ]);
            $oid = $opportunity->id;
            $result = array('status' => true, "oid" => $oid, "enc_oid" => Crypt::encrypt($oid));
            return response()->json($result, Config::get('constants.STATUS_OK'));
        } catch (Exception $e) {
            $result = array('status' => false, "message" => $e->getMessage());
            return response()->json($result, Config::get('constants.STATUS_OK'));
        }
    }

    protected function createOpportunity($oid)
    {
        $oid = Crypt::decrypt($oid);
        $opportunityData = Opportunity::with("user_actions","creator","creator.profile")
        ->where("id", $oid)->first();
        if($opportunityData->status == config('kloves.RECORD_STATUS_ACTIVE')) {
            header('Location: '. route('published-opportunity', Crypt::encrypt($oid)) );
        }

        $selectedSkills = OpportunityTermsRelationship::where('oid', $oid)->where("vid", config('kloves.SKILL_AREA'))->pluck('tid')->toArray();

        $selectedFocusAr = OpportunityTermsRelationship::where('oid', $oid)->where("vid", config('kloves.FOCUS_AREA'))->pluck('tid')->toArray();

        $skillsData = TaxonomyTerm::select(["tid", "name"])
            ->where("vid", config('kloves.SKILL_AREA'))
            ->where("status", config('kloves.RECORD_STATUS_ACTIVE'))
            ->get();

        $focusAreaData = TaxonomyTerm::select(["tid", "name"])
            ->where("vid", config('kloves.FOCUS_AREA'))
            ->where("status", config('kloves.RECORD_STATUS_ACTIVE'))
            ->get();

        $oppForCanFilters = [];
        $oppForCanFilters['loggedUserID'] = auth()->user()->id;
        $myOppForCandidates = $this->opportunity->myOppForCandidates($oppForCanFilters);

        
        $usersApplied = OpportunityUser::select(["oid", "org_uid", "approve"])
            ->with("user_details", "profile_image")
            ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where("oid", $oid)
            ->orderBy("created_at", "DESC")
            ->get()->toArray();

        $data = array(
            "opportunity" => $opportunityData,
            "skills" => $skillsData,
            "focusArea" => $focusAreaData,
            "selectedSkills" => $selectedSkills,
            "selectedFocusAr" => $selectedFocusAr,
            "myOppForCandidates" => $myOppForCandidates,
            "usersApplied" => $usersApplied,
            "encryptOid" => Crypt::encrypt($oid)
        );
        return view('opportunity.create', $data);
    }

    protected function storeDraftOpportunity(Request $request) {
        $result = $this->saveOpportunity($request);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function storeOpportunity(StoreOpportunityRequest $request)
    {
        $result = $this->saveOpportunity($request);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function saveOpportunity(Request $request) {
        $opportunity = array(
            "opportunity" => $request->post('otitle'),
            "opportunity_desc" => $request->post('odesc'),
            "incentives" => $request->post('incentives'),
            "rewards" => $request->post('rewards'),
            "tokens" => $request->post('tokens'),
            "expert_qty" => $request->post("oexperts"),
            "expert_hrs" => $request->post("oexperts_hrs"),
            "start_date" => $request->post('start_date'),
            "end_date" => $request->post('end_date'),
            "apply_before" => $request->post('apply_before'),
            'org_uid' => auth()->user()->id,
            'org_id' => auth()->user()->org_id,
            'status' => $request->post('status')
        );
        Opportunity::where("id", $request->post('oid'))->update($opportunity);

        
        OpportunityTermsRelationship::where("oid", $request->post('oid'))->delete();

        if($request->has("skills")) {
            foreach($request->post("skills") as $skill) {
                $chk_taxonomy_term = TaxonomyTerm::where('tid', '=', $skill)->where('vid', '=', config('kloves.SKILL_AREA'))->count();
                if ($chk_taxonomy_term > 0) {
                    $skillInsArr = array(
                        "oid" => $request->post('oid'),
                        "vid" => config('kloves.SKILL_AREA'),
                        "tid" => $skill,
                    );
                    OpportunityTermsRelationship::create($skillInsArr);
                } else {
                    $chkskill = TaxonomyTerm::where('name', '=', $skill)->where('vid', '=',  config('kloves.SKILL_AREA'))->first();
                    if ($chkskill === null) {
                        $taxmony_data = array(
                                'vid' => config('kloves.SKILL_AREA'),
                                'name' => $skill,
                                'description' => $skill,
                                'status' => 1
                        );
                        $term_id = TaxonomyTerm::create($taxmony_data);
                        if($term_id->tid > 0) {
                            $skillInsArr = array(
                            "oid" => $request->post('oid'),
                            "vid" => config('kloves.SKILL_AREA'),
                            "tid" => $term_id->tid,
                        );
                        OpportunityTermsRelationship::create($skillInsArr);
                        }
                    } else {
                        $skillInsArr = array(
                            "oid" => $request->post('oid'),
                            "vid" => config('kloves.SKILL_AREA'),
                            "tid" => $chkskill->tid,
                        );
                        OpportunityTermsRelationship::create($skillInsArr);
                    }
                }
            }
        }

        if($request->has("focus_area")) {
            foreach($request->post("focus_area") as $focusAr) {
                $chk_taxonomy_term = TaxonomyTerm::where('tid', '=', $focusAr)->where('vid', '=', config('kloves.FOCUS_AREA'))->count();
                if ($chk_taxonomy_term > 0) {
                    $skillInsArr = array(
                        "oid" => $request->post('oid'),
                        "vid" => config('kloves.FOCUS_AREA'),
                        "tid" => $focusAr,
                    );
                    OpportunityTermsRelationship::create($skillInsArr);
                } else {
                    $chkskill = TaxonomyTerm::where('name', '=', $focusAr)->where('vid', '=',  config('kloves.FOCUS_AREA'))->first();
                    if ($chkskill === null) {
                        $taxmony_data = array(
                                'vid' => config('kloves.FOCUS_AREA'),
                                'name' => $focusAr,
                                'description' => $focusAr,
                                'status' => 1
                        );
                        $term_id = TaxonomyTerm::create($taxmony_data);
                        if($term_id->tid > 0) {
                            $skillInsArr = array(
                                "oid" => $request->post('oid'),
                                "vid" => config('kloves.FOCUS_AREA'),
                                "tid" => $term_id->tid,
                            );
                            OpportunityTermsRelationship::create($skillInsArr);
                        }
                    } else {
                        $skillInsArr = array(
                            "oid" => $request->post('oid'),
                            "vid" => config('kloves.FOCUS_AREA'),
                            "tid" => $chkskill->tid,
                        );
                        OpportunityTermsRelationship::create($skillInsArr);
                    }
                }
            }
        }

        if($request->post('status')==1) {
            $feedInsArr = array(
                "feed_type" => config('kloves.FEED_TYPE_NEW_OPP'),
                "key_id" => $request->post('oid'),
                "org_id" => auth()->user()->org_id,
                "status" => config('kloves.RECORD_STATUS_ACTIVE'),
                "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
                "updated_at" => \Carbon\Carbon::now()->toDateTimeString(),
            );
            Feed::updateOrCreate(
            ['key_id' => $request->post('oid')], 
            $feedInsArr
            );

            /**
             * add notification : start
             * When Opportunity related to someone's skills/focus area is published.
             */
            $relTid = array_merge($request->post("focus_area"), $request->post("skills"));
            $userIds = UserInterest::select(["user_id"])
                ->whereHas('user_details', function($q2)
                {
                    $q2->where('users.status', '=', config('kloves.RECORD_STATUS_ACTIVE'))
                    ->where("users.id", "!=", \Auth::user()->id);
                })
                ->whereIn('tid', $relTid)
                ->distinct('user_id')->get();
            foreach($userIds as $user) {
                $notification_data['type_of_notification'] = config('kloves.NOTI_RELATED_OPOR');
                $notification_data['key_value'] = $request->post('oid');
                $notification_data['sender_id'] = auth()->user()->id;
                $notification_data['recipient_id'] = $user->user_id;
                $notification_data['status'] = config('kloves.RECORD_STATUS_ACTIVE');
                Notification::insert($notification_data);
            }
            /** add notification : end */

        }

        $opportunity["frmt_start_date"] = date_format(date_create($opportunity["start_date"]),"M d, Y");
        $opportunity["frmt_end_date"] = date_format(date_create($opportunity["end_date"]),"M d, Y");
        $opportunity["frmt_apply_before"] = date_format(date_create($opportunity["apply_before"]),"M d, Y");
        $result = array(
          'status' => true,
          "opportunity" => $opportunity,
          "select_skills" => $request->post("skills"),
          "select_focus_area" => $request->post("focus_area"),
        );
        return $result;
    }

    protected function publishedOpportunity($oid, Request $request) {
        $oid = Crypt::decrypt($oid); //prd($oid);
        $opportunityData = Opportunity::with("user_actions","creator","creator.profile")
        ->where("id", $oid)->first();
//prd($opportunityData->creator);
        $selectedSkills = OpportunityTermsRelationship::where('oid', $oid)->where("vid", config('kloves.SKILL_AREA'))->pluck('tid')->toArray();

        $selectedFocusAr = OpportunityTermsRelationship::where('oid', $oid)->where("vid", config('kloves.FOCUS_AREA'))->pluck('tid')->toArray();

        $skillsData = TaxonomyTerm::select(["tid", "name"])
            ->where("vid", config('kloves.SKILL_AREA'))
            ->where("status", config('kloves.RECORD_STATUS_ACTIVE'))
            ->get();

        $focusAreaData = TaxonomyTerm::select(["tid", "name"])
            ->where("vid", config('kloves.FOCUS_AREA'))
            ->where("status", config('kloves.RECORD_STATUS_ACTIVE'))
            ->get();

        $usersApplied = OpportunityUser::select(["oid", "org_uid", "approve"])
            ->with("user_details", "profile_image")
            ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where("oid", $oid)
            ->orderBy("created_at", "DESC")
            ->get()->toArray();
         if($usersApplied)  {
			foreach($usersApplied as $key =>$applied) {
				$user_id = $applied['org_uid'];
				$usersApplied[$key]['comment_count'] = UserComment::where(function ($q) use($user_id) {
					$q->where('user_id', $user_id)->orWhere('to_id', $user_id);
				})->where('org_id',$oid)->count();
			}
		}   

        $usersApproved = OpportunityUser::select(["oid", "org_uid", "approve"])
            ->with("user_details", "profile_image")
            ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where("approve", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where("oid", $oid)
            ->orderBy("created_at", "DESC")
            ->get()->toArray();
            
        if($usersApproved)  {
			foreach($usersApproved as $key =>$approved) {
				$user_id = $applied['org_uid'];
				$usersApproved[$key]['comment_count'] = UserComment::where(function ($q) use($user_id) {
					$q->where('user_id', $user_id)->orWhere('to_id', $user_id);
				})->where('org_id',$oid)->count();
			}
		}      

        $selectedRecoIds = array_merge($selectedSkills,$selectedFocusAr);

        /** get opportunity already invited user list */
        $alreadyInvitedUsers = OpportunityInvites::where('opp_id', $oid)->where("status", config('kloves.RECORD_STATUS_ACTIVE'))->pluck('user_id')->toArray(); 
        
        $recommendations = UserInterest::select(["user_id"])
            ->with([
                "profile_image",
                "user_details" => function($query){
                      $query->where('status', '=', config('kloves.RECORD_STATUS_ACTIVE'));
             }])
             ->whereHas('user_details', function($q2)
             {
                 $q2->where('users.status', '=', config('kloves.RECORD_STATUS_ACTIVE'))
                    ->where("users.id", "!=", \Auth::user()->id);
             })
            ->where(function ($query) use ($selectedRecoIds) {
                $query->whereIn('tid', $selectedRecoIds);
            })
            // ->orWhere(function ($query) use ($selectedFocusAr) {
            //     $query->whereIn('tid', $selectedFocusAr)
            //         ->where('vid', 3);
            // })
            ->distinct('user_id')->limit(28)->get()->toArray();
			//prd($recommendations);
		
		if($recommendations)  {
			foreach($recommendations as $key =>$recommend) {
				$user_id = $recommend['user_id'];
				$recommendations[$key]['comment_count'] = UserComment::where(function ($q) use($user_id) {
					$q->where('user_id', $user_id)->orWhere('to_id', $user_id);
				})->where('org_id',$oid)->count();
			}
		}  	
			
		/** share user list */
        $shareUserList['all'] = $this->user->where('status','=',config('kloves.RECORD_STATUS_ACTIVE'))->where('id', '<>', \Auth::user()->id)->select('id','firstName')->get()->toArray(); 
        $shareUserJsonList = json_encode($shareUserList['all']);    // prd($shareUserList['all']);
            
        /** share user list for opp-invites */
         $inviteUserList =  User::select(["id","firstName"])
            ->where("status", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where(function ($query) use ($alreadyInvitedUsers) {
                $query->whereNotIn('id', $alreadyInvitedUsers);
            })
			->where('id', '<>', \Auth::user()->id)
            ->orderBy("firstName", "ASC")
            ->get()->toArray(); //prd($inviteUserList);
        $inviteUserJSONList = json_encode($inviteUserList); 

        $prevOpportunity = Opportunity::select(["id"])
            ->where("id","<",$oid)->where("status",1)
            ->orderBy("id", "DESC");
        if($prevOpportunity->count()>0) {
            $prevOpportunity = $prevOpportunity->first()->toArray();
        } else {
            $prevOpportunity = array();
        }
            

        $nextOpportunity = Opportunity::select(["id"])
            ->where("id",">",$oid)->where("status",1)
            ->orderBy("id", "ASC");
        if($nextOpportunity->count()>0) {
            $nextOpportunity = $nextOpportunity->first()->toArray();
        } else {
            $nextOpportunity = array();
        }
        
        $data = array(
            "opportunity" => $opportunityData,
            "skills" => $skillsData,
            "focusArea" => $focusAreaData,
            "selectedSkills" => $selectedSkills,
            "selectedFocusAr" => $selectedFocusAr,
            "usersApplied" => $usersApplied,
            "usersApproved" => $usersApproved,
            "recommendations" => $recommendations,
            "encryptOid" => Crypt::encrypt($oid),
            "shareUserJsonList" => $shareUserJsonList,
            "inviteUserJSONList" => $inviteUserJSONList,
            "alreadyInvitedUsers" => $alreadyInvitedUsers,
            "prevOpportunity" => (isset($prevOpportunity["id"]) && !empty($prevOpportunity["id"]))?Crypt::encrypt($prevOpportunity["id"]):"",
            "nextOpportunity" => (isset($nextOpportunity["id"]) && !empty($nextOpportunity["id"]))?Crypt::encrypt($nextOpportunity["id"]):"",
        );
        
        return view('opportunity.published', $data);
    }

    protected function draftOpportunity($oid) {
        Opportunity::where("id", $oid)->update(array("status"=>config('kloves.RECORD_STATUS_INACTIVE')));
        Feed::where("key_id", $oid)->update(array("status"=>config('kloves.RECORD_STATUS_INACTIVE')));

        OpportunityUser::where("oid", $oid)->update(array("apply"=> 0));

        $result = array('status' => true);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function cancelOpportunity($oid) {
        Opportunity::where("id", $oid)->update(array("status"=> 3));
        Feed::where("key_id", $oid)->update(array("status"=>config('kloves.RECORD_STATUS_INACTIVE')));

        OpportunityUser::where("oid", $oid)->update(array("approve"=> config('kloves.OPP_APPLY_CANCELLED')));

        $result = array('status' => true);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function approveOpportunity(Request $request) {
        $oid = $request->post("oid");
        $org_uid = $request->post("org_uid");

        OpportunityUser::where("oid", $oid)
                ->where("org_uid", $org_uid)
                ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
                ->update(["approve" => config('kloves.RECORD_STATUS_ACTIVE')]);

        OpportunityUserActions::create([
            "oid" => $oid,
            "applicant_id" => $org_uid,
            "action_status" => 1,
            "approver_id" => auth()->user()->id,
            "org_id" => auth()->user()->org_id
        ]);

        $userData = User::select(["firstName", "id"])
            ->with("profile_image")
            ->where("id", $org_uid)
            ->first();

        $result = array('status' => true, 'userData' => $userData);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function disapproveOpportunity(Request $request) {
        $oid = $request->post("oid");
        $org_uid = $request->post("org_uid");

        OpportunityUser::where("oid", $oid)
                ->where("org_uid", $org_uid)
                ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
                ->update(["approve" => 2]);

        OpportunityUserActions::create([
            "oid" => $oid,
            "applicant_id" => $org_uid,
            "action_status" => 2,
            "approver_id" => auth()->user()->id,
            "org_id" => auth()->user()->org_id
        ]);

        $result = array('status' => true);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function dismissOpportunity(Request $request) {
        $oid = $request->post("oid");
        $org_uid = $request->post("org_uid");

        OpportunityUser::where("oid", $oid)
                ->where("org_uid", $org_uid)
                ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
                ->update(["approve" => 0]);

        OpportunityUserActions::create([
            "oid" => $oid,
            "applicant_id" => $org_uid,
            "action_status" => 0,
            "approver_id" => auth()->user()->id,
            "org_id" => auth()->user()->org_id
        ]);

        $result = array('status' => true);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function startOpportunity($oid) {
        Opportunity::where("id", $oid)->update(array("job_start_date"=> Carbon::now()));

        $result = array('status' => true);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    protected function completeOpportunity($oid) {
        Opportunity::where("id", $oid)->update(array("job_complete_date"=> Carbon::now()));

        /** add notification : start */
        // $notification_data['type_of_notification'] = config('kloves.NOTI_OPOR_COMPLETED');
        // $notification_data['key_value'] = $oid;
        // $notification_data['sender_id'] = auth()->user()->id;
        // $notification_data['recipient_id'] = auth()->user()->id;
        // $notification_data['status'] = config('kloves.RECORD_STATUS_ACTIVE');
        // Notification::insert($notification_data);
        /** add notification : end */

        $result = array('status' => true);
        return response()->json($result, Config::get('constants.STATUS_OK'));
    }

    /**
     * Create a new opportunity instance after a valid data.
     * @param  Request
     * @return Response
     */
    protected function createOpportunityOld(Request $request)
    {
        $this->validate($request, [
            'opportunity' => 'required|max:250',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'apply_before' => 'required|after_or_equal:start_date|before:end_date',
            'rewards' => 'required|max:1000',
            'opportunity_desc' => 'required|max:1000',
            'focus_area' => 'required|array',
            'skills' => 'required|array',
            'locations' => 'required|array',
            'org_uid' => 'required',
        ]);

        $oppStatus = ($request['submit'] == 'draft') ? config('kloves.OPP_APPLY_NEW') : config('kloves.OPP_APPLY_APPROVED');
        $opportunity = Opportunity::create([
            'opportunity' => $request['opportunity'],
            'opportunity_desc' => $request['opportunity_desc'],
            'rewards' => $request['rewards'],
            'org_uid' => (!empty($request['org_uid'])) ? $request['org_uid'] : auth()->user()->id,
            'org_id' => auth()->user()->org_id,
            'department_id' => 1,
            'status' => $oppStatus,
            'start_date' => date('Y-m-d', strtotime($request['start_date'])),
            'end_date' => date('Y-m-d', strtotime($request['end_date'])),
            'apply_before' => date('Y-m-d', strtotime($request['apply_before'])),
        ]);

        $oid = $opportunity->id;
        if (!empty($request['skills'])) {
            $opportunity_skills_vid = config('kloves.SKILL_AREA');
            foreach ($request['skills'] as $skill) {
                OpportunityTermsRelationship::create([
                    'oid' => $oid,
                    'vid' => $opportunity_skills_vid,
                    'tid' => $skill,
                ]);

            }
        }
        if (!empty($request['focus_area'])) {
            $opportunity_focus_areas_vid = config('kloves.FOCUS_AREA');
            foreach ($request['focus_area'] as $focus_area) {
                OpportunityTermsRelationship::create([
                    'oid' => $oid,
                    'vid' => $opportunity_focus_areas_vid,
                    'tid' => $focus_area,
                ]);
            }
        }
        if (!empty($request['locations'])) {
            $opportunity_location_vid = config('kloves.LOCATION_AREA');
            foreach ($request['locations'] as $location) {
                OpportunityTermsRelationship::create([
                    'oid' => $oid,
                    'vid' => $opportunity_location_vid,
                    'tid' => $location,
                ]);
            }
        }
        return redirect('opportunities')->with('success', 'Opportunity created successfully.');
    }

    /**
     * Update opportunity instance after a valid data.
     * @param  Request
     * @return Response
     */
    protected function updateOpportunity(Request $request, $id)
    {

        $this->validate($request, [
            'opportunity' => 'required|max:250',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'apply_before' => 'required|after_or_equal:start_date|before:end_date',
            'rewards' => 'required|max:1000',
            'opportunity_desc' => 'required|max:1000',
            'focus_area' => 'required|array',
            'skills' => 'required|array',
            'locations' => 'required|array',
            'org_uid' => 'required',
        ]);
        $opportunity = Opportunity::find($id);
        if ($opportunity) {
            $oppStatus = ($request['submit'] == 'draft') ? config('kloves.OPP_APPLY_NEW') : config('kloves.OPP_APPLY_APPROVED');

            $opportunity_skills_vid = config('kloves.SKILL_AREA');
            $opportunity_focus_areas_vid = config('kloves.FOCUS_AREA');
            $opportunity_location_vid = config('kloves.LOCATION_AREA');
            $opportunity->opportunity = $request['opportunity'];
            $opportunity->opportunity_desc = $request['opportunity_desc'];
            $opportunity->rewards = $request['rewards'];
            $opportunity->org_uid = (!empty($request['org_uid'])) ? $request['org_uid'] : auth()->user()->id;
            $opportunity->org_id = auth()->user()->org_id;
            $opportunity->department_id = 1;
            $opportunity->status = $oppStatus;
            $opportunity->start_date = date('Y-m-d', strtotime($request['start_date']));
            $opportunity->end_date = date('Y-m-d', strtotime($request['end_date']));
            $opportunity->apply_before = date('Y-m-d', strtotime($request['apply_before']));
            $opportunity->save();
            if (!empty($request['skills'])) {
                $skills = $request['skills'];
                $opp_skills_array = array();
                $opp_skills_exist = OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_skills_vid)->get('tid')->toArray();
                foreach ($opp_skills_exist as $opp_skill_exist) {
                    $opp_skills_array[] = $opp_skill_exist['tid'];
                }
                $delete_skill_ids = array_diff($opp_skills_array, $skills);
                if ($delete_skill_ids) {
                    OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_skills_vid)->whereIn('tid', $delete_skill_ids)->delete();
                }
                $new_skills_data = array();
                foreach ($skills as $skill_id) {
                    if (!in_array($skill_id, $opp_skills_array)) {
                        $new_skills_data[] = array(
                            'oid' => $id,
                            'vid' => $opportunity_skills_vid,
                            'tid' => $skill_id,
                        );
                    }
                }
                if ($new_skills_data) {
                    OpportunityTermsRelationship::insert($new_skills_data);
                }
            } else {
                OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_skills_vid)->delete();
            }
            if (!empty($request['focus_area'])) {
                $focus_areas = $request['focus_area'];
                $opp_focus_array = array();
                $opp_focus_areas_exist = OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_focus_areas_vid)->get('tid')->toArray();
                foreach ($opp_focus_areas_exist as $opp_focus_area_exist) {
                    $opp_focus_array[] = $opp_focus_area_exist['tid'];
                }
                $delete_focus_ids = array_diff($opp_focus_array, $focus_areas);
                if ($delete_focus_ids) {
                    OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_focus_areas_vid)->whereIn('tid', $delete_focus_ids)->delete();
                }
                $new_focus_areas = array();
                foreach ($focus_areas as $focus_area) {
                    if (!in_array($focus_area, $opp_focus_array)) {
                        $new_focus_areas[] = array(
                            'oid' => $id,
                            'vid' => $opportunity_focus_areas_vid,
                            'tid' => $focus_area,
                        );
                    }
                }
                if ($new_focus_areas) {
                    OpportunityTermsRelationship::insert($new_focus_areas);
                }
            } else {
                OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_focus_areas_vid)->delete();
            }
            if (!empty($request['locations'])) {
                $locations = $request['locations'];
                $opp_locations_array = array();
                $opp_locations_exist = OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_location_vid)->get('tid')->toArray();
                foreach ($opp_locations_exist as $opp_location_exist) {
                    $opp_locations_array[] = $opp_location_exist['tid'];
                }
                $delete_focus_ids = array_diff($opp_locations_array, $locations);
                if ($delete_focus_ids) {
                    OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_location_vid)->whereIn('tid', $delete_focus_ids)->delete();
                }
                $new_locations = array();
                foreach ($locations as $location) {
                    if (!in_array($location, $opp_locations_array)) {
                        $new_locations[] = array(
                            'oid' => $id,
                            'vid' => $opportunity_location_vid,
                            'tid' => $location,
                        );
                    }
                }
                if ($new_locations) {
                    OpportunityTermsRelationship::insert($new_locations);
                }
            } else {
                OpportunityTermsRelationship::where('oid', $id)->where('vid', $opportunity_location_vid)->delete();
            }
            return redirect('opportunities')->with('success', 'Opportunity updated successfully.');
        } else {
            return redirect('create-opportunity');
        }
    }
    /**
     * delete opportunity.
     * @param  Request
     * @return Response
     */
    protected function deleteOpportunity(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $opportunity = Opportunity::find($id);
        if ($opportunity) {
            Opportunity::where('id', $id)->update(array('status' => 2));

        }
        return redirect('opportunities')->with('success', 'Opportunity deleted successfully.');
    }
      /**
     * View opportunity detail page.
     * @param  id
     * @return Response
     */
    public function view($id = null)
    {
        $loggedInUserID = $roleId = '';
        $topMatchedFilter = [];
        $user = \Auth::user();
        if (!empty($user)) {
            $loggedInUserID = $user->id;
            $roleId = $user->role;
            $topMatchedFilter['loggedUserID'] = $loggedInUserID;
        }
        if ($id) {
            $id = Crypt::decrypt($id);

            //$oppData = DB::table('org_opportunity')->where('id',$id)->first();
            $filters['id'] = $id;
            $filters['loggedInUserID'] = $loggedInUserID;
            $opportunity_data = $this->opportunity->getOpportunityDetailsByID($filters);
            $youMayLikeOppFilter['loggedUserID'] = $loggedInUserID;
            $youMayLikeOppFilter['doNotIncludeList'] = $id;
            $youMayLikeOppFilter['limit'] = 2;
            $youMayLikeOpp = $this->opportunity->getYouMayLikeOpportunities($youMayLikeOppFilter); 
			
			$status = config('kloves.RECORD_STATUS_ACTIVE');
            $shareUserList['all'] = $this->user->where('status','=', $status)->where('id', '<>', $loggedInUserID)->select('id','firstName')->get()->toArray(); 
            $shareUserJsonList = json_encode($shareUserList['all']);
            
        }

        $page_title = "Opportunity Details";

        return view('opportunity.view', compact(['opportunity_data','youMayLikeOpp','shareUserJsonList']));
    }
	
	

    /**
	 * render opporutnity invite external view
	 * @param  Request
	 * @return Response
	*/
	public function opportunityInviteView(Request $request,$id = null){
		$response = array( 
			"type" => NULL,
			"errors" => NULL,
			"message" => NULL,
		);
		$user_id = \Auth::user()->id;  
		$opp_id = Crypt::decrypt($id);
		//$share_type = $request->post('share_type');
		$status = config('kloves.RECORD_STATUS_ACTIVE');
		$page_title = "";
		$response["html"] = view('opportunity.common.opportunity-invite', compact(['opp_id']))->render();
		$response["type"] = "success";
		echo json_encode($response);
		exit();
    }
    

    
	/**
	 * post opporutnity invite
	 * @param  Request
	 * @return Response
	*/
	function opportunityInvite(Request $request)
	{  
	    $response = array( 
		  "type" => NULL,
		  "errors" => NULL,
		  "success_html" => NULL,
	    );
	    $loggedInUserID = $roleId = '';
	    $user = \Auth::user();  
	   
	    if($request->ajax()){ 
			
			 $messages = [
				    'checkedUsers.required' => 'Please choose atleast one expert', 
				];
			 
		  $validator = \Validator::make($request->all(), [
			'checkedUsers' => 'sometimes|required'
		  ],$messages);
		  
		  if ($validator->fails())
		  {
			$response["type"] = "error";
			$response["errors"] = $validator->errors()->all();
			$response["keys"] = $validator->errors()->keys();
		  }else{
            $user_id = auth()->user()->id; 
            if($request->post('action')=='SINGLE-INVITE'){
                $post_users[] = $request->post('user_id');
            }else{
                $post_users = explode(",",$request->post('checkedUsers')); //prd($request->post());
            }
            $opp_id = $request->post('opp_id'); 
            
			/** add 'invites' ... */
			$invite_post_multidata = []; $notification_multidata = [];
			$batch_id = time();
            $status = config('kloves.RECORD_STATUS_ACTIVE');
            $type_of_notification = config('kloves.NOTI_OPOR_INVITES');
			foreach($post_users as $ukey => $uval){ 
				$udata = $this->user->where('id', '=', $uval)->select('id','firstName','email')->first()->toArray();
				// prd($udata);

				$invite_post_multidata[$ukey]['batch_id'] = $batch_id;
				$invite_post_multidata[$ukey]['user_id'] = trim($uval);
				$invite_post_multidata[$ukey]['opp_id'] = $opp_id;
				$invite_post_multidata[$ukey]['status'] = $status;
				$invite_post_multidata[$ukey]['created_by'] = $user_id;

				/** add notification */
				$notification_multidata[$ukey]['type_of_notification'] = $type_of_notification;
				$notification_multidata[$ukey]['key_value'] = $opp_id;
				$notification_multidata[$ukey]['sender_id'] = $user_id;
				$notification_multidata[$ukey]['recipient_id'] = $uval;
				$notification_multidata[$ukey]['status'] = $status;

				/** @send_email : to notify */
				$sender_name  = auth()->user()->firstName;
				$emaildata['subject'] = $sender_name." has invited you to apply on an opportunity!";
				$emaildata['receiver_name'] = $udata['firstName']; 
				$emaildata['receiver_email'] = $udata['email'];
                $message = $sender_name.'  has invited you to apply on an opportunity.';
				$emaildata['message'] = $message;
				$emaildata['sender_name'] = $sender_name;
				$emaildata['sender_email'] = auth()->user()->email;
				$mailResponse =  send_email($emaildata);
				/** @send_email : to manager to notify ENDS*/
			}
			//prd($invite_post_multidata);
			DB::table('opportunity_invites')->insert($invite_post_multidata);
			DB::table('notifications')->insert($notification_multidata);

			$success_message = '<p>That\'s All</p><br> Thanks for inviting!';
			$response["success_html"] = view("common.thumbup-pop") //render view
			->with("success_message", $success_message)
			->render();
			$response["type"] = "success"; 
		  }  
	    }
	    echo json_encode($response);
	    exit();
	}
	
	public function get_user_comment(Request $request) {
		$response['status'] = false;
		if($request->ajax()){
			$user = \Auth::user();
			$terms = array();
			if(!empty($user)){
				$input = $request->post();
				$oid = $input['oid'];
				$to_id = $input['user_id'];
				$user_id = $user->id;
				$all_comments = UserComment::with(['users','users.profile'])->where(function ($q) use($to_id) {
					$q->where('user_id', $to_id)->orWhere('to_id', $to_id);
				})->where('org_id',$oid)->get()->toArray();
				if($all_comments) {
					$response["comments"] = view('opportunity.common.opp_comment',compact(['all_comments']))->render();
				}
				$response['status'] = true;	
			}
			
		}	
		return json_encode($response);
	}
	
	public function post_user_comment(Request $request) {
		$response['status'] = false;
		if($request->ajax()){
			$user = \Auth::user();
			$terms = array();
			if(!empty($user)){
				$input = $request->post();
				$pdata = array(
					'user_id' => $user->id,
					'to_id' => $input['user_id'],
					'org_id' => $input['oid'],
					'comment' => $input['comment']
				);
				UserComment::create($pdata);
				$to_id = $input['user_id'];
				$all_comments = UserComment::with(['users','users.profile'])->where(function ($q) use($to_id) {
					$q->where('user_id', $to_id)->orWhere('to_id', $to_id);
				})->where('org_id',$input['oid'])->get()->toArray();
				$response["cnt_comment"] = 0;
				if($all_comments) {
					$response["comments"] = view('opportunity.common.opp_comment',compact(['all_comments']))->render();
					$response["cnt_comment"] = count($all_comments);
				}
				$response['status'] = true;	
			}
			
		}	
		return json_encode($response);
	}


}
