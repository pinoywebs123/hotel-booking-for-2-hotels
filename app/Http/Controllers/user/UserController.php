<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rooms;
use App\UserTransaction;
use Auth;
use DB;
use App\UserPayment;
use App\User;
use App\Amenity;
use App\TransactionAmenity;
use Illuminate\Support\Facades\Mail;
use App\PayPerson;
use App\Category;

class UserController extends Controller
{
	public function __construct(){
		$this->middleware('customerCheck');
	}

     public function customer_home(){
        return view('user.home');
     }

    public function customer_book_now(Request $request,$id){

    	$this->validate($request, [
            'room_number'=> 'required',
            'check_in_time' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required'
         ]);  

        


    	$differenceFormat = '%a';
		$datetime1 = date_create($request['check_in_date']);
    	$datetime2 = date_create($request['check_out_date']);
    	$interval = date_diff($datetime1, $datetime2);
    	$days = intval($interval->format($differenceFormat));
       


    	 $find = Rooms::where('room_number',$request['room_number'])->first();


        $users = DB::select('SELECT * FROM `user_transactions` WHERE ((UNIX_TIMESTAMP("' . $request['check_in_date'] . '") BETWEEN UNIX_TIMESTAMP(check_in) AND UNIX_TIMESTAMP(check_out)) OR (UNIX_TIMESTAMP("' . $request['check_out_date'] . '") BETWEEN UNIX_TIMESTAMP(check_in) AND UNIX_TIMESTAMP(check_out))) AND (status_id = 1 OR status_id = 2 OR status_id = 5) AND room_id = ' . $find->room_number);

        if (count($users))
            return redirect()->back()->with('no', 'This room and date is already occupied. kindly choose another date or room!');


    	$price = $find->category->price;

        $book = new UserTransaction;
        $book->user_id = Auth::id();
        $book->room_id = $find->room_number;
        $book->status_id = 1;
        $book->check_in = $request['check_in_date'];
        $book->check_in_time =  $request['check_in_time'];
        $book->check_out = $request['check_out_date'];
        $book->occupants = $find->category->person;
        $book->bill = $price * $days;
        $book->save();

         if($find->category->hotel_id == 1){
                 $data = array('title'=> 'Margareta Pension House',
                      'content'=> 'Dear our value customers. You have chosen to check-in from '.$request['check_in_date'].' and check-out date of '.$request['check_out_date'].' at ' .$request['check_in_time']. ' you have a total bill of: '.$book->bill. '. Kindly send the money to any remittance available in your place to Aileen Makabebe receptionist from Margareta Pension House contact# 123456',
                      'email'=> Auth::user()->email
                      );
               Mail::send('auth.email', $data, function($message) use ($data){
                $message->to($data['email'])->subject('Bill of Payment for Margareta Pension House');
               });
        }else{
            $data = array('title'=> 'Velez Pension House',
                      'content'=> 'Dear our value customers. You have chosen to check-in from '.$request['check_in_date'].' and check-out date of '.$request['check_out_date'].' at ' .$request['check_in_time'].' you have a total bill of: '.$book->bill.'. Kindly send the money to any remittance available in your place to Kenneth Abril receptionist from Velez Pension House contact# 7891011',
                      'email'=> Auth::user()->email
                      );
               Mail::send('auth.email', $data, function($message) use ($data){
                $message->to($data['email'])->subject('Bill of Payment for Velez Pension House');
               });
        }



       

       return redirect()->back()->with('ok', 'You have already booked. Thank you for choosing us.');

    }

    public function customer_logout(){
        Auth::logout();
        return redirect('/');
    }

    public function customer_activity(){
        $activity = UserTransaction::where('user_id', Auth::id())->orderBy('id','desc')->get();
        return view('user.activity', compact('activity'));
    }

    public function customer_profile(){
        return view('user.profile');
    }

    public function customer_setting(){
        return view('user.setting');
    }

    public function customer_activity_view($id){
        $personnel = PayPerson::all();
        $find = UserTransaction::findOrFail($id);
        

        $differenceFormat = '%a';
        $datetime1 = date_create($find->check_in);
        $datetime2 = date_create($find->check_out);
        $interval = date_diff($datetime1, $datetime2);
        $days = intval($interval->format($differenceFormat));

        return view('user.activity_view', compact('find','days','personnel'));
    }

    public function customer_payment(Request $request, $id){
        $this->validate($request, [
            'proof'=> 'required'
        ]); 

        $image_test =  $request->proof->getClientOriginalExtension();
        if($image_test == "jpg" || $image_test == "jpeg" || $image_test == "png" || $image_test == "gif"){
            $size= getimagesize($request->proof);
        
         if($size[0] > 850 && $size[1] > 450){
            return redirect()->back()->with('ok','Image Size is to big , kindly select another one!');
         }

        $file = $request['proof'];
        $name = $file->getClientOriginalName();
        
           

        $find = UserTransaction::findOrFail($id);
         $file->move('bayad', $name); 
        $pay = new UserPayment;
        $pay->image =  $name;
        $find->proof()->save($pay);

       return redirect()->back()->with('ok','Image uploaded successfully!');
        }else{
             return redirect()->back()->with('no','Invalid Image type');
        }     
          


    }

    public function customer_password_change(Request $request){
        $this->validate($request, [
            'new_password'=> 'required|max:12',
            'retype_password'=> 'required|same:new_password'
        ]);
        $change = User::where('id', Auth::id())->update(['password'=> bcrypt($request['retype_password'])]);

        if($change){
            return redirect()->back()->with('ok', 'Password has been change successfully!.');
        }
    }

    public function customer_update_info(Request $request){
        $this->validate($request, [
            'fname' => 'required|max:20',
            'lname' => 'required|max:20',
            'contact' => 'required|max:15',
            'email' => 'required|max:30|email'
        ]);

        $update = User::where('id', Auth::id())->update(['fname'=> $request['fname'],'lname'=> $request['lname'],'contact'=> $request['contact'],'email'=> $request['email']]);

        if($update){
            return redirect()->back()->with('ok', 'Personal Information has been change successfully!.');
        }
    }

    public function customer_velez_rooms(){
         $cats = Category::where('hotel_id',2)->get();
        return view('user.velez.view', compact('cats'));
    }

    public function customer_velez_rooms_select($id){
        $cat = Category::findOrFail($id);
        return view('user.velez.rooms', compact('cat'));
    }

    public function customer_margareta_rooms(){
        $cats = Category::where('hotel_id',1)->get();
        return view('user.margareta.view', compact('cats'));
    }

    public function customer_margareta_rooms_select($id){
        $cat = Category::findOrFail($id);
        return view('user.margareta.rooms', compact('cat'));
    }
    

    

    
}
