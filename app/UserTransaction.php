<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    public function room(){
    	return $this->belongsTo('App\Rooms', 'room_id', 'room_number');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function status(){
    	return $this->belongsTo('App\Status');
    }

    public function proof(){
    	return $this->hasOne('App\UserPayment');
    }
}
