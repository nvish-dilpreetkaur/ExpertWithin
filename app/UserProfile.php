<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
	public function getImageUrlAttribute($image_name)
	{		
		$file_path = url('/uploads/').Config('constants.DS').$image_name;
		if(!file_exists($file_path)) {
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
            $value = url('/uploads/') . "/" . $value;
        } else {
            $value = "";
        }
        return $value;
    }

}
