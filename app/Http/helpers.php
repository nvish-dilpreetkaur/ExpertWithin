<?php
use App\Models\Configuration;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;


function pre($arr)
{	
    echo "<pre>"; print_r($arr) ;  echo "</pre>";
}
function prd($arr)
{	
    echo "<pre>"; print_r($arr) ;  echo "</pre>"; 
	die();
}
if (!function_exists('home_card_cls')) {
	function home_card_cls() {
		$home_card_cls = config('kloves.HOME_CARD_CLASSES');
		return $home_card_cls;
	}
}
/**
	 * To get organization related skills
	 * @param none
	 * @return array
  */
if (!function_exists('org_skill_list')) {
	function org_skill_list() {
		$skill_list = []; $skillList = [];
		$skillID = config('kloves.SKILL_AREA');
		$taxonomyTerm = new \App\Models\TaxonomyTerm;	
		$skill_list['skill_list'] = $taxonomyTerm->getTaxonomyTermDataByVid($skillID);
		$skill_list['popular_skill_list'] = $taxonomyTerm->getTaxonomyTermDataByVid($skillID,1);
		foreach ($skill_list['skill_list'] as  $skl) {
			$skillList[$skl->tid] = $skl->name;
		}
		$skill_list['skillList'] = $skillList;
		
		return $skill_list;
	}
}
/**
	 * To get organization related focus areas
	 * @param none
	 * @return array
  */
if (!function_exists('org_focus_list')) {
	function org_focus_list() {
		$focus_list = []; $focusList = [];
		$focusID =config('kloves.FOCUS_AREA');
		$taxonomyTerm = new \App\Models\TaxonomyTerm;	
		$focus_list['focus_list'] = $taxonomyTerm->getTaxonomyTermDataByVid($focusID);
		$focus_list['popular_focus_list'] = $taxonomyTerm->getTaxonomyTermDataByVid($focusID,1);
		foreach ($focus_list['focus_list'] as  $foc) {
			$focusList[$foc->tid] = $foc->name;
		}
		$focus_list['focusList'] = $focusList;
		return $focus_list;
	}
}
/**
	 * To get organization related location areas
	 * @param none
	 * @return array
  */
if (!function_exists('org_location_list')) {
	function org_location_list() {
		$location_list = []; $locList = [];
		$vocSlug = config('kloves.LOCATION_AREA');
		$taxonomyTerm = new \App\Models\TaxonomyTerm;	
		$location_list ['location_list'] = $taxonomyTerm->getTaxonomyTermDataByVid($vocSlug);
		$location_list ['popular_location_list'] = $taxonomyTerm->getTaxonomyTermDataByVid($vocSlug,1);
		foreach ($location_list ['location_list'] as  $foc) {
			$locList[$foc->tid] = $foc->name;
		}
		$location_list['locList'] = $locList;
		return $location_list ;
	}
}

if (! function_exists('format_tags')) {
    function format_tags($text) {
    	if($text!='')
    		$text = preg_replace("/#(\S+)/", "<span class='hash-tags'>#$1</span>", $text);

    	 return $text;
    }
}
/**
	 * To get status label value by num val
	 * @param args
	 * @return response
  */
if (! function_exists('get_opp_status_label')) {
	function get_opp_status_label($status) {
		switch ($status) {
			case 0:
			  	$label = 'Draft';
			 	break;
			case 1:
				$label = 'Published';
				break;
			case 2:
				$label = 'Deleted';
				break;
			default:
				$label = 'Unknown';
		  }
  
		 return $label;
	}
  }
 /**
	 * Common function to send email
	 * @param args
	 * @return true/false
  */
  function send_email($emaildata){
	if(config('mail.SEND_LIVE_EMAILS')){
		$to = $emaildata['receiver_email'];
		$from = !empty($emaildata['sender_email']) ? $emaildata['sender_email'] : '';
	}else{
		$to =config('mail.TEST_RECEIVER_EMAIL');
		$from = !empty($emaildata['sender_email']) ? config('mail.TEST_SENDER_EMAIL')  : '';
	} 
	$ccUsers = config('mail.CC_LIST');
	$bccUsers = config('mail.BCC_LIST');
	$when = now()->addMinutes(1);
	Mail::to($to)
	->cc($ccUsers)
	->bcc($bccUsers)
	->later($when,new EmailNotification($emaildata)); 
	if (Mail::failures()) {
		return false;
	}else{
		return true;
	}
  }
  
  function getHRAdminData(){
	$user = new \App\User;	
	$udata = $user->getUserProfileDataById(1);
	return $udata;
  }
  /**
	 * To get users highest role
	 * @param user_id
	 * @return Response
  */
  function get_user_highest_role($user_id){
	$user = new \App\User;	
	$role_data = $user->get_user_highest_role($user_id); //dd($role_data);
	if($role_data->role==config('kloves.ROLE_MANAGER') &&  $role_data->status==0){
		$is_manager_val =  'Waiting for apporval' ;
 	}else if($role_data->role==config('kloves.ROLE_MANAGER') &&  $role_data->status==1){
		$is_manager_val =  'Yes' ;
	}else{
		$is_manager_val =  'No' ;
	}
	$is_manager_val =  'No' ;
	return $is_manager_val;
  }
 /**
	 * To trim char and append passed string in the end
	 * @param args
	 * @return Response
  */
  function char_trim($text, $maxchar, $end='...') {
	if (strlen($text) > $maxchar || $text == '') {
	    $words = preg_split('/\s/', $text);      
	    $output = '';
	    $i      = 0;
	    while (1) {
		  $length = strlen($output)+strlen($words[$i]);
		  if ($length > $maxchar) {
			break;
		  } 
		  else {
			$output .= " " . $words[$i];
			++$i;
		  }
	    }
	    $output .= $end;
	} 
	else {
	    $output = $text;
	}
	return $output;
  }
  /**
	 * To get user email by token
	 * @param token
	 * @return Response
  */
  function get_user_by_token($token){
	$records =  DB::table('password_resets')->get();
	foreach ($records as $record) {
	    if (Hash::check($token, $record->token) ) {
		 return $record->email;
	    }
	}
  }
 /**
	 * To get user manager
	 * @param user_id
	 * @return Response
  */
  function get_user_manager($user_id){
	if($user_id){
		$user = new \App\User;	
		$res = $user->get_user_manager($user_id); 
		return $res;
	}
	return false;
  }

  /**
	 * To get opp applicaiton status label value by num val
	 * @param args
	 * @return response
  */
if (! function_exists('get_opp_application_status_label')) {
	function get_opp_application_status_label($status) {
		switch ($status) {
			case 0:
			  	$label = 'Applied';
			 	break;
			case 1:
				$label = 'Approved';
				break;
			case 2:
				$label = 'Rejected'; //deleted
				break;
			default:
				$label = 'Unknown';
		  }
  
		 return $label;
	}
  }


?>
