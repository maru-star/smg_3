<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.min.js"></script>

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


@foreach ($find_venues as $find_venue)
日付：{{$find_venue->reserve_date}}<br>
入室：{{date('Y-m-d',strtotime($find_venue->reserve_date)).' '.$find_venue->enter_time}}<br>
退室：{{date('Y-m-d',strtotime($find_venue->reserve_date)).' '.$find_venue->leave_time}}<br>
<br><br>
@endforeach


<div class="calender-wrap">

  <div class="calender-ttl">
    {{ Form::open(['url' => 'calender/venue_calendar', 'method' => 'get']) }}
    @csrf
    <select name="venue_id" id="venue_id">
      @foreach ($venues as $venue)
      <option value="{{$venue->id}}" @if ($venue->id==$selected_venue)
        selected
        @endif
        >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
      @endforeach
    </select>
    {{Form::submit('確認する')}}
    {{ Form::close() }}

    <h3>予約状況</h3>
  </div>
  <ul class="calender-color">
    <li class="li-bg-reserve">予約済み</li>
    <li class="li-bg-prereserve">仮予約</li>
    <li class="li-bg-empty">空室</li>
    <li class="li-bg-closed">休業日</li>
  </ul>
  {{-- <div>
    start : <input type="text" id="start">
    finish : <input type="text" id="finish">
    <button>カレンダー表示！</button>
  </div> --}}

  <table class="table table-bordered calender-flame">
    <thead>
      <tr class="calender-head">
        <td class="field-title">タイトル</td>
        <td colspan="2">10:00</td>
        <td colspan="2">11:00</td>
        <td colspan="2">12:00</td>
        <td colspan="2">13:00</td>
        <td colspan="2">14:00</td>
        <td colspan="2">15:00</td>
        <td colspan="2">16:00</td>
        <td colspan="2">17:00</td>
        <td colspan="2">18:00</td>
        <td colspan="2">19:00</td>
        <td colspan="2">20:00</td>
        <td colspan="2">21:00</td>
        <td colspan="2">22:00</td>
        <td colspan="2">23:00</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($days as $key=>$day)
      @foreach ($find_venues as $find_venue)
      @if ($find_venue->reserve_date==$day)
      <tr class="calender-data">
        <td class="field-title">{{ReservationHelper::formatDate($day)}}</td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal100 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1030"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal110 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1130"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal120 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1230"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal130 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1330"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal140 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1430"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal150 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1530"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal160 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1630"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal170 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1730"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal180 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1830"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal190 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1930"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal200 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2030"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal210 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2130"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal220 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2230"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal230 calhalf"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2330"></td>
        <td>
          {{Form::text('start', date("Hi",strtotime($find_venue->enter_time)),['id'=>date('Y-m-d',strtotime($day)).'start'])}}
        </td>
        <td>
          {{Form::text('finish', date("Hi",strtotime($find_venue->leave_time)),['id'=>date('Y-m-d',strtotime($day)).'finish'])}}
        </td>
      </tr>
      @endif
      @endforeach
      @endforeach
    </tbody>
  </table>
</div>

<script>
  $(function(){
    var ds= new Date('2021-01-20 11:30:00');
    ds.setMinutes(ds.getMinutes() - (30));
    var df= new Date('2021-01-20 16:00:00');
    var diffTime = df.getTime() - ds.getTime();
    var diffTime = Math.floor(diffTime / (1000 * 60  ));
    var target=diffTime/30;

    var times=[];
    for (let index = 0; index < target-1; index++) {
      ds.setMinutes(ds.getMinutes() + (30));
      var result=String(ds.getHours())+String(ds.getMinutes());
      $('.2021-01-20cal'+ result).addClass('bg-reserve');
      console.log(result);
    }


  //   var name = $('input[name="start"]');
  //   for (let index = 0; index < name.length; index++) {
  //     console.log($(name[index]));
  //     // var start = $('#2021-01-14start').val();
  //     // var finish = $('#2021-01-14finish').val();

  //   }


  // var between=[];
  // for(var i=start; i<=finish; i++) {
  //   between.push(i);
  // }
  
  // $.each(between, function(index, value){
  //   $('.2021-01-14cal'+ value).addClass('bg-reserve');
  // })
})

</script>