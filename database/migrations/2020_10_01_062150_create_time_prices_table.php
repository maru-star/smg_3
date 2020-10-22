<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venue_id')->unsigned()->index();
            $table->integer('time');
            $table->integer('price');
            $table->integer('extend');
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
        Schema::dropIfExists('time_prices');
    }
}
