<?php

namespace App\Http\Controllers\Masters;

use App\Product;
use App\Brand;
use App\Supplier;
use App\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

require_once(public_path().'/php/dbc.php');
require_once(public_path().'/php/function.php');

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    protected $product;

    public function __construct(Product $product){
        $this->middleware('auth');
        $this->product = $product;
    }

    public function index()
    {
        //
        //$products = DB::table('products')->orderBy('created_at','desc')->paginate(20);
        $products = DB::table('products')->orderBy('id','asc')->paginate(50);
        $suppliers = Supplier::all();
        $users = User::all();
        return view('masters.products.index', ['products' => $products, 'suppliers' => $suppliers, 'users' => $users ]);
    }

    public function search(Request $request){   //ajaxの場合は引数を$kewordにする

        $keyword = $request->input('keyword');
        $products = DB::table('products')->where('product_name', 'like', "%{$keyword}%")->orderBy('created_at','desc')->paginate(50);
        //header('Content-Type: application/json');
        //echo json_encode($products);
        $suppliers = Supplier::all();
        $users = User::all();
        return view('masters.products.index', ['products' => $products, 'suppliers' => $suppliers, 'users' => $users ]);
    }

    public function management()
    {
        return redirect()->to('masters/products/management');
        //return view('masters.products.management');
    }

    public function smilecomplete(Request $request){

        /*
        *
        *
        *
        */
        $data = Product::find($request->id);
        echo $request->id;
        echo $request->product_smileregistration;
        $data->product_smileregistration = $request->product_smileregistration;
        $data->save();
        return redirect()->to('masters/products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $categories = Category::all();
        return view('masters.products.create', [ 'brands' => $brands, 'suppliers' => $suppliers, 'categories' => $categories ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = $request->all();

        //$user_idの追加処理
            $user_id = Auth::id();
            $data['user_id'] = $user_id;

        $this->product->fill($data);
        $this->product->save();
        //Mail::to($request->user())->send("新規商品登録依頼");

        /*
        $data = Product::select('product_code', 'product_name', 'product_modelnumber', 'product_name')->get();
        csvoutput('product', $data);
        */
        return redirect()->to('masters/products');

    }


    public function batch(Request $request)
    {
        //ファイルを受け取り
        $file = Input::file('data-file');
        $file_name = $file->getClientOriginalName();
        $line1 = $request->input('line1');

        //ファイルの整合性をチェック
        if(preg_match('/\.csv$/i', $file_name)){ //拡張子がCSVの場合
            //ファイル名を変更して移動
            $file_name = preg_replace("/\.csv$/i", "", $file_name) . "_" . 'products' . '_' .time() . '.csv';
            $file_path = $file->move(storage_path().'/upload', $file_name);

            $csvFile = new \SplFileObject($file_path);
            $csvFile->setFlags(\SplFileObject::READ_CSV);
            $csvFile->setCsvControl(',');

            $records = array();
            $line = array();

            function getProductCode($brand_id){
                $link = dbc();
                //ブランドテーブルからブランドコードを取得
                $sqlQuery = "SELECT brand_code FROM brands WHERE id=$brand_id";
                $result = mysqli_query($link, $sqlQuery);
                $brand_code = mysqli_fetch_assoc($result);
                $brand_code = $brand_code['brand_code']; //get brand_code
                //debug# echo "getProductCodeの中:".$brand_code;
                //プロダクトテーブルからブランドコードを検索し、その中のプロダクトコードが最大値のものを取得
                if($brand_code == 0){   //管理系コードの場合
                    //debug# cho "管理系コード<br />";
                    $sqlQuery = "SELECT max(product_code) FROM products WHERE product_code <= 9999";
                }else{  //商品系コードの場合
                    //debug# echo "商品系コード<br />";
                    $sqlQuery = "SELECT max(product_code) FROM products WHERE $brand_code = LEFT(product_code,char_length(product_code)-4)";
                }
                $result = mysqli_query($link, $sqlQuery);
                $product_code = mysqli_fetch_assoc($result);
                $product_code = $product_code['max(product_code)'];
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
                //debug# echo "getProductCodeが終わりました";
            }

            foreach($csvFile as $line_key => $line){
                foreach($line as $key => $value){
                    $line[$key] = mb_convert_encoding($value, 'UTF-8', 'sjis-win');//文字コードをUTF-8に変換
                }

                //If first line is item name in this data, first line is continued. 
                if($line1 == "true" && $line_key == 0){
                    continue;
                }

                //終端の空レコードを削除
                if(max(array_keys($line)) == ""){
                    continue;
                }
                $records[] = $line; //Create array of csv
            }


            //重複登録チェック、バリデーション
            $error_message = array();
            $modelnumber_count = 0;
            $name_count = 0;
            $error_count = 0;
            $line = array();


            foreach($records as $line){
                $modelnumber_count = DB::table('products')->where('product_modelnumber', $line[3])->count();
                $name_count = DB::table('products')->where('product_name', $line[4])->count();
                if($modelnumber_count > 0 || $name_count > 0){
                    array_push($error_message, '商品名:'.$line[3]);
                    $error_count += 1;
                }
                $modelnumber_count = 0;
                $name_count = 0;
            }
            if($error_count > 0){
                return redirect('/masters/products/management')->with('duplication', '重複登録が' . $error_count.'件あります。ファイルを修正して再度アップロードしてください。')->with('duplication_message', $error_message);
            }

            //debug# echo "<pre>レコード配列を展開します。<br>";
                //debug# print_r($records);
            //debug# echo "</pre>";
            $product_code_array = array();  //商品コードの存在チェック用配列を初期化
            $product_name_lencheck = null;
            //データ加工
            foreach($records as $key => $line){
                /*
                $recordsの配列構造
                array(
                    [0] => array( $key
                        [0] => 商品ｺｰﾄﾞ,
                        [1] => ブランドコード,
                        [2] => ブランド名,
                        [3] => 型番,
                        [4] => 商品名,
                        [5] => 索引
                        [6] => 主仕入先ｺｰﾄﾞ,
                        [7] => 主仕入先名,
                        [8] => 標準売上単価,
                        [9] => 標準仕入単価,
                        [10] => 在庫評価単価,
                        [11] => 上代単価,
                        [12] => 新単価実施日,
                        [13] => 新標準売上単価,
                        [14] => 新標準仕入単価,
                        [15] => 新在庫評価単価,
                        [16] => 新上代単価,
                        [17] => 在庫状況ｺｰﾄﾞ,
                        [18] => 在庫状況名,
                        [19] => 商品大分類ｺｰﾄﾞ,
                        [20] => 商品大分類名,
                        [21] => 商品小分類ｺｰﾄﾞ,
                        [22] => 商品小分類名,
                        [23] => 商品種別ｺｰﾄﾞ,
                        [24] => 商品種別名,
                        [25] => 在庫保有ｺｰﾄﾞ,
                        [26] => 在庫保有名,
                        [27] => 棚コードｺｰﾄﾞ,
                        [28] => 棚コード名,
                        [29] => 倉庫保有ｺｰﾄﾞ,
                        [30] => 倉庫保有名,
                        [31] => 適正在庫数量,
                        [32] => 期首残数量,
                        [33] => 期首残金額,
                        [34] => ﾏｽﾀｰ検索表示区分,
                        [35] => ﾏｽﾀｰ検索表示区分名,
                        [36] => JANｺｰﾄﾞ
                        [37] => ASINコード
                    )
                )

                */
                //対象のbrandレコードを取得

                $brand_code = $line[1];
                $brand_record = DB::table('brands')->where('brand_code', $brand_code)->first();
                //brand_codeでbrand_record

                //if(isset($brand_code){}
                $brand_id = $brand_record->id;

                //対象のsupplierレコードを取得
                $supplier_code = $line[6];
                $supplier_record = DB::table('suppliers')->where('supplier_code', $supplier_code)->first();
                if(is_null($supplier_record)){
                    $supplier_id = null;
                }else{
                    $supplier_id = $supplier_record->id;
                }

                //対象のcategoriesレコードを取得
                $category_code = $line[21]; //小分類
                $category_record = DB::table('categories')->where('category_code', $category_code)->first();
                if(is_null($category_record)){
                    $category_id = null;
                }else{
                    $category_id = $category_record->id;                    
                }

                //商品コード、商品名、索引を設定
                //ひとまずbrand_idから新しいproduct_codeを取得
                $new_product_code = getProductCode($brand_id);//現在商品コードの最大値プラス1
                //debug# echo "<br>DBからproduct_codeを取得しました。</br>new_product_codeは【".$new_product_code."】です。";

                //CSV内に同ブランドが複数存在する場合の処理 9/26ここが処理できていいない
                //$records内のブランドコードを検索して2個目以降からは+1してからproduct_codeを設定する？？
                //$new_product_codeが$records内に存在するかチェック array_keys

                $bool = False; //デフォルトをFalseにする→次のチェックで商品コードがまだ存在していなければFalseのまま
                //新規商品コードが$records内にあるかチェック
                //debug# echo "<br>キー".$key."、商品".$line[3]."について処理を開始します。";
                $n = 0;
                foreach($records as $checkKey => $value){
                    $n += 1;
                    //debug# echo "<br>".$n."回目の商品コード存在チェック";
                    //debug# echo "<br>-----新規商品コードの存在チェックここから------<br>";
                    //debug# echo "records内の商品コード有無をチェックします。<br>";
                    //debug# echo "keyの確認".$key."と".$checkKey."です。<br>";
                    if($new_product_code == $value[0] && $key == $checkKey){    //in_array($new_product_code, $value)
                        //debug# echo "records内に商品コードが存在します<br>";
                        //debug# echo "keyの確認".$key."と".$checkKey."です。商品は".$value[3]."です。<br>";
                        //debug# echo "<br>".$value[3]."<br>";
                        $bool = True;
                        //debug# echo "<br>product_code_arrayを出力します<br>";
                        //debug# print_r($product_code_array);
                        if(empty($product_code_array)){
                            $product_code_array[] = $value[0];
                        }else{
                            //debug# echo "<br>product_code_arrayにプッシュします。1<br>";
                            $product_code_array[] = max($product_code_array) + 1;
                        }
                    }elseif($value[0] !== "" && $key == $checkKey){
                        //debug# echo "records内の指定商品コードと一致しました。<br>";
                        //debug# echo "keyの確認".$key."と".$checkKey."です。商品は".$value[3]."です。<br>";
                        //debug# echo "指定商品コードは".$value[0]."です。<br>";

                        //debug# echo "<br>product_code_arrayにプッシュします。2<br>";
                        $product_code_array[] = $value[0];
                        $bool = true;
                    }elseif($value[0] == "" && $key == $checkKey && in_array($new_product_code, $product_code_array)){
                        
                        $counta = count($product_code_array);
                        for($i=0; $i<$counta; $i++){
                            $new_product_code += 1;
                            if(!in_array($new_product_code, $product_code_array)){
                                break;
                            }
                        }
                        //debug# echo "<br>product_code_arrayにプッシュします。3<br>";
                        $product_code_array[] = $new_product_code;
                        $bool = true;

                    }else{
                            //debug# echo "商品コードは一致しません。<br>";
                            //debug# echo "keyの確認".$key."と".$checkKey."です。商品は".$value[3]."です。<br>";
                    }
                    //debug# echo "<br>-----新規商品コードの存在チェックここまで------<br>";
                }

                //getProductCodeで取得した商品コードがすでに存在する場合は新たに商品コードを生成
                //debug# echo "<br>recordsに商品コードが存在するかどうかのboolean:".$bool."<br>";
                if($bool){
                    //配列内に存在していた場合、array_keysの戻り値のkeyの最大値を取得して$new_product_codeに加算
                    //debug# echo "<pre>";
                    //debug# echo print_r($product_code_array);
                    //debug# echo "</pre>";
                    if($line[1] == 0){ //11/1追加
                        //debug# echo "管理系コードの場合";
                        $new_product_code = $new_product_code + max(array_keys($product_code_array));
                        //debug# echo "<br>新たに商品コードを設定しました<br>".$new_product_code;
                    }else{
                        //debug# echo "商品系コードの場合</br></br>";

                        if(!empty($line[0])){ //CSVファイルに商品コードが指定されていた場合
                            //debug# echo "<br>CSVファイルに商品コードが指定されています。<br>";
                            $new_product_code = $line[0];
                            $designation_code = true;
                        }else{

                            $designation_code = false;
                            //$new_product_code = $new_product_code + max(array_keys($product_code_array)) + 1;
                        }
                    }
                }else{
                    //debug# echo "records内に商品コードが存在しないのでproduct_code_arrayを初期化します</br></br>";
                    $product_code_array = array();
                    //debug# echo "最初のブランド行です。product_code_arrayを設定します";
                    //debug# echo "<br>product_code_arrayにプッシュします。5<br>";
                    $product_code_array[] = $new_product_code;
                }

                $product_name = $brand_record->brand_name . " " . $line[3];   //商品名を確定

                if(strlen( mb_convert_encoding($product_name, 'SJIS', 'UTF-8') ) > 36){

                    $product_name_lencheck[] = $product_name;

                }

                $product_index = substr(mb_strtolower($line[3]), 0, 10);   //型番を小文字にする


                //要素が空の場合、nullに変換 これをやらないとDB insert時にエラー
                foreach($line as $key2 => $line2){
                    if($line2 == ""){
                        $line = array_replace($line, array($key2 => null));
                    }
                }
                unset($line2);

                //配列書き換え
                $replacements = array(
                                        0 => $new_product_code,
                                        1 => $brand_id,
                                        4 => $product_name,
                                        //5 => $product_index,
                                        6 => $supplier_id,
                                        21 => $category_id
                                    );
                
                $line = array_replace($line, $replacements);
                $records = array_replace($records, array($key => $line));


                /*
                array(
                    [0] => array( $key
                        [0] => 商品ｺｰﾄﾞ, numeric
                        [1] => ブランドコード, numeric
                        [2] => ブランド名,
                        [3] => 型番, string
                        [4] => 商品名, string
                        [5] => 索引, string
                        [6] => 主仕入先ｺｰﾄﾞ, numeric
                        [7] => 主仕入先名, 
                        [8] => 標準売上単価, numeric
                        [9] => 標準仕入単価, numeric
                        [10] => 在庫評価単価, numeric
                        [11] => 上代単価, numeric
                        [12] => 新単価実施日,
                        [13] => 新標準売上単価, numeric
                        [14] => 新標準仕入単価, numeric
                        [15] => 新在庫評価単価, numeric
                        [16] => 新上代単価, numeric
                        [17] => 在庫状況ｺｰﾄﾞ, numeric
                        [18] => 在庫状況名,
                        [19] => 商品大分類ｺｰﾄﾞ, numeric
                        [20] => 商品大分類名,
                        [21] => 商品小分類ｺｰﾄﾞ, numeric
                        [22] => 商品小分類名,
                        [23] => 商品種別ｺｰﾄﾞ, numeric
                        [24] => 商品種別名,
                        [25] => 在庫保有ｺｰﾄﾞ, numeric
                        [26] => 在庫保有名,
                        [27] => 棚コードｺｰﾄﾞ, numeric
                        [28] => 棚コード名,
                        [29] => 倉庫保有ｺｰﾄﾞ, numeric
                        [30] => 倉庫保有名,
                        [31] => 適正在庫数量, numeric
                        [32] => 期首残数量, numeric
                        [33] => 期首残金額, numeric
                        [34] => ﾏｽﾀｰ検索表示区分, numeric
                        [35] => ﾏｽﾀｰ検索表示区分名,
                        [36] => JANｺｰﾄﾞ numeric
                        [37] => ASINコード string
                    )
                )
                */
                //データ型のチェック

                if(!is_numeric($line[0]) && !empty($line[0])){
                    $dataTypeCheckArray[] = $line[0];
                }elseif(!is_numeric($line[1]) && !empty($line[1])){
                    $dataTypeCheckArray[] = $line[1];
                }elseif(!is_string($line[3]) && !empty($line[3])){
                    $dataTypeCheckArray[] = $line[3];
                }elseif(!is_string($line[4]) && !empty($line[4])){
                    $dataTypeCheckArray[] = $line[4];
                }elseif(!is_string($line[5]) && !empty($line[5])){
                    $dataTypeCheckArray[] = $line[5];
                }elseif(!is_numeric($line[6]) && !empty($line[6])){
                    $dataTypeCheckArray[] = $line[6];
                }elseif(!is_numeric($line[8]) && !empty($line[8])){
                    $dataTypeCheckArray[] = $line[8];
                }elseif(!is_numeric($line[9]) && !empty($line[9])){
                    $dataTypeCheckArray[] = $line[9];
                }elseif(!is_numeric($line[10]) && !empty($line[10])){
                    $dataTypeCheckArray[] = $line[10];
                }elseif(!is_numeric($line[11]) && !empty($line[11])){
                    $dataTypeCheckArray[] = $line[11];
                }elseif(!is_numeric($line[13]) && !empty($line[13])){
                    $dataTypeCheckArray[] = $line[13];
                }elseif(!is_numeric($line[14]) && !empty($line[14])){
                    $dataTypeCheckArray[] = $line[14];
                }elseif(!is_numeric($line[15]) && !empty($line[15])){
                    $dataTypeCheckArray[] = $line[15];
                }elseif(!is_numeric($line[16]) && !empty($line[16])){
                    $dataTypeCheckArray[] = $line[16];
                }elseif(!is_numeric($line[17]) && !empty($line[17])){
                    $dataTypeCheckArray[] = $line[17];
                }elseif(!is_numeric($line[19]) && !empty($line[19])){
                    $dataTypeCheckArray[] = $line[19];
                }elseif(!is_numeric($line[21]) && !empty($line[21])){
                    $dataTypeCheckArray[] = $line[21];
                }elseif(!is_numeric($line[23]) && !empty($line[23])){
                    $dataTypeCheckArray[] = $line[23];
                }elseif(!is_numeric($line[25]) && !empty($line[25])){
                    $dataTypeCheckArray[] = $line[25];
                }elseif(!is_numeric($line[27]) && !empty($line[27])){
                    $dataTypeCheckArray[] = $line[27];
                }elseif(!is_numeric($line[29]) && !empty($line[29])){
                    $dataTypeCheckArray[] = $line[29];
                }elseif(!is_numeric($line[31]) && !empty($line[31])){
                    $dataTypeCheckArray[] = $line[31];
                }elseif(!is_numeric($line[32]) && !empty($line[32])){
                    $dataTypeCheckArray[] = $line[32];
                }elseif(!is_numeric($line[33]) && !empty($line[33])){
                    $dataTypeCheckArray[] = $line[33];
                }elseif(!is_numeric($line[34]) && !empty($line[34])){
                    $dataTypeCheckArray[] = $line[34];
                }elseif(!is_numeric($line[36]) && !empty($line[36])){
                    $dataTypeCheckArray[] = $line[36];
                }elseif(!is_string($line[37]) && !empty($line[37])){
                    $dataTypeCheckArray[] = $line[37];
                }

                if(!empty($dataTypeCheckArray)){
                    $key_names[] = $line[4];
                    $dataTypeCheck[] = $dataTypeCheckArray;
                }
               $dataTypeCheckArray = array();
            }

            if(isset($product_name_lencheck)){
                return redirect('/masters/products/management')->with('product_name_lencheck', '商品名が長すぎます。')->with('product_name_lencheck_array', $product_name_lencheck);
            }

            if(!empty($dataTypeCheckArray)){
                $dataTypeCheck = array_combine($key_names, $dataTypeCheck);
            }
            /*
            try{
                if(isset($dataTypeCheck)){
                }
            }catch(\Exception $e){
                redirect('masters/products/management')->with('data_type_error', $e)->with('data_type_error_array', $dataTypeCheckArray);
            }*/

            if(isset($dataTypeCheck)){
                return redirect('/masters/products/management')->with('data_type_error', 'データ型に誤りがあります。')->with('data_type_error_array', $dataTypeCheck);
            }


            //$user_idの追加処理
            $user_id = Auth::id();

            //DBインサート
            $i = 0;
           //dd(print_r($user_id));
            try {
            DB::beginTransaction();

                foreach($records as $line){
                    DB::table('products')->insert(['brand_id' => $line[1], //brand_codeからｂbrands DBを検索してbrand_idを取得
                                                   'product_code' => $line[0], //brand_codeでproducts DBを検索して、範囲内の最大値+1を取得 同じブランドがあった場合は増えるごとにプラス1する
                                                   'product_modelnumber' => $line[3],
                                                   'product_name' => $line[4],
                                                   'product_index' => $line[5],
                                                   'supplier_id' => $line[6],
                                                   'product_unitprice' => $line[8],
                                                   'product_costprice' => $line[9],
                                                   'product_stockprice' => $line[10],
                                                   'product_retailprice' => $line[11],
                                                   'product_newpricestartdate' => $line[12] == 0 ? null : $line[12],
                                                   'product_newunitprice' => $line[13],
                                                   'product_newcostprice' => $line[14],
                                                   'product_newstockprice' => $line[15],
                                                   'product_newretailprice' => $line[16],
                                                   'category_id' => $line[21],
                                                   'product_typecode' => $line[23],
                                                   'product_stockholdingcode' => $line[25],
                                                   'product_rackcode' => $line[27],
                                                   'product_warehouseholdingcode' => $line[29],
                                                   'product_properstockquantity' => $line[31],
                                                   'product_boystockquantity' => $line[32],
                                                   'product_boybalance' => $line[33],
                                                   'product_showmastersearch' => $line[34],
                                                   'product_eancode' => $line[36],
                                                   'product_asin' => $line[37],
                                                   'user_id' => $user_id, //current user
                                                   'product_smileregistration' => $designation_code == true ? '新規登録済' : '新規未登録',
                                                   'created_at' => date('Y-m-d H:i:s')
                                                    ]);
                    $i += 1;
                }

                DB::commit();
            }
            catch(\Exception $e) {
                DB::rollback();

                dd($e);

                //$eArray = (array)$e;
                $eArray = json_decode(json_encode($e), true);
                //dd($eArray);
                return redirect('masters/products/management')->with('exception_error', '登録中にエラーが発生しました。エラーメッセージを確認してください。')->with('exception_message', $eArray);

            }
            return redirect('masters/products/management')->with('success_message', '成功しました。');
        }else{ //拡張子がcsvじゃない場合
            return redirect('masters/products/management')->with('file_type_error', '無効なファイルが送信されました。ファイル形式を確認してください。');
        }

        $data = Product::select('product_code', 'product_name', 'product_modelnumber', 'product_name')->get();
        csvoutput('products', $data);

    }

    public function batchfile_download(Request $request){

        $products = Product::where('product_smileregistration', '=', '新規未登録')->select('product_code', 'product_name', 'product_index', 'supplier_id', 'product_unitprice', 'product_costprice', 'product_stockprice', 'product_retailprice', 'product_newpricestartdate', 'product_newunitprice', 'product_newcostprice', 'product_newstockprice', 'product_newretailprice', 'category_id', 'product_typecode', 'product_stockholdingcode', 'product_rackcode', 'product_warehouseholdingcode', 'product_properstockquantity', 'product_boystockquantity', 'product_boybalance', 'product_showmastersearch', 'product_eancode')->get();

            echo "<pre>";
            var_dump($products->category_id);
            echo "</pre>";
            dd();
        //$productsをforeachで回してデータを修正

        $itemname = array(
            'product_code' => "商品ｺｰﾄﾞ",
            'product_name' => "商品名",
            'product_index' => "商品名索引",
            'supplier_code' => "主仕入先ｺｰﾄﾞ",
            'supplier_name' => "主仕入先名",
            'product_unitprice' => "標準売上単価",
            'product_costprice' => "標準仕入単価",
            'product_stockprice' => "在庫評価単価",
            'product_retailprice' => "上代単価",
            'product_newpricestartdate' => "新単価実施日",
            'product_newunitprice' => "新標準売上単価",
            'product_newcostprice' => "新標準仕入単価",
            'product_newstockprice' => "新在庫評価単価",
            'product_newretailprice' => "新上代単価",
            'product_stockstatuscode' => '在庫状況ｺｰﾄﾞ',/*this item isn't in DB. */
            'product_sotcksatusname' => '在庫状況名',
            'bigcategory_code' => "商品大分類ｺｰﾄﾞ",
            'bigcategory_name' => '商品大分類名',
            'smallcategory_code' => "商品小分類ｺｰﾄﾞ",
            'smallcategory_name' => "商品小分類名",
            'product_typecode' => "商品種別ｺｰﾄﾞ",
            'product_typename' => '商品種別名',
            'product_stockholdingcode' => "在庫保有ｺｰﾄﾞ",
            'product_stockholdingname' => "在庫保有名",
            'product_rackcode' => "棚コードｺｰﾄﾞ",
            'product_rackname' => '棚コード名',
            'product_warehouseholdingcode' => "倉庫保有ｺｰﾄﾞ",
            'product_warehouseholdingname' => "倉庫保有名",
            'product_properstockquantity' => "適正在庫数量",
            'product_boystockquantity' => "期首残数量",
            'product_boybalance' => "期首残金額",
            'product_showmastersearch' => "ﾏｽﾀｰ検索表示区分",
            'product_showmastersearchname' => "ﾏｽﾀｰ検索表示区分名",
            'product_eancode' => "JANｺｰﾄﾞ"
        );
        //ダウンロードファイル用の項目名を設定
        $data[] = $itemname;



        foreach($products as $key => $value){

            $supplier_id = $value['supplier_id'];
            $category_id = $value['category_id'];

            //supplier_idから仕入先コード取得
            //$supplier_record = DB::table('suppliers')->where('supplier_code', $supplier_code)->first();
            if(!is_null($supplier_id)){
                $supplier = Supplier::where('id', '=', $supplier_id)->first();
                $supplier_code = $supplier->supplier_code;
                $supplier_name = $supplier->supplier_name;
            }

            //category_idからカテゴリーコード取得
            if(!is_null($category_id)){
                $category = Category::where('id', '=', $category_id)->first();
                $category_code = $category->category_code;
                $category_name = $category->category_name;
            }


            //$replace = array();

            $data[] = array(
                'product_code' => $value['product_code'],
                'product_name' => $value['product_name'],
                'product_index' => $value['product_index'],
                'supplier_code' => isset($supplier_code) ? $supplier_code : "",
                'supplier_name' => isset($supplier_name) ? $supplier_name : "",
                'product_unitprice' => $value['product_unitprice'],
                'product_costprice' => $value['product_costprice'],
                'product_stockprice' => $value['product_stockprice'],
                'product_retailprice' => $value['product_retailprice'],
                'product_newpricestartdate' => $value['product_newpricestartdate'],
                'product_newunitprice' => $value['product_newunitprice'],
                'product_newcostprice' => $value['product_newcostprice'],
                'product_newstockprice' => $value['product_newstockprice'],
                'product_newretailprice' => $value['product_newretailprice'],
                'product_stockstatuscode' => '',/*this item isn't in DB. */
                'product_sotcksatusname' => '',
                'bigcategory_code' => substr($category_code, 0 ,2),
                'bigcategory_name' => '',
                'smallcategory_code' => $category_code,
                'smallcategory_name' => $category_name,
                'product_typecode' => $value['product_typecode'],
                'product_typename' => '',
                'product_stockholdingcode' => $value['product_stockholdingcode'],
                'product_stockholdingname' => $value['product_stockholdingcode']===2 ? "有り" : "無し",
                'product_rackcode' => $value['product_rackcode'],
                'product_rackname' => '',
                'product_warehouseholdingcode' => $value['product_warehouseholdingcode'],
                'product_warehouseholdingname' => $value['product_warehouseholdingcode']===2 ? "有り" : "無し",
                'product_properstockquantity' => $value['product_properstockquantity'],
                'product_boystockquantity' => $value['product_boystockquantity'],
                'product_boybalance' => $value['product_boybalance'],
                'product_showmastersearch' => $value['product_showmastersearch'],
                'product_showmastersearchname' => $value['product_showmastersearch']===0 ? "表示する" : "表示しない",
                'product_eancode' => $value['product_eancode']
            );    

        }

        //新規CSVファイル生成

        $file_name = 'smile_newproducts_reg_'.time().'.txt'; //CSVにする場合は拡張子変更
        $file_handler = storage_path().'/smile';

        $txtfile = fopen($file_handler.'/'.$file_name, "w");

        if($txtfile){
            foreach($data as $value){
                mb_convert_variables('SJIS-win','UTF-8', $value);
                //fputcsv($csvfile, $value, '\t'); //CSVにする場合はこれ
                foreach($value as $string){
                    fwrite($txtfile, $string."\t");
                }
                fwrite($txtfile, "\n");

            }
        }
        fclose($txtfile);

        //ダウンロードURLを戻す
        $headers = ['Content-Type' => 'text/csv'];
        return Response::download($file_handler.'/'.$file_name, $file_name, $headers);
        //return redirect('masters/products')->with('download_path', $file_handler.'\\'.$file_name)->with('file_name', $file_name);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $users = User::all();
        return view('masters.products.show', [ 'product' => $product, 'brands' => $brands, 'suppliers' => $suppliers, 'users' => $users , 'categories' => $categories]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product )
    {
        //
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $users = User::all();

        
        return view('masters.products.edit', [ 'product' => $product, 'brands' => $brands, 'suppliers' => $suppliers, 'users' => $users , 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $data = $request->all();
        $product->fill($data);
        $product->save();
        return redirect()->to('masters/products');

    }

    public function batch_update(){


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return redirect('masters/products');
    }
}
