@extends('layout')
@section('content')


	<h2 class="page-header">商品マスタ一覧</h2>
	<div class="row">
		<div class="col-md-12">
			<form action="{{ url('masters/products/search') }}" method="post" id="search">
				{{ csrf_field() }}
				<div class="form-group">
					<input type="text" name="keyword" placeholder="商品名で検索" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" value="検索" class="btn btn-primary" id="searchbutton">
				</div>
			</form>
			<div class="search_results_message">
			</div>
			{{-- AJAXの場合これ
			<script type="text/javascript">
				$(function(){

					$("#searchbutton").click(function(){
						var keyword = $('input[name=search]').val();
						console.log(keyword);
						var url = '{{ url("masters/products/search/") }}'+ "/" + keyword
						console.log(url)
						$.ajax({
							url:url,
							dataType:'json',
							//data:{keyword:$keyword}, この指定はエラー
							type:'GET'
						}).done(function(result){
							if($('.message').length){
								$('.message').remove();
							}
							$('.search_results_message').prepend('<p class="message">通信に成功しました。</p>');
							console.log(result);
							$('tbody').remove();

						}).fail(function(result){
							if($('.message').length){
								$('.message').remove();
							}
							$('.search_results_message').prepend('<p class="message">データの取得に失敗しました。</p>');
						});
					});
				});

			</script>
			--}}

			<script type="text/javascript">
				(function(){

					var smile_checkbox;
					var smile_button = document.getElementById("smileupdate_button");
					console.log(smile_button);

					smile_button.addEventListener("click", function(){
						alert('aaa');
						var jsondata = {'id' : [], 'check' : []};
						var smile_checkbox = document.getElementByClassName('mileregistrationcheck');
						console.log(smile_checkbox);

						var xhr = new XMLHttpRequest();
						xhr.open('POST', 'masters/products/smilecompleteall', true);
						xhr.setRequestHeader("Content-type", "application/json");
						xhr.send(JSON.stringify(data));

					}, false);






				})();
			</script>
		</div>
	</div>
	<table class="table table-straiped table-hover">
		<thead>
			<tr>
				<th>商品コード</th>
				<th>商品名</th>
				<th>仕入先コード</th>
				<th>標準売上単価</th>
				<th>仕入評価単価</th>
				<th>在庫評価単価</th>
				<th>上代単価</th>
				<th>新単価実施日</th>
				<th>新標準売上単価</th>
				<th>新仕入評価単価</th>
				<th>新在庫評価単価</th>
				<th>新上代単価</th>
				<th>EAN(JAN)</th>
				<th>ASIN(amazon)</th>
				<th>申請ユーザー</th>
				<th>
					スマイル登録状況
					<?php $current_user = Auth::user() ;?>
					@if($current_user->id == 3 || $current_user->id == 4)
						<input type="button" value="一括更新" id="smileupdate_button">
					@endif
				</th>
				<th>スマイル登録状況のコメント</th>
				<th>ステータス</th>
				<th>在庫状況</th>
				<th>入荷予定</th>
				<th>発注状況</th>
				<th>入荷予定日</th>
				<th>発注に関するメモ</th>
				<th>商品画像</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td>{{{ $product->product_code }}}</td>
				<td>{{{ $product->product_name }}}</td>
				<td>
				@foreach($suppliers as $supplier)
					@if($supplier->id == $product->supplier_id)
						{{{ $supplier->supplier_code.'('. $supplier->supplier_name.')' }}}
					@endif
				@endforeach
				</td>
				<td>{{{ $product->product_unitprice }}}</td>
				<td>{{{ $product->product_costprice }}}</td>
				<td>{{{ $product->product_stockprice }}}</td>
				<td>{{{ $product->product_retailprice }}}</td>
				<td>{{{ $product->product_newpricestartdate }}}</td>
				<td>{{{ $product->product_newunitprice }}}</td>
				<td>{{{ $product->product_newcostprice }}}</td>
				<td>{{{ $product->product_newstockprice }}}</td>
				<td>{{{ $product->product_newretailprice }}}</td>
				<td>{{{ $product->product_eancode }}}</td>
				<td><a href="http://amazon.jp/dp/{{{ $product->product_asin }}}" target="new">{{{ $product->product_asin }}}</a></td>
				<td>
				@foreach($users as $user)
					<span style="color:red">{{$user->id}}</span>/{{$product->user_id}}<br />
					@if($user->id == $product->user_id)
						{{{ $user->name }}}
					@endif
				@endforeach

				</td>
				<td>
					@if($product->product_smileregistration == "新規登録済")
						<i class="fa fa-check-square-o" style="color: green;" aria-hidden="true"></i>
					@endif

					{{{ $product->product_smileregistration }}}

					@if($current_user->id == 3 || $current_user->id == 4 and $product->product_smileregistration == "新規未登録")
						<input type="checkbox" name="smileregistrationcheck" data-id="{{ $product->id }}" class="smileregistrationcheck">
						<form action="{{ url("masters/products/smilecomplete") }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $product->id }}">
							<input type="hidden" name="product_smileregistration" value="新規登録済">
							<input type="submit" value="Done">
						</form>
					@endif
				</td>
				<td>{{{ $product->product_smileregistrationcomment }}}</td>
				<td>{{{ $product->product_status }}}</td>
				<td>{{{ $product->product_stockstatus }}}</td>
				<td>{{{ $product->product_arrivalschedule }}}</td>
				<td>{{{ $product->product_orderstatus }}}</td>
				<td>{{{ $product->product_arrivaldate }}}</td>
				<td>{{{ $product->product_ordernote }}}</td>
				<td><img src="url('{{{ $product->product_imageurl }}}')" /></td>
				<td>
					<a href="{{ url("masters/products/{$product->id}") }}" class="btn btn-primary">詳細</a>
					<a href="{{ url("masters/products/{$product->id}/edit") }}" class="btn btn-primary">編集</a>
					<form action="{{ url("masters/products/{$product->id}") }}" method="post">
						{{ csrf_field() }}
						{{ method_field('DELETE')}}
						<input type="submit" class="btn btn-danger destroy" value="削除" disabled="disabled" />
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $products->links() }}
@endsection('content')