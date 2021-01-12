@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script> --}}






<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> >
              予約一覧
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約一覧</h1>
      <hr>
    </div>

    <div class="col12">
      <dl class="d-flex col-12 justify-content-end align-items-center statuscheck">
        <dt><label for="">支払状況</label></dt>
        <dd class="mr-1">
          <select class="form-control select2" name="">
            <option>未入金</option>
            <option>入金済</option>
          </select>
        </dd>
        <dd>
          <p class="text-right"><a class="more_btn" href="">検索</a></p>
        </dd>
      </dl>

    </div>
    <div class="col-12">
      <p class="text-right font-weight-bold"><span class="count-color">10</span>件</p>
    </div>

    <!-- 一覧　　------------------------------------------------ -->

    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a href="#reserve-list" class="nav-link active" data-toggle="tab">予約一覧</a>
      </li>
      <li class="nav-item">
        <a href="#used-list" class="nav-link" data-toggle="tab">過去履歴</a>
      </li>
    </ul>


    <div class="tab-content">
      <div id="reserve-list" class="tab-pane active">
        <div class="container-field">
          <table class="table table-striped table-bordered table-box">
            <thead>
              <tr>
                <th>予約<br>ID</th>
                <th>利用日</th>
                <th>入室</th>
                <th>退室</th>
                <th>利用会場</th>
                <th width="120">予約状況</th>
                <th width="120">カテゴリー</th>
                <th>利用料金</th>
                <th>支払期日</th>
                <th>支払状況</th>
                <th class="btn-cell">予約詳細</th>
                <th class="btn-cell">請求書</th>
                <th class="btn-cell">領収書</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($user->reservations()->get() as $reserve)
              <tr>
                <td>{{$reserve->id}}</td>
                <td>{{ReservationHelper::formatDate($reserve->reserve_date)}}</td>
                <td>{{$reserve->enter_time}}</td>
                <td>{{$reserve->leave_time}}</td>
                <td>{{$reserve->venue_id}}</td>
                <td>{{ReservationHelper::judgeStatus($reserve->reservation_status)}}</td>
                <td>カテゴリー</td>
                <td>
                  @foreach ($reservation as $item)
                  {{$item->bills()->first()->total}}
                  @endforeach
                </td>
                <td>
                  {{ReservationHelper::formatDate($reserve->bill_pay_limit)}}
                </td>
                <td>
                  {{ReservationHelper::judgePaid($reserve->paid)}}
                </td>
                <td>
                  {{-- <a href="#">詳細</a> --}}
                  <a href="{{ url('user/home',$reserve->id) }}" class="">詳細</a>


                </td>
                <td>請求書</td>
                <td>領収書</td>
              </tr>

              @endforeach



              {{-- {{$reservation->first()->bills}} --}}

              {{-- 以下、最大４行 --}}
              {{-- <tr>
                <td rowspan="4"></td>
                <td rowspan="4"></td>
                <td rowspan="4"></td>
                <td rowspan="4"></td>
                <td rowspan="4"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td rowspan="4"></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr> --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>







    <!-- 一覧　　終わり------------------------------------------------ -->

    <ul class="pagination justify-content-center">
      <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; 前">
        <span class="page-link" aria-hidden="true">&lsaquo;</span>
      </li>
      <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
      <li class="page-item"><a class="page-link" href="">2</a>
      </li>
      <li class="page-item"><a class="page-link" href="">3</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="http://staging-smg2.herokuapp.com/admin/clients?page=2" rel="next"
          aria-label="次 &raquo">&rsaquo;</a>
      </li>
    </ul>

  </div>
</div>























@endsection