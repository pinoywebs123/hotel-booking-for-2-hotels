<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\Amenity;
use App\UserTransaction;
use App\Rooms;
use App\User;
use DB;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth', ['only'=> ['amenities', 'book','change_password']]);
    }

    public function login(Request $request){
    	$this->validate($request, [
    		'username'=> 'required|max:12',
    		'password'=> 'required|max:12'
    	]);

    	$data = $request->only('username','password');
    	try{
    		if(! $token = JWTAuth::attempt($data)){
    			return response()->json(['status'=> false]);
    		}
    	}catch(JWTException $e){
    		return response()->json(['error'=> $e],500);
    	}

    	return response()->json(['key'=> $token, 'status'=> true]);
    }

    public function amenities(){
         if(!$user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['status'=> false]);
           }
        $data = Amenity::all();
        return response()->json(['data'=> $data]);
    }

    public function book(Request $request){
       if(!$user = JWTAuth::parseToken()->authenticate()){
        return response()->json(['status'=> false]);
       }
        $this->validate($request, [
            'check_in' => 'required|max:25',
            'check_out' => 'required|max:25',
            'occupants' => 'required|max:25',
            'bill' => 'required|max:25',
            'check_in_time' => 'required|max:25',
            "room_id"=> 'required|max:10'
            
        ]);

      
        $find = Rooms::where('room_number',$request->input('room_id'))->first();

         $users = DB::select('SELECT * FROM `user_transactions` WHERE ((UNIX_TIMESTAMP("' . $request->input('check_in') . '") BETWEEN UNIX_TIMESTAMP(check_in) AND UNIX_TIMESTAMP(check_out)) OR (UNIX_TIMESTAMP("' . $request->input('check_out') . '") BETWEEN UNIX_TIMESTAMP(check_in) AND UNIX_TIMESTAMP(check_out))) AND (status_id = 1 OR status_id = 2 OR status_id = 5) AND room_id = ' . $find->room_number);

        if (count($users)){
            return response()->json(['status'=> false]);
        }
           


       


        $book = new UserTransaction;
        $book->user_id = $user->id;
        $book->status_id = 1;
        $book->room_id  = $request->input('room_id');
        $book->check_in_time = $request->input('check_in_time');
        $book->check_in = $request->input('check_in');
        $book->check_out = $request->input('check_out');
        $book->occupants = $request->input('occupants');
        $book->bill = $request->input('bill');
        $book->check_in_time = $request->input('check_in_time');
        $book->save();

        return response()->json(['status'=> true]);
       
       

        
    }

    public function signme(Request $request){
        $this->validate($request, [
            'fname'  => 'required|max:20',
            'lname' => 'required|max:20|max:20',
            'email' => 'required|max:30',
            'username' => 'required|max:12',
            'password' => 'required|max:12',
            'repeat_password' => 'required|same:password',
            'contact'=> 'required|max:15'
        ]);

        $user = new User;
        $user->fname = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('repeat_password'));
        $user->contact = $request->input('contact');
        $user->role_id = 2;
        $user->status_id = 1;
        $user->save();

        if($user){
            return response()->json(['status'=> true]);
        }

        return response()->json($request);

    }

    public function change_password(Request $request){
        $this->validate($request, [
            'new_password' => 'required|max:12',
            'repeat_password'=> 'required|same:new_password'
        ]);

        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['status'=> 'no id']);
        }
        
        $find = User::where('id', $user->id)->update(['password'=> bcrypt($request->input('new_password'))]);

        if($find){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }

    }






}
