<?php

use App\Product;
use App\Brand;
use App\Supplier;
use App\Category;
use App\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

function csvoutput($item,$data){

   //CSVファイル作成
    $file_name = $item."_master.csv"; //CSVにする場合は拡張子変更
    $file_handler = storage_path()."\\reference";

    //既存ファイルがあればそれを開く。なければ新規ファイルを生成
    $csvfile = fopen($file_handler.'\\'.$file_name, "w");

    $data = json_decode(json_encode($data), true);

    if($csvfile){
        foreach($data as $value){
        	//mb_convert_variables('SJIS-win','UTF-8', $value); //txt形式
            fputcsv($csvfile, $value, ','); //CSVにする場合はこれ
            /*foreach($value as $string){
                fwrite($csvfile, $string."\t");
            }*/
            //fwrite($csvfile);
        }
    }
    fclose($csvfile);
}



?>