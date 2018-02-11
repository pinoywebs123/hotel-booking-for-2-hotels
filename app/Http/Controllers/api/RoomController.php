<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rooms;

class RoomController extends Controller
{
    // public function __construct(){
    //     $this->middleware('jwt.auth');
    // }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Rooms::where('id', $id)->get();
        foreach($data as $data){
            $data->category = $data->category;
        }
        return response()->json(['data'=> $data]);
    }

  
   
}
