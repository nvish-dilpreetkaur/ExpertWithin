<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareFeed extends Model
{
    	protected $table = 'share_feed';
		
		public $timestamps = false;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			"batch_id",
			"user_id",
			"key_id",
			"share_type",
			"created_by",
			"status",
		];	
		
		protected $primaryKey = 'id';
		
		public function user()
		{
			return $this->belongsTo('App\User', "user_id", "id");
		}
		
		public function opportunity()
		{
			return $this->belongsTo('App\Models\Opportunity', "key_id", "id")->select("*");
		}
		
		
		
		public function acknoledgement()
		{
			return $this->belongsTo('App\Models\Acknoledgement', "key_id", "id")->select("*");
		}
		
		
		/*public function term_data()
		{
			return $this->belongsTo('App\Models\TaxonomyTerm', "tid", "tid")->select(array('tid', 'name'));
		}*/
}
