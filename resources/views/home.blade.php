@extends('layout') {{-- layout.blade.phpを拡張 --}}
@section('content') {{-- sectionを定義 --}}
<div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1>ダッシュボード</h1></div>
            <div class="panel-body">

                <div class="col-md-6">
                    <p>{{ Auth::user()->name }}さんに関するお知らせです</p>
                    <p>商品登録状況などを検索していれる</p>
                </div>

                <div class="col-md-6">
                    <p>全社共有情報</p>
                    <p>お知らせ情報を入れる</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
    	<div class="panel panel-default">
    		<div class="panel-heading"><h1>登録状況</h1><p>最新の10件を表示</p></div>
    		<div class="panel-body">
                <div class="col-md-3">
                    <p>ブランド</p>
                    @foreach($brands as $brand)

                            <dt>{{ $brand->brand_code }}</dt>
                            <dd>{{ $brand->brand_name }}</dd>

                    @endforeach
                </div>
                <div class="col-md-3">
                    <p>商品</p>
                    <dl>
                    @foreach($products as $product)

                        <dt>{{{ $product->product_name }}}</dt>
                        <dd>{{{ $product->product_smileregistration }}}</dd>

                    @endforeach
                    </dl>
                </div>
    		</div>
    	</div>
    </div>
</div>
@endsection

