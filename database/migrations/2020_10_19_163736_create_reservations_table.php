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
      $table->bigInteger('venue_id')->unsigned()->index();
      $table->bigInteger('user_id')->unsigned()->index();
      $table->string('name');


      // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
      // $table->bigIncrements('id');
      // $table->bigInteger('venue_id')->unsigned()->index();
      // $table->bigInteger('user_id')->unsigned()->index();
      // // $table->bigInteger('agent_id')->unsigned()->index(); //仲介

      // // 外部
      // $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
      // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      // $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade'); //仲介
      // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★

      // $table->dateTime('reserve_date');
      // $table->time('enter_time');
      // $table->time('leave_time');
      // $table->time('event_start');
      // $table->time('event_finish');
      // $table->string('event_name1');
      // $table->string('event_name2');
      // $table->string('event_owner');
      // $table->integer('email_flag'); //あるかないかだけ保持
      // $table->string('in_charge');
      // $table->string('tel');
      // $table->integer('email_send');
      // $table->integer('cost');
      // $table->text('discount_condition')->nullable();
      // $table->text('attention')->nullable();
      // $table->text('user_details')->nullable();
      // $table->text('admin_details')->nullable();

      // $table->integer('reservation_status'); //予約状況（例：予約確認中　等）
      // $table->integer('double_check_status'); //ダブルチェックのフラグ
      // $table->string('double_check1_name'); //ダブルチェック一人目
      // $table->string('double_check2_name'); //ダブルチェック一人目

      // 売掛かどうかの判別　入金日
      // 請求書の宛名
      // 請求書の請求日、
      // 支払い期日　
      // 変えれるように

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
