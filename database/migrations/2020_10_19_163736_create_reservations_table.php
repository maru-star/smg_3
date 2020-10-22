<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reservations', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->dateTime('reserve_date');
      $table->integer('status');
      $table->string('venues');
      $table->time('start');
      $table->time('finish');
      $table->time('clients');
      $table->string('agents');
      $table->string('person');
      $table->string('person_tel');
      $table->integer('email_flag');
      $table->text('remark');
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
    Schema::dropIfExists('reservations');
  }
}
