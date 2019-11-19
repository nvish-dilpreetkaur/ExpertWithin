<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Feed extends Model{
      
     /**
     * add new feed
     *
     * @param  $data
     * @return Response
     */
      public function add_feed($data = array()){
            try{ 
                  $data['org_id'] = auth()->user()->org_id;
                  $last_insert_id = DB::table('feeds')->insertGetId($data);
                  DB::commit();
                  return $last_insert_id;
            }catch(\Exception $e){
                    DB::rollBack();
                    return false;
            }
      }

      
      /**
       * get total feed count for homepage
       *
       * @param  $filters
       * @return Response
       */
      public function getfeedCount($filters = array()){
            $where[] = " t1.status = '1' ";
            $where[] = " t1.org_id = '". auth()->user()->org_id."' " ;
            
            if( !empty($where) )
                  $where = " WHERE ".implode(" AND ", $where );
            else
                  $where = " ";
            
            // echo "<pre>"; print_r($where); 
            // die;
            $query = "SELECT count(t1.id) AS record_count 
            FROM ".DB::getTablePrefix()."feeds AS t1
            LEFT JOIN ".DB::getTablePrefix()."org_opportunity AS t2 ON (t2.id = t1.key_id AND t2.status =  '".config('kloves.OPP_APPROVED')."' AND t2.org_id = '". auth()->user()->org_id."')
            LEFT JOIN ".DB::getTablePrefix()."acknoledgement AS t3 ON (t3.id = t1.key_id AND t3.status = 1) "
            .$where
            ." "; 
            //echo "<pre>"; print_r($query);  die; 
            $resultData = DB::select( DB::raw($query) )[0]; //dd($resultData);
		return $resultData->record_count;
      }

       /**
     * get feeds for homepage
     *
     * @param  $filters
     * @return Response
     */
    public function getfeedData($filters = array(), $offset = 0, $limit = null){
            $where[] = " t1.status = '1' ";
            $where[] = " t1.org_id = '". auth()->user()->org_id."' " ;
            $offset = (!empty($offset) ? $offset : 0);
            if( !empty($where) )
                  $where = " WHERE ".implode(" AND ", $where );
            else
                  $where = " ";
            
            // echo "<pre>"; print_r($where); 
            // die;
            $query = "SELECT t1.id,t1.feed_type, t1.key_id, t2.opportunity, t2.opportunity_desc, t2.rewards, t2.tokens, t3.message AS ack_message, t4.firstName AS ack_user, t5.firstName AS ack_added_by, t6.department, t7.firstName AS opp_added_by, t8.department AS opp_dept, COALESCE(t9.liked_feed,0) AS liked_feed,  COALESCE(t9.marked_as_fav,0) AS marked_as_fav
            FROM ".DB::getTablePrefix()."feeds AS t1
            LEFT JOIN ".DB::getTablePrefix()."org_opportunity AS t2 ON (t2.id = t1.key_id AND t2.status =  '".config('kloves.OPP_APPROVED')."' AND t2.org_id = '". auth()->user()->org_id."')
            LEFT JOIN ".DB::getTablePrefix()."acknoledgement AS t3 ON (t3.id = t1.key_id AND t3.status = 1) 
            LEFT JOIN ".DB::getTablePrefix()."users AS t4 ON (t4.id = t3.user_id) 
            LEFT JOIN ".DB::getTablePrefix()."users AS t5 ON (t5.id = t3.created_by) 
            LEFT JOIN ".DB::getTablePrefix()."user_profiles AS t6 ON (t6.user_id = t3.created_by) 
            LEFT JOIN ".DB::getTablePrefix()."users AS t7 ON (t7.id = t2.org_uid) 
            LEFT JOIN ".DB::getTablePrefix()."user_profiles AS t8 ON (t8.user_id = t2.org_uid) 
            LEFT JOIN ".DB::getTablePrefix()."feeds_user_action AS t9 ON (t9.feed_pk_id = t1.id) "
            .$where
            ." ORDER BY t1.created_at DESC"
            ." LIMIT  $offset, $limit "; 
            //echo "<pre>"; print_r($query);  die; 
            $queResult = DB::select( DB::raw($query) );  //prd($queResult);
            
            return $queResult;
      }
      
      /**
     * add user feed action
     *
     * @param  $data
     * @return Response
     */
    public function record_feeds_user_action($data = array()){
            try{ 
                  $last_insert_id = DB::table('feeds')->insertGetId($data);
                  DB::commit();
                  return $last_insert_id;
            }catch(\Exception $e){
                  DB::rollBack();
                  return false;
            }
      }
}
?>