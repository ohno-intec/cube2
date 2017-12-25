@extends('layout')
@section('content')

	<div class="row">
		<div class="col-md-12">
		<h2 class="page-header">商品編集</h2>
		<ul class="list-inline">
			<li>
				<a href="{{ url("masters/products") }}" class="btn btn-primary pull-left">商品一覧</a>
			</li>
			<li>
				<form action="masters/products/{$product->id}" method="delete">
					<button type="submit" class="btn btn-danger pull-left">削除</button>
				</form>
			</li>
		</ul>
		</div>
	</div>

	<script>
	$(function(){
			var product_smileregistration = $("input[name=product_smileregistration]:checked").val();
				var product_modelnumber = $('[name=product_modelnumber]').val();
				var product_name = $('[name=product_name').val();
				var product_index = $('[name=product_index]').val();
				var supplier_id = $('[name=supplier_id]:selected').val()
				var product_unitprice = $('[name=product_unitprice]').val();
				var product_costprice = $('[name=product_costprice]').val();
				var product_stockprice = $('[name=product_stockprice]').val();
				var product_retailprice = $('[name=product_retailprice]').val();
				var product_newpricestartdate = $('[name=product_newpricestartdate]').val();
				var product_newunitprice = $('[name=product_newunitprice]').val();
				var product_newcostprice = $('[name=product_newcostprice]').val();
				var product_newstockprice = $('[name=product_newstockprice]').val();
				var product_newretailprice =$('[name=product_newretailprice]').val();
				var category_id = $('[name=category_id]').val();
				var product_typecode = $('[name=product_typecode]').val();
				var product_stockholdingcode = $('[name=product_stockholdingcode]').val();
				var product_rackcode = $('[name=product_rackcode]').val();
				var product_warehouseholdingcode = $('[name=product_warehouseholdingcode]').val();
				var product_properstockquantity = $('[name=product_properstockquantity]').val();
				var product_boystockquantity = $('[name=product_boystockquantity]').val();
				var product_boybalance = $('[name=product_boybalance]').val();
				var product_showmastersearch = $('[name=product_showmastersearch]').val();
				var product_eancode = $('[name=product_eancode]').val();
	});


	//変更内容の比較用に最初にDBの情報を取得して変数に格納

	$.ajax({
		type: "POST",
		url: "{{ asset('/php/getProductUpdateTargetData.php') }}",
		data: { "product_id" : "{{ $product->id }}" },
		dataType:"json"
	}).done(function(data){
		db_data = data;
	}).fail(function(data){
		console.log("商品情報が取得できませんでした")
	});

	$(function(){
		var form_selector = $("#edit_product").find('input,select,textarea');
		//各formの要素が
		form_selector.each(function(){
			//変更されたら
			$(this).change(function(){
				//変更内容を変数に代入
				var new_data = $(this).val();
				//変更内容とDBの無いようを比較して異なっていたら
				if($(this).val() !== db_data[$(this).attr("name")]){
					//exclamation markを表示
					//$(this).prev().addClass("my-tooltip");
					$('[name=' + $(this).attr('name') + ']').prev().append('<i class="fa fa-exclamation-circle i_tooltip" aria-hidden="true" title="' + db_data[$(this).attr("name")] + ' → '+ new_data + '" data-toggle="tooltip"></i>');
					//$("[name=" + $(this).attr("name") + "]").prev().append('<br /><span style="color:red;">' + db_data[$(this).attr("name")] + '→'+ new_data +'</span>');

					//tooltip関数を実行
					$(function () {
						$('[data-toggle="tooltip"]').tooltip()
					});
				}
			})
		});
	});

