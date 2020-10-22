<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFramePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frame_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venue_id')->unsigned()->index();
            $table->string('frame');
            $table->time('start');
            $table->time('finish');
            $table->integer('price');
            $table->integer('extend'); //一律なので全レコードに持たせる
            $table->timestamps();

            // 外部キー制約
            $table->foreign('venue_id')->references('id')->on('venues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_prices');
    }
}
