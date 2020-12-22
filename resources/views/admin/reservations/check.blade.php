@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>



<div class="form-group">
  利用日：<p>{{$enter_time}}</p>
</div>


<div class="form-group">
  会場：
</div>

<div class="form-group">
  入室時間：
</div>


<div class="form-group">
  退室時間：
</div>

<div class="form-group">
  案内板：
</div>

<div class="form-group">
  イベント開始時間：
</div>

<div class="form-group">
  イベント終了時間：
</div>

<div class="form-group">
  イベント名称1：
</div>

<div class="form-group">
  イベント名称2：
</div>

<div class="form-group">
  主催者名：
</div>

<div class="form-group">
  会社名・団体名：
</div>

<div class="form-group">
  担当者氏名：
</div>

<div class="form-group">
  当日の連絡できる担当者：
</div>

<div class="form-group">
  氏名：
</div>

<div class="form-group">
  携帯番号：
</div>

<div class="form-group">
  利用後の送信メール：
</div>

<div class="form-group">
  原価率：
</div>

<div class="form-group">
  割引条件：
</div>

<div class="form-group">
  注意事項：
</div>

<div class="form-group">
  顧客情報の備考：
</div>

<div class="form-group">
  管理者備考：
</div>

<div class="form-group">
  payment_limit：
</div>

<div class="form-group">
  paid：
</div>

<div class="form-group">
  reservation_status：
</div>

<div class="form-group">
  double_check_status：
</div>

<div class="form-group">
  bill_company：
</div>

<div class="form-group">
  bill_person：
</div>

<div class="form-group">
  bill_created_at：
</div>

<div class="form-group">
  bill_pay_limit
</div>



@endsection