<?php

namespace App\Http\Controllers\Masters;

use App\Supplier;	//Eloquentモデル
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//https://readouble.com/laravel/5.4/ja/controllers.html

class SuppliersController extends Controller
{
    /*
    *
    * @var Suppliers
    *
    */

    protected $supplier;

    public function __construct(Supplier $supplier){
    	$this->middleware('auth');
    	$this->supplier = $supplier;
    }


    /*
    *　Index of Supplier
    * @returen \Illuminate\View\View
    *
    */

	public function index() {

		$suppliers = Supplier::all();
		return view('masters.suppliers.index', ['suppliers' => $suppliers]);

	}

	/*
	*
	*記事の詳細
	*
	*@return \Illuminate\View\View
	*
	*/


	public function show(Supplier $supplier) {
		
		$users = User::pluck('id', 'name')->toArray();
		return view('masters.suppliers.show', ['supplier' => $supplier], compact('users'));
	}

	/*
	*
	*記事の投稿
	*
	*@param Request $request
	*@return \Illuminate\Http\RedirectResponse
	*
	*/

	public function create() {

		$users = User::pluck('id', 'name')->toArray();
		return view('masters.suppliers.create', compact('users'));

	}

	public function batch() {

		//ファイルを受け取り
		$file = Input::file('data-file');
		$file_name = $file->getClientOriginalName();

		//ファイルの整合性をチェック
		if(preg_match('/\.csv$/i', $file_name)){ //拡張子がCSVの場合

			//ファイル名を変更して移動
			$file_name = preg_replace("/\.csv$/i", "", $file_name) . '_' . 'brands' . '_' .time() . '.csv';
			$file_path = $file->move(storage_path().'/upload', $file_name);

			$csvFile = new \SplFileObject($file_path);
			$csvFile->setFlags(\SplFileObject::READ_CSV);
			$csvFile->setCsvControl(',');

			$records = array();
			$line = array();

			foreach($csvFile as $line){
				foreach($line as $key => $value){
					$line[$key] = mb_convert_encoding($value, 'UTF-8', 'sjis-win');
				}
				//1行目の項目名レコードと終端の空レコードを削除
				if($line[0] == "supplier_code" || $line[0] == ""){
					continue;
				}
				$records[] = $line; //Create array of csv
			}
			//重複登録チェック
			$error_message = array();
			$code_count = 0;
			$name_count = 0;
			$error_count = 0;
			$line = array();
			
			foreach($records as $line){
				$code_count = DB::table('suppliers')->where('supplier_code', $line[0])->count();
				$name_count = DB::table('suppliers')->where('supplier_name', $line[1])->count();
				if($code_count > 0 || $name_count > 0){
					array_push($error_message, '仕入先コード'.$line[0].'の'.$line[1]);
					$error_count += 1;
				}
				$code_count = 0;//initialization
				$name_count = 0;//initialization
			}
			if($error_count > 0 ){
				return redirect('masters/suppliers')->with('duplication', '既に登録されている行が'.$error_count.'件あります。ファイルを修正して再度アップロードしてください。')->with('duplication_message', $error_message);
			}
			//DBインサート

			foreach($records as $line){
				DB::table('suppliers')->insert(['supplier_code' => $line[0],
												'supplier_name' => $line[1],
												'supplier_index' => $line[2],
												'supplier_zipcode' => $line[3],
												'supplier_address1' => $line[4],
												'supplier_address2' => $line[5],
												'supplier_address3' => $line[6],
												'supplier_fax' => $line[7],
												'supplier_fax' => $line[8],
												'supplier_email' => $line[9],
												'supplier_salerep' => $line[10],
												'supplier_industrytype' => $line[11],
												'supplier_businesstype' => $line[12],
												'supplier_information' => $line[13]
												]);

			}

			return redirect('master/supplier');

		}else{	//拡張子がcsvじゃない場合

			return redirect('masters/suppliers')->with('file_type_error', '無効なファイルが送信されました。ファイル形式を確認してください。');


		}

	}//end of batch action



	public function store(Request $request) {
		
		$data = $request->all();
		$this->supplier->fill($data);
		$this->supplier->save();
		return redirect()->to('masters/suppliers');	

	}



	/*
	*
	*記事の編集
	*
	*@param Request $request
	*@param $id
	*@return \Illuminate\Http\RedirectResponse
	*
	*/

	public function edit(Supplier $supplier) {

		$users = User::pluck('id', 'name')->toArray();
		return view('masters.suppliers.edit', ['supplier' => $supplier], compact('users'));

	}

	public function update(Request $request, Supplier $supplier) {
		$data = $request->all();
		$supplier->fill($data);
		$supplier->save();
		return redirect()->to('masters/suppliers');
	}

	public function destroy(Supplier $supplier) {

		$supplier->delete();
		return redirect('masters/suppliers');

	}
}
