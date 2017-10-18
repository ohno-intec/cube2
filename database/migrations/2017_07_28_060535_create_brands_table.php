<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_code')->unique();
            $table->string('brand_name',100);
            $table->string('brand_subname',100);
            $table->text('brand_description');
            $table->string('brand_category',50);
            $table->string('brand_logofilename');
            $table->string('barnd_website');
            $table->string('brand_country',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
