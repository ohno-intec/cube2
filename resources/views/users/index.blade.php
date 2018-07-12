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
				    <div class="col-md-12">
                    <h2>Smileアカウント</h2>

	                    <dl class="dl-horizontal">
	                    	@foreach( $accountSmile as $account)
	                   		<dt>アカウント名</dt><dd>{{ $account->name }}</dd>
	                   		<dt>パスワード</dt><dd>{{ $account->password }}</dd>
	                   		@endforeach
	                   	</dl>
                    </div>
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
    		</div>
    	</div>
    </div>

@endsection