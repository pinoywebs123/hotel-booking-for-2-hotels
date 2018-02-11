<?php 

namespace App\Class\Auth;

use Illuminate\Http\Requests;

class LoginReview {

	protected $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function loginChecking(){
		return $this->request;
	}
}