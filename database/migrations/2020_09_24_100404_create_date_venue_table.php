<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateVenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_venue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venue_id')->unsigned()->index();
            $table->bigInteger('date_id')->unsigned()->index();
            // $table->dateTime('start');
            // $table->dateTime('finish');
            $table->timestamps();
            // 外部キー設定
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('date_id')->references('id')->on('dates')->onDelete('cascade');
            // 重複不可
            $table->unique(['venue_id', 'date_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_venue');
    }
}
