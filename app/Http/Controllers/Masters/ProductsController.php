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
        $products = DB::table('products')->orderBy('created_at','desc')->paginate(20);
        $suppliers = Supplier::all();
        $users = User::all();
        return view('masters.products.index', ['products' => $products, 'suppliers' => $suppliers, 'users' => $users ]);
    }

    public function search(Request $request){   //ajaxの場合は引数を$kewordにする

        $keyword = $request->input('keyword');
        $products = DB::table('products')->where('product_name', 'like', "%{$keyword}%")->orderBy('created_at','desc')->paginate(20);
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

        $data = Product::select('product_code', 'product_name', 'product_modelnumber', 'product_name')->get();
        csvoutput('product', $data);

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
            $file_name = preg_replace("/\.csv$/i", "", $file_name) . "_" . 'products' . '_' .time() . 'csv';
            $file_path = $file->move(storage_path().'upload', $file_name);

            $csvFile = new \SplFileObject($file_path);
            $csvFile->setFlags(\SplFileObject::READ_CSV);
            $csvFile->setCsvControl(',');

            $records = array();
            $line = array();

            function getProductCode($brand_id){

                $link = mysqli_connect("localhost", "root", "takuya" ,"cube2");
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
            foreach($csvFile as $line_key => $line){
                foreach($line as $key => $value){
                    $line[$key] = mb_convert_encoding($value, 'UTF-8', 'sjis-win');
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
                $modelnumber_count = DB::table('products')->where('product_modelnumber', $line[1])->count();
                $name_count = DB::table('products')->where('product_name', $line[3])->count();
                if($modelnumber_count > 0 || $name_count > 0){
                    array_push($error_message, '商品名'.$line[3]);
                    $error_count += 1;
                }
                $modelnumber_count = 0;
                $name_count = 0;
            }
            if($error_count > 0){
                return redirect('masters/products')->with('duplication', '重複登録が' . $error_count.'件あります。ファイルを修正して再度アップロードしてください。')->with('duplication_message', $error_message);
            }
            
            $product_code_array = array();  //商品コードの存在チェック用配列を初期化
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
                    )
                )

                */
                //対象のbrandレコードを取得

                $brand_code = $line[1];
                $brand_record = DB::table('brands')->where('brand_code', $brand_code)->first();

                $brand_id = $brand_record->id;

                //対象のsupplierレコードを取得
                $supplier_code = $line[6];
                $supplier_record = DB::table('suppliers')->where('supplier_code', $supplier_code)->first();
                $supplier_id = $supplier_record->id;

                //対象のcategoriesレコードを取得
                $category_code = $line[21]; //小分類
                $category_record = DB::table('categories')->where('category_code', $category_code)->first();
                $category_id = $category_record->id;

                //商品コード、商品名、索引を設定
                //ひとまずbrand_idから新しいproduct_codeを取得
                $new_product_code = getProductCode($brand_id);//現在商品コードの最大値プラス1

                //CSV内に同ブランドが複数存在する場合の処理 9/26ここが処理できていいない
                //$records内のブランドコードを検索して2個目以降からは+1してからproduct_codeを設定する？？
                //$new_product_codeが$records内に存在するかチェック array_keys
                $bool = "";

                //新規商品コードが$records内にあるかチェック
                foreach($records as $value){
                    if(in_array($new_product_code, $value)){
                        $bool = true;
                        $product_code_array[] = $value[0];
                     }
                }

                //getProductCodeで取得した商品コードがすでに存在する場合は新たに商品コードを生成
                if($bool === true){
                    echo "存在します！<br>";
                    //配列内に存在していた場合、array_keysの戻り値のkeyの最大値を取得して$new_product_codeに加算
                    $new_product_code = $new_product_code + max(array_keys($product_code_array, $new_product_code)) + 1;
                }else{
                    $product_code_array = array();
                }

                $product_name = $brand_record->brand_name . " " . $line[3];   //商品名を確定
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
                                        5 => $product_index,
                                        6 => $supplier_id,
                                        21 => $category_id
                                    );
                
                $line = array_replace($line, $replacements);
                $records = array_replace($records, array($key => $line));
            }


            //$user_idの追加処理
            $user_id = Auth::id();

            //DBインサート
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
                                               'product_newpricestartdate' => $line[12],
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
                                               'product_asin' => '',
                                               'user_id' => $user_id, //current user
                                               'product_smileregistration' => '新規未登録',
                                               'created_at' => date('Y-m-d H:i:s')

                                                ]);
            }
            return redirect('masters/products/management')->with('success_message', '成功しました。');
        }else{ //拡張子がcsvじゃない場合
            return redirect('masters/products/management')->with('file_type_error', '無効なファイルが送信されました。ファイル形式を確認してください。');
        }

        $data = Product::select('product_code', 'product_name', 'product_modelnumber', 'product_name')->get();
        csvoutput('products', $data);

    }

    public function batchfile_download(Request $request){

        $products = Product::where('product_smileregistration', '新規未登録')->select('product_code', 'product_name', 'product_index', 'supplier_id', 'product_unitprice', 'product_costprice', 'product_stockprice', 'product_retailprice', 'product_newpricestartdate', 'product_newunitprice', 'product_newcostprice', 'product_newstockprice', 'product_newretailprice', 'category_id', 'product_typecode', 'product_stockholdingcode', 'product_rackcode', 'product_warehouseholdingcode', 'product_properstockquantity', 'product_boystockquantity', 'product_boybalance', 'product_showmastersearch', 'product_eancode')->get();



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
        $data[] = $itemname;

        foreach($products as $key => $value){

            $supplier_id = $value['supplier_id'];
            $category_id = $value['category_id'];

            //supplier_idから仕入先コード取得
            //$supplier_record = DB::table('suppliers')->where('supplier_code', $supplier_code)->first();
            $supplier = Supplier::where('id', $supplier_id)->first();
            $supplier_code = $supplier->supplier_code;
            $supplier_name = $supplier->supplier_name;

            //category_idからカテゴリーコード取得
            $category = Category::where('id', $category_id)->first();
            $category_code = $category->category_code;
            $category_name = $category->category_name;

            //$replace = array();

            $data[] = array(
                'product_code' => $value['product_code'],
                'product_name' => $value['product_name'],
                'product_index' => $value['product_index'],
                'supplier_code' => $supplier_code,
                'supplier_name' => $supplier_name,
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
        $file_handler = storage_path().'\smile';

        $txtfile = fopen($file_handler.'\\'.$file_name, "w");

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
        return Response::download($file_handler.'\\'.$file_name, $file_name, $headers);
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
