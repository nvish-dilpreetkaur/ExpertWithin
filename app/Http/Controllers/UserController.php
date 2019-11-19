<?php

namespace App\Http\Controllers;
use App\User;
use App\UserProfile;
use App\Models\TaxonomyTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use DB;
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
        if ($id) {
            $user_id = Crypt::decrypt($id);
            $action_type = 'HR-EDIT';
        }else{
            $user_id = auth()->user()->id; 
            $action_type = 'SELF-EDIT';
        }
        $user = new User;
	    $users = $user->getUserProfileDataById($user_id);  
        $focus = TaxonomyTerm::where('vid', config('kloves.FOCUS_AREA'))->where('status',config('kloves.RECORD_STATUS_ACTIVE'))->select('name', 'tid')->orderBy('name')->get();
        $skills = TaxonomyTerm::where('vid', config('kloves.SKILL_AREA'))->where('status',config('kloves.RECORD_STATUS_ACTIVE'))
        ->select('name', 'tid')->orderBy('name')->get();
        $managers = $user->getManagerDdlList($user_id); 
	  
	    return view('users.profile', compact(['users', 'skills', 'focus','managers','action_type']));
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
	
	
}
