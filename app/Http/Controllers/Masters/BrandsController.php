<?php

namespace App\Http\Controllers\Masters;

use App\Brand;	//Eloquentモデル
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//https://readouble.com/laravel/5.4/ja/controllers.html

require_once(public_path()."/php/function.php");

class BrandsController extends Controller
{
    /*
    *
    * @var Brands
    *
    */

    protected $brand;

    public function __construct(Brand $brand){
    	$this->middleware('auth');
    	$this->brand = $brand;
    }


    /*
    *　Index of brand
    * @returen \Illuminate\View\View
    *
    */

	public function index() {

		///$brands = $this->brand->all();
		$brands = Brand::all();
		return view('masters.brands.index', ['brands' => $brands]);

	}

	/*
	*
	*記事の詳細
	*
	*@return \Illuminate\View\View
	*
	*/


	public function show(Brand $brand) {

		//$brand = $this->brand->find($id);
		//return view('masters.brands.show', compact('brand'));
		return view('masters.brands.show', ['brand' => $brand]);
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

		return view('masters.brands.create');

	}


	public function batch(Brand $brand) {

		$file = Input::file('data_file');
		$fileName = $file->getClientOriginalName();	//ファイル名取得

		if(preg_match('/\.csv$/i', $fileName)){	//拡張子がCSVの場合

			//ファイル名を変更して移動
			$fileName = preg_replace("/\.csv$/i", "", $fileName) . '_' . 'brands' . '_'. time() .'.csv';
			$filePath = $file->move(storage_path().'/upload', $fileName);

			$csvFile = new \SplFileObject($filePath);
			$csvFile->setFlags(\SplFileObject::READ_AHEAD);
			$csvFile->setFlags(\SplFileObject::SKIP_EMPTY);
			$csvFile->setFlags(\SplFileObject::DROP_NEW_LINE);
			$csvFile->setFlags(\SplFileObject::READ_CSV);
			$csvFile->setCsvControl(',');

			$records = array();
			$line = array();

			foreach ($csvFile as $line){
				//エンコーディング変換
				foreach ($line as $key => $value) {
					$line[$key] = mb_convert_encoding($value, 'UTF-8', 'sjis-win');
				}
				//1行目の項目名と終端の空行をドロップ
				if($line[0] == "brand_code" || $line[0] == ""){
					continue;
				}
				$records[] = $line; //Create　array of csv
			}

			//http://qiita.com/emotu/items/05892965fccb719cd8d1
			//重複登録チェック

			$errorMessage = array();
			$brand_code_count = 0;
			$brand_name_count = 0;
			$error_count = 0;
			$line = array();
			foreach ($records as $line){
				//echo DB::table('brands')->where('brand_code', $value2[0])->count() . "<br>";
				//echo $value2 . DB::table('brands')->where('brand_name', $value2[1])->count() . "<br>";
				$brand_code_count += DB::table('brands')->where('brand_code', $line[0])->count(); //Count brand code
				$brand_name_count += DB::table('brands')->where('brand_name', $line[1])->count(); //Count brand name
				if($brand_code_count > 0 || $brand_name_count > 0 ){ //If brand code or brand name are not equal 0 in the db
					array_push($errorMessage, 'ブランドコード'.$line[0].'の'.$line[1]); //Add error meesage to $errorMessage array
					$error_count += 1;
				}
				$brand_code_count = 0;//initialization
				$brand_name_count = 0;//initialization
			}
			if($error_count > 0){
				return redirect('masters/brands')->with('duplication', '既に登録されている行が'.$error_count.'件あります。ファイルを修正して再度アップロードしてください。')->with('duplication_message', $errorMessage);
				//http://laraweb.net/knowledge/362/参照
			}

			foreach($records as $line){
				echo $line[1];
				DB::table('brands')->insert(['brand_code' => $line[0],
											'brand_name' => $line[1],
											'brand_subname' => $line[2],
											'brand_description' => $line[3],
											'brand_category' => $line[4],
											'brand_logofilename' => $line[5],
											'barnd_website' => $line[6],'brand_country' => $line[7]
											]);
			}

			return redirect('masters/brands');

		}else{

			return redirect('masters/brands')->with('file_type_error', '無効なファイルが送信されました。ファイル形式が無効です。');

		}

	}

	public function store(Request $request) {
		
		$data = $request->all();
		$brand_category = $data['brand_category'];


		if($brand_category == "受託OEM" || $brand_category == "他社仕入"){
			$max_brand_code = DB::table('brands')->max('brand_code');
			if($max_brand_code < 101){
				$max_brand_code = 101;
			}else{
				$max_brand_code += 1;
			}
			$replacements = array("brand_code" => $max_brand_code);
			$data = array_replace($data, $replacements);
			$this->brand->fill($data);
			$this->brand->save();

		}else{
			$max_brand_code = DB::table('brands')->where('brand_code', '<', 101)->max('brand_code');
			$max_brand_code += 1;
			print_r($max_brand_code);
			$replacements = array("brand_code" => $max_brand_code);
			$data = array_replace($data, $replacements);
			$this->brand->fill($data);
			$this->brand->save();
		}

        $data = Brand::select('brand_code', 'brand_name', 'brand_subname')->get();
        
        csvoutput('brands', $data);

		return redirect()->to('masters/brands');	

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

	public function edit(Brand $brand) {

		return view('masters.brands.edit', ['brand' => $brand]);

	}

	public function update(Request $request, Brand $brand) {


		$data = $request->all();
		$brand->fill($data);
		$brand->save();

		return redirect()->to('masters/brands');
	}

	public function destroy(Brand $brand) {

		$brand->delete();
		return redirect('masters/brands');

	}
}
