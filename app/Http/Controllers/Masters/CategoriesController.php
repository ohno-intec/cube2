<?php

namespace App\Http\Controllers\Masters;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $category;

    public function __construct(Category $category){
        $this->middleware('auth');
        $this->category = $category;
    }


    public function index()
    {
        //
        $categories = Category::all();
        return view('masters.categories.index', ['categories' => $categories]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('masters.categories.create');

    }

    public function batch()
    {

        //ファイル受け取り
        $file = Input::file('data-file'); //ファイル受け取り
        $file_name = $file->getClientOriginalName();    //ファイル名取得
        //ファイルの整合性をチェック

        if(preg_match('/\.csv$/i', $file_name)){ //拡張子がcsvの場合
            //ファイル名を変更して移動
            $file_name = preg_replace('/\.csv$/i', "", $file_name).'_'.'categories'.'_'.time().'csv';
            $file_path = $file->move(storage_path().'/upload', $file_name);
            //csvファイル読み取り
            $csv_file = new \splFileObject($file_path);
            $csv_file->setFlags(\splFileObject::READ_CSV);
            $csv_file->setCsvControl(',');

            //配列初期化
            $records = array();
            $line = array();

            foreach($csv_file as $line){
                //エンコーディング変換
                foreach($line as $key => $value){
                    $line[$key] = mb_convert_encoding($value, 'UTF-8', 'sjis-win');
                }

                //1行目の項目と終端の空行を削除
                if($line[0] == "category_type" || $line[0] == ""){
                    continue;
                }
                $records[] = $line; //Create array of csv
            }
            //重複チェック


            $error_message = array();
            $code_count = 0;
            $name_count = 0;
            $error_count = 0;
            $line = array();
            foreach($records as $line){
                //DBを検索
                $code_count = DB::table('categories')->where('category_code', $line[1])->count();
                $name_count = DB::table('categories')->where('category_name', $line[2])->count();

                if($code_count > 0 || $name_count > 0){
                    array_push($error_message, 'カテゴリーコード'.$line[1].'の'.$line[2]);
                    $error_count += 1;
                }

                $code_count = 0;
                $name_count = 0;
            }

            //エラー処理
            if($error_count > 0){
                return redirect('masters/categories')->with('duplication', '既に登録されている行が'.$error_count.'件あります。ファイルを修正して再度アップロードしてください。')->with('duplication_message', $error_message);
            }


            //DBインサート
            foreach($records as $line){
                DB::table('categories')->insert(['category_type' => $line[0],
                                                'category_code' => $line[1],
                                                'category_name' => $line[2],
                                                'category_detail' => $line[3]
                                                ]);
            }
            return redirect('masters/categories');

        }else{
            //ファイル形式無効エラー

            return redirect('masters/categories')->with('file_type_error', '無効なファイルが送信されました。ファイル形式を確認してください。');
        }
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
        $this->category->fill($data);
        $this->category->save();
        return redirect()->to('masters/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return view('masters.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('masters.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $data = $request->all();
        $category->fill($data);
        $category->save();
        return redirect()->to('masters/categories');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect('masters/categories');
    }
}
