<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\UserTransaction;
use App\Category;
use App\PayPerson;
use App\Rooms;
use App\Record;
class MargaretaController extends Controller
{
    public function __construct(){
       $this->middleware('margaretacheck');
    }
    public function margaret_main(){
    	$rooms = UserTransaction::where('status_id',1)->orwhere('status_id',5)->orwhere('status_id',2)->orderBy('id','desc')->get();
    	return view('margareta.main', compact('rooms'));
    }

    public function margareta_logout(){
    	Auth::logout();
    	return redirect('/');
    }

     public function margareta_rooms(){
        $cats = Category::where('hotel_id',1)->get();
      

    	return view('margareta.room.list', compact('cats'));
    }

    public function margareta_create_check(Request $request){
         $this->validate($request, [
            'image'=> 'required'
        ]); 

        $image_test =  $request->image->getClientOriginalExtension();
        if($image_test == "jpg" || $image_test == "jpeg" || $image_test == "png" || $image_test == "gif"){
            

            $file = $request['image'];
            $name = $file->getClientOriginalName();
            $file->move('rooms', $name); 

            $cat = new Category;
            $cat->hotel_id = 1;
            $cat->image = $name;
            $cat->category_name = $request['room_type'];
            $cat->description = $request['room_desc'];
            $cat->price = $request['price'];
            $cat->person = $request['person'];
            $cat->save();

            return redirect()->back()->with('info', 'New Room Type added successfully!');


         
         }else{
             return redirect()->back()->with('no','Invalid Image type');
        }  


    	
    }

    public function margareta_room_in_cat(Request $request){
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

     public function margareta_rooms_create(){
    	$cats = Category::where('hotel_id',1)->get();
    	return view('margareta.room.create', compact('cats'));
    }

    public function margareta_reports(){
    	$cat = UserTransaction::all();
    	return view('margareta.report.reports',compact('cat'));

    }

    public function margareta_payment_personnel(){
    	$persons = PayPerson::where('hotel_id',1)->get();
       return view('margareta.payment.pay', compact('persons'));
    }

    public function margareta_payment_personnel_check(Request $request){
        $this->validate($request, [
            'fname'=> 'required|max:20',
            'mname'=> 'required|max:20',
            'lname'=> 'required|max:20',
            'contact'=> 'required|max:20',
            'position'=> 'required|max:20',

        ]);

        $count = PayPerson::where('hotel_id',1)->count();
       if($count == 1){
        return redirect()->back()->with('no', 'You are only allowed to have one Personnel!');
       }

        $save = new PayPerson;
        $save->hotel_id = 1;
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

    public function margareta_payment_personnel_delete($id){
       $find = PayPerson::where('id', $id)->delete();
       if($find){
        return redirect()->back()->with('ok', 'Payment Personnel has been deleted successfully!');
       }
    }

    public function margareta_cancel($id){
       
         $cancel = UserTransaction::where('id',$id)->update(['status_id'=>4]);

       if($cancel){
        return redirect()->back()->with('cancel', 'Cancel Room successfully!');
       }

    }

     public function margareta_approve($id){
        

        $find = UserTransaction::where('id',$id)->first();

        $rec = new Record;
       $rec->room_id = $find->room_id;
       $rec->status_id = 5;
       $rec->user_id = Auth::id();
       $rec->save();

       
        UserTransaction::where('id', $id)->update(['status_id'=>5]);

        return redirect()->back()->with('paid', 'Paid Room successfully!');



    }

     public function margareta_info($id){
        

        $find = UserTransaction::findOrFail($id);
        
        $differenceFormat = '%a';
        $datetime1 = date_create($find->check_in);
        $datetime2 = date_create($find->check_out);
        $interval = date_diff($datetime1, $datetime2);
        $days = intval($interval->format($differenceFormat));


        return view('margareta.info', compact('find', 'days'));


    }
}
