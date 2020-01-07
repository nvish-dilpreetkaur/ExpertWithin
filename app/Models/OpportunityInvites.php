<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityInvites extends Model
{
    //
		protected $table = 'opportunity_invites';
		
		public $timestamps = false;
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "batch_id",
        "user_id",
        "opp_id",
        "created_by",
        "status",
        "created_at"
    ];	
    
    protected $primaryKey = 'id';
    
    public function opportunity()
    {
          return $this->belongsTo('App\Models\Opportunity', "opp_id", "id")->select(["id", "opportunity","opportunity_desc","rewards","org_uid","apply_before","tokens","expert_hrs","expert_qty","status"]);
    }
    
    
    
    public function user()
    {
        return $this->belongsTo('App\User', "user_id", "id");
    }
}
