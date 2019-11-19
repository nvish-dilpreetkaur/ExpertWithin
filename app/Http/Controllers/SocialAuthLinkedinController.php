<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
use Exception;
use DB;


class SocialAuthLinkedinController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin')->redirect();
		//return Socialite::driver('linkedin')->scopes(['r_fullprofile'])->redirect();
    }

    public function callback()
    {
        try {
            $linkdinUser = Socialite::driver('linkedin')->user(); 
            $existUser = User::where('email',$linkdinUser->email)->first();
            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
				/** create user **/
                $user = new User;
                $user->firstName = $linkdinUser->name;
                $user->email = $linkdinUser->email;
                $user->linkedin_id = $linkdinUser->id;
                $user->password = md5(rand(1,10000));
                $user_id = $user->save();
				
				/** add role **/
				DB::table('user_roles')->insert([
					'user_id'       => $user_id,
					'role'          => config('kloves.ROLE_EXPERT'),
					'status'        => 1,
				]);
                Auth::loginUsingId($user->id);
            }
            return redirect()->to('/');
        } 
        catch (Exception $e) {
            return 'error';
        }
    }
}