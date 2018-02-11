<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserTransaction;
use App\Rooms;
use App\Record;
use JWTAuth;

class ActivityController extends Controller
{
    
    public function index()
    {
        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['message'=> 'invaild user']);
        }
        $activity = UserTransaction::where('user_id', $user->id)->orderBy('id','desc')->get();

       

        foreach($activity as $vity){
            $vity->room = $vity->room->category;

        }

       return response()->json(['activity'=> $activity]);
    }

   


   
    public function show($id)
    {
         if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['message'=> 'invaild user']);
        }
        $find = UserTransaction::where('id',$id)->first();
        Rooms::where('room_number', $find->room_id)->update(['status_id'=> 0]);
         $rec = new Record;
           $rec->room_id = $find->room_id;
           $rec->status_id = 4;
           $rec->user_id = $user->id;
           $rec->save();
         $find->delete();  
         return response()->json(['status'=> true]);  
        
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
