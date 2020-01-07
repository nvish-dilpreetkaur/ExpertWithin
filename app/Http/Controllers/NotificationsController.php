<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\User;
use App\Models\Notification;

class NotificationsController extends Controller
{
     /**
     * Create a new controller instance...
     *
     * @return void
     */

    public function __construct()
    {
	  $this->middleware('auth');
	  $this->user = new User;
    }
	
    	/**
	 * To Show index page
	 * @param  none
	 * @return Response
 	*/
	public function index(Request $request)
	{ 
		$user = \Auth::user();
		$loggedInUserID = $user->id;
		Notification::where('recipient_id',$loggedInUserID)->where('is_unread',0)->update(['is_unread'=>1]);
		$details = $user->where('id', '=', $loggedInUserID)->with(['profile','notifications','notifications.sender','notifications.sender.profile','notifications.opportunity'])->first()->toArray();
		//pre($details); exit;
		return view('notifications.index', compact(
		[
			'details'
		]) );
		
	} 
	

	
}
