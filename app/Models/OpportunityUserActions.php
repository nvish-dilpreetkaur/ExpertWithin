<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OpportunityUserActions extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'org_opportunity_user_actions';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'oid',
      'applicant_id',
      'approver_id',
      'action_type',
      'action_status',
      'org_id',
      'created_at'
    ];
    
   
}
