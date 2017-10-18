@extends('layout')
@section('content')

	<h2 class="page-header">仕入先一覧</h2>
	<div class="row">
		<div class="col-md-3">
			{{HTML::linkAction('Masters\SuppliersController@create', '仕入先登録', [], ['class' => 'btn btn-primary'])}}
		</div>
		<div class="col-md-5">
			<form action="{{ url('masters/suppliers/batch') }}" method="post" enctype="multipart/form-data" class="form-inline">
				{{ csrf_field() }}
				<div class="form-group">
					<label>仕入先一括登録</label>
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
	</div>



	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>仕入先コード</th>
				<th>仕入先名</th>
				<th>電話番号</th>
				<th>FAX</th>
				<th>メールアドレス</th>
				<th>相手担当者</th>
				<th>担当ユーザーID</th>
				<th>業界</th>
				<th>業種</th>
				<th>情報</th>
				<th>登録日</th>
				<th>更新日</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		@foreach($suppliers as $supplier)
			<tr>
				<td>{{{ $supplier->id }}}</td>
				<td>{{{ $supplier->supplier_code }}}</td>
				<td>{{{ $supplier->supplier_name }}}</td>
				<td>{{{ $supplier->supplier_tel }}}</td>
				<td>{{{ $supplier->supplier_fax }}}</td>
				<td>{{{ $supplier->supplier_email }}}</td>
				<td>{{{ $supplier->supplier_salerep }}}</td>
				<td>{{{ $supplier->user_id }}}</td>
				<td>{{{ $supplier->supplier_industrytype }}}</td>
				<td>{{{ $supplier->supplier_businesstype }}}</td>
				<td>{{{ $supplier->supplier_information }}}</td>
				<td>{{{ $supplier->created_at }}}</td>
				<td>{{{ $supplier->updated_at }}}</td>
				<td>
					<a href="{{ url("masters/suppliers/{$supplier->id}") }}" class="btn btn-primary">詳細</a>
					<a href="{{ url("masters/suppliers/{$supplier->id}/edit") }}" class="btn btn-primary">編集</a>
					<form action="{{ url("masters/suppliers/{$supplier->id}") }}" method="post">
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