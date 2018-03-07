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
        //$brands = DB::table('brands')->orderBy('id', 'desc')->take(10)->get();
        $brands = \App\Brand::take(30)->orderBy('id', 'desc')->get();
        $products = \App\Product::take(30)->orderBy('id', 'desc')->get();
        $updated_products = \App\Product::take(10)->orderBy('updated_at', 'desc')->get();
        return view('home', ['brands' => $brands, 'products' => $products, 'updated_products' => $updated_products]);
    }

	public function master() {

		return view ( 'masters.index' );

	}

    public function productsManagement() {


        return view('masters.products.management');

    }


}

?>