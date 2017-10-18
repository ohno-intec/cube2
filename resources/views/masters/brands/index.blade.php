@extends('layout')
@section('content')

	<h2 class="page-header">ブランド一覧</h2>
	<div class="row">
		<div class="col-md-3">
			{{HTML::linkAction('Masters\BrandsController@create', 'ブランド個別登録', [], ['class' => 'btn btn-primary'])}}
		</div>
		<div class="col-md-5">
			<form action="{{ url('masters/brands/batch') }}" method="post" enctype="multipart/form-data" class="form-inline">
				{{ csrf_field() }}
				<div class="form-group">
					<label>ブランド一括登録</label>
				</div>
				<div class="form-group">
					<input type="file" name="data_file">
				</div>
				<input class="btn btn-primary" type="submit" value="アップロード">
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
	</div>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>ブランドコード</th>
				<th>ブランド名</th>
				<th>サブブランド名</th>
				<th>ブランドの説明</th>
				<th>ブランドカテゴリ</th>
				<th>ブランドロゴ</th>
				<th>WEBサイト</th>
				<th>発祥国</th>
				<th>作成日</th>
				<th>更新日</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		@foreach($brands as $brand)
			<tr>
				<td>{{{ $brand->id }}}</td>
				<td>{{{ $brand->brand_code }}}</td>
				<td>{{{ $brand->brand_name }}}</td>
				<td>{{{ $brand->brand_subname }}}</td>
				<td>{{{ $brand->brand_description }}}</td>
				<td>{{{ $brand->brand_category }}}</td>
				<td>{{{ $brand->brand_logofilename }}}</td>
				<td>{{{ $brand->barnd_website }}}</td>
				<td>{{{ $brand->brand_country }}}</td>
				<td>{{{ $brand->created_at }}}</td>
				<td>{{{ $brand->updated_at }}}</td>
				<td>
					<a href="{{ url("masters/brands/{$brand->id}") }}" class="btn btn-primary">詳細</a>
					<a href="{{ url("masters/brands/{$brand->id}/edit") }}" class="btn btn-primary">編集</a>
					<form action="{{ url("masters/brands/{$brand->id}") }}" method="post">
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