@extends('layout') {{-- layout.blade.phpを拡張 --}}
@section('content') {{-- sectionを定義 --}}

    	<div class="panel panel-default">
    		<div class="panel-heading"><h1>ユーザー情報の確認</h1></div>
    		<div class="panel-body">
    			<p>こんちには！{{ $user->name }}さん</p>
    			<div class="row">
				    <div class="col-md-12">
                    <h2>CUBE2登録アカウント</h2>
	                    <dl class="dl-horizontal">
	                   		<dt>アカウント名</dt><dd>{{ $user->email }}</dd>
	                   		<dt>パスワード</dt><dd>{{-- <input type="password" value="{{ $user->password }}" disabled=""> --}}忘れた場合はリセットが必要です</dd>
	                   	</dl>
                   	</div>
                </div>
    			<div class="row">
				    <div class="col-md-12">
                    <h2>Smileアカウント</h2>
	                    <dl class="dl-horizontal">
	                    	@foreach( $accountSmile as $account)
	                   		<dt>アカウント名</dt><dd>{{ $account->name }}</dd>
	                   		<dt>パスワード</dt><dd>{{ $account->password }}</dd>
	                   		@endforeach
	                   	</dl>
                    </div>
                </div>
    			<div class="row">
				    <div class="col-md-12">
                    <h2>Alphaアカウント</h2>
	                    <dl class="dl-horizontal">
	                    	@foreach( $accountAlpha as $account)
	                   		<dt>アカウント名</dt><dd>{{ $account->name }}</dd>
	                   		<dt>パスワード</dt><dd>{{ $account->password }}</dd>
	                   		@endforeach
	                   	</dl>
                   	</div>
                </div>
    			<div class="row">
    				<div class="panel-heading col-md-12"><h2>Emailアカウント</h2></div>
				    <div class="col-md-6">
	                    <dl class="dl-horizontal">
	                    	@foreach( $accountEmail as $account)
	                   		<dt>アカウント名</dt><dd>{{ $account->name }}</dd>
	                   		<dt>パスワード</dt><dd>{{ $account->password }}</dd>
	                   		@endforeach	                   		
	                   		<dt></dt><dd></dd>
	                   		<dt></dt><dd></dd>
	                   		<dt></dt><dd></dd>
	                   		<dt></dt><dd></dd>
	                   	</dl>
                   	</div>
				    <div class="col-md-6">
				    <p>このEmailアカウントはXSERVERのWEBメール用アカウントです</p>
				    <p><a href="https://www.xserver.ne.jp/login_mail.php" target="new">XSERVER WEBメールログイン</a></p>
				    </div>
                   	<div class="col-md-12">
                      	<h3>共通Emailアカウント</h3>
	                   	<table class="table table-striped">
	                   		<thead>
	                   			<tr>
	                   				<th>アカウント名</th>
	                   				<th>パスワード</th>
	                   			</tr>
	                   		</thead>
	                   		<tbody>
	                   			<tr>
	                   				<td>e-mailorder@intec1998.co.jp</td>
	                   				<td>s3n7iiwqnbtu</td>
	                   			</tr>
	                   			<tr>
	                   				<td>info@intec1998.co.jp</td>
	                   				<td>f77art7n3axa</td>
	                   			</tr>
	                   			<tr>
	                   				<td>support-sw@soluswatch.jp</td>
	                   				<td>r46bqe6fiea5</td>
	                   			</tr>
	                   			<tr>
	                   				<td>support@grus.tokyo</td>
	                   				<td>v7xwhs3gkz5c</td>
	                   			</tr>
	                   			<tr>
	                   				<td>newbalance-watches@intec1998.co.jp</td>
	                   				<td>newbalance</td>
	                   			</tr>
	                   		</tbody>
	                   	</table>
	                   	</div>

                </div>
    		</div>
    	</div>
    </div>

@endsection