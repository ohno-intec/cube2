@extends('layout')
@section('content')

	<h2 class="page-header">仕入先詳細</h2>
	<ul class="list-inline">
		<li>
			<a href="{{ url("masters/suppliers") }}" class="btn btn-primary pull-left">一覧</a>
		</li>
		<li>
			<a href="{{ url("masters/suppliers/{$supplier->id}/edit") }}" class="btn btn-primary pull-left">編集</a>
		</li>
		<li>
			<form action="masters/suppliers/{$supplier->id}" method="delete">
				<button type="submit" class="btn btn-danger pull-left">削除</button>
			</form>
		</li>
	</ul>
	<table class="table table-striped">
			<tr>
				<th>ID</th>
				<td>{{{ $supplier->id }}}</td>
			</tr>
			<tr>
				<th>仕入先コード</th>
				<td>{{{ $supplier->supplier_code }}}</td>
			</tr>
			<tr>
				<th>仕入先名</th>
				<td>{{{ $supplier->supplier_name }}}</td>
			</tr>
			<tr>
				<th>索引</th>
				<td>{{{ $supplier->supplier_index }}}</td>
			</tr>
			<tr>
				<th>郵便番号</th>
				<td>{{{ $supplier->supplier_zipcode }}}</td>
			</tr>
			<tr>
				<th>住所1</th>
				<td>{{{ $supplier->supplier_address1 }}}</td>
			</tr>
			<tr>
				<th>住所2</th>
				<td>{{{ $supplier->supplier_address2 }}}</td>
			</tr>
			<tr>
				<th>住所3</th>
				<td>{{{ $supplier->supplier_address3 }}}</td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td>{{{ $supplier->supplier_tel }}}</td>
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td>{{{ $supplier->supplier_email }}}</td>
			</tr>
			<tr>
				<th>相手担当者</th>
				<td>{{{ $supplier->supplier_salerep }}}</td>
			</tr>
			<tr>
				<th>担当ユーザーID</th>
				<td>{{{ $supplier->user_id }}}({{{ key($users) }}})</td>
			</tr>
			<tr>
				<th>業界</th>
				<td>{{{ $supplier->supplier_industrytype }}}</td>
			</tr>
			<tr>
				<th>業種</th>
				<td>{{{ $supplier->supplier_businesstype }}}</td>
			</tr>
			<tr>
				<th>情報</th>
				<td>{{{ $supplier->supplier_information }}}</td>
			</tr>
			<tr>
				<th>作成日</th>
				<td>{{{ $supplier->created_at }}}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{{{ $supplier->updated_at }}}</td>
			</tr>
	</table>

@endsection
