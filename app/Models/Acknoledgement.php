<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acknoledgement extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'acknoledgement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'user_id',   
    ];
	
	public function acknoledgement()
	{
		return $this->hasMany('App\Models\ShareFeed', "key_id", "id")->where("share_type","ACK")->select("*");
	}
}
