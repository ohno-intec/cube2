@extends('layout')
@section('content')

	<h2 class="page-header">仕入先編集</h2>

	<form action="{{ url("masters/suppliers/{$supplier->id}") }}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="form-group">
			<label>仕入先コード</label>
			<input required class="form-control" name="supplier_code" type="text" value="{{{ $supplier->supplier_code }}}" />
		</div>
		<div class="form-group">
			<label>仕入先名</label>
			<input required class="form-control" name="supplier_name" type="text" value="{{{ $supplier->supplier_name }}}" />
		</div>
		<div class="form-group">
			<label>索引</label>
			<input class="form-control" name="supplier_index" type="text" value="{{{ $supplier->supplier_index }}}" />
		</div>
		<div class="form-group">
			<label>郵便番号</label>
			<input class="form-control" name="supplier_zipcode" type="text" value="{{{ $supplier->supplier_zipcode }}}" />
		</div>
		<div class="form-group">
			<label>住所1</label>
			<input class="form-control" name="supplier_address1" type="text" value="{{{ $supplier->supplier_address1 }}}" />
		</div>
		<div class="form-group">
			<label>住所2</label>
			<input class="form-control" name="supplier_address2" type="text" value="{{{ $supplier->supplier_address2 }}}" />
		</div>
		<div class="form-group">
			<label>住所3</label>
			<input class="form-control" name="supplier_address3" type="text" value="{{{ $supplier->supplier_address3 }}}" />
		</div>
		<div class="form-group">
			<label>電話番号</label>
			<input class="form-control" name="supplier_tel" type="text" value="{{{ $supplier->supplier_tel }}}" />
		</div>
		<div class="form-group">
			<label>FAX</label>
			<input class="form-control" name="supplier_fax" type="text" value="{{{ $supplier->supplier_fax }}}" />
		</div>
		<div class="form-group">
			<label>メールアドレス</label>
			<input class="form-control" name="supplier_fax" type="text" value="{{{ $supplier->supplier_email }}}" />
		</div>
		<div class="form-group">
			<label>相手担当者</label>
			<input class="form-control" name="supplier_salerep" type="text" value="{{{ $supplier->supplier_salerep }}}">
		</div>
		{{-- http://www.webopixel.net/php/1261.html --}}

		<script type="text/javascript">
		$(function(){

			var $user_id = {{{ $supplier->user_id }}}
			$('#user_id').val($user_id);


		});

		</script>

		<div class="form-group">
			<label>担当ユーザー</label>
			<select name="user_id" id="user_id">
				<option value="">選択してください</option>
				@foreach ($users as $key => $user)
					<option value="{{ $user }}">{{ $key }}</option>
				@endforeach
			</select>
		</div>


		<script type="text/javascript">
		$(function(){

			var $supplier_industrytype = {{{ $supplier->supplier_industrytype }}}
			$('#supplier_industrytype').val($supplier_industrytype);
		});

		</script>
		<div class="form-group">
			<label>業界</label>
			<select name="supplier_industrytype" id="supplier_industrytype">
				<option value="">選択してください</option>
				<option value="時計">時計</option>
				<option value="ジュエリー">ジュエリー</option>
				<option value="アパレル">アパレル</option>
				<option value="雑貨">雑貨</option>
				<option value="バッグ">バッグ</option>
				<option value="シューズ">シューズ</option>
				<option value="キッチン">キッチン</option>
				<option value="喫煙具">喫煙具</option>
				<option value="美容・健康・福祉">美容・健康・福祉</option>
				<option value="スポーツ">スポーツ</option>
				<option value="その他">その他</option>
			</select>
		</div>

		<script type="text/javascript">
		$(function(){

			var $supplier_businesstype = "{{{ $supplier->supplier_businesstype }}}"
			$('[name=supplier_businesstype][value="'+ $supplier_businesstype +'"]').prop('checked', true);
		});

		</script>

		<div class="form-group">
			<p class="cotrol-label"><b>業種</b></p>
			<div class="radio">
				<label>
					<input type="radio" name="supplier_businesstype" value="メーカー">メーカー
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="supplier_businesstype" value="卸売">卸売
				</label>
			</div>
		</div>

		<div class="form-group">
			<label>情報</label>
			<textarea required class="form-control" name="supplier_information">{{{ $supplier->supplier_information }}}</textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>
	</form>

@endsection