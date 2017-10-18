@extends('layout')
@section('content')

	<h2 class="page-header">仕入先登録</h2>

	<form action="{{ url('masters/suppliers') }}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<label>仕入先コード</label>
			<input required class="form-control" name="supplier_code" type="text" value="{{{ old('supplier_code') }}}" />
		</div>
		<div class="form-group">
			<label>仕入先名</label>
			<input required class="form-control" name="supplier_name" type="text" value="{{{ old('supplier_name') }}}" />
		</div>
		<div class="form-group">
			<label>索引</label>
			<input class="form-control" name="supplier_index" type="text" value="{{{ old('supplier_index') }}}" />
		</div>
		<div class="form-group">
			<label>郵便番号</label>
			<input class="form-control" name="supplier_zipcode" type="text" value="{{{ old('supplier_zipcode') }}}" />
		</div>
		<div class="form-group">
			<label>住所1</label>
			<input class="form-control" name="supplier_address1" type="text" value="{{{ old('supplier_address1') }}}" />
		</div>
		<div class="form-group">
			<label>住所2</label>
			<input class="form-control" name="supplier_address2" type="text" value="{{{ old('supplier_address2') }}}" />
		</div>
		<div class="form-group">
			<label>住所3</label>
			<input class="form-control" name="supplier_address3" type="text" value="{{{ old('supplier_address3') }}}" />
		</div>
		<div class="form-group">
			<label>電話番号</label>
			<input class="form-control" name="supplier_tel" type="text" value="{{{ old('supplier_tel') }}}" />
		</div>
		<div class="form-group">
			<label>FAX</label>
			<input class="form-control" name="supplier_fax" type="text" value="{{{ old('supplier_fax')}}}" />
		</div>
		<div class="form-group">
			<label>メールアドレス</label>
			<input class="form-control" name="supplier_email" type="text" value="{{{ old('supplier_email')}}}">
		</div>
		<div class="form-group">
			<label>相手担当者</label>
			<input class="form-control" name="supplier_salerep" type="text" value="{{{ old('supplier_salesrep')}}}">
		</div>
		{{-- http://www.webopixel.net/php/1261.html --}}
		<div class="form-group">
			<label>担当ユーザー</label>
			<select name="user_id">
				<option value="">選択してください</option>
				@foreach ($users as $key => $user)
					<option value="{{ $user }}">{{ $key }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>業界</label>
			<select name="supplier_industrytype">
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
			<textarea required class="form-control" name="supplier_information" value="{{{ old('supplier_information') }}}"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>
	</form>


@endsection