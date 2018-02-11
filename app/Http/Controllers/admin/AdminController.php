<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Rooms;
use App\Amenity;
use Auth;
use App\UserTransaction;
use App\Record;
use App\User;
use DB;
use App\UserPayment;
use App\TransactionAmenity;
use App\PayPerson;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('adminCheck');
    }

    public function admin_main(){
        $rooms = UserTransaction::where('status_id',1)->orwhere('status_id',5)->orwhere('status_id',2)->orderBy('id','desc')->get();
    	return view('admin.main', compact('rooms'));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function admin_rooms(){
        $cats = Category::all();
      

    	return view('admin.room.rooms', compact('cats'));
    }

    public function admin_reports(){
        $cat = UserTransaction::where('status_id',1)->get();
    	return view('admin.report.reports',compact('cat'));
    }

    public function admin_settings(){
    	return view('admin.setting.settings');
    }

    public function admin_rooms_create(){
    	$cats = Category::all();
    	return view('admin.room.create', compact('cats'));
    }

    public function admin_create_check(Request $request){
    	$cat = new Category;
        $cat->hotel_id = 1;
    	$cat->category_name = $request['room_type'];
    	$cat->description = $request['room_desc'];
    	$cat->price = $request['price'];
        $cat->person = $request['person'];
    	$cat->save();

    	return redirect()->back()->with('info', 'New Room Type added successfully!');
    }

    public function admin_room_in_cat(Request $request){
        $find = Rooms::where('room_number', $request['room_number'])->first();
        if($find){
            return redirect()->back()->with('error', 'Room Number already exist!');
        }
    	$room = new Rooms;
    	$room->category_id = $request['room_type'];
    	$room->room_number = $request['room_number'];
    	$room->status_id = 0;
    	$room->save(); 
    	return redirect()->back()->with('info2', 'New Room Type added successfully!');
    }

    public function admin_checkin(){
        $cat = UserTransaction::where('status_id',2)->get();
        return view('admin.report.checkin', compact('cat'));
    }

    public function admin_checkout(){
        $cat = UserTransaction::where('status_id',3)->get();
        return view('admin.report.checkout', compact('cat'));
    }

    public function admin_cancel(){
        $cat = UserTransaction::where('status_id',4)->get();
        return view('admin.report.cancel', compact('cat'));
    }

    public function admin_rate(){
        $cat = Category::all();
        return view('admin.report.rate', compact('cat'));
    }

    public function admin_amenities(){
         $cat = Amenity::all();
        return view('admin.report.amenities', compact('cat'));
    }
       public function admin_add_amenities(Request $request){
            


            $ams = new Amenity;
            $ams->amenities_name = $request['am_name'];
            $ams->price = $request['am_price'];
            $ams->quantity = $request['am_quantity'];
            $ams->save();

            return redirect()->back()->with('yes', 'New Customer has been added successfully!!');


       } 

    public function cancel($id){
       $cancel = UserTransaction::where('id',$id)->update(['status_id'=>4]);

       if($cancel){
        return redirect()->back()->with('cancel', 'Cancel Room successfully!');
       }
       

    }

    public function approve($id){
       $find = UserTransaction::where('id',$id)->first();

        $rec = new Record;
       $rec->room_id = $find->room_id;
       $rec->status_id = 5;
       $rec->user_id = Auth::id();
       $rec->save();

       
        UserTransaction::where('id', $id)->update(['status_id'=>5]);

        return redirect()->back()->with('paid', 'Paid Room successfully!');

    }

    public function info($id){
        $find = UserTransaction::findOrFail($id);
        $amenities = TransactionAmenity::where('user_transaction_id', $id)->get();

        $differenceFormat = '%a';
        $datetime1 = date_create($find->check_in);
        $datetime2 = date_create($find->check_out);
        $interval = date_diff($datetime1, $datetime2);
        $days = intval($interval->format($differenceFormat));


        return view('admin.info', compact('find', 'amenities', 'days'));
    }

    public function admin_walkin(){
        $cats = Category::all();
        return view('admin.walk.walk', compact('cats'));
    }

        public function admin_walkin_cat($id, $cat){

            $find = Category::where('id',$id)->first();
            $cats = Rooms::where('category_id',$id)->get();
            return view('admin.walk.walk_category', compact('cats','find'));
        }

         public function admin_walkin_book($room_no){
            $find = Rooms::where('room_number',$room_no)->first();
            $users = User::where('role_id',2)->paginate(10);
            return view('admin.walk.walk_book',compact('find','users'));
        }

        public function admin_walkin_book_search(Request $request,$room_no){
            $this->validate($request, [
                'search'=> 'required|max:20'
            ]);

            $find = Rooms::where('room_number',$room_no)->first();
            $lname = $request['search'];
            $users = User::where('lname', 'like', '%'.$lname.'%')->get();

            return view('admin.walk.walkin_search', compact('find','users'));
        }

        public function admin_walkin_new(Request $request){
            $this->validate($request, [
                'fname' => 'required|max:20',
                'lname' => 'required|max:20',
                'contact' => 'required|max:15',
                'email' => 'required|email|max:30|unique:users',
                'username' => 'required|max:20|unique:users'
            ]);
            $password = '123456789';
            $user = new User;
            $user->fname = $request['fname'];
            $user->lname = $request['lname'];
            $user->contact = $request['contact'];
            $user->email = $request['email'];
            $user->username =$request['username'];
            $user->role_id = 2;
            $user->status_id = 1;
            $user->password =  bcrypt($password);
            $user->save(); 

            
            return redirect()->back()->with('yes', 'New Customer has been added successfully!!');

        }

        public function admin_walkin_boow_now($room_no, $customer_id){
            $find = Rooms::where('room_number',$room_no)->first();
            $user = User::findOrFail($customer_id);
            $ams = Amenity::all();
            return view('admin.walk.walkin_book',compact('find','user','ams'));
        }

        public function admin_walk_me_yes(Request $request,$room_no, $customer_id){
            $time = date('G:i');
           
         $this->validate($request, [
            'totalprice' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required'

         ]);  
         $total_amenity = explode(' ', $request['total_amenity']);
         $total_quantity = explode(' ', $request['total_quantity']);
       
         

        $differenceFormat = '%a';
        $datetime1 = date_create($request['check_in_date']);
        $datetime2 = date_create($request['check_out_date']);
        $interval = date_diff($datetime1, $datetime2);
        $days = intval($interval->format($differenceFormat));



         $find = Rooms::where('room_number',$room_no)->first();

        $users = DB::select('SELECT * FROM `user_transactions` WHERE ((UNIX_TIMESTAMP("' . $request['check_in_date'] . '") BETWEEN UNIX_TIMESTAMP(check_in) AND UNIX_TIMESTAMP(check_out)) OR (UNIX_TIMESTAMP("' . $request['check_out_date'] . '") BETWEEN UNIX_TIMESTAMP(check_in) AND UNIX_TIMESTAMP(check_out))) AND (status_id = 1 OR status_id = 2 OR status_id = 5) AND room_id = ' . $find->room_number);

        if (count($users))
            return redirect()->back()->with('no', 'error');


        $price = $find->category->price;
        $book = new UserTransaction;
        $book->user_id = $customer_id;
        $book->room_id = $find->room_number;
        $book->status_id = 2;
        $book->check_in = $request['check_in_date'];
        $book->check_in_time =   $time;
        $book->check_out = $request['check_out_date'];
        $book->occupants = $request['occupants'];
        $book->bill = $request['totalprice'];
        $book->save();

        $payment = new UserPayment;
        $payment->user_transaction_id = $book->id;
        $payment->image = 0;
        $payment->save();

        // for ($i = 0; $i < sizeof($total_amenity); $i++) {


        //     $am = new TransactionAmenity;
        //     $am->user_transaction_id = $book->id;
        //     $am->amenity_id = $total_amenity[$i];
        //     $am->quantity = $total_quantity[$i];
        //     $am->save();

        // }

        // $am = new TransactionAmenity;
        //         $am->user_transaction_id = $book->id;
        //         $am->amenity_id = $wek;
        //         $am->quantity = $kwak;
        //         $am->save();

       return redirect()->back()->with('ok', 'You have already booked. Thank you for choosing us.');
        }

    public function admin_record(){
        return view('admin.guest.guest');
    }

    public function admin_users(){
        $users = User::where('role_id',3)->orwhere('role_id',4)->get();
        return view('admin.users.users',compact('users'));
    }

    public function admin_customers(){
        $users = User::where('role_id',2)->get();
        return view('admin.users.customer', compact('users'));
    }

    public function admin_new_user(Request $request){
        $this->validate($request, [
                'fname' => 'required|max:20',
                'lname' => 'required|max:20',
                'contact' => 'required|max:15',
                'email' => 'required|email|max:30|unique:users',
                'username' => 'required|max:20|unique:users',
                'password'=> 'required|max:12'
            ]);
           
            $user = new User;
            $user->fname = $request['fname'];
            $user->lname = $request['lname'];
            $user->contact = $request['contact'];
            $user->email = $request['email'];
            $user->username =$request['username'];
            $user->role_id = $request['hotel'];
            $user->status_id = 1;
            $user->password =  bcrypt($request['password']);
            $user->save(); 

            return redirect()->back()->with('yes', 'New Adminr has been added successfully!!');

    }

    public function admin_set_check_in($id){
        
        $in = UserTransaction::where('id',$id)->update(['status_id'=> 2]);
        if($in){
            return redirect()->back()->with('yes', 'Customer has been successfully Check-In.');
        }
    }

    public function admin_set_check_out($id){
        $in = UserTransaction::where('id',$id)->update(['status_id'=> 3]);
        if($in){
            return redirect()->back()->with('yes', 'Customer has been successfully Check-Out.');
        }
    }

    public function admin_rate_edit($id){
        $find = Category::findOrFail($id);
        return view('admin.rate.edit', compact('find'));
    }

    public function admin_rate_update(Request $request,$id){
        $this->validate($request, [
            'category_name' => 'required|max:50',
            'description' => 'required|max:190',
            'price' => 'required|max:5',
            'occupants' => 'required|max:3'
        ]);

        $update = Category::where('id',$id)->update(['category_name'=> $request['category_name'], 'description'=> $request['description'],'price'=> $request['price'], 'person'=> $request['occupants']]);
        if($update){
            return redirect()->back()->with('update', 'Category Type has been updated successfully!');
        }
    }

    public function admin_rate_delete($id){
        $delete = Category::where('id',$id)->delete();
        if($delete){
            return redirect()->back();
        }
    }

    public function admin_amenities_edit($id){
        $find = Amenity::findOrFail($id);
        return view('admin.amenities.edit', compact('find'));
    }

    public function admin_amenities_update(Request $request,$id){
        $this->validate($request, [
            'amenities_name' => 'required|max:50',
            'price' => 'required|max:5',
            'quantity' => 'required|max:3'
        ]);

        $update = Amenity::where('id',$id)->update(['amenities_name'=> $request['amenities_name'],'price'=> $request['price'], 'quantity'=> $request['quantity']]);
        if($update){
            return redirect()->back()->with('update', 'Amenity Type has been updated successfully!');
        }

    }

    public function admin_amenities_delete($id){
         $delete = Amenity::where('id',$id)->delete();
        if($delete){
            return redirect()->back();
        }
    }

    public function admin_user_lock($id){
        $lock = User::where('id', $id)->update(['status_id'=> 0]);
        if($lock){
            return redirect()->back();
        }
    }

    public function admin_lock_me($id){
        $lock = User::where('id', $id)->update(['status_id'=> 0]);
        if($lock){
            return redirect()->back();
        }
    }

    public function admin_password_change(Request $request){
        $this->validate($request, [
            'password'=> 'required',
            'new_password' => 'required|max:12',
            'retype_password' => 'required|same:new_password'
        ]);
     
        if(Auth::attempt(['password'=> $request['password']])){
            $change = User::where('id', Auth::id())->update(['password'=> bcrypt($request['retype_password'])]);
            if($change){
                return redirect()->back()->with('change', 'Password has been change successfully!!');
            }
        }else{
           return redirect()->back()->with('no', 'Old Password Do not match!');
        }

        
    }

    public function admin_profile(){
        return view('admin.setting.profile');
    }

    public function admin_reserve_view_modal($id){
       $find = Rooms::findOrFail($id);
       $reserve = UserTransaction::where('room_id', $find->room_number)->where('status_id',1)->get();

       return view('admin.walk.view_reserve', compact('find','reserve'));
    }

    public function admin_new_customer_twin(){
        return view('admin.users.new_customer');
    }

    public function admin_new_me(){
        return view('admin.users.new_user');
    }

    public function admin_walk_checkin_view($id){
         $find = Rooms::where('room_number',$id)->first();
        $reserve = UserTransaction::where('room_id', $find->room_number)->where('status_id',2)->get();

       return view('admin.walk.view_checkin', compact('find','reserve'));
    }

    public function admin_payment_personnel(){
        $persons = PayPerson::all();
       return view('admin.payment.pay', compact('persons'));
    }

    public function admin_payment_personnel_check(Request $request){
        $this->validate($request, [
            'fname'=> 'required|max:20',
            'mname'=> 'required|max:20',
            'lname'=> 'required|max:20',
            'contact'=> 'required|max:20',
            'position'=> 'required|max:20',

        ]);

        $count = PayPerson::count();
       if($count == 1){
        return redirect()->back()->with('no', 'You are only allowed to have one Personnel!');
       }

        $save = new PayPerson;
        $save->fname = $request['fname'];
        $save->mname = $request['mname'];
        $save->lname = $request['lname'];
        $save->contact = $request['contact'];
        $save->position = $request['position'];
        $save->save();

        if($save){
            return redirect()->back()->with('ok', 'New Personnel has been added successfully!');
        }
    }

   
    public function admin_payment_personnel_delete($id){
       $find = PayPerson::where('id', $id)->delete();
       if($find){
        return redirect()->back()->with('ok', 'Payment Personnel has been deleted successfully!');
       }
    }

}
