<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
class TaxonomyTerm extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
	 protected $primaryKey = 'tid';
	
   protected $table = 'taxonomy_term_data';
   
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
	  protected $fillable = [
			'tid',
			'vid',
			'name',
			'description',
			'status',
			'created_at',
			'updated_at'        
	  ];
	 /**
     * function to get 
     *
     * @var string taxonomy term data by taxonomy vocabulary id
     */
	function getTaxonomyTermDataByVid($vid = null,$orderBy = null){
		$resultData = [];
		$where[] = " t1.vid = '".$vid."' ";
		$where[] = " t1.status = '".config('kloves.RECORD_STATUS_ACTIVE')."' ";
		
		$orderByStr = (!empty($orderBy) && ($orderBy==1) ? ' t2.opp_count DESC' : ' t1.name ASC ');
		
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " ";

	
		$query = " SELECT t1.name, t1.tid, t2.opp_count 
		FROM ".DB::getTablePrefix()."taxonomy_term_data AS t1
		LEFT JOIN ".DB::getTablePrefix()."vw_txm_opportunity_count AS t2 ON (t1.tid = t2.tid) "
		.$where
		." ORDER BY $orderByStr ";
		//echo print_r($query);
		$resultData = DB::select( DB::raw($query) );
		return $resultData;
	}
	
	 /**
     * function to get 
     *
     * @var string taxonomy term data by taxonomy term id
     */
	function getTaxonomyTermDataByTids($tid = null, $ordering = ''){
		$resultData = []; 
		$where[] = " status = '".config('kloves.RECORD_STATUS_ACTIVE')."' ";
		$where[] = " tid IN (".trim($tid,", ").") ";
		if( !empty($where) )
			$where = " WHERE ".implode(" AND ", $where );
		else
			$where = " "; 
		//echo $where ; die;
		if(!empty($ordering)){
			$orderBy = " ORDER BY FIELD(tid,$ordering) ASC ";
		}else{
			$orderBy = " ORDER BY name ASC ";
		}
		
		if(!empty($tid)){
			$query = " SELECT `name`, `tid` 
						 FROM ".DB::getTablePrefix()."taxonomy_term_data  "
						.$where
						.$orderBy;
			
			$resultData = DB::select( DB::raw($query) );
		}
		//echo $query ; die;
		return $resultData;
	}
}
