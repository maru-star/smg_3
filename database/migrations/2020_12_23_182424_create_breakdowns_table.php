<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakdownsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('breakdowns', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('bill_id')->unsigned()->index();
      $table->integer('unit_item');
      $table->integer('unit_cost');
      $table->integer('unit_count');
      $table->integer('unit_subtotal');
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
    Schema::dropIfExists('breakdowns');
  }
}