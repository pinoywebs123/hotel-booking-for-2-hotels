<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function room(){
    	return $this->belongsTo('App\Rooms', 'room_id', 'room_number');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
