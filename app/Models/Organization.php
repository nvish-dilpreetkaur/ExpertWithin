<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Organization extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organisation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'street',
        'city',
        'state',
        'phone',
        'director',
        'notes',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by'       
    ];

   
     /**
     * To Display a listing of the Organizations.
     *
     * @param  $filters
     * @return Response
    */
    public function organization_list($id = "", $no_of_pages = "", $status = "")
    {
      $uid = auth()->user()->id;
      $query = DB::table('organisation')
        ->select(
          'organisation.*', 'cities.city_name', 'states.state_name'
        )
		->join('cities', 'cities.id' ,'=' ,'organisation.city')
		->join('states', 'states.id' ,'=' ,'organisation.state');
       // ->where('org_opportunity.org_uid', $uid);
      if ($status) {
        $query->where('organisation.status','=', $status);
      }
      if ($id) {
         $query->where('organisation.id', $id);
      }
      if ($no_of_pages) {
        return $query->groupBy('organisation.id')->orderBy('organisation.id', 'DESC')->paginate($no_of_pages);
      }
      else{
        return $query->groupBy('organisation.id')->orderBy('organisation.id', 'DESC')->get(); 
      }
    }
	
	   /**
     * To get cities list from cities table
     *
     * @param  $filters
     * @return Response
    */
	function getAllCities(){
		$cities = DB::table('cities')
        ->select(
          'cities.*'
        )
		->orderBy('city_name','ASC')->get(); 
		return $cities;
	}
   /**
     * To get states list from states table
     *
     * @param  $filters
     * @return Response
    */
	function getAllStates(){
		$states = DB::table('states')
        ->select(
          'states.*'
        )
		->orderBy('state_name','ASC')->get(); 
		return $states;
	}
  }