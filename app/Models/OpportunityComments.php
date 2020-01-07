<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityComments extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'org_opportunity_comments';
    public $primaryKey='id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'parent_id',
        'org_id',
        'user_id',
        'comment',
        'type',
        'created_at',
        'updated_at'        
    ];
    
    public function opportunity(){
        return $this->belongsTo('App\Model\Opportunity');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id')->select(array('id', 'firstName'));
    }
    
    public function profile(){
		$file_path = url('/uploads/');
        return $this->belongsTo('App\UserProfile', 'user_id', 'user_id')->select(array('user_id','image_name'));;
    }
    
    public function replies()
	{
		return $this->hasOne('App\Models\OpportunityComments', 'parent_id', 'id')->orderBy('id', 'desc');
	}

    public function all_replies() {
        return $this->hasMany('App\Models\OpportunityComments', 'parent_id', 'id')->limit(1)->orderBy('id','desc');
    }
    
}
