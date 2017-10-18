@extends('layout')
@section('content')

	<h2 class="page-header">カテゴリー一覧</h2>
	<div class="col-md-3">
		{{HTML::linkAction('Masters\CategoriesController@create', 'カテゴリー登録', [], ['class' => 'btn btn-primary'])}}
	</div>	
	<div class="col-md-5">
		<form action="{{ url('masters/categories/batch') }}" method="post" enctype="multipart/form-data" class="form-inline">
			{{ csrf_field() }}
			<div class="form-group">
				<label>カテゴリ一括登録</label>
			</div>
			<div class="form-group">
				<input type="file" name="data-file">
			</div>
			<input type="submit" value="アップロード">
		</form>
		@if(session('file_type_error'))
			<div class="alert alert-warning" role="alert">
				{{ session('file_type_error') }}
			</div>
		@elseif(session('duplication'))
			<div class="alert alert-warning" role="alert">
				<P>{{ session('duplication') }}</P>
				<ul>
				@foreach( session('duplication_message') as $line)
					<li>{{ $line }}</li>
				@endforeach
				</ul>
			</div>
		@endif

	</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>分類種別</th>
				<th>分類コード</th>
				<th>分類名</th>
				<th>分類詳細</th>
				<th>登録日</th>
				<th>更新日</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		@foreach($categories as $category)
			<tr>
				<td>{{{ $category->id }}}</td>
				<td>{{{ $category->category_type }}}</td>
				<td>{{{ $category->category_code }}}</td>
				<td>{{{ $category->category_name }}}</td>
				<td>{{{ mb_strimwidth($category->category_detail, 0, 100, "...") }}}</td>
				<td>{{{ $category->created_at }}}</td>
				<td>{{{ $category->updated_at }}}</td>
				<td>
					<a href="{{ url("masters/categories/{$category->id}") }}" class="btn btn-primary">詳細</a>
					<a href="{{ url("masters/categories/{$category->id}/edit") }}" class="btn btn-primary">編集</a>
					<form action="{{ url("masters/categories/{$category->id}") }}" method="post">
						{{ csrf_field() }}
						{{ method_field('DELETE')}}
						<input type="submit" class="btn btn-danger destroy" value="削除" />
					</form>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>




@endsection