<?php
require('dbc.php');
require($_SERVER['SERVER_NAME'].'vendor/laravel/framework/src/Illuminate/Support/helpers.php');
$link = DBC();
if(mysql_connect_errno()){
	printf("connect failed: %s\n", mysqli_connect_error());
	exit();
}
//define csv file information
$file_path = '/home/intec/cube2/';
$file_name = 'products.csv';
$export_csv_title = ["product", "product_name"];
$sql = "SELECT product_code,product_name FROM products";

//encoding title into SJIS-win

foreach ( $export_csv_title as $key => $value){
	$export_header[] = mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
}

if($results = mysqli_query($link, $sql)){
	if(!$results){
		printf("Error:%s\n", mysqli_error($link));
	}
	mysqli_free_result($result);
}
mysqli_close($link);

$file = fopen($file_name, 'W');
fputcsv($file, $export_csv_title, ',');
fputcsv($file, (array)$results, ',');
fclose($file)

?>