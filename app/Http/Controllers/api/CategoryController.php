<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Rooms;
class CategoryController extends Controller
{
    // public function __construct(){
    //     $this->middleware('jwt.auth');
    // }
    public function index()
    {
        $cats = Category::all();
        return response()->json(['data'=> $cats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rooms = Rooms::where('category_id', $id)->where('status_id', 0)->get();
        $cats = Category::where('id', $id)->first();
        return response()->json(['data'=> $rooms, 'category'=> $cats]);
        
    }

    
   
}
