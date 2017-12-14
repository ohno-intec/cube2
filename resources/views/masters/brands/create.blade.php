@extends('layout')
@section('content')
	<h2 class="page-header">ブランド登録</h2>

	<form action="{{ url('masters/brands') }}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<p>ブランドコードは自動で付与されます。</p>
		</div>
		<div class="form-group">
			<label>ブランド名[必須 ：　半角ｶﾅのみ 例：ソーラス(NG) => ｿｰﾗｽ(OK) スペースや記号もNG]</label>
			<input required class="form-control" name="brand_name" type="text" value="{{{ old('brand_name') }}}" />
		</div>
		<div class="form-group">
			<label>サブブランド名</label>
			<input class="form-control" name="brand_subname" type="text" value="{{{ old('brand_subname') }}}" />
		</div>
		<div class="form-group">
			<label>ブランドの説明</label>
			<textarea class="form-control" name="brand_description" type="text">{{{ old('brand_description') }}}</textarea>
		</div>
		<div class="form-group">
			<label>ブランドカテゴリ[必須]</label>
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
			<input class="form-control" name="brand_logofilename" type="text" value="{{{ old('brand_logofilename') }}}" />
		</div>
		<div class="form-group">
			<label>WEBサイト</label>
			<input class="form-control" name="barnd_website" type="text" value="{{{ old('barnd_website') }}}" />
		</div>
		<div class="form-group">
			<label>発祥国</label>
			<input class="form-control" name="brand_country" type="text" value="{{{ old('brand_country') }}}" />
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" />
		</div>
	</form>


@endsection