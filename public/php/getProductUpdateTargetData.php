<?php

use App\Product;
use App\Brand;
use App\Supplier;
use App\Category;
use App\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$product_id = $_POST['product_id'];
	//$product_id = file_get_contents("php://input");
	//$product_id = filter_input(INPUT_GET, 'product_id')
	//json_decode($product_id);

	$link = mysqli_connect("localhost", "root", "takuya", "cube2");
	//DBから対象のデータを検索して変数に格納
	$sqlQuery = "SELECT * FROM products WHERE id = $product_id";
	$result = mysqli_query($link, $sqlQuery);
	$product_data = mysqli_fetch_assoc($result);
	header("Content-Type: application/json; charset=utf-8");
	print_r(json_encode($product_data));

}


?>