<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserTransaction;

class Rooms extends Model
{
    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function reserve($room){
    	return UserTransaction::where('room_id', $room)->where('status_id',1)->count();
    }

    public function occupied($room){
    	return UserTransaction::where('room_id', $room)->where('status_id',2)->count();
    }

   
}
