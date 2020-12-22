@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>



<div class="form-group">
  <div>{{$reserve_date}}</div>
  利用日：
</div>

<div class="form-group">
  <div>{{$venue_id}}</div>
  会場：
</div>

<div class="form-group">
  <div>{{$enter_time}}</div>
  入室時間：
</div>

<div class="form-group">
  <div>{{$leave_time}}</div>
  退室時間：
</div>

<div class="form-group">
  <div>{{$board_flag}}</div>
  案内板：
</div>

<div class="form-group">
  <div>{{$event_start}}</div>
  イベント開始時間：
</div>

<div class="form-group">
  <div>{{$event_finish}}</div>
  イベント終了時間：
</div>

<div class="form-group">
  <div>{{$event_name1}}</div>
  イベント名称1：
</div>

<div class="form-group">
  <div>{{$event_name2}}</div>
  イベント名称2：
</div>

<div class="form-group">
  <div>{{$event_owner}}</div>
  主催者名：
</div>

<div class="form-group">
  <div>{{$user_id}}</div>
  会社名・団体名：
</div>

<div class="form-group">
  <div>{{$in_charge}}</div>
  担当者氏名：
</div>

<div class="form-group">
  <div>{{$tel}}</div>
  当日の連絡できる担当者：
</div>

<div class="form-group">
  <div>{{$email_flag}}</div>
  利用後の送信メール：
</div>

<div class="form-group">
  <div>{{$cost}}</div>
  原価率：
</div>

<div class="form-group">
  <div>{{$discount_condition}}</div>
  割引条件：
</div>

<div class="form-group">
  <div>{{$attention}}</div>
  注意事項：
</div>

<div class="form-group">
  <div>{{$user_details}}</div>
  顧客情報の備考：
</div>

<div class="form-group">
  <div>{{$admin_details}}</div>
  管理者備考：
</div>

<div class="form-group">
  <div>{{$payment_limit}}</div>
  payment_limit：
</div>

<div class="form-group">
  <div>{{$paid}}</div>
  paid：
</div>

<div class="form-group">
  <div>{{$reservation_status}}</div>
  reservation_status：
</div>

<div class="form-group">
  <div>{{$double_check_status}}</div>
  double_check_status：
</div>

<div class="form-group">
  <div>{{$bill_company}}</div>
  bill_company：
</div>

<div class="form-group">
  <div>{{$bill_person}}</div>
  bill_person：
</div>

<div class="form-group">
  <div>{{$bill_created_at}}</div>
  bill_created_at：
</div>

<div class="form-group">
  <div>{{$bill_pay_limit}}</div>
  bill_pay_limit
</div>



@endsection