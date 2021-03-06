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
              <select name="start" id="start" class="form-control col-sm-2">
                @for ($i = 1; $i < 24; $i++)
                @for ($ii = 1; $ii < 3; $ii++)
                    @if ($ii%2==0)
                    <option value="{{sprintf('%02d',$i).":30:00"}}"
                    @if ($date_venues->where('week_day',$weekday_id)->first()->start==sprintf('%02d',$i).":30:00")
                    selected
                @endif
                    >{{sprintf('%02d',$i).":30"}}</option>
                    @else
                    <option value="{{sprintf('%02d',$i).":00:00"}}"
                    @if ($date_venues->where('week_day',$weekday_id)->first()->start==sprintf('%02d',$i).":00:00")
                    selected
                @endif
                    >{{sprintf('%02d',$i).":00"}}</option>
                    @endif
                @endfor
            @endfor
              </select>
              ~
              <select name="finish" id="finish" class="form-control col-sm-2">
                @for ($i = 1; $i < 24; $i++)
                @for ($ii = 1; $ii < 3; $ii++)
                    @if ($ii%2==0)
                    <option value="{{sprintf('%02d',$i).":30:00"}}"
                    @if ($date_venues->where('week_day',$weekday_id)->first()->finish==sprintf('%02d',$i).":30:00")
                    selected
                @endif
                    >{{sprintf('%02d',$i).":30"}}</option>
                    @else
                    <option value="{{sprintf('%02d',$i).":00:00"}}"
                    @if ($date_venues->where('week_day',$weekday_id)->first()->finish==sprintf('%02d',$i).":00:00")
                    selected
                @endif
                    >{{sprintf('%02d',$i).":00"}}</option>
                    @endif
                @endfor
            @endfor
              </select>
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
          <td>
            {{date('H:i',strtotime($date_venue->start))}}
            ~
            {{date('H:i',strtotime($date_venue->finish))}}
          </td>
          <td></td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection