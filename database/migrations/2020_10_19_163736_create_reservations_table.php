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
      $table->date('reserve_date');
      $table->time('enter_time');
      $table->time('leave_time');
      $table->time('event_start');
      $table->time('event_finish');
      $table->string('event_name1')->nullable();
      $table->string('event_name2')->nullable();
      $table->string('event_owner')->nullable();
      $table->integer('email_flag'); //あるかないかだけ保持
      $table->string('in_charge');
      $table->string('tel');
      $table->integer('email_send');
      $table->integer('cost');
      $table->text('discount_condition')->nullable();
      $table->text('attention')->nullable();
      $table->text('user_details')->nullable();
      $table->text('admin_details')->nullable();
      $table->date('payment_limit'); //該当予約の支払い期日
      $table->string('paid'); //支払い状況、未入金か？入金済みか？　デフォルトは1で未入金

      $table->integer('reservation_status'); //予約状況（例：予約確認中　等）
      $table->integer('double_check_status'); //ダブルチェックのフラグ
      $table->string('double_check1_name'); //ダブルチェック一人目
      $table->string('double_check2_name'); //ダブルチェック一人目

      $table->string('bill_company'); //請求書の会社名　デフォルトは顧客名
      $table->string('bill_person'); //請求書の担当者名　デフォルトは顧客の担当者
      $table->string('bill_created_at'); //請求書作成日　デフォルトはtimestamp
      $table->string('bill_pay_limit'); //請求書支払い期日　デフォルトは自動計算
      $table->string('bill_remark')->nullable(); //請求書備考　デフォルト空白

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
