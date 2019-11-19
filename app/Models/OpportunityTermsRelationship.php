<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityTermsRelationship extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'org_opportunity_terms_rel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'oid',
        'vid',
        'tid',
        'created_at',
        'updated_at'        
    ];
    

    
}
