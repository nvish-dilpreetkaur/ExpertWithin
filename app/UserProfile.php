<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Config;
class UserProfile extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'availability'
    ];
    
     /**
     * Set profile image url.
     *
     * @return mixed
     */
    
	public function getImageUrlAttribute($image_name,$folder='thumbnail')
	{	$file_path =  Storage::disk('public_uploads')->url($folder.Config('constants.DS').$image_name);
		if (!Storage::disk('public_uploads')->exists($image_name)){
			$file_path = '';
		}	
		if (!Storage::disk('public_uploads')->exists($folder.Config('constants.DS').$image_name)){
			$file_path = '';
		}
		return $file_path;
	}
	
	 /**
     * A profile belongs to a user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getProfileImageAttribute($value)
    {
        if(!empty($value)) {
            $profileImagePath = Storage::disk('public_uploads')->url('/thumbnail/');
            $value = $profileImagePath . $value;
        } else {
            $value = "";
        }
        return $value;
    }

}
