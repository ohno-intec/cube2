<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PagesController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */


	function __construct(){

        $this->middleware('auth');


	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = DB::table('brands')->get();
        $products = DB::table('products')->get();
        return view('home', ['brands' => $brands, 'products' => $products]);
    }

	public function master() {

		return view ( 'masters.index' );

	}

    public function productsmanagement() {

        return view('masters.products.management');

    }


}

?>