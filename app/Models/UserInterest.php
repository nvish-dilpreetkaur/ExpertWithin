<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    //
		protected $table = 'user_interests';
		
		public $timestamps = false;
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "tid",
        "vid",
        "user_id"
    ];	
    
    protected $primaryKey = 'id';
    
    public function user()
    {
        return $this->belongsTo('App\User', "user_id", "id");
    }
    
    
    public function term_data()
    {
        return $this->belongsTo('App\Models\TaxonomyTerm', "tid", "tid")->select(array('tid', 'name'));
    }
}
