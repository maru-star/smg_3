<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 命名規則で自動でアルファベット順になるため注意
        Schema::create('equipment_venue', function (Blueprint $table) {
            $table->bigIncrements('id');

            // 外部キー設定時の注意点
            // https://qiita.com/ucan-lab/items/976d4d8b45685b1a4ada
            $table->bigInteger('venue_id')->unsigned()->index();
            $table->bigInteger('equipment_id')->unsigned()->index();
            $table->timestamps();
            // 外部キー設定
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            // 重複不可
            $table->unique(['venue_id', 'equipment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_venue');
    }
}
