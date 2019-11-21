<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\User;
use App\Models\TaxonomyTerm;
use App\Models\OpportunityTermsRelationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Auth;
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
  }
  
	/**
	 * Display a list of opportunity.
	 * @param  none
	 * @return Response
	*/
  function  index(){

    if(request()->ajax()) {
        $filters = [];
        $filters['status'] = [0,1]; //active
        $oppData = $this->opportunity->ajax_opportunity_list($filters); //dd($oppData);

      /*  return Datatables::of($posts)
        ->editColumn('title', '{!! str_limit($title, 60) !!}')
        ->editColumn('name', function ($model) {
            return \HTML::mailto($model->email, $model->name);
        })
        ->make(true); */
        return datatables()->of($oppData)
        //return datatables::->of($oppData)
        ->editColumn('opportunity', function($oppData) {
          $colName = 'opportunity';

          $focus_areas = array();
          $focus_area_options = $this->taxonomyterm->getTaxonomyTermDataByVid(config('kloves.FOCUS_AREA'));
          foreach ($focus_area_options as  $focus_area_option) {
            $focus_areas[$focus_area_option->tid] = $focus_area_option->name;
          }
          return view('opportunity.datatable-col-view', compact('oppData','colName','focus_areas'));  
          //return (string) 
         })
        ->addColumn('start_date', function($oppData) {
          $colName = 'start_date';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
         })
         ->addColumn('end_date', function($oppData) {
          $colName = 'end_date';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
         })
         /*->addColumn('apply_before', function($oppData) {
          $colName = 'apply_before';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
         })*/
        ->addColumn('action', function($oppData) {
          $colName = 'action';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
         })
        ->rawColumns(['action','start_date','end_date','opportunity'])
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
      $opportunity_exists  = Opportunity::find($id); 
      if ($opportunity_exists) {

        $opportunity_array =  $this->opportunity->opportunity_list($id); 
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
              'managers' => $managers
            ];
    return view('opportunity.opportunity-form')->with($data);
  }

  /**
	 * Create a new opportunity instance after a valid data.
	 * @param  Request
	 * @return Response
	*/
  protected function createOpportunity(Request $request)
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
  
    $oppStatus = ($request['submit']=='draft') ?  config('kloves.OPP_APPLY_NEW') : config('kloves.OPP_APPLY_APPROVED');
    $opportunity = Opportunity::create([
      'opportunity' => $request['opportunity'],
      'opportunity_desc' => $request['opportunity_desc'],
      'rewards' =>$request['rewards'],
      'org_uid' => (!empty($request['org_uid'])) ? $request['org_uid'] : auth()->user()->id,
      'org_id' => auth()->user()->org_id,
      'department_id' => 1,
      'status' => $oppStatus,
      'start_date' => date('Y-m-d', strtotime($request['start_date'])),
      'end_date' => date('Y-m-d', strtotime($request['end_date'])),
      'apply_before' => date('Y-m-d', strtotime($request['apply_before'])),
    ]);

    $oid = $opportunity->id;
    if(!empty($request['skills'])){
      $opportunity_skills_vid = config('kloves.SKILL_AREA');
      foreach ($request['skills'] as $skill) {
        OpportunityTermsRelationship::create([
          'oid' => $oid,
          'vid' => $opportunity_skills_vid,
          'tid' => $skill,
        ]);
        
      }
    }
    if(!empty($request['focus_area'])){
      $opportunity_focus_areas_vid = config('kloves.FOCUS_AREA');
      foreach ($request['focus_area'] as $focus_area) {
        OpportunityTermsRelationship::create([
          'oid' => $oid,
          'vid' => $opportunity_focus_areas_vid,
          'tid' => $focus_area,
        ]);
      }
    }
    if(!empty($request['locations'])){
      $opportunity_location_vid = config('kloves.LOCATION_AREA');
      foreach ($request['locations'] as $location) {
        OpportunityTermsRelationship::create([
          'oid' => $oid,
          'vid' => $opportunity_location_vid,
          'tid' => $location,
        ]);
      }
    }
    return  redirect('opportunities')->with('success', 'Opportunity created successfully.');
  }

  /**
	 * Update opportunity instance after a valid data.
	 * @param  Request
	 * @return Response
	*/
  protected function updateOpportunity(Request $request, $id){

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
    $opportunity  = Opportunity::find($id);
    if ($opportunity) {
      $oppStatus = ($request['submit']=='draft') ?  config('kloves.OPP_APPLY_NEW') : config('kloves.OPP_APPLY_APPROVED');

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
      $opportunity->start_date   = date('Y-m-d', strtotime($request['start_date']));
      $opportunity->end_date =  date('Y-m-d', strtotime($request['end_date']));
      $opportunity->apply_before =  date('Y-m-d', strtotime($request['apply_before']));
      $opportunity->save();
      if (!empty($request['skills'])) {
        $skills = $request['skills'];
        $opp_skills_array = array();
        $opp_skills_exist  = OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_skills_vid)->get('tid')->toArray();
        foreach ($opp_skills_exist as $opp_skill_exist) {
          $opp_skills_array[] = $opp_skill_exist['tid'];
        }
        $delete_skill_ids = array_diff($opp_skills_array, $skills);
        if ($delete_skill_ids) {
         OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_skills_vid)->whereIn('tid',$delete_skill_ids)->delete();
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
      }else{
        OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_skills_vid)->delete();
      }
      if (!empty($request['focus_area'])) {
        $focus_areas = $request['focus_area'];
        $opp_focus_array = array();
        $opp_focus_areas_exist  = OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_focus_areas_vid)->get('tid')->toArray();
        foreach ($opp_focus_areas_exist as $opp_focus_area_exist) {
          $opp_focus_array[] = $opp_focus_area_exist['tid'];
        }
        $delete_focus_ids = array_diff($opp_focus_array, $focus_areas);
        if ($delete_focus_ids) {
          OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_focus_areas_vid)->whereIn('tid',$delete_focus_ids)->delete();
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
      }
      else{
        OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_focus_areas_vid)->delete();
      }
      if (!empty($request['locations'])) {
        $locations = $request['locations'];
        $opp_locations_array = array();
        $opp_locations_exist  = OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_location_vid)->get('tid')->toArray();
        foreach ($opp_locations_exist as $opp_location_exist) {
          $opp_locations_array[] = $opp_location_exist['tid'];
        }
        $delete_focus_ids = array_diff($opp_locations_array, $locations);
        if ($delete_focus_ids) {
          OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_location_vid)->whereIn('tid',$delete_focus_ids)->delete();
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
      }
      else {
          OpportunityTermsRelationship::where('oid', $id)->where('vid',$opportunity_location_vid)->delete();
      } 
          return  redirect('opportunities')->with('success', 'Opportunity updated successfully.');
    }
    else{
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
    $opportunity  = Opportunity::find($id);
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
  function view($id = null){
    $loggedInUserID = $roleId = '';  $topMatchedFilter = [];
		$user = \Auth::user();  
		if(!empty($user)){
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
      }
    
      $page_title = "Opportunity Details";
   
      return view('opportunity.view', compact(['opportunity_data']));
  }
  
}
