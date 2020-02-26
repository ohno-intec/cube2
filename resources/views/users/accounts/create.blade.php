@extends('layout') {{-- layout.blade.phpを拡張 --}}
@section('content') {{-- sectionを定義 --}}
<div class="row">
    <div class="col-md-12">
   		<h1>各種ユーザーアカウントの登録</h1>
   		<form action="{{ url('accounts') }}" method="post">
   			{{ csrf_field() }}
   			<div class="form-group">
   				<label>ユーザー</label>
   				<select name="user_id" class="form-control">
   					@foreach($users as $user)
   						<option value="{{ $user->id }}">{{ $user->name}}</option>
   					@endforeach
   				</select>
   			</div>
   			<div class="form-group">
   				<label>システム名</label>
   				<select name="system" class="form-control">
   					<option value="SMILE BS">SMILE BS</option>
   					<option value="ALPHA">ALPHA</option>
   					<option value="EMAIL">E-mail</option>
   				</select>
   			</div>
   			<div class="form-group">
   				<label>アカウント名</label>
   				<input type="text" name="name" class="form-control" />
   			</div>
			<div class="form-group">
   				<lable>パスワード</lable>
   				<input type="text" name="password" class="form-control" />
   			</div>
   			<button type="submit">登録</button>
   		</form>
    </div>
</div>
@endsection

