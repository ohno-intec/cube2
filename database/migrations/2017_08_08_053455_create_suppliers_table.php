<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table){
            $table->increments('id', 6);
            $table->integer('supplier_code')->comment('仕入先コード');
            $table->string('supplier_name', 32)->comment('仕入先名');
            $table->string('supplier_index', 10)->nullable()->comment('索引');
            $table->string('supplier_zipcode', 10)->nullable()->comment('郵便番号');
            $table->string('supplier_address1', 32)->nullable()->comment('住所1');
            $table->string('supplier_address2', 32)->nullable()->comment('住所2');
            $table->string('supplier_address3', 32)->nullable()->comment('住所3');
            $table->string('supplier_tel', 15)->nullable()->comment('電話番号');
            $table->string('supplier_fax', 15)->nullable()->comment('FAX');
            $table->string('supplier_email')->nullable()->comment('メールアドレス');
            $table->string('supplier_salerep')->nullable()->comment('仕入先担当者'); //representative
            $table->integer('user_id')->nullable()->comment('自社担当者');
            $table->string('supplier_industrytype', 20)->nullable()->comment('業界'); //時計、アパレル、喫煙具、バッグ、文具、キッチン
            $table->string('supplier_businesstype', 20)->nullable()->comment('業種'); //メーカー、卸売
            $table->text('supplier_information')->nullalbe()->comment('情報');
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
