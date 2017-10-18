@extends('layout')
@section('content')

	<h2 class="page-header">仕入先登録</h2>

	<form action="{{ url('masters/categories') }}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<label>分類タイプ</label>
			<select name="category_type">
				<option>選択してください</option>
				<option value="商品小分類">商品小分類</option>
				<option value="商品大分類">商品大分類</option>
			</select>
		</div>
		<div class="form-group">
			<label>分類コード</label>
			<input required class="form-control" name="category_code" type="text" value="{{{ old('category_code') }}}" />
		</div>
		<div class="form-group">
			<label>分類名</label>
			<input class="form-control" name="category_name" type="text" value="{{{ old('category_name') }}}" />
		</div>
		<div class="form-group">
			<label>分類詳細</label>
			<textarea required class="form-control" name="category_detail" value="{{{ old('category_detail') }}}"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>
	</form>


@endsection