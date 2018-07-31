@extends('layout') {{-- layout.blade.phpを拡張 --}}
@section('content') {{-- sectionを定義 --}}
<div>
	<h1>アフター基本料金一覧</h1>

	<div class="table-responsive">
	<table class="table table-hover">
		<thead class="thead-dark">
			<tr>
				<th colspan="2"></th>

				<th scope="col">ユーザー</th>
				<th scope="col">ショップ</th>
				<th scope="col">問屋</th>
			</tr>
			<tr>	
				<th scope="col">種類</th>
				<th scope="col">内容</th>
				<th scope="col">100%</th>
				<th scope="col">80%</th>
				<th scope="col">70%</th>
			</tr>
		</thead>
		<tbody>
			<tr>	
				<th rowspan="5" scope="row">ムーブ交換</th>
				<th scope="row">電波</th>
				<td>￥5,000</td>
				<td>￥4,000</td>
				<td>￥3,500</td>
			</tr>
			<tr>	

				<th scope="row">ソーラー</th>
				<td>￥6,000</td>
				<td>￥4,800</td>
				<td>￥4,200</td>
			</tr>
			<tr>

				<th scope="row">デジタル</th>
				<td>￥1,500</td>
				<td>￥1,200</td>
				<td>￥1,050</td>
			</tr>
			<tr>

				<th scope="row">アナログ（1万未満）</th>
				<td>￥2,000</td>
				<td>￥1,600</td>
				<td>￥1,400</td>
			</tr>
			<tr>

				<th scope="row">アナログ（1万以上）</th>
				<td>￥3,000</td>
				<td>￥2,400</td>
				<td>￥2,100</td>
			</tr>
			<tr>
				<th rowspan="6" scope="row">ベルト交換</th>
				<th scope="row">革バンド</th>
				<td>￥3,000</td>
				<td>￥2,400</td>
				<td>￥2,100</td>
			</tr>
			<tr>

				<th scope="row">伸縮バンド</th>
				<td>￥3,500</td>
				<td>￥2,800</td>
				<td>￥2,450</td>
			</tr>
			<tr>

				<th scope="row">メタルバンド</th>
				<td>￥3,500</td>
				<td>￥2,800</td>
				<td>￥2,450</td>
			</tr>
			<tr>

				<th scope="row">メタルバンド（特殊なバックル）</th>
				<td>￥4,000</td>
				<td>￥3,200</td>
				<td>￥2,800</td>
			</tr>
			<tr>

				<th scope="row">バックル単品</th>
				<td>￥2,000</td>
				<td>￥1,600</td>
				<td>￥1,400</td>
			</tr>
			<tr>

				<th scope="row">キッズウォッチ革</th>
				<td>￥1,500</td>
				<td>￥1,200</td>
				<td>￥1,050</td>
			</tr>
			<tr>
				<th rowspan="3" scope="row">電池交換</th>
				<th>ソーラー（ムーブ交換の料金）</th>
				<td>￥6,000</td>
				<td>￥4,800</td>
				<td>￥4,200</td>
			</tr>
			<tr>

				<th scope="row">通常のボタン電池</th>
				<td>￥1,500</td>
				<td>￥1,200</td>
				<td>￥1,050</td>
			</tr>
			<tr>

				<th scope="row">防水テスト</th>
				<td>別途見積もり</td>
				<td>別途見積もり</td>
				<td>別途見積もり</td>
			</tr>
		</tbody>
	</table>
	</div>

</div>
@endsection