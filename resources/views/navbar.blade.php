<nav class="navbar navbar-inverse row">
	<div class="container-fluid">
		<div class="navbar-header col-md-12">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbarEexample7">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">マスター情報参照システム{{HTML::image('images/cube_svg.svg', 'cube logo', ['style' => 'display: inline-block;', 'height' => '40'])}}
		</div>

		<div class="collapse navbar-collapse" id="navbarEexample7">
			<ul class="nav navbar-nav">

				<li class="dropdown">{{HTML::linkAction('PagesController@index', 'ホーム')}}</li>
				<li class="dropdown">{{HTML::linkAction('PagesController@master', 'マスタ管理')}}
					<ul class="dropdown-menu">
						{{--
                        <li><a href="#">マスタ検索</a></li>
                        --}}
						<li><a href="{{url('masters/products')}}">商品マスタ一覧</a></li>
						<li><a href="{{url('masters/products/management')}}">商品マスタ登録・修正</a></li>
						<li><a href="{{url('masters/suppliers')}}">仕入先マスタ</a></li>
						<li>{{HTML::linkAction('Masters\BrandsController@index', 'ブランドマスタ')}}</li>
						<li><a href="{{url('masters/categories')}}">商品カテゴリマスタ</a></li>
						{{--
						<li><a href="#">フォーマット</a></li>
						--}}
						<!--<li><a href="#">商品登録申請</a></li>
						<li><a href="#">単価登録申請</a></li>-->
					</ul>
				</li>
				{{--	
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">データチェック<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">単価・売単価0チェック</a></li>
					</ul>
				</li>				
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">委託・貸出管理<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">委託伝票</a></li>
						<li><a href="#">貸出伝票</a></li>
					</ul>
				</li>
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">営業<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">日報</a></li>
						<li><a href="#">売上</a></li>
					</ul>
				</li>
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">社内リソース<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">得意先・仕入先への案内文</a></li>
						<li><a href="#">社内用申請書</a></li>
					</ul>
				</li>				
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">アフターサービス管理<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">修正受付</a></li>
					</ul>
				</li>
				--}}
			</ul>			

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">ログイン</a></li>
                            <li><a href="{{ route('register') }}">登録</a></li>
                        @else
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} さん <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                	<li>
                                		<a href="{{ route('users.index')}}">アカウント情報の確認</a>
                                	</li>
                                	@if( Auth::user()->name == '管理者')
                                		<li><a href="{{ route('accounts.create') }}">アカウント情報の登録</a></li>
                                	@endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            ログアウト
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
		</div>
	</div>
</nav>