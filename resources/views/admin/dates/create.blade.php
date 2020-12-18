@extends('layouts.admin.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
  $(function(){
      $('#start').on('change',function(){
        var start=$('#start').val();
        var finish=$('#finish').val();
        if(start>finish){
          swal('営業開始時間は営業終了時間より前に設定してください');
            $('#start').val('');
        }
    })
    $('#finish').on('change',function(){
        var start=$('#start').val();
        var finish=$('#finish').val();
        if(start>finish){
          swal('営業終了時間は営業開始時間より後に設定してください');
            $('#finish').val('');
        }
      })
    })
</script>

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">営業時間管理　編集</h1>
  <hr>
  <div class="d-flex justify-content-between mt-3 mb-5">
  </div>
</div>
<div class="p-3 mb-2 bg-white text-dark">
  <div class="d-flex align-items-center border border-light" style="height:60px;">
    <span class="ml-1">営業時間管理</span>
  </div>
  <div class="mt-4 mb-4">
    <span>この情報はカレンダーからのドラッグ登録や会場予約フォームの時間指定の開始・終了時間に紐づく情報です</span>
  </div>
  <div class="w-100">
    <span class="d-block mb-2">会場</span>
    <strong class="border border-light d-block"
      style="width:100%;">{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</strong>
  </div>
  <div class="mt-5">
    <table class="table">
      <tbody>
        <tr>
          <td>曜日</td>
          <td>営業時間</td>
          <td>編集</td>
        </tr>
        @foreach ($date_venues as $date_venue)
        @if ($date_venue->week_day==$weekday_id)
        {{ Form::open(['url' => 'admin/dates', 'method'=>'POST']) }}
        @csrf
        <tr>
          <td>
            @if ($date_venue->week_day==1)
            月
            @elseif ($date_venue->week_day==2)
            火
            @elseif ($date_venue->week_day==3)
            水
            @elseif ($date_venue->week_day==4)
            木
            @elseif ($date_venue->week_day==5)
            金
            @elseif ($date_venue->week_day==6)
            土
            @elseif ($date_venue->week_day==7)
            日
            @endif
          </td>
          <td>
            <div class="form-inline">
              {{Form::select('start', 
                ['01:00:00' => '01:00','01:30:00' => '01:30','02:00:00' => '02:00','02:30:00' => '02:30','03:00:00' => '03:00','03:30:00' => '03:30','04:00:00' => '04:00','04:30:00' => '04:30','05:00:00' => '05:00','05:30:00' => '05:30','06:00:00' => '06:00','06:30:00' => '06:30','07:00:00' => '07:00','07:30:00' => '07:30','08:00:00' => '08:00','08:30:00' => '08:30','09:00:00' => '09:00','09:30:00' => '09:30','10:00:00' => '10:00','10:30:00' => '10:30','11:00:00' => '11:00','11:30:00' => '11:30','12:00:00' => '12:00','12:30:00' => '12:30','13:00:00' => '13:00','13:30:00' => '13:30','14:00:00' => '14:00','14:30:00' => '14:30','15:00:00' => '15:00','15:30:00' => '15:30','16:00:00' => '16:00','16:30:00' => '16:30','17:00:00' => '17:00','17:30:00' => '17:30','18:00:00' => '18:00','18:30:00' => '18:30','19:00:00' => '19:00','19:30:00' => '19:30','20:00:00' => '20:00','20:30:00' => '20:30','21:00:00' => '21:00','21:30:00' => '21:30','22:00:00' => '22:00','22:30:00' => '22:30','23:00:00' => '23:00','23:30:00' => '23:30','24:00:00' => '24:00','24:30:00' => '24:30',        
                ],old('start',Carbon\Carbon::parse($date_venues->where('week_day',$weekday_id)->first()->start)->format('H:i:s')),['class'=>'form-control col-sm-2', 'id'=>'start'])}}
              ~
              {{Form::select('finish', 
                ['01:00:00' => '01:00','01:30:00' => '01:30','02:00:00' => '02:00','02:30:00' => '02:30','03:00:00' => '03:00','03:30:00' => '03:30','04:00:00' => '04:00','04:30:00' => '04:30','05:00:00' => '05:00','05:30:00' => '05:30','06:00:00' => '06:00','06:30:00' => '06:30','07:00:00' => '07:00','07:30:00' => '07:30','08:00:00' => '08:00','08:30:00' => '08:30','09:00:00' => '09:00','09:30:00' => '09:30','10:00:00' => '10:00','10:30:00' => '10:30','11:00:00' => '11:00','11:30:00' => '11:30','12:00:00' => '12:00','12:30:00' => '12:30','13:00:00' => '13:00','13:30:00' => '13:30','14:00:00' => '14:00','14:30:00' => '14:30','15:00:00' => '15:00','15:30:00' => '15:30','16:00:00' => '16:00','16:30:00' => '16:30','17:00:00' => '17:00','17:30:00' => '17:30','18:00:00' => '18:00','18:30:00' => '18:30','19:00:00' => '19:00','19:30:00' => '19:30','20:00:00' => '20:00','20:30:00' => '20:30','21:00:00' => '21:00','21:30:00' => '21:30','22:00:00' => '22:00','22:30:00' => '22:30','23:00:00' => '23:00','23:30:00' => '23:30','24:00:00' => '24:00','24:30:00' => '24:30',        
                ],old('finish',Carbon\Carbon::parse($date_venues->where('week_day',$weekday_id)->first()->finish)->format('H:i:s')),['class'=>'form-control col-sm-2', 'id'=>'finish'])}}
            </div>
          </td>
          <td>
            {{Form::hidden('weekday_id', $weekday_id)}}
            {{Form::hidden('venue_id', $venue_id)}}
            {{Form::submit('修正する', ['class'=>'submit btn btn-primary'])}}
          </td>
        </tr>
        {{ Form::close() }}
        @else
        <tr>
          <td>
            @if ($date_venue->week_day==1)
            月
            @elseif ($date_venue->week_day==2)
            火
            @elseif ($date_venue->week_day==3)
            水
            @elseif ($date_venue->week_day==4)
            木
            @elseif ($date_venue->week_day==5)
            金
            @elseif ($date_venue->week_day==6)
            土
            @elseif ($date_venue->week_day==7)
            日
            @endif
          </td>
          <td>{{$date_venue->start}}~{{$date_venue->finish}}</td>
          <td></td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection