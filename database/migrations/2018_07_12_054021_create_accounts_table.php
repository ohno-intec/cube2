<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('ユーザーID');
            $table->string('system', 10)->comment('システム名');
            $table->string('name', 50)->comment('アカウント名');
            $table->string('password', 100)->comment('パスワード');
            $table->string('photo', 2083)->comment('写真のファイル名')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
