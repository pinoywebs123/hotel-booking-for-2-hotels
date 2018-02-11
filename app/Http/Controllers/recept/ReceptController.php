<?php

namespace App\Http\Controllers\recept;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceptController extends Controller
{
	public function __construct(){
		$this->middleware('receptionCheck');
	}
    public function recept_main(){
    	return view('recept.main');
    }
}
