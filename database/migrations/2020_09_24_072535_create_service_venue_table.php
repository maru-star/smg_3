<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceVenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_venue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venue_id')->unsigned()->index();
            $table->bigInteger('service_id')->unsigned()->index();
            $table->timestamps();
            // 外部キー設定
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            // 重複不可
            $table->unique(['venue_id', 'service_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_venue');
    }
}
