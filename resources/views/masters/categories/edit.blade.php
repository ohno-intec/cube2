@extends('layout')
@section('content')

	<h2 class="page-header">カテゴリー編集</h2>

	<form action="{{ url("masters/categories/{$category->id}") }}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		{{-- http://www.webopixel.net/php/1261.html --}}
		<script type="text/javascript">
		$(function(){

			var $category_type = "{{{ $category->category_type }}}"
			$('#category_type').val($category_type);


		});

		</script>
		<div class="form-group">
			<label>分類種別</label>
			<select name="category_type" id="category_type">
				<option value="">選択してください</option>
				<option value="商品小分類">商品小分類</option>
				<option value="商品大分類">商品大分類</option>
			</select>
		</div>
		<div class="form-group">
			<label>分類コード</label>
			<input required class="form-control" name="category_code" type="text" value="{{{ $category->category_code }}}" />
		</div>
		<div class="form-group">
			<label>分類名</label>
			<input class="form-control" name="category_name" type="text" value="{{{ $category->category_name }}}" />
		</div>
		<div class="form-group">
			<label>分類詳細</label>
			<textarea required class="form-control" name="category_detail" value="">{{{ $category->category_detail }}}</textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>
	</form>

@endsection