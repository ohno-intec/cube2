<?php

use App\Product;
use App\Brand;
use App\Supplier;
use App\Category;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;	//https://readouble.com/laravel/5.4/ja/facades.html
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

require_once('dbc.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$brand_id = $_POST['brand_id'];
	$link = DBC();
	//ブランドテーブルからブランドコードを取得
	$sqlQuery = "SELECT brand_code FROM brands WHERE id=$brand_id";
	$result = mysqli_query($link, $sqlQuery);
	#$result = DB::select("SELECT brand_code FROM brands WHERE id=$brand_id");
	$brand_code = mysqli_fetch_assoc($result);
	$brand_code = $brand_code['brand_code']; //get brand_code

	//プロダクトテーブルからブランドコードを検索し、その中のプロダクトコードが最大値のものを取得
	//$sqlQuery = "SELECT max(product_code) FROM products WHERE $brand_code = LEFT(product_code,char_length(product_code)-4)";
	//プロダクトテーブルからブランドコードを検索し、特定の範囲内(該当のブランドコード内)のプロダクトコードを取得する
	$sqlQuery = "SELECT product_code FROM products WHERE product_code BETWEEN CONCAT($brand_code, '0001') AND CONCAT($brand_code, '9999')";
	if($result = mysqli_query($link, $sqlQuery)){
		while($row = mysqli_fetch_assoc($result)){
			$product_code[] = $row["product_code"];
		}
		mysqli_free_result($result);
	}

	//$product_code = $product_code['max(product_code)'];
	$check_product_code = $brand_code . '0001';
	if(isset($product_code)){
		$count_product_code = count($product_code);
		for($i=0; $i<$count_product_code; $i++){
			if($product_code[$i] == $check_product_code){
				$check_product_code += 1;
			}else{
				//$check_product_code += 1;
				break;
			}
		}
	}


	//print_r($product_code);
    if(empty($product_code)){
        $new_product_code = $brand_code . '0001';//rowが0の場合は0001を採番
        echo $new_product_code;
    }else {
        $new_product_code = $check_product_code;  //rowが1以上の場合は最大値+1の値を採番
        echo $new_product_code;
    }	

}


function getBrandCode($brand_id){
	$link = DBC();
	//ブランドテーブルからブランドコードを取得
	$sqlQuery = "SELECT brand_code FROM brands WHERE id=$brand_id";
	$result = mysqli_query($link, $sqlQuery);
	$brand_code = mysqli_fetch_assoc($result);
	$brand_code = $brand_code['brand_code']; //get brand_code
	//プロダクトテーブルからブランドコードを検索し、その中のプロダクトコードが最大値のものを取得
	$sqlQuery = "SELECT max(product_code) FROM products WHERE $brand_code = LEFT(product_code,char_length(product_code)-4)";
	$result = mysqli_query($link, $sqlQuery);
	$product_code = mysqli_fetch_assoc($result);
	$product_code = $product_code['max(product_code)'];
	//print_r($product_code);
    if(empty($product_code)){
        $new_product_code = $brand_code . '0001';//rowが0の場合は0001を採番
        return $new_product_code;
    }else {
        $new_product_code = $product_code + 1;  //rowが1以上の場合は最大値+1の値を採番
        return $new_product_code;
    }	

}

?>