@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>


{{ Form::open(['url' => 'admin/reservations', 'method'=>'POST']) }}
@csrf

<div class="form-group">
  <div>{{$reserve_date}}</div>
  利用日：
  {{ Form::text('reserve_date', $reserve_date,['class'=>''] ) }}
</div>

<div class="form-group">
  <div>{{$venue_id}}</div>
  会場：
  {{ Form::text('venue_id', $venue_id,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$enter_time}}</div>
  入室時間：
  {{ Form::text('enter_time', $enter_time,['class'=>''] ) }}
</div>

<div class="form-group">
  <div>{{$leave_time}}</div>
  退室時間：
  {{ Form::text('leave_time', $leave_time,['class'=>''] ) }}
</div>

<div class="form-group">
  <div>{{$board_flag}}</div>
  案内板：
  {{ Form::text('board_flag', $board_flag,['class'=>''] ) }}
</div>

<div class="form-group">
  <div>{{$event_start}}</div>
  イベント開始時間：
  {{ Form::text('event_start', $event_start,['class'=>''] ) }}
</div>

<div class="form-group">
  <div>{{$event_finish}}</div>
  イベント終了時間：
  {{ Form::text('event_finish', $event_finish,['class'=>''] ) }}
</div>

<div class="form-group">
  <div>{{$event_name1}}</div>
  イベント名称1：
  {{ Form::text('event_name1', $event_name1,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$event_name2}}</div>
  イベント名称2：
  {{ Form::text('event_name2', $event_name2,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$event_owner}}</div>
  主催者名：
  {{ Form::text('event_owner', $event_owner,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$user_id}}</div>
  会社名・団体名：
  {{ Form::text('user_id', $user_id,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$in_charge}}</div>
  担当者氏名：
  {{ Form::text('in_charge', $in_charge,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$tel}}</div>
  当日の連絡できる担当者：
  {{ Form::text('tel', $tel,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$email_flag}}</div>
  利用後の送信メール：
  {{ Form::text('email_flag', $email_flag,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$cost}}</div>
  原価率：
  {{ Form::text('cost', $cost,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$discount_condition}}</div>
  割引条件：
  {{ Form::text('discount_condition', $discount_condition,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$attention}}</div>
  注意事項：
  {{ Form::text('attention', $attention,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$user_details}}</div>
  顧客情報の備考：
  {{ Form::text('user_details', $user_details,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$admin_details}}</div>
  管理者備考：
  {{ Form::text('admin_details', $admin_details,['class'=>''] ) }}

</div>


<div class="form-group">
  <div>{{$payment_limit}}</div>
  payment_limit：
  {{ Form::text('payment_limit', $payment_limit,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$paid}}</div>
  {{ Form::text('paid', $paid,['class'=>''] ) }}

  paid：
</div>

<div class="form-group">
  <div>{{$reservation_status}}</div>
  reservation_status：
  {{ Form::text('reservation_status', $reservation_status,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$double_check_status}}</div>
  double_check_status：
  {{ Form::text('double_check_status', $double_check_status,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$bill_company}}</div>
  bill_company：
  {{ Form::text('bill_company', $bill_company,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$bill_person}}</div>
  bill_person：
  {{ Form::text('bill_person', $bill_person,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$bill_created_at}}</div>
  bill_created_at：
  {{ Form::text('bill_created_at', $bill_created_at,['class'=>''] ) }}

</div>

<div class="form-group">
  <div>{{$bill_pay_limit}}</div>
  bill_pay_limit
  {{ Form::text('bill_pay_limit', $bill_pay_limit,['class'=>''] ) }}

</div>

<a href="#" class="btn btn-danger">戻る</a>
{!! Form::submit('登録', ['class' => 'btn btn-primary']) !!}
{{ Form::close() }}




{{-- 丸岡さんカスタム --}}

@endsection