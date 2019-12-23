<?php

namespace App\Http\Controllers;
use App\User;
use App\Models\Feed;
use App\Models\OpportunityUser;
use App\Models\Opportunity;
use App\Models\TaxonomyTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
//use Illuminate\Support\Facades\Mail;
//use App\Mail\EmailNotification;
use DB;

class OpportunityUserController extends Controller
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
    $this->opportunity_user = new OpportunityUser();
    $this->opportunity = new Opportunity();
    $this->taxonomyterm = new TaxonomyTerm();
    $this->feed = new Feed();
    $this->user = new User();
  }

   /**
	 * To Apply/like/favourite opportunity
	 * @param Request
	 * @return Response
	*/
  public function  actionOpportunityUser(Request $request)
  { 
    $response = array( 
		"type" => NULL,
		"errors" => NULL,
		"message" => NULL,
    );

    if($request->ajax()){ 

        $action = $request->post('action');
        $oid = $request->post('oid');
        $uid = auth()->user()->id;
        $org_id = auth()->user()->org_id;

        $actionstatus = 1;  $actionstatus_rollback = 0; $success_message = "";
        $opportunity_user = array();

       
        switch ($action) {
            /*case $opportunityApply:
              $opportunity_user[$opportunityApply] = $actionstatus;
              $success_message = "applied";
              $successMessage = 'You have successfully '.$success_message.' to this opportunity.';
              break; */
            case 'like':
              $opp_action = 'like'; 
              $response["action"] = "like"; 
              $opportunity_user['like'] = $actionstatus;
              $updateFeedData['liked_feed'] = $actionstatus; 
              break;
            case 'unlike':
              $opp_action = 'like'; 
              $response["action"] = "unlike"; 
              $opportunity_user['like'] = $actionstatus_rollback;
              $updateFeedData['liked_feed'] = $actionstatus_rollback; 
            break;
            case 'fav':
              $opp_action = 'favourite'; 
              $response["action"] = "fav"; 
              $opportunity_user['favourite'] = $actionstatus;
              $updateFeedData['marked_as_fav'] = $actionstatus; 
              break;
              case 'unfav':
                $opp_action = 'favourite'; 
                $response["action"] = "unfav"; 
                $opportunity_user['favourite'] = $actionstatus_rollback;
                $updateFeedData['marked_as_fav'] = $actionstatus_rollback; 
              break;
          }
          $opportunityuser_exists = $this->opportunity_user->opportunity_user_exists($oid, $uid, $org_id); 
          if ($opportunityuser_exists) {
            $opportunity_user_data = $this->opportunity_user->opportunity_user_update($opportunity_user, $oid, $uid, $org_id);
          }else{
            $opportunity_user_new = new OpportunityUser;
            $opportunity_user_new->oid = $oid;
            $opportunity_user_new->org_uid = $uid;
            $opportunity_user_new->org_id = $org_id;
            $opportunity_user_new->$opp_action = $actionstatus;
            $opportunity_user_data = $opportunity_user_new->save();
          }

          /** record action in feeds :start */
            $feed_type_opp = config('kloves.FEED_TYPE_NEW_OPP');
            $feedData = Feed::where('key_id',$oid)->where('feed_type',$feed_type_opp)->first(); //dd($feedData);
		    /* $feedFilter['key_id'] = $oid;
		    $feedFilter['feed_type'] = $feed_type_opp;
			$feedData =  $this->feed->get_feed_by_id($feedFilter); dd($feedData); */
             if (!empty($feedData) && DB::table('feeds_user_action')->where('feed_pk_id',$feedData->id)->where('user_id',$uid)->exists()) {
                  $updateFeedData['updated_by'] = $uid;
                  $updateFeedData['updated_at'] = date('Y-m-d H:i:s');
              }else{  
                  $saveData = [
                    'user_id' => $uid,
                    'feed_pk_id' => $feedData->id,
                    'liked_feed' => 0,
                    'marked_as_fav' => 0,
                    'removed_feed' => 0,
                    'created_by' => $uid,
                  ];
                  $this->feed->record_feeds_user_action($saveData);
              }
            
              DB::table('feeds_user_action')
              ->where('user_id', $uid)
              ->where('feed_pk_id', $feedData->id)
              ->update($updateFeedData);
               //prd($request->post());
          /** record action in feeds :ends */
         
          $response["type"] = "success";
      }
      echo json_encode($response);
      exit();
  

  }

    /**
     * To show my opportunity
     * @param Request
     * @return Response
    */
  protected function myOpportunity(Request $request)
  {
    if(request()->ajax()) {
        $opportunityApply = config('kloves.OPPORTUNITY_APPLY');
        $oppData = $this->opportunity_user->opportunity_action_list($opportunityApply); // dd($oppData);
        return datatables()->of($oppData)
        ->addColumn('opportunity', function($oppData) {
          $colName = 'opportunity';

          $focus_areas = array();
          $focus_area_options = $this->taxonomyterm->getTaxonomyTermDataByVid(config('kloves.FOCUS_AREA'));
          foreach ($focus_area_options as  $focus_area_option) {
            $focus_areas[$focus_area_option->tid] = $focus_area_option->name;
          }

          return (string) view('opportunity.datatable-col-view', compact('oppData','colName','focus_areas'));
        })
        ->addColumn('start_date', function($oppData) {
          $colName = 'start_date';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
        })
        ->addColumn('end_date', function($oppData) {
          $colName = 'end_date';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
        })
        ->addColumn('app_status', function($oppData) {
          $colName = 'app_status';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
        })
        
       /* ->addColumn('apply_before', function($oppData) {
          $colName = 'apply_before';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
        })
        ->addColumn('action', function($oppData) {
          $colName = 'action';
          return (string) view('opportunity.datatable-col-view', compact('oppData','colName'));
        }) */
        ->rawColumns(['start_date','end_date','opportunity','app_status'])
        ->addIndexColumn()
        ->make(true);
    }
    return view('opportunity.my-opportunity');
  }
  /**
   * To show opportunity terms
   * @param Request
   * @return Response
  */
  public function OpportunityTerms()
  {
    $opp_terms = $skills = $focus_areas = array();
    $skill_options = $this->taxonomyterm->getTaxonomyTermDataByVid(config('kloves.SKILL_AREA'));
    $focus_area_options = $this->taxonomyterm->getTaxonomyTermDataByVid(config('kloves.FOCUS_AREA'));
    foreach ($skill_options as  $skill_option) {
      $skills[$skill_option->tid] = $skill_option->name;
    }
    foreach ($focus_area_options as  $focus_area_option) {
      $focus_areas[$focus_area_option->tid] = $focus_area_option->name;
    }
    $opp_terms['skills'] = $skills;
    $opp_terms['focus_areas'] = $focus_areas;
    return $opp_terms;
  }
   /**
   * To perform opportunity action
   * @param Request
   * @return Response
  */
  function opportunityAction(Request $request){ 
      $loggeduserId = auth()->user()->id;
      $org_id = auth()->user()->org_id;
      $action_type = $request->post('action_type');
      $action = $request->post('action');
      $oid =  Crypt::decrypt($request->post('id'));
      $applicant_id =  Crypt::decrypt($request->post('applicant_id'));

      if($action=='approve'){
        $action =  config('kloves.OPP_APPLY_APPROVED');
        $success_message = 'approved';
      }elseif($action=='reject'){
        $action =  config('kloves.OPP_APPLY_REJECTED');
        $success_message = 'rejected';
       // $update_user_opp_status
       OpportunityUser::where('oid', '=', $oid)->where('org_uid', '=', $applicant_id)->where('org_id', '=', $org_id)
       ->update(['apply' => 0]);
      }
     
       /** @send_email : to manager to notify */
       $userData = User::where('id', $applicant_id)->select('firstName AS name', 'email')->first();
       $filters['id'] = $oid;
       $oppDetails = $this->opportunity->getOpportunityOneDetails($filters); 
       $user_name  = auth()->user()->firstName;
       $emaildata['subject'] = "Your Application Status";
       $emaildata['receiver_name'] = $userData->name;
       $emaildata['receiver_email'] = $userData->email;
       $emaildata['message'] = $message = $oppDetails->opp_creator.' has '.$success_message.' your application <strong>'.$oppDetails->opportunity.'</strong>.';
       $emaildata['sender_name'] = $oppDetails->opp_creator;
       $emaildata['sender_email'] = $oppDetails->opp_creator_mail;
       $mailResponse =  send_email($emaildata);
       if ($mailResponse) {
        
       }else{
        
       }
        /** @send_email : to manager to notify ENDS*/

      if($action_type == config('kloves.OPPORTUNITY_APPLY')){
        $data_to_save['oid'] = $oid;
        $data_to_save['applicant_id'] = $applicant_id;
        $data_to_save['approver_id'] = $loggeduserId;
        $data_to_save['org_id'] =  $org_id;
        $data_to_save['action_type'] = '1'; //apply action
        $data_to_save['action_status'] = $action;
        $res = $this->opportunity_user->log_opp_user_action($data_to_save);
        if($res){
          $successMessage = 'You have successfully '.$success_message.' to this opportunity.';
          if($request->ajax()){
            return response()->json(['status'=>1,'message' => $successMessage]);
          }else{
            return back()->with('success', $successMessage);
          }
        }else{
          return response()->json(['status'=>0]);
        }
    }
  }
  /**
   * To post comment
   * @param Request
   * @return Response
  */
  function postComment(Request $request){
    parse_str($request->post('formData'), $searcharray); // print_r($searcharray); dd();
    $loggeduserId = auth()->user()->id;
    $org_id = auth()->user()->org_id;

    $publicComment = config('kloves.COMMENT_TYPE_PUBLIC');
    $privateComment = config('kloves.COMMENT_TYPE_PRIVATE');

    $commentData = [
      'parent_thread_id'  => date('YmdHis'),
      'oid'             => Crypt::decrypt($searcharray['oid']),
      'from_id'         => Crypt::decrypt($searcharray['from_id']),
      'to_id'           => Crypt::decrypt($searcharray['to_id']),
      'comment_content' => $searcharray['comment_content'],
      'comment_type'    => $searcharray['comment_type'],
      'org_id'          => $org_id,
      'comment_status'  => config('kloves.COMMENT_ACTIVE')
    ];

    $res = DB::table('org_opportunity_comments')->insert($commentData);

    if($res){
      if($searcharray['comment_type']==$publicComment){
        $successMessage = 'Your message has been successfully sent.';
      }else{
        $successMessage = 'Your message has been posted successfully.';
      }
     
      if($request->ajax()){
        return response()->json(['status'=>1,'type'=>$searcharray['comment_type'],'message' => $successMessage]);
      }else{
        return back()->with('success', $successMessage);
      }
    }else{
      return response()->json(['status'=>0]);
    }
  }
  
  /**
   * To get private Opportunity comments
   * @param id
   * @return Response
  */
  function getPrivateComments($id = null){
    $id = Crypt::decrypt($id);
    $commentRow = DB::table('org_opportunity_comments')->where('id', $id)->first(); //dd($commentRow);
    $oid = $commentRow->oid;
    $filters['applicant_id'] = $commentRow->from_id;
    $filters['to_id'] = $commentRow->to_id;
    $filters['comment_type'] = config('kloves.COMMENT_TYPE_PRIVATE');
    $filters['comment_status'] = config('kloves.COMMENT_ACTIVE'); 
    $pvtcommentdata = $this->opportunity->getOppCommentList($oid,$filters); //dd($pvtcommentdata);
    return view('opportunity.view-comments',compact('pvtcommentdata'));
  }

  /**
	 * To Apply on opportunity
	 * @param Request
	 * @return Response
	*/
  public function applyOpportunity(Request $request, $opp_action, $oid){ 
      $userAction = strtoupper($opp_action);
      $oid = Crypt::decrypt($oid);
      $opportunityApply = config('kloves.OPPORTUNITY_APPLY');
      $uid = auth()->user()->id;
      $org_id = auth()->user()->org_id;
      $actionstatus = 1;  $actionstatus_rollback = 0; $success_message = "";
      $opportunity_user = array();
      switch ($userAction) {
        case $opportunityApply:
          $opportunity_user[$opportunityApply] = $actionstatus;
          $success_message = '<strong>Hooray, a real super hero</strong><br>The opportunity manager will be in touch.';
          break;
      }
      $opportunityuser_exists = $this->opportunity_user->opportunity_user_exists($oid, $uid, $org_id); 
      if ($opportunityuser_exists) {
        $opportunity_user_data = $this->opportunity_user->opportunity_user_update($opportunity_user, $oid, $uid, $org_id);
      }else{
        $opportunity_user_new = new OpportunityUser;
        $opportunity_user_new->oid = $oid;
        $opportunity_user_new->org_uid = $uid;
        $opportunity_user_new->org_id = $org_id;
        $opportunity_user_new->$opp_action = $actionstatus;
        $opportunity_user_data = $opportunity_user_new->save();
      }
      if($userAction==$opportunityApply){
          $data_to_save['oid'] = $oid;
          $data_to_save['applicant_id'] = $uid;
          $data_to_save['org_id'] = $org_id;
          $data_to_save['action_type'] = '1'; //apply action
          $data_to_save['action_status'] ='0';
        $this->opportunity_user->log_opp_user_action($data_to_save); 

        /** @send_email : to manager to notify */
       /* $filters['id'] = $oid;
        $oppDetails = $this->opportunity->getOpportunityOneDetails($filters); 
        $user_name  = auth()->user()->firstName;
        $emaildata['subject'] = "New User Applied";
        $emaildata['receiver_name'] = $oppDetails->opp_creator;
        $emaildata['receiver_email'] = $oppDetails->opp_creator_mail;
        $emaildata['message'] = $message = $user_name.' have applied on your opportunity <strong>'.$oppDetails->opportunity.'</strong>.';
        $emaildata['sender_name'] = $user_name;
        $emaildata['sender_email'] = auth()->user()->email;
        $mailResponse =  send_email($emaildata);
        if ($mailResponse) {
        
        }else{
        
        }*/
        /** @send_email : to manager to notify ENDS*/
      }
    
      if($request->ajax()){
      
        $response["success_html"] = $success_message;
        $response["status"] = 1; 
        $response["action"] = $userAction;
        return response()->json( $response );
      }else{
        return back()->with('success', $successMessage);
      }
  }


   /**
   * To get favorite Opportunities
   * @param Request
   * @return Response
  */
  function favoritesOpportunity(){
    $activityFilter = [];
    $loggedInUserID  = auth()->user()->id;

    /** share user list */
    $shareUserList['all'] = $this->user->where('status','=',config('kloves.RECORD_STATUS_ACTIVE'))->where('id', '<>', $loggedInUserID)->select('id','firstName')->get()->toArray(); 
    $shareUserJsonList = json_encode($shareUserList['all']);

    $favoritesOpportunities = OpportunityUser::select(["oid", "org_uid", "like", "favourite"])
           ->with(["opportunity","opportunity.creator","opportunity.creator.profile","opportunity.creator.profile_image"]) 
            ->where("favourite", config('kloves.FLAG_SET'))
            ->where("org_uid", $loggedInUserID)
            ->orderBy("created_at", "DESC")
            ->get()->toArray(); //prd($favoritesOpportunities);
   
        

    return view('opportunity.favorites',compact('favoritesOpportunities','shareUserJsonList'));
  }
}
