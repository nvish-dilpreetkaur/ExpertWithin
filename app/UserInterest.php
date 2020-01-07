<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    //

    public function user_details()
    {
        return $this->hasOne('App\User', "id", "user_id")->select(["id", "firstName","status"]);
    }

    public function profile_image() {
        return $this->hasOne('App\UserProfile', "user_id", "user_id")->select(["user_id", "image_name as profile_image"]);
    }
}
