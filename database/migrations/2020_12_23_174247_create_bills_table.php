<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bills', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('reservation_id')->unsigned()->index();

      $table->integer('venue_total');
      $table->integer('venue_discount_percent')->nullable();
      $table->integer('venue_dicsount_number')->nullable();
      $table->integer('discount_venue_total');

      $table->integer('equipment_total');
      $table->integer('service_total');
      $table->integer('luggage_total');
      $table->integer('equipment_service_total');
      $table->integer('discount_item')->nullable();
      $table->integer('discount_equipment_service_total');


      $table->integer('layout_total');
      $table->integer('layout_discount')->nullable();
      $table->integer('after_duscount_layouts');

      $table->integer('sub_total');
      $table->integer('tax');
      $table->integer('total');
      // ソフトデリート用
      $table->softDeletes();

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
    Schema::dropIfExists('bills');
  }
}
