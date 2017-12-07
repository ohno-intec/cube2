<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Illuminate\Support\Facades\Request;
//use Request;
use Illuminate\Http\Request;
class RegisterController extends Controller {
	/*
	 * |--------------------------------------------------------------------------
	 * | Register Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | This controller handles the registration of new users as well as their
	 * | validation and creation. By default this controller uses a trait to
	 * | provide this functionality without requiring any additional code.
	 * |
	 */


	//https://qiita.com/saiseisei/items/26d1c1e16bb897e0b4d6

	private $key;
	protected function check_key(Request $request){

		//print_r("{{ url('register/check_key') }}", HttpRequest::Request::METH_GET);

		$post_data = new Request;
		$key = $request->input('key');
		//$postdata = Session::post();

		if($key !== env('REGISTRATION_KEY', false)){

			return redirect('register/')->with('registration_error', '登録キーが一致していません。');

		}else{

			//print_r($post_data);

			//return view('auth\register@register', compact('post_data'));
			$this->register($request);
			return redirect('/');

		}

	}
	
	use RegistersUsers;
	
	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware ( 'guest' );
	}
	
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make ( $data, [ 
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6|confirmed',
		] );
	}
	
	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data        	
	 * @return \App\User
	 */
	protected function create(array $data) {
		return User::create ( [ 
				'name' => $data ['name'],
				'email' => $data ['email'],
				'password' => bcrypt ( $data ['password'] ) 
		] );
	}
}
