@extends('layout')
@section('content')


<h2 class="page-header">商品マスタ登録・編集</h2>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>商品を個別登録する</h3>
				</div>
				<div class="panel-body">
					<a href="{{url('masters/products/create')}}" class="btn btn-primary">個別商品登録</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>商品を一括登録する</h3>
				</div>
				<div class="panel-body">
					<div class="well">
						<h4>登録フォーマット</h4>
						<p>スマイルへ登録するための基本フォーマットをダウンロードします。</p>
						<a href="{{ asset('storage/master/product/format/product_format_ver01.xlsm') }}" class="btn btn-primary">ダウンロード</a>
					</div>
					<h4>ファイルアップロード</h4>
					<form action="{{ url('masters/products/batch') }}" method="POST" enctype="multipart/form-data" class="form-inline">
						{{ csrf_field() }}

						<div class="form-group">
							<label><input type="checkbox" value="true" name="line1" checked="checked">1行目は項目名</label>
						</div>
						<div class="form-group">
							<input type="file" name="data-file">
						</div>
						<div class="form-group">
							<input type="submit" value="アップロード" class="btn btn-default">
						</div>
					</form>
					@if(session('success_message'))
						<div class="alert alert-success" role="alert">
							{{ session('success_message')}}
						</div>
					@elseif(session('file_type_error'))
						<div class="alert alert-danger" role="alert">
							{{ session('file_type_error')}}
						</div>
					@elseif(session('duplication'))
						<div class="alert alert-danger" role="alert">
							{{ session('duplication')}}
							<ul>
							@foreach( session('duplication_message') as $line)
								<li>{{ $line }}</li>
							@endforeach
							</ul>
						</div>
					@elseif(session('data_type_error'))
						<div class="alert alert-danger" role="alert">
							{{ session('data_type_error')}}
							<ul>
							@foreach( session('data_type_error_array') as $key => $line)
								<li>
									@foreach( $line as $value)
										{{ $key }} の {{ $value }},
									@endforeach
								</li>
							@endforeach
							</ul>
						</div>
					@elseif(session('product_name_lencheck'))
						<div class="alert alert-danger" role="alert">
							{{ session('product_name_lencheck') }}
							@foreach( session('product_name_lencheck_array') as $line)
								<li>
									{{ $line }}
								</li>
							@endforeach
						</div>
					@elseif(session('exception_error'))
						<div class="alert alert-danger" role="alert">
							{{ session('exception_error') }}
							<div>
							{{ print_r(session('exception_message')) }}
							</div>
						</div>
					@elseif(session('brand_id_error'))
						<div class="alert alert-danger" role="alert">
							{{ session('brand_id_error') }}
						</div>
					@endif
					<div class="well">
						<h4>最近一括登録されたファイル</h4>
						<p>最近一括登録されたテキストファイルをダウンロードできます。</p>
						<a href="{{ asset('storage/master/product/format/product_format_ver01.xlsm') }}" class="btn btn-primary">ダウンロード</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>商品を一括編集する</h3>
				</div>
				<div class="panel-body">
					<div class="well">
						<h4>編集フォーマット</h4>
						<p>スマイルへ登録するための基本フォーマットをダウンロードします。</p>
						<a href="" class="btn btn-primary">ダウンロード</a>
					</div>
					<h4>ファイルアップロード</h4>
						<form action="{{ url('masters/products/batch') }}" method="POST" enctype="multipart/form-data" class="form-inline">
							{{ csrf_field() }}
							<div class="form-group">
								<label><input type="checkbox" value="true" name="line1" checked="checked">1行目は項目名</label>
							</div>
							<div class="form-group">
								<input type="file" name="data-file">
							</div>
							<div class="form-group">
								<input type="submit" value="アップロード" class="btn btn-default">
							</div>
						</form>
					@if(session('success_message'))
						<div class="alert alert-success" role="alert">
							{{ session('success_message ')}}
						</div>
					@elseif(session('file_type_error'))
						<div class="alert alert-danger" role="alert">
							{{ session('file_type_error')}}
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>新規未登録ファイル</h3>
				</div>
				<div class="panel-body">
					<h4>スマイル用登録フォーマット</h4>
					<p>スマイル専用のテキストファイルをダウンロードします。</p>
					<form action="{{ url('masters/products/batchfile_download')}}" method="POST">
						{{ csrf_field() }}
						<div class="form-group">
							<input type="submit" value="ダウンロード" class="btn btn-primary">
						</div>
					</form>
					@if(session('download_path'))
						<div class="alert alert-info" role="alert"><a href="{{ session('download_path')}}">{{ session('file_name') }}</a></div>
					@elseif(session('error_message'))
						<div class="alert alert-danger" role="alert">ファイルの取得に失敗しました。</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection('content')