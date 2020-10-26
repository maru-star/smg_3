<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dates', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('venue_id')->unsigned();
      $table->integer('week_day');
      $table->unique(['venue_id', 'week_day'], 'uniq');
      $table->time('start');
      $table->time('finish');
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
    Schema::dropIfExists('dates');
  }
}
