@extends('layout')
@section('content')

	<div class="row">
		<div class="col-md-12">
			<h2 class="page-header">商品個別登録</h2>
			<p>※ここで商品登録を行ってもすぐにスマイルに登録されるわけではありません。登録状況はスマイル登録状況カラムを参照してください。</p>
		</div>
	</div>

	<form action="{{ url('masters/products') }}" method="post">
		{{ csrf_field() }}

		<div class="row">
			<div class="form-group col-md-4">
				<label>ブランド名[必須]</label>
				<select name="brand_id" class="form-control">
						<option>選択してください</option>
					@foreach($brands as $brand)
						<option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
					@endforeach
				</select>
			</div>

			<script type="text/javascript">

				$("select[name=brand_id]").change(function(){
					$brand_id = $(this).val();
					$.ajax({
						type:　"GET",
						url: "{{ url('masters/get_product_code') }}",
						data: { "brand_id" : $brand_id },
						dataType:"text"
					}).done(function($new_product_code){
						console.log($new_product_code);
						$('input[name=product_code]').val($new_product_code);
					}).fail(function(){
						$('input[name=product_code]').val('商品コードが取得できませんでした');
					});
				});

			</script>
			<div class="form-group col-md-4">
				<label>商品コード[必須]</label>
				<input required class="form-control" name="product_code" type="text" value="{{{ old('product_code') }}}"  placeholder="商品コードはブランドコードを元に自動で付与されます" readonly="readonly" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-4">
				<label>型番(半角英数 最大36文字)[必須]</label>
				<input required class="form-control" name="product_modelnumber" type="text" maxlength="36" value="{{{ old('product_modelnumber') }}}" />
			</div>
			<div class="form-group col-md-4">
				<label>商品名[必須]</label>
				<input required class="form-control" name="product_name" type="text" maxlength="36" value="{{{ old('product_name') }}}" readonly="readonly" />
			</div>
			<div class="form-group col-md-4">
				<label>索引[型番の半角小文字]</label>
				<input required class="form-control" name="product_index" type="text" maxlength="10" value="{{{ old('product_index') }}}" readonly="readonly" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label>仕入先コード</label>
				<select name="supplier_id" class="form-control">
					<option value="">指定なし</option>
					@foreach($suppliers as $supplier)
					<option value="{{ $supplier->id }}">{{ $supplier->supplier_code . "(" . $supplier->supplier_name .")" }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<label>標準売上単価[通常は空白でOKです]</label>
			<input class="form-control" name="product_unitprice" type="text" maxlength="9" value="{{{ old('product_unitprice') }}}" />円
		</div>
		<div class="form-group">
			<label>標準仕入単価[必須]</label>
			<input class="form-control" name="product_costprice" type="text" maxlength="9" value="{{{ old('product_costprice') }}}" />円
		</div>
		<div class="form-group">
			<label>在庫評価単価[必須]</label>
			<input class="form-control" name="product_stockprice" type="text" maxlength="9" value="{{{ old('product_stockprice') }}}" />円
		</div>
		<div class="form-group">
			<label>上代単価</label>
			<input class="form-control" name="product_retailprice" type="text" maxlength="8" value="{{{ old('product_retailprice') }}}" />円
		</div>
		<div class="form-group">
			<label>新単価実施日</label>
			<input class="form-control datepicker" name="product_newpricestartdate" type="text" value="{{{ old('product_newpricestartdate')}}}" />
		</div>

		<script>
			$(function(){
				var newPriceDate = $('input[name="product_newpricestartdate"]');
				var newPriceBox = $(".newPriceBox");

				newPriceDate.change(function(){
					if(newPriceDate.val().length){
						newPriceBox.show('slow');
					}else{
						newPriceBox.hide('slow');
					}
				});

			});
		</script>
		<div class="newPriceBox" style="display: none;">
			<div class="form-group">
				<label>新標準売上単価[通常は空白でOK]</label>
				<input class="form-control" name="product_newunitprice" type="text" maxlength="9" value="{{{ old('product_unitprice') }}}" />円
			</div>
			<div class="form-group">
				<label>新標準仕入単価[必須]</label>
				<input class="form-control" name="product_newcostprice" type="text" maxlength="9" value="{{{ old('product_costprice') }}}" />円
			</div>
			<div class="form-group">
				<label>新在庫評価単価[必須]</label>
				<input class="form-control" name="product_newstockprice" type="text" maxlength="9" value="{{{ old('product_stockprice') }}}" />円
			</div>
			<div class="form-group">
				<label>新上代単価</label>
				<input class="form-control" name="product_newretailprice" type="text" maxlength="8" value="{{{ old('product_retailprice') }}}" />円
			</div>
		</div>
		<div class="form-group">
			<label>カテゴリー</label>
			<select class="form-control" name="category_id">
				<option value="">選択してください</option>
				@foreach($categories as $category)
				<option value="{{ $category->id }}">{{$category->category_code . "(" . $category->category_name . ")" }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>商品種別</label>
			<select name="product_typecode" class="form-control">
				<option value="">選択してください</option>
				<option value="000001">自社オリジナル</option>
				<option value="000002">自社ライセンス</option>
				<option value="000005">自社正規輸入品</option>
				<option value="000004">自社並行輸入品</option>
				<option value="000005">受託OEM</option>
				<option value="000101">他社仕入</option>
			</select>
		</div>
		<div class="form-group">
			<label>在庫保有</label>
			<label class="radio-inline"><input type="radio" name="product_stockholdingcode" value="1" checked="checked">無し</label>
			<label class="radio-inline"><input type="radio" name="product_stockholdingcode" value="2">有り</label>
		</div>
		<div class="form-group">
			<label>棚番コード</label>
			<select class="form-control" name="product_rackcode"　required>
				<option value="">選択してください</option>
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
		<div class="form-group">
			<label>倉庫保有</label>
			<label class="radio-inline"><input type="radio" name="product_warehouseholdingcode" value="1" checked="checked">無し</label>
			<label class="radio-inline"><input type="radio" name="product_warehouseholdingcode" value="2">有り</label>
		</div>
		<input type="hidden" name="product_properstockquantity" value="0">
		<input type="hidden" name="product_boystockquantity" value="0">
		<input type="hidden" name="product_boybalance" value="0">
		<input type="hidden" name="product_showmastersearch" value="0">
		<div class="form-group">
			<label>EANコード</label>
			<input class="form-control" type="text" name="product_eancode" value="{{ old('product_eancode')}}" maxlength="13">
		</div>
		<div class="form-group">
			<label>ASIN</label>
			<input class="form-control" type="text" name="product_asin" value="{{ old('product_asin') }}">
		</div>
		<input type="hidden" name="product_smileregistration" value="新規未登録">
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>

	</form>
@endsection

