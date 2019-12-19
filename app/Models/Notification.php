<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
		
	public $timestamps = false;

    public function sender()
    {
        return $this->belongsTo('App\User', "sender_id", "id");
    }

    public function recipient()
    {
        return $this->belongsTo('App\User', "recipient_id", "id");
    }

    public function opportunity()
    { 
        $type_list =  array(
                config('kloves.NOTI_SHARED_OPP')
        );
        return $this->belongsTo('App\Models\Opportunity', "key_value", "id")->select(array('id', 'opportunity'));
    }

}
?>