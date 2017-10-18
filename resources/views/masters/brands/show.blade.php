@extends('layout')
@section('content')

	<h2 class="page-header">ブランド詳細</h2>
	<ul class="list-inline">
		<li>
			<a href="{{ url("masters/brands") }}" class="btn btn-primary pull-left">一覧</a>
		</li>
		<li>
			<a href="{{ url("masters/brands/{$brand->id}/edit") }}" class="btn btn-primary pull-left">編集</a>
		</li>
		<li>
			<form action="masters/brands/{$brand->id}" method="delete">
				<button type="submit" class="btn btn-danger pull-left">削除</button>
			</form>
		</li>
	</ul>
	<table class="table table-striped">
			<tr>
				<th>ID</th>
				<td>{{{ $brand->id }}}</td>
			</tr>
			<tr>
				<th>ブランドコード</th>
				<td>{{{ $brand->brand_code }}}</td>
			</tr>
			<tr>
				<th>ブランド名</th>
				<td>{{{ $brand->brand_name }}}</td>
			</tr>
			<tr>
				<th>サブブランド名</th>
				<td>{{{ $brand->bradn_subname }}}</td>
			</tr>
			<tr>
				<th>ブランドの説明</th>
				<td>{{{ $brand->brand_description }}}</td>
			</tr>
			<tr>
				<th>ブランドカテゴリ</th>
				<td>{{{ $brand->brand_category }}}</td>
			</tr>
			<tr>
				<th>ブランドロゴ</th>
				<td>{{{ $brand->brand_logofilename }}}</td>
			</tr>
			<tr>
				<th>WEBサイト</th>
				<td>{{{ $brand->barnd_website }}}</td>
			</tr>
			<tr>
				<th>発祥国</th>
				<td>{{{ $brand->brand_country }}}</td>
			</tr>
			<tr>
				<th>作成日</th>
				<td>{{{ $brand->created_at }}}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{{{ $brand->updated_at }}}</td>
			</tr>
	</table>


@endsection
