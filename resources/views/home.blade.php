@extends('layout') {{-- layout.blade.phpを拡張 --}}
@section('content') {{-- sectionを定義 --}}
<div>
    {{--
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
    --}}
    <div class="col-md-12">
    	<div class="panel panel-default">
    		<div class="panel-heading"><h1>登録状況</h1><p>最新の30件を表示</p></div>
    		<div class="panel-body">
                <div class="col-md-3">
                    <h2>最新のブランド一覧</h2>
                    <p>最近登録されたブランドの一覧を30件表示しています。</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ブランドコード</th>
                                <th>ブランド名</th>
                            </tr>
                        </thead>
                        <tbod>
                            @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand->brand_code }}</td>
                                <td>{{ $brand->brand_name }}</td>
                            </tr>
                            @endforeach
                        </tbod>
                    </table>
                </div>
                <div class="col-md-9">
                    <h2>最新の商品一覧</h2>
                    <p>最近登録された商品の一覧を30件表示しています。</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>商品コード</th>
                                <th>商品名</th>
                                <th>EAN/JAN</th>
                                <th>ASIN</th>
                                <th>基幹システムへの登録状況</th>
                                <th>登録した人</th>
                            </tr>
                        </thead>
                        <tbod>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_eancode }}</td>
                                <td>{{ $product->product_asin }}</td>
                                <td>{{ $product->product_smileregistration }}</td>
                                <td>{{ $product->user->name }}</td>
                            </tr>
                            @endforeach
                        </tbod>
                    </table>
                </div>
    		</div>
    	</div>
    </div>
</div>
@endsection

