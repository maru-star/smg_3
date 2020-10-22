<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 255)->comment('メールアドレス');
            $table->string('token', 250)->comment('確認トークン');
            $table->dateTime('expiration_datetime')->comment('有効期限');
            $table->integer('status')->nullable()->comment('認証確認');

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
        Schema::dropIfExists('preusers');
    }
}
