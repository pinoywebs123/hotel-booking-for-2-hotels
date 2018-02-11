<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\login;

use Auth;
use App\Category;
use App\Rooms;
use App\User;
class AuthController extends Controller
{
    public function index(){
        if(Auth::check()){
            if(Auth::user()->role_id == 1){
                return redirect()->route('admin_main');
            }
        }
        return view('auth.main');
    }
   
    public function login(){
        if(Auth::check()){
            if(Auth::user()->role_id == 1){
                return redirect()->route('admin_main');
            }else{
                return redirect()->route('customer_activity');
            }
        }
    	return view('auth.login');
    }

    public function loginCheck(Request $request, login $check){
    	$data = array('username'=> $request['username'], 'password'=> $request['password']);
    	if(Auth::attempt($data)){
    		if(Auth::user()->status_id == 0){
                Auth::logout();
                return view('auth.ban');
            }

            if(Auth::user()->role_id == 1){
                return redirect()->route('admin_main');
            }else if(Auth::user()->role_id == 2){
                return redirect()->route('customer_home');
            }else if(Auth::user()->role_id == 3){
                return redirect()->route('margaret_main');
            }else if(Auth::user()->role_id == 4){
                return redirect()->route('velez_main');
            }
    	
        }else{
            return redirect()->back()->with('error','Invalid Username/Password Combination!');
        }
}


   

    

   

   
   public function register(){
    return view('auth.register');
   }

   public function registerCheck(Request $request){
    $this->validate($request, [
        'fname' => 'required|max:20|unique:users',
        'lname' => 'required|max:20|unique:users',
        'contact' => 'required|max:15',
        'email' => 'required|email|max:30|unique:users',
        'username' => 'required|max:12|unique:users',
        'password' => 'required|max:12',
        'retype_password' => 'required|same:password',
    ]);
    
    $user = new User;
    $user->fname = $request['fname'];
    $user->lname = $request['lname'];
    $user->contact = $request['contact'];
    $user->username = $request['username'];
    $user->email = $request['email'];
    $user->password = bcrypt($request['retype_password']);
    $user->role_id = 2;
    $user->status_id = 1;
    $user->save();

    return redirect()->route('login')->with('reg', 'You have registered successfully!');
   }

   
}
