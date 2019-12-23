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
use App\User;
use App\UserInterest;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
		$this->user = new User();
    }

    /**
     * Display a list of opportunity.
     * @param  none
     * @return Response
     */
    public function index()
    {

        if (request()->ajax()) {
            $filters = [];
            $filters['status'] = [0, 1]; //active
            $oppData = $this->opportunity->ajax_opportunity_list($filters); //dd($oppData);

            /*  return Datatables::of($posts)
            ->editColumn('title', '{!! str_limit($title, 60) !!}')
            ->editColumn('name', function ($model) {
            return \HTML::mailto($model->email, $model->name);
            })
            ->make(true); */
            return datatables()->of($oppData)
            //return datatables::->of($oppData)
                ->editColumn('opportunity', function ($oppData) {
                    $colName = 'opportunity';

                    $focus_areas = array();
                    $focus_area_options = $this->taxonomyterm->getTaxonomyTermDataByVid(config('kloves.FOCUS_AREA'));
                    foreach ($focus_area_options as $focus_area_option) {
                        $focus_areas[$focus_area_option->tid] = $focus_area_option->name;
                    }
                    return view('opportunity.datatable-col-view', compact('oppData', 'colName', 'focus_areas'));
                    //return (string)
                })
                ->addColumn('start_date', function ($oppData) {
                    $colName = 'start_date';
                    return (string) view('opportunity.datatable-col-view', compact('oppData', 'colName'));
                })
                ->addColumn('end_date', function ($oppData) {
                    $colName = 'end_date';
                    return (string) view('opportunity.datatable-col-view', compact('oppData', 'colName'));
                })
            /*->addColumn('apply_before', function($oppData) {
            $colName = 'apply_before';
            return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
            })*/
                ->addColumn('action', function ($oppData) {
                    $colName = 'action';
                    return (string) view('opportunity.datatable-col-view', compact('oppData', 'colName'));
                })
                ->rawColumns(['action', 'start_date', 'end_date', 'opportunity'])
                ->addIndexColumn()
                ->make(true);
        }
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
        $opportunityData = Opportunity::select([
            "id",
            "opportunity",
            "opportunity_desc",
            "incentives",
            "rewards",
            "tokens",
            "expert_qty",
            "expert_hrs",
            "start_date",
            "end_date",
            "apply_before",
            "status",
        ])->where("id", $oid)->first();

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
          );
          Feed::updateOrCreate(
            ['key_id' => $request->post('oid')], 
            $feedInsArr
          );
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
        $oid = Crypt::decrypt($oid);
        $opportunityData = Opportunity::select([
            "id",
            "opportunity",
            "opportunity_desc",
            "incentives",
            "rewards",
            "tokens",
            "expert_qty",
            "start_date",
            "end_date",
            "apply_before",
            "status",
        ])
        ->with("user_actions")
        ->where("id", $oid)->first();

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

        $usersApproved = OpportunityUser::select(["oid", "org_uid", "approve"])
            ->with("user_details", "profile_image")
            ->where("apply", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where("approve", config('kloves.RECORD_STATUS_ACTIVE'))
            ->where("oid", $oid)
            ->orderBy("created_at", "DESC")
            ->get()->toArray();

        $recommendations = UserInterest::select(["user_id"])
            ->with("user_details", "profile_image")
            ->where(function ($query) use ($selectedSkills) {
                $query->whereIn('tid', $selectedSkills)
                    ->where('vid', 1);
            })
            ->orWhere(function ($query) use ($selectedFocusAr) {
                $query->whereIn('tid', $selectedFocusAr)
                    ->where('vid', 3);
            })->distinct('user_id')->limit(28)->get()->toArray();
			
		/** share user list */
            $shareUserList['all'] = $this->user->where('status','=',config('kloves.RECORD_STATUS_ACTIVE'))->where('id', '<>', \Auth::user()->id)->select('id','firstName')->get()->toArray(); 
            $shareUserJsonList = json_encode($shareUserList['all']);
			
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
            "shareUserJsonList" => $shareUserJsonList
        );
        //prd($data);
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

        OpportunityUser::where("oid", $oid)->update(array("apply"=> 0));

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

}
