<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rooms;
use DB;
class Category extends Model
{

    public function numAvailable($cat_id){
    	return Rooms::where('category_id', $cat_id)->where('status_id',0)->count();
    }

    public function numReserve($cat_id){
    	return Rooms::where('category_id', $cat_id)->where('status_id',1)->count();
    }

    public function numOccupy($cat_id){
    	return Rooms::where('category_id', $cat_id)->where('status_id',2)->count();
    }

     public function aweew($cat_id){
    	return $single = DB::select('SELECT count(user_transactions.id) as single FROM user_transactions INNER JOIN rooms ON user_transactions.room_id = rooms.room_number WHERE user_transactions.status_id = 1 AND rooms.category_id =' . $cat_id);
    }

    public function aweew2($cat_id){
        return $single = DB::select('SELECT count(user_transactions.id) as single FROM user_transactions INNER JOIN rooms ON user_transactions.room_id = rooms.room_number WHERE user_transactions.status_id = 2 AND rooms.category_id =' . $cat_id);
    }   

    public function rooms(){
        return $this->hasMany('App\Rooms');
    } 

}
