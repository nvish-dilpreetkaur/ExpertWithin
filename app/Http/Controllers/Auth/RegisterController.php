<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\TaxonomyTerm;
use App\Models\UserInterest;
use DB;
use Auth;
use Eloquent;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
           // 'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            /*'mobile' => ['required', 'string', 'max:255'],
           'org_id' => ['required'],
            'role' => ['required'],*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

  public function create(array $data ) { 
     
      $user = new User;
      $user->firstName = $data['name'];
      $user->email = $data['email'];
      $user->password = Hash::make($data['password']);
      $user->org_id = config('kloves.DEFAULT_ORG_ID');
      $user->save();
    
      $lastInsertId = $user->id; 
      $utype = 'expert';  
      //insert user basic 'expert' role to roles table
      DB::table('user_roles')->insert([
        'user_id'       => $lastInsertId,
        'role'          => config('kloves.ROLE_EXPERT'),
        'status'        => 1,
    ]);

    //insert some dafaults skills/focus-area (remove code after AMBER release) : starts
    $this->addSomeDefaultSkills($lastInsertId);
    //insert some dafaults skills/focus-area (remove code after AMBER release) : ends


    if($data['role']==config('kloves.ROLE_MANAGER')){
        DB::table('user_roles')->insert([
            'user_id'       => $lastInsertId,
            'role'          => $data['role'],
            'status'        => 1,
        ]);
        $utype = 'manager';
   
        session()->flash('success', 'You have Successfully registered as manager but your approval is pending. You can login back as manager once your account is approved.'); 

              /** @send_email : after manager registration */
             /* $hrData = getHRAdminData(); 
              $user_name  = $data['name'];
              $emaildata['subject'] = "New User Signup";
              $emaildata['receiver_name'] = $hrData->firstName;
              $emaildata['receiver_email'] = $hrData->email;
              $emaildata['message'] = $message = $user_name.' has registered as '.$utype.'. Please login to approve.';
              $emaildata['sender_name'] = $user_name;
              $emaildata['sender_email'] = $data['email']; 
              $mailResponse =  send_email($emaildata);
              if ($mailResponse) {
              
              }else{
              
              }*/
              /** @send_email : after manager registration ENDS*/
    }
     
   
     return $user;
  }


    function addSomeDefaultSkills($user_id){
        $focus_area = config('kloves.FOCUS_AREA'); // prd($user_id);
        $skill_area = config('kloves.SKILL_AREA'); 
        // Add some focus area as Default 'Focus Area' 
        $focData = TaxonomyTerm::where('vid', $focus_area)->where('status',config('kloves.RECORD_STATUS_ACTIVE'))->select('name', 'tid')->orderBy('tid')->first(); //dd($focData->tid);
        $foc_data = array(
                'tid' => $focData->tid,
                'vid' => $focus_area,
                'user_id' => $user_id
        );
        UserInterest::create($foc_data);
        // Add Some Skills as Default skills
        $skillData = TaxonomyTerm::where('vid', $skill_area)->where('status',config('kloves.RECORD_STATUS_ACTIVE'))->select('name', 'tid')->orderBy('tid')->limit(5)->get(); 
        if($skillData != null){
            foreach($skillData as $sklVal){
                $skilldata = array(
                    'tid' => $sklVal->tid,
                    'vid' => $skill_area,
                    'user_id' => $user_id
                );
                UserInterest::create($skilldata);    
            }
        }
        return true;
    }
}
