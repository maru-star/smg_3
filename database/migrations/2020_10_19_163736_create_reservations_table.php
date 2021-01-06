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
      $table->integer('board_flag');
      $table->time('event_start');
      $table->time('event_finish');
      $table->string('event_name1')->nullable();
      $table->string('event_name2')->nullable();
      $table->string('event_owner')->nullable();
      $table->integer('email_flag'); //あるかないかだけ保持
      $table->string('in_charge');
      $table->string('tel');
      $table->integer('cost');
      $table->text('discount_condition')->nullable();
      $table->text('attention')->nullable();
      $table->text('user_details')->nullable();
      $table->text('admin_details')->nullable();

      $table->date('payment_limit'); //該当予約の支払い期日
      $table->string('paid'); //支払い状況、未入金か？入金済みか？　デフォルトは0で未入金
      $table->integer('reservation_status'); //予約状況　0:仮抑え　1:予約確認中　2:予約完了　3:キャンセル申請中　4:キャンセル承認待ち　5:キャンセル
      $table->integer('double_check_status'); //ダブルチェックのフラグ 0:未　1:一人済　2:二人済
      $table->string('double_check1_name')->nullable(); //ダブルチェック一人目
      $table->string('double_check2_name')->nullable(); //ダブルチェック一人目

      $table->string('bill_company'); //請求書の会社名　デフォルトは顧客名
      $table->string('bill_person'); //請求書の担当者名　デフォルトは顧客の担当者
      $table->date('bill_created_at'); //請求書作成日　デフォルトはtimestamp
      $table->date('bill_pay_limit'); //請求書支払い期日　デフォルトは自動計算
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
