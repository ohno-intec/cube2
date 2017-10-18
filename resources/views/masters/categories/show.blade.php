@extends('layout')
@section('content')

	<h2 class="page-header">カテゴリー詳細</h2>
	<ul class="list-inline">
		<li>
			<a href="{{ url("masters/categories") }}" class="btn btn-primary pull-left">一覧</a>
		</li>
		<li>
			<a href="{{ url("masters/categories/{$category->id}/edit") }}" class="btn btn-primary pull-left">編集</a>
		</li>
		<li>
			<form action="masters/categories/{$category->id}" method="delete">
				<button type="submit" class="btn btn-danger pull-left">削除</button>
			</form>
		</li>
	</ul>
	<table class="table table-striped">
			<tr>
				<th>ID</th>
				<td>{{{ $category->id }}}</td>
			</tr>
			<tr>
				<th>分類種別</th>
				<td>{{{ $category->category_type }}}</td>
			</tr>
			<tr>
				<th>分類コード</th>
				<td>{{{ $category->category_code }}}</td>
			</tr>
			<tr>
				<th>分類名</th>
				<td>{{{ $category->category_name }}}</td>
			</tr>
			<tr>
				<th>分類詳細</th>
				<td>{{{ $category->category_detail }}}</td>
			</tr>
			<tr>
				<th>作成日</th>
				<td>{{{ $category->created_at }}}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{{{ $category->updated_at }}}</td>
			</tr>
	</table>

@endsection
