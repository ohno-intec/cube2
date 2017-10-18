<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        schema::create('products', function(Blueprint $table){
            $table->increments('id');
            $table->integer('brand_id')->unsigned()->comment('ブランドID');    //belongsTo brand
            $table->unsignedBigInteger('product_code')->comment('商品コード[ブランドID+4桁連番]');    //ブランドIDごとで自動採番 1ｂ.brand_idからproduct_codeをfind 2.if(row == 0){brand_id+0001}else{brand_code += 1}
            $table->string('product_modelnumber', 36)->comment('型番');
            $table->string('product_name', 36)->comment('商品名[ブランド名(半角カタカナ)+型番]'); //
            $table->string('product_index', 10)->comment('索引[型番の半角小文字]');
            $table->integer('supplier_id')->unsigned()->comment('仕入先コード');
            $table->decimal('product_unitprice', 9, 3)->comment('標準売上単価')->nullable();
            $table->decimal('product_costprice', 9, 3)->comment('標準仕入単価')->nullable();
            $table->decimal('product_stockprice', 9, 3)->comment('在庫評価単価')->nullable();
            $table->decimal('product_retailprice', 8, 3)->comment('上代単価')->nullable();
            $table->date('product_newpricestartdate')->comment('新単価実施日')->nullable();
            $table->decimal('product_newunitprice', 9, 3)->comment('新標準売上単価')->nullable();
            $table->decimal('product_newcostprice', 9, 3)->comment('新標準仕入単価')->nullable();
            $table->decimal('product_newstockprice', 9, 3)->comment('新在庫評価単価')->nullable();
            $table->decimal('product_newretailprice', 8, 3)->comment('新上代単価')->nullable();
            $table->integer('category_id')->unsigned()->comment('カテゴリーID');   //商品大分類34
            $table->unsignedMediumInteger('product_typecode')->comment('商品種別コード');   //商品種別
            $table->unsignedMediumInteger('product_stockholdingcode')->comment('在庫保有コード');   //在庫保有
            $table->unsignedMediumInteger('product_rackcode')->comment('棚番号コード');   //棚コード10
            $table->unsignedMediumInteger('product_warehouseholdingcode')->comment('倉庫保有コード');   //倉庫保有
            $table->integer('product_properstockquantity')->comment('適正在庫数');    //適正在庫数
            $table->integer('product_boystockquantity')->comment('期首残数量');
            $table->decimal('product_boybalance', 11, 3)->comment('期首残金額');
            $table->unsignedTinyInteger('product_showmastersearch')->comment('マスター検索表示区分');
            $table->integer('product_eancode')->comment('EANコード')->nullable();
            $table->string('product_asin')->comment('ASIN')->nullable();
            $table->string('product_smileregistration')->comment('スマイル登録状況')->nullable();  //未対応、拒否、完了
            $table->string('product_smileregistrationcomment')->comment('登録に関するコメント')->nullable(); //重複の為拒否されました。など
 
            $table->string('product_status')->comment('ステータス')->nullable();   //状態 継続,廃盤
            $table->string('product_stockstatus')->comment('在庫状況')->nullable();   //在庫状況 在庫あり,在庫なし
            $table->string('product_arrivalschedule')->comment('入荷予定')->nullable(); //入荷予定 入荷予定あり,入荷予定なし
            $table->string('product_orderstatus')->comment('発注状況')->nullable();  //未発注,発注済
            $table->date('product_arrivaldate')->comment('入荷予定着')->nullable();  //入荷予定日
            $table->text('product_ordernote')->comment('発注メモ')->nullable();  //この商品の発注に関する覚書

            $table->string('product_imageurl')->comment('商品画像')->nullable(); //商品画像
            $table->text('product_size')->comment('商品サイズ')->nullable(); //商品サイズ   本体サイズ、バンドサイズ、ケースサイズなどをまとめて記載
            $table->decimal('product_weight', 5, 1)->comment('本体重量')->nullable();  //本体重量　単位g
            $table->string('product_material')->comment('商品素材')->nullalbe(); //商品材質　ケース、バンド、風防などをまとめて記載
            $table->string('product_packagesize')->comment('パッケージサイズ')->nullable(); //パッケージサイズ　単位cm
            $table->decimal('product_packageweight', 5, 1)->comment('パッケージ重量')->nullable();   //パッケージ重量 単位g
            $table->unsignedTinyInteger('product_waterproof')->unsigned()->comment('防水性能')->nullable();  //防水性能 単位ATM
            $table->string('product_color')->comment('色')->nullable();  //色
            $table->string('product_batterynumber')->comment('電池型番')->nullable();    //電池型番
            $table->text('product_specnote')->comment('スペックメモ')->nullable();   //仕様に関するメモ
            $table->text('product_function')->comment('機能')->nullable();   //機能　電波、クロノ、アラームなどをまとめて記載
            $table->string('product_includeditems')->comment('同梱物')->nullable();   //同梱物
            $table->decimal('product_warrantyterm', 3, 1)->comment('保証期間')->nullable(); //保証期間 3桁小数点以下1桁 単位年
            $table->date('product_releasedate')->comment('販売開始日')->nullable();    //販売開始日
            $table->text('product_description')->comment('商品の説明')->nullable();    //商品の説明

            $table->timestamps();
            $table->softDeletes()->comment('論理削除');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
