<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Auth;

class OrganizationController extends Controller
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
    $this->organization = new Organization();
  }
  /**
   * Display a listing of the organizations.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function index(){
    $no_of_pages = "";
    $pagintaionEnabled = config('kloves.enablePagination');
    if ($pagintaionEnabled) {
       $no_of_pages = config('kloves.paginateListSize');
    }
    $organizations = $this->organization->organization_list("", $no_of_pages);
    $data = [
      'organizations' => $organizations
    ];
    return view('organizations.listing')->with($data);
  }


   /**
   * Create a new Organization instance after a valid data.
   *
   * @param  array  $data
   * @return \App\Organization
   */
  
  protected function organization(Request $request, $id = "")
  {
  
    $org_form_action = route('new-organization');
    $org_page_title = "Create Organization";
    $org_data = array();

    if ($id) {
      $id = Crypt::decrypt($id); 
      $org_exists  = Organization::find($id); 
      if ($org_exists) {

        $org_array =  $this->organization->organization_list($id);
        $org_data = $org_array[0];
        $org_form_action = route('update-organization', ['id' => $id]);
        $org_page_title = "Update Organization";
      }
    }
	$cities_list = $this->organization->getAllCities(); 
	$states_list = $this->organization->getAllStates(); 

    $data = [
              'org_data' => $org_data,
              'org_form_action' => $org_form_action,
              'org_page_title' => $org_page_title,
              'cities_list' => $cities_list,
              'states_list' => $states_list
            ];
    return view('organizations.organization-form')->with($data);
  }


  /**
   * update organization
  **/

  protected function updateOrganization(Request $request, $id){

    $this->validate($request, [
      'name' => 'required|max:254',
      'street' => 'required',
      'state' => 'required',
      'city' => 'required',
      'director' => 'required|max:3',
      'country_code' => 'required',
      'phone' => 'required|min:11|numeric',
      'notes' => 'max:1000'
    ]);
    $loggedInUser = \Auth::user();   
    $organization  = Organization::find($id);
    if ($organization) {
        $organization->name = $request['name'];
        $organization->street = $request['street'];
        $organization->state = $request['state'];
        $organization->city = $request['city'];
        $organization->country_code = $request['country_code'];
        $organization->phone = $request['phone'];
        $organization->director = $request['director'];
        $organization->notes = $request['notes'];
        $organization->updated_by = $loggedInUser->id;
        $organization->updated_at = now();
        $organization->save();
        return  redirect('organizations')->with('success', 'You have successfully updated '.$organization->name.' organization.');
    }
    else{
      return redirect('organization');
    }
  }


  /**
   * Create a new organization instance after a valid data.
   *
   * @param  array  $data
   * @return \App\Organization
   */
  protected function newOrganization(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:254',
      'street' => 'required',
      'state' => 'required',
      'city' => 'required',
      'director' => 'required|max:3',
      'country_code' => 'required',
      'phone' => 'required|min:11|numeric',
      'notes' => 'max:1000'
    ]);
    $loggedInUser = \Auth::user(); 
    $organization = Organization::create([
      'name' => $request['name'],
      'street' => $request['street'],
      'city' =>$request['city'],
      'state' =>$request['state'],
      'country_code' =>$request['country_code'],
      'phone' =>$request['phone'],
      'director' =>$request['director'],
      'notes' => $request['notes'],
      'created_by' =>  $loggedInUser->id
    ]);
    return  redirect('organizations')->with('success', 'You have successfully created '.$request['name'].' organization.');
  }

  
  /**
   * deactivate organization to status [2]
  **/

  protected function deleteOrganization(Request $request, $id)
  {
    $id = Crypt::decrypt($id);
    $organization  = Organization::find($id);
    if ($organization) {
      $status_deact = config('kloves.RECORD_STATUS_DEACTIVE');
      $loggedInUser = \Auth::user(); 
      Organization::where('id', $id)->update(
        array(
          'status' => $status_deact,
          'updated_at' => now(),
          'updated_by' => $loggedInUser->id
      )); 
    }
    return redirect('organizations')->with('success', 'You have successfully deactiavted '.$organization->name.' organization.');
  }


  
}
