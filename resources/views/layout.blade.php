<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<title>CUBE2</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- css -->
<link
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	rel="stylesheet" type="text/css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600"
	rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<!-- javascript -->
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script><!-- Compressed jquery3-->
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->

<script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script><!-- jQuery統合用ファイル -->
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
	integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
	crossorigin="anonymous"></script>

<script type="text/javascript"
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript" src="{{ asset('/js/function.js') }}"></script>

  <script>
  </script>

	<style>
	.dropdown:hover>.dropdown-menu {
		display: block;
	}
	</style>

</head>
<body>
	{{-- ナビゲーションバーのPartialを使用 --}} @include('navbar')
	<div class="container-fluid">
		<!--
		@if (Session::has('flash_message'))
			<div class="alert alert-success"> {{ Session::get('flash_message')}}</div>
		@endif

		@yield('content')
		-->
		@yield('content')
	</div>
</body>
</html>