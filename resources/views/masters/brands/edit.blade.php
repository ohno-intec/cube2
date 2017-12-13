@extends('layout')
@section('content')

	<h2 class="page-header">ブランド編集</h2>

	<form action="{{ url("masters/brands/{$brand->id}") }}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="form-group">
			<label>ブランドコード</label>
			<input required class="form-control" name="brand_code" type="text" value="{{{ $brand->brand_code }}}" />
		</div>
		<div class="form-group">
			<label>ブランド名</label>
			<input required class="form-control" name="brand_name" type="text" value="{{{ $brand->brand_name }}}" />
		</div>
		<div class="form-group">
			<label>サブブランド名</label>
			<input class="form-control" name="brand_subname" type="text" value="{{{ $brand->brand_subname }}}" />
		</div>
		<div class="form-group">
			<label>ブランドの説明</label>
			<textarea class="form-control" name="brand_description" type="text">{{{ $brand->brand_description }}}</textarea>
		</div>
		<div class="form-group">
			<label>ブランドカテゴリ</label>
			<script>
				$(function(){

					barnd_category_db = {{{ $brand->brand_category}}}

					console.log(brand_category);

					$("[name=brand_category] option").each(fuction(){

						if( $(this).val() == brand_category ){

							$(this).prop('selected', true);

						}

					});

				});

			</script>

			<select name="brand_category">
				<option　value="自社オリジナル">自社オリジナル</option>
				<option value="自社ライセンス">自社ライセンス</option>
				<option value="自社正規輸入">自社正規輸入</option>
				<option value="自社並行輸入">自社並行輸入</option>
				<option value="受託OEM">受託OEM</option>
				<option value="他社仕入">他社仕入</option>
			</select>

		</div>
		<div class="form-group">
			<label>ブランドロゴ</label>
			<input required class="form-control" name="brand_logofilename" type="text" value="{{{ $brand->brand_logofilename }}}" />
		</div>
		<div class="form-group">
			<label>WEBサイト</label>
			<input required class="form-control" name="barnd_website" type="text" value="{{{ $brand->barnd_website }}}" />
		</div>
		<div class="form-group">
			<label>発祥国</label>
			<input required class="form-control" name="brand_country" type="text" value="{{{ $brand->brand_country }}}" />
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>
	</form>


@endsection