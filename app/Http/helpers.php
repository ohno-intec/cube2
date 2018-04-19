<?php
use App\Product;
use App\Brand;
use App\Category;
use App\User;

use Illuminate\Support\Facades\DB;  //https://readouble.com/laravel/5.4/ja/facades.html
use Illuminate\Http\Request;

if(! function_exists('getProductCode')) {
	/**
	*
	* 新しいブランドコードを取得する関数
	*
	* @param string $value
	* @return 
	*
	*/
    function getProductCode($brand_id){

        /**
        *
        * プロダクトテーブルからブランドコードを検索し、その中のプロダクトコードが最大値のものを取得
        *　取得したプロダクトコードに1を足す
        *　スポットコード(末尾が9999)を考慮する
        * 
        * @param 
        * @return $new_product_code
        *
        *
        *
        */
        //

        //ブランドテーブルからブランドコードを取得
        $brand_code = DB::table('brands')->where('id', $brand_id)->value('brand_code');
        if($brand_code == 0){   //管理系コードの場合
            $product_code = DB::table('products')->where('product_code', '<=', '9989')->max('product_code'); //9999はスポットコードのため
        }else{  //商品系コードの場合
            //プロダクツテーブルでプロダクトコードの左3桁とブランドコードが一致する中の最大のプロダクトコード
            //$product_code = DB::table('products')->orWhere(DB::raw('LEFT(product_code, char_length(product_code)-4)'), '=', $brand_code)->orWhere('product_code', '<=', '9998');
            //$sqlQuery = "SELECT max(product_code) FROM products WHERE $brand_code = LEFT(product_code, char_length(product_code)-4)";
            //$product_code = DB::table('products')->where('brand_id', '=', $brand_id)->where(RIGHT('product_code, 4'), '<=', '9998')->max('product_code');
            
            $product_code = DB::table('products')->where('brand_id', '=', $brand_id)->where(DB::raw('RIGHT(product_code, 4)'), '<=', '9989')->max('product_code');

        }
        //print_r($product_code);
        if(empty($product_code)){
            //debug# echo "商品コードは空<br />";
            if($brand_code == 0){
                //debug# echo "管理系コード";
                $new_product_code = 1;//rowが0の場合は1を採番
                return $new_product_code;
            }else{
                //debug# echo "商品系コード<br />";
                $new_product_code = $brand_code . '0001';//rowが0の場合は0001を採番
                return $new_product_code;
            }
        }else{
            //debug# echo "商品コードは存在<br />";
            $new_product_code = $product_code + 1;  //rowが1以上の場合は最大値+1の値を採番
            return $new_product_code;
        }
    }


}


if(!function_exists('fm_slack')){ // fm_slack = free message to slack

    function fm_slack($message = "何かアクションが起こりましたが、メッセージが含まれていません。"){
        $slackApikey = env('SLACK_API_KEY');
        $text = $message;
        $text = urlencode($text);
        $channel = ($_SERVER['SERVER_NAME'] == "cube2.intec1998.co.jp") ? "if_cube2" : "if_dev-cube2" ;
        $url = "https://slack.com/api/chat.postMessage?token=".$slackApikey."&channel=%23".$channel."&text=".$text."&as_user=true";
        file_get_contents($url);
    }

}