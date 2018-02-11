<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\UserPayment;
class PaymentController extends Controller
{
  
    public function index()
    {
        return 'payment index';
    }

  
   
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=> 'required',
            'user_transaction_id'=> 'required'
        ]);

        $pay = new UserPayment;
        $pay->user_transaction_id = $request->input('user_transaction_id');
        $pay->image = $request->input('image');
        $pay->save();
        
        if($pay){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
        
    }

   
    
   
   
}
