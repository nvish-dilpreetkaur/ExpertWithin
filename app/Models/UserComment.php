<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class UserComment extends Model
{
    //
		protected $table = 'user_comments';
		
		public $timestamps = false;
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "to_id",
        "org_id",
        "comment",
        "created_at"
    ];	
    
    protected $primaryKey = 'id';
    
    public function comments()
	{
		return $this->belongsTo('App\Models\Opportunity', "id", "org_id");
	}
	
	public function opportunity(){
        $this->belongsTo('App\Models\Opportunity', 'org_id', 'id');
    }
	
	public function users()
	{
	    return $this->belongsTo('App\User', 'user_id', 'id')->select(['id','firstName']);
	}
	
	
    
}
