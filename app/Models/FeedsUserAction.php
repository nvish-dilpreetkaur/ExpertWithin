<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FeedsUserAction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'feeds_user_action';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id',
      'user_id',
      'feed_pk_id',
      'removed_feed',
      'liked_feed',
      'marked_as_fav',
      'created_by',
      'created_at'
    ];
    
   
}
