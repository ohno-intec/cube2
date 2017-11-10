@extends('layout')
@section('content')

	<h2 class="page-header">商品詳細</h2>
	<ul class="list-inline">
		<li>
			<a href="{{ url("masters/products") }}" class="btn btn-primary pull-left">商品一覧</a>
		</li>
		<li>
			<a href="{{ url("masters/products/{$product->id}/edit") }}" class="btn btn-primary pull-left">編集</a>
		</li>
		<li>
			<form action="masters/products/{$product->id}" method="delete">
				<button type="submit" class="btn btn-danger pull-left" disabled="disabled">削除</button>
			</form>
		</li>
	</ul>
	<table class="table table-striped">
		<tr>
			<th>商品コード</th>
			<td>{{{ $product->product_code }}}</td>
		</tr>
		<tr>
			<th>型番</th>
			<td>{{{ $product->product_modelnumber }}}</td>
		</tr>
		<tr>
			<th>商品名</th>
			<td>{{{ $product->product_name }}}</td>
		</tr>
		<tr>
			<th>索引</th>
			<td>{{{ $product->product_index }}}</td>
		</tr>
		<tr>
			<th>仕入先コード</th>
			@if(is_null($product->supplier_id))
				<td></td>
			@else
				@foreach($suppliers as $supplier)
					@if($supplier->id == $product->supplier_id)
						<td>{{{ $supplier->supplier_code.'('. $supplier->supplier_name.')' }}}</td>
					@endif
				@endforeach
			@endif
		</tr>
		<tr>
			<th>標準売上単価</th>
			<td>{{{ $product->product_unitprice }}}</td>
		</tr>
		<tr>
			<th>仕入評価単価</th>
			<td>{{{ $product->product_costprice }}}</td>
		</tr>
		<tr>
			<th>在庫評価単価</th>
			<td>{{{ $product->product_stockprice }}}</td>
		</tr>
		<tr>
			<th>上代単価</th>
			<td>{{{ $product->product_retailprice }}}</td>
		</tr>
		<tr>
			<th>新単価実施日</th>
			<td>{{{ $product->newpricestartdate }}}</td>
		</tr>
		<tr>
			<th>新標準売上単価</th>
			<td>{{{ $product->newunitprice }}}</td>
		</tr>
		<tr>
			<th>新仕入評価単価</th>
			<td>{{{ $product->newcostprice }}}</td>
		</tr>
		<tr>
			<th>新在庫評価単価</th>
			<td>{{{ $product->newstockprice }}}</td>
		</tr>
		<tr>
			<th>新上代単価</th>
			<td>{{{ $product->newretailprice }}}</td>
		</tr>
		<tr>
			<th>カテゴリー</th>
			@if($product->category_id)
				@foreach($categories as $category)
					@if($category->id == $product->category_id)
						<td>{{ $category->category_code . "(" . $category->category_name . ")" }}</td>
					@endif
				@endforeach
			@else
				<td></td>
			@endif
		</tr>
		<tr>
			<th>商品種別コード</th>
			<td>{{{ $product->product_typecode }}}</td>
		</tr>
		<tr>
			<th>在庫保有コード</th>
			<td>{{{ $product->product_stockholdingcode }}}</td>
		</tr>
		<tr>
			<th>棚番コード</th>
			<td>{{{ $product->product_rackcode }}}</td>
		</tr>
		<tr>
			<th>倉庫保有コード</th>
			<td>{{{ $product->product_warehouseholdingcode }}}</td>
		</tr>
		<tr>
			<th>適正在庫数</th>
			<td>{{{ $product->product_properstockquantity }}}</td>
		</tr>
		<tr>
			<th>期首残数量</th>
			<td>{{{ $product->product_boystockquantity }}}</td>
		</tr>
		<tr>
			<th>期首残金額</th>
			<td>{{{ $product->product_boybalance }}}</td>
		</tr>
		<tr>
			<th>マスター検索表示</th>
			<td>{{{ $product->product_showmastersearch　}}}</td>
		</tr>
		<tr>
			<th>EANコード(JAN)</th>
			<td>{{{ $product->product_eancode }}}</td>
		</tr>
		<tr>
			<th>ASINコード(amazon)</th>
			<td>{{{ $product->product_asin }}}</td>
		</tr>
		<tr>
			<th>申請ユーザー</th>
			@if($product->user_id)
				@foreach($users as $user)
					@if($user->id == $product->user_id)
						<td>{{{ $user->name }}}</td>
					@endif
				@endforeach
			@else
				<td></td>
			@endif

		</tr>
		<tr>
			<th>スマイル登録状況</th>
			<td>{{{ $product->product_smileregistration }}}</td>
		</tr>
		<tr>
			<th>スマイル登録状況のコメント</th>
			<td>{{{ $product->product_smileregistrationcomment }}}</td>
		</tr>
		<tr>
			<th>ステータス</th>
			<td>{{{ $product->product_status }}}</td>
		</tr>
		<tr>
			<th>在庫状況</th>
			<td>{{{ $product->product_stockstatus }}}</td>
		</tr>
		<tr>
			<th>入荷予定</th>
			<td>{{{ $product->product_arrivalschedule }}}</td>
		</tr>
		<tr>
			<th>発注状況</th>
			<td>{{{ $product->product_orderstatus }}}</td>
		</tr>
		<tr>
			<th>入荷予定日</th>
			<td>{{{ $product->product_arrivaldate }}}</td>
		</tr>
		<tr>
			<th>発注に関するメモ</th>
			<td>{{{ $product->product_ordernote }}}</td>
		</tr>
		<tr>
			<th>商品画像</th>
			<td><img src="url('{{{ $product->imageurl }}}')" /></td>
		</tr>
		<tr>
			<th>商品サイズ</th>
			<td>{{{ $product->product_size }}}</td>
		</tr>
		<tr>
			<th>本体重量</th>
			<td>{{{ $product->product_weight }}}</td>
		</tr>
		<tr>
			<th>商品素材</th>
			<td>{{{ $product->product_material }}}</td>
		</tr>
		<tr>
			<th>パッケージサイズ</th>
			<td>{{{ $product->product_packagesize }}}</td>
		</tr>
		<tr>
			<th>パッケージ重量</th>
			<td>{{{ $product->product_packageweight }}}</td>
		</tr>
		<tr>
			<th>防水性能</th>
			<td>{{{ $product->product_waterproof }}}</td>
		</tr>
		<tr>
			<th>商品カラー</th>
			<td>{{{ $product->product_color }}}</td>
		</tr>
		<tr>
			<th>電池型番</th>
			<td>{{{ $product->product_batterynumber }}}</td>
		</tr>
		<tr>
			<th>仕様に関する備考</th>
			<td>{{{ $product->product_specnote }}}</td>
		</tr>
		<tr>
			<th>機能</th>
			<td>{{{ $product->product_function }}}</td>
		</tr>
		<tr>
			<th>同梱物</th>
			<td>{{{ $product->product_includeditems }}}</td>
		</tr>
		<tr>
			<th>保証期間</th>
			<td>{{{ $product->product_warrantyterm }}}</td>
		</tr>
		<tr>
			<th>販売開始日</th>
			<td>{{{ $product->product_releasedate}}}</td>
		</tr>
		<tr>
			<th>商品の説明</th>
			<td>{{{ $product->product_description }}}</td>
		</tr>
	</table>

@endsection