</script>

	<form action="{{ url("masters/products/{$product->id}") }}" method="post" id="edit_product">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		<div class="row">
			<div class="form-group col-md-4">
				<label>ブランド名</label>
				<input type="hidden" name="brand_id" value="{{{ $product->brand_id }}}" data-type="default" />
				<input id="brand_name" class="form-control" type="text" value="{{{ $product->brand->brand_name }}}" readonly="readonly" />
			</div>
			<div class="form-group col-md-2">
				<label>商品コード</label>
				<input required class="form-control" name="product_code" type="text" value="{{{ $product->product_code }}}" readonly="readonly" data-type="default" />
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				<label>型番</label>
				<input required class="form-control" name="product_modelnumber" type="text" maxlength="36" value="{{{ $product->product_modelnumber }}}" data-type="default" />
			</div>
			<div class="form-group col-md-6">
				<label>商品名</label>
				<input required class="form-control" name="product_name" type="text" maxlength="36" value="{{{ $product->product_name }}}" readonly="" data-type="default" />
			</div>
			<div class="form-group col-md-2">
				<label>索引</label>
				<input class="form-control" name="product_index" type="text" maxlength="10" value="{{{ $product->product_index }}}" data-type="default" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-sm-6">
				<label>仕入先コード</label>
				<select name="supplier_id" class="form-control" data-type="default">
					@foreach($suppliers as $supplier)
						<option value="">指定なし</option>
						<option value="{{{ $supplier->id }}}" @if($supplier->id == $product->supplier_id) selected @endif>{{{ $supplier->supplier_code.'('. $supplier->supplier_name.')' }}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>標準売上単価(通常は0円)</label>
				<input class="form-control" name="product_unitprice" type="text" maxlength="9" value="{{{ $product->product_unitprice }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>仕入評価単価(海外仕入は生原価)</label>
				<input class="form-control" name="product_costprice" type="text" maxlength="9" value="{{{ $product->product_costprice }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>在庫評価単価(海外仕入は生原価×輸入諸掛費)</label>
				<input class="form-control" name="product_stockprice" type="text" maxlength="9" value="{{{ $product->product_stockprice }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>上代単価(オープンの場合は0円)</label>
				<input class="form-control" name="product_retailprice" type="text" maxlength="8" value="{{{ $product->product_retailprice }}}" data-type="default" />円
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				<label>新単価実施日</label>
				<input class="form-control datepicker" name="product_newpricestartdate" type="text" value="{{{ $product->newpricestartdate }}}" data-type="default" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>新標準売上単価</label>
				<input class="form-control" name="product_newunitprice" type="text" maxlength="9" value="{{{ $product->product_newunitprice }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>新仕入評価単価</label>
				<input class="form-control" name="product_newcostprice" type="text" maxlength="9" value="{{{ $product->product_newcostprice }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>新在庫評価単価</label>
				<input class="form-control" name="product_newretailprice" type="text" maxlength="8" value="{{{ $product->product_newretailprice }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>新上代単価</label>
				<input class="form-control" name="product_newretailprice" type="text" maxlength="8" value="{{{ $product->product_newretailprice }}}" data-type="default" />円
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">
				<label>カテゴリー</label>
				<select name="category_id" class="form-control" data-type="default">
					@foreach ($categories as $category )
						<option value="{{{ $category->id }}}" @if( $product->category_id == $category->id ) selected @endif>{{{ $category->category_name }}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label>商品種別コード</label>
				<script>add_selected('product_typecode', {{{ $product->product_typecode }}});</script>
				<select name="product_typecode" class="form-control" data-type="default">
					<option value="1">自社オリジナル</option>
					<option value="2">自社ライセンス</option>
					<option value="5">自社正規輸入品</option>
					<option value="4">自社並行輸入品</option>
					<option value="5">受託OEM</option>
					<option value="101">他社仕入</option>
				</select>
			</div>
			<div class="form-group col-md-3">
				<label>在庫保有コード</label>
				<div>
				<script>add_checked('product_stockholdingcode', {{{ $product->product_stockholdingcode }}})</script>
				<label class="radio-inline"><input type="radio" name="product_stockholdingcode" value="1" data-type="default">有り</label>
				<label class="radio-inline"><input type="radio" name="product_stockholdingcode" value="2" data-type="default">無し</label>
				</div>
			</div>
			<div class="form-group col-md-3">
				<label>棚番コード</label>
				<script>add_selected('product_rackcode', {{{ $product->product_rackcode }}});</script>
				<select class="form-control" name="product_rackcode" data-type="default">
					<option value="1">A-1</option>
					<option value="2">A-2</option>
					<option value="3">A-3</option>
					<option value="4">B-1</option>
					<option value="5">B-2</option>
					<option value="6">B-3</option>
					<option value="7">C-1</option>
					<option value="8">C-2</option>
					<option value="9">C-3</option>
					<option value="10">C-4</option>
					<option value="11">C-5</option>
					<option value="12">D-1</option>
					<option value="13">D-2</option>
					<option value="14">D-3</option>
					<option value="15">D-4</option>
					<option value="16">D-5</option>
					<option value="17">E-1</option>
					<option value="18">E-2</option>
					<option value="19">E-3</option>
					<option value="20">E-4</option>
					<option value="21">E-5</option>
					<option value="22">F-1</option>
					<option value="23">F-2</option>
					<option value="24">F-3</option>
					<option value="25">F-4</option>
					<option value="26">F-5</option>
				</select>
			</div>
			<div class="form-group col-md-3">
				<label>倉庫保有コード</label>
				<div>
				<script>add_checked('product_warehouseholdingcode', {{{ $product->product_warehouseholdingcode }}})</script>
				<label class="radio-inline"><input type="radio" name="product_warehouseholdingcode" value="1" data-type="default">有り</label>
				<label class="radio-inline"><input type="radio" name="product_warehouseholdingcode" value="2" data-type="default">無し</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>適正在庫数量</label>
				<input class="form-control" type="text" name="product_properstockquantity" value="{{{ $product->product_properstockquantity }}}" data-type="default" />
			</div>
			<div class="form-group col-md-3">
				<label>期首残数量</label>
				<input class="form-control" type="text" name="product_boystockquantity" value="{{{ $product->product_boystockquantity }}}" data-type="default" />
			</div>
			<div class="form-group col-md-3">
				<label>期首残金額</label>
				<input class="form-control" type="text" name="product_boybalance" value="{{{ $product->product_boybalance }}}" data-type="default" />円
			</div>
			<div class="form-group col-md-3">
				<label>マスター検索表示※スマイル用</label>
				<div>
				<script>add_checked('product_showmastersearch', {{{ $product->product_showmastersearch }}})</script>
				<label class="radio-inline"><input type="radio" name="product_showmastersearch" value="1" data-type="default">表示する</label>
				<label class="radio-inline"><input type="radio" name="product_showmastersearch" value="2" data-type="default">表示しない</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				<label>EANコード(JAN)</label>
				<input class="form-control" type="text" name="product_eancode" value="{{{ $product->product_eancode }}}" maxlength="13" data-type="default">
			</div>
			<div class="form-group col-md-4">
				<label>ASINコード(amazon)</label>
				<input class="form-control" type="text" name="product_asin" value="{{{ $product->product_asin }}}" data-type="default">
			</div>
			<div class="form-group col-md-4">
				<label>申請ユーザー</label>
				@foreach($users as $user)
					@if($user->id == $product->user_id)
						<input type="hidden" name="user_id" value="{{{ $product->user_id }}}" data-type="default" />
						<input class="form-control" type="text" value="{{{ $user->name }}}" disabled="disabled" />
					@endif
				@endforeach
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label>スマイル登録区分<br />※スマイル更新が入る場合は更新未対応にチェック</label>
				<div>
					<script>add_checked('product_smileregistration', '{{{ $product->product_smileregistration }}}')</script>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="新規未登録">新規未登録</label>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="新規登録済">新規登録済</label>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="新規要修正">新規要修正</label>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="新規拒否">新規拒否</label><br />
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="更新未登録">更新未登録</label>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="更新登録済">更新登録済</label>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="更新要修正">更新要修正</label>
					<label class="radio-inline"><input type="radio" name="product_smileregistration" value="更新拒否">更新拒否</label>
				</div>
			</div>
			<script>
				//product_smileregistrationより前の内容が変更されたら更新未登録を選択するスクリプト

			</script>

			{{-- 区分が更新未登録、の場合はhiddenで対象のnameを持つ --}}



			<input type="hidden" name="product_targetsmileupdate" value="">

			<div class="form-group col-md-9">
				<label>スマイル登録状況のコメント</label>
				<textarea class="form-control" rows="3" name="product_smileregistrationcomment">{{{ $product->product_smileregistrationcomment }}}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>ステータス</label>
				<div>
				<label class="radio-inline"><input type="radio" name="product_status" value="継続">継続</label>
				<label class="radio-inline"><input type="radio" name="product_status" value="廃盤">廃盤</label>
				</div>
			</div>
			<div class="form-group col-md-3">
				<label>在庫状況</label>
				<div>
				<label class="radio-inline"><input type="radio" name="product_stockstatus" value="在庫あり">在庫あり</label>
				<label class="radio-inline"><input type="radio" name="product_stockstatus" value="在庫なし">在庫なし</label>
				</div>
			</div>
			<div class="form-group col-md-3">
				<label>入荷予定</label>
				<div>
				<label class="radio-inline"><input type="radio" name="product_arrivalschedule" value="入荷予定あり">入荷予定あり</label>
				<label class="radio-inline"><input type="radio" name="product_arrivalschedule" value="入荷予定なし">入荷予定なし</label>
				</div>
			</div>
			<div class="form-group col-md-3">
				<label>発注状況</label>
				<div>
				<label class="radio-inline"><input type="radio" name="product_orderstatus" value="未発注">未発注</label>
				<label class="radio-inline"><input type="radio" name="product_orderstatus" value="発注済">発注済</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>入荷予定日</label>
				<input class="form-control datepicker" name="product_arrivaldate" type="text" value="{{{ $product->product_arrivaldate }}}" />
			</div>
			<div class="form-group col-md-9">
				<label>発注に関するメモ</label>
				<textarea class="form-control" rows="3" name="product_ordernote">{{{ $product->product_ordernote }}}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>商品画像</label>
				@if(isset($product->product_asin))
					<img src="http://images-jp.amazon.com/images/P/{{ $product->product_asin }}.09.MZZZZZZZ.jpg" />
				@else
					<img src="url('{{{ $product->product_imageurl }}}')" />
				@endif
				<input type="file" name="produt_imageurl" value="{{{ $product->imageurl }}}" />
			</div>
			<div class="form-group col-md-9">
				<label>商品サイズ</label>
				<textarea class="form-control" rows="3" name="product_size">{{{ $product->product_size }}}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>本体重量</label>
				<input class="form-control" type="text" name="product_weight" value="{{{ $product->product_weight }}}" />g
			</div>
			<div class="form-group col-md-9">
				<label>商品素材</label>
				<textarea class="form-control" name="product_material">{{{ $product->product_material }}}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label>パッケージサイズ</label>
				<input class="form-control" type="text" name="product_packagesize" value="{{{ $product->product_packagesize }}}">
			</div>
			<div class="form-group col-md-2">
				<label>パッケージ重量</label>
				<input class="form-control" type="text" name="product_packageweight" value="{{{ $product->product_packageweight}}}" />g
			</div>
			<div class="form-group col-md-2">
				<label>防水性能</label>
				<input class="form-control" type="text" name="product_waterproof" value="{{{ $product->product_waterproof }}}" />ATM
			</div>
			<div class="form-group col-md-3">
				<label>商品カラー</label>
				<input class="form-control" type="text" name="product_color" value="{{{ $product->product_color }}}" />
			</div>
			<div class="form-group col-md-2">
				<label>電池型番</label>
				<input class="form-control" type="text" name="product_batterynumber" value="{{{ $product->product_batterynumber }}}" />
			</div>
	
		</div>

		<div class="row">
			<div class="form-group col-md-4">
				<label>仕様に関する備考</label>
				<textarea class="form-control" rows="3" name="product_specnote">{{{ $product->product_specnote }}}</textarea>
			</div>
			<div class="form-group col-md-4">
				<label>機能</label>
				<textarea class="form-control" rows="3" name="product_function">{{{ $product->product_function }}}</textarea>
			</div>
			<div class="form-group col-md-4">
				<label>同梱物</label>
				<input class="form-control" type="text" name="product_includeditems" value="{{{ $product->product_includeditems }}}" />
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-4">
				<label>保証期間</label>
				<input class="form-control" type="text" name="product_warrantyterm" value="{{{ $product->product_warrantyterm }}}" />年
			</div>
			<div class="form-group col-md-4">
				<label>販売開始日</label>
				<input class="form-control datepicker" type="text" name="product_releasedate" value="{{{ $product->product_releasedate}}}" />
			</div>
			<div class="form-group col-md-4">
				<label>商品の説明</label>
				<textarea class="form-control" name="product_description">{{{ $product->product_description }}}</textarea>
			</div>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary">
		</div>
	</form>

@endsection

