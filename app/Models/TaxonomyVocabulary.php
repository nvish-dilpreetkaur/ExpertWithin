<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;


class TaxonomyVocabulary extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'taxonomy_vocabulary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "status",
        "created_at",
        "updated_at"
    ];

    protected $primaryKey = 'vid';


     /**
     * function to get 
     *
     * @var string taxonomy term data by taxonomy term id
     */

     function get(){

     }


  
}

