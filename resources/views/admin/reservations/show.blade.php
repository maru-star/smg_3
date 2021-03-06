@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

billsのカウント：{{count($reservation->bills()->get())}}

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a>
              予約 詳細
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約 詳細</h1>
    </div>
    <div class="btn-wrapper2 col-12 align-items-center d-flex justify-content-between">
      <!-- 削除ボタン-ステータス：予約が完了する前で表示----- -->
      @if ($reservation->bills()->first()->reservation_status<3) <div class="text-left">
        {{ Form::model($reservation, ['route' => ['admin.reservations.destroy', $reservation->id], 'method' => 'delete']) }}
        @csrf
        {{ Form::submit('削除', ['class' => 'btn more_btn4']) }}
        {{ Form::close() }}
    </div>
    @endif

    @if ($reservation->bills()->first()->reservation_status==3)
    <!-- 請求書の追加ボタン-ステータス：予約完了で表示----- -->
    <p class="text-right">
      {{ Form::open(['url' => 'admin/bills/create/'.$reservation->id, 'method'=>'POST', 'class'=>'']) }}
      @csrf
      {{ Form::hidden('reservation_id', $reservation->id ) }}
      {{ Form::submit('追加の請求書を作成する',['class' => 'btn more_btn3']) }}
      {{ Form::close() }}
    </p>
    @endif
  </div>
  <div class="col-12 btn-wrapper2">
    <!-- 請求書の追加ボタン-ステータス：予約完了で表示----- -->
    {{-- <p class="text-right"><a class="more_btn4_lg" href="">一括キャンセルをする</a></p> --}}
  </div>
  <!-- 予約詳細--------------------------------------------------------　 -->

  <div class="section-wrap">
    <div class="ttl-box d-flex align-items-center">
      <div class="col-9 d-flex justify-content-between">
        <h2>予約概要</h2>
        <p>予約ID: {{$reservation->id}}</p>
        <p>予約一括ID:</p>
      </div>

      {{-- 予約完了前（予約ステータス3以前）なら表示 --}}
      @if ($reservation->bills()->first()->reservation_status<3) <div class="col-3">
        <p class="text-right">
          {{ link_to_route('admin.reservations.edit', '編集', $parameters = $reservation->id, ['class' => 'more_btn']) }}
        </p>
    </div>
    @endif
  </div>

  <section class="register-wrap">
    <div class="section-header">
      <div class="row">
        <div class="d-flex col-10 flex-wrap">
          <dl>
            <dt>予約状況</dt>
            <dd>{{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}</dd>
          </dl>
          @if ($reservation->bills()->first()->double_check_status==0)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"> <button class="btn more_btn first_double_check">チェックをする</button> </p>
            </dd>
          </dl>
          @elseif ($reservation->bills()->first()->double_check_status==1)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"> <button class="btn more_btn second_double_check">チェックをする</button> </p>
            </dd>
          </dl>
          @elseif ($reservation->bills()->first()->double_check_status==2)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check2_name}}</p>
            </dd>
          </dl>
          @endif
        </div>


        <div class="col-2">
          <p>
            <dd>申込日：{{ReservationHelper::formatDate($reservation->created_at)}}</dd>
          </p>
          <p>
            ※後ほど修正※　予約確定日：2020/10/15(木)
          </p>
        </div>
      </div>

      @if ($reservation->bills()->first()->double_check_status==2)
      <!-- 承認確認ボタン-ダブルチェック後に表示------ -->
      {{-- 予約完了後、非表示 --}}
      @if ($reservation->bills()->first()->reservation_status<=2) <div class="row justify-content-end mt-5">
        <div class="d-flex col-2 justify-content-around">
          <p class="text-right">
            {{-- 予約ステータスを2にして、ユーザーにメール送付 --}}
            {{-- <a class="more_btn" href="">承認</a> --}}
            {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/send_email_and_approve', 'method'=>'POST', 'class'=>'']) }}
            @csrf
            {{ Form::hidden('reservation_id', $reservation->id ) }}
            {{ Form::hidden('user_id', $reservation->user_id ) }}
            {{ Form::submit('承認',['class' => 'btn more_btn']) }}
            {{ Form::close() }}
          </p>
          <p class="text-right">
            {{-- <a class="more_btn4" href="">確定</a> --}}
            {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
            @csrf
            {{ Form::hidden('reservation_id', $reservation->id ) }}
            {{ Form::hidden('user_id', $reservation->user_id ) }}
            {{ Form::submit('確定',['class' => 'btn more_btn4']) }}
            {{ Form::close() }}
          </p>
        </div>
    </div>

    @endif
    @endif

    <!-- キャンセルボタン-ステータス：予約完了で表示------ -->
    {{-- <div class="row justify-content-end mt-5">
            <div class="d-flex col-12 justify-content-end">
              <p class="text-right"><a class="more_btn4" href="">キャンセルする</a></p>
            </div>
          </div> --}}
</div>


<div class="row">
  <!-- 左側の項目------------------------------------------------------------------------ -->
  <div class="col-6">
    <table class="table table-bordered">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-info-circle icon-size"></i>
            予約情報
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="date">利用日</label></td>
        <td>{{ReservationHelper::formatDate($reservation->reserve_date)}}</td>
      </tr>
      <tr>
        <td class="table-active"><label for="venue">会場</label></td>
        <td>
          <p>
            {{ReservationHelper::getVenue($reservation->venue_id)[0]}}
            {{ReservationHelper::getVenue($reservation->venue_id)[1]}}
            {{ReservationHelper::getVenue($reservation->venue_id)[2]}}
          </p>
          <p>アクセア仕様</p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="start">入室時間</label></td>
        <td>
          {{$reservation->enter_time}}
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="finish">退室時間</label></td>
        <td>
          {{$reservation->leave_time}}
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="direction">案内板</label></td>
        <td class="d-flex justify-content-between">
          <p>{{$reservation->board_flag==0?'無し':"要作成"}}</p>
          <p>
            {{-- <a class="more_btn" href="">※後ほど修正※案内板出力(PDF)</a> --}}
            {{-- <a href="{{ url('/admin/reservations/'. $reservation->id.'/generate_pdf') }}"
            class="more_btn">案内版出力(PDF)</a> --}}

            <a href="{{ url('/admin/reservations/generate_pdf', $reservation->id) }}" class="more_btn">案内版出力</a>

          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
        <td>
          {{isset($reservation->event_start)&&isset($reservation->event_finish)?"有り":"無し"}}
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
        <td>
          {{$reservation->event_start}}
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
        <td>
          {{$reservation->event_finish}}
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="eventName1">イベント名称1</label></td>
        <td>{{$reservation->event_name1}}</td>
      </tr>
      <tr>
        <td class="table-active"><label for="eventName2">イベント名称2</label></td>
        <td>{{$reservation->event_name2}}</td>
      </tr>
      <tr>
        <td class="table-active"><label for="organizer">主催者名</label></td>
        <td>{{$reservation->event_owner}}</td>
      </tr>
    </table>

    <table class="table table-bordered equipment-table">
      <thead class="accordion-ttl">
        <tr>
          <td colspan="2">
            <p class="title-icon active">有料備品</p>
          </td>
        </tr>
      </thead>
      <tbody class="accordion-wrap">
        @foreach ($equipments as $equipment)
        @foreach ($breakdowns as $breakdown)
        @if ($equipment->item==$breakdown->unit_item)
        <tr>
          <td class="justify-content-between d-flex">
            {{$equipment->item}}({{$equipment->price}}円)×{{$breakdown->unit_count}}
          </td>
        </tr>
        @endif
        @endforeach
        @endforeach
      </tbody>
    </table>

    <table class="table table-bordered service-table">
      <thead class="accordion-ttl">
        <tr>
          <td colspan="2">
            <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
          </td>
        </tr>
      </thead>
      <tbody class="accordion-wrap">
        <tr>
          <td colspan="2">
            <ul class="icheck-primary">
              @foreach ($services as $service)
              @foreach ($breakdowns as $breakdown)
              @if ($service->item==$breakdown->unit_item)
              <li>
                {{$service->item}}({{$service->price}}円)
              </li>
              @endif
              @endforeach
              @endforeach
            </ul>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="layout">レイアウト変更</label></td>
          <td>
            @foreach ($breakdowns as $breakdown)
            @if ($breakdown->unit_type==3)
            あり
            @break
            @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="prelayout">レイアウト準備</label></td>
          <td>
            @foreach ($breakdowns as $breakdown)
            {{$breakdown->unit_item=='レイアウト準備'?'あり':''}}
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
          <td>
            @foreach ($breakdowns as $breakdown)
            {{$breakdown->unit_item=='レイアウト片付'?'あり':''}}
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
          <td>
            @foreach ($breakdowns as $breakdown)
            {{$breakdown->unit_item=='荷物預かり/返送'?'あり':''}}
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
          <td>
            <ul class="table-cell-box">
              <li>
                <p>
                  {{isset($reservation->luggage_count)?'あり':'なし'}}
                </p>
              </li>
              <li class="d-flex justify-content-between">
                <p>荷物個数</p>
                <p>
                  {{isset($reservation->luggage_count)?$reservation->luggage_count:''}}個
                </p>
              </li>

              <li class="d-flex justify-content-between">
                <p>事前荷物の到着日</p>
                <p>
                  {{isset($reservation->luggage_arrive)?ReservationHelper::formatDate($reservation->luggage_arrive):''}}
                </p>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="postDelivery">事後返送する荷物</label></td>
          <td>
            <ul class="table-cell-box">
              <li>
                <p>
                  {{isset($reservation->luggage_return)?'あり':''}}
                </p>
              </li>
              <li class="d-flex justify-content-between">
                <p>荷物個数</p>
                <p>
                  {{isset($reservation->luggage_return)?$reservation->luggage_return:''}}個
                </p>
              </li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered eating-table">
      <tr>
        <td>
          <p class="title-icon">室内飲食</p>
        </td>
      </tr>
      <tr>
        <td>
          ※後ほど修正　なし
        </td>
      </tr>
    </table>
  </div>
  <!-- 左側の項目 終わり-------------------------------------------------- -->

  <!-- 右側の項目-------------------------------------------------- -->
  <div class="col-6">
    <div class="customer-table">
      <table class="table table-bordered name-table">
        <tr>
          <td colspan="2">
            <div class="d-flex align-items-center justify-content-between">
              <p class="title-icon">
                <i class="far fa-address-card icon-size"></i>
                顧客情報
              </p>
              <p><a class="more_btn" href="">顧客詳細</a></p>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="company">会社名・団体名</label></td>
          <td>
            {{$user->company}}
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="name">担当者氏名</label></td>
          <td>
            {{$user->first_name}}{{$user->last_name}}
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名(フリガナ)</td>
          <td>
            {{$user->first_name_kana}}{{$user->last_name_kana}}
          </td>
        </tr>
        <tr>
          <td class="table-active">電話番号</td>
          <td>
            <ul class="table-cell-box">
              <li>
                <p>携帯番号</p>
                <p> {{$user->mobile}}
                </p>
              </li>
              <li>
                <p>固定番号</p>
                <p> {{$user->tel}}
                </p>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <td class="table-active">メールアドレス</td>
          <td>
            {{$user->email}}
          </td>
        </tr>
        <tr>
          <td class="table-active">顧客属性</td>
          <td>
            {{$user->attr}}
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <p>備考</p>
            <p> {{$user->remark}}
            </p>
          </td>
        </tr>
        <tr class="caution">
          <td colspan="2">
            <p>注意事項</p>
            <p>{{$user->attention}}</p>
          </td>
        </tr>
      </table>

      <table class="table table-bordered oneday-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-user icon-size"></i>
              当日の連絡できる担当者
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="ondayName">氏名</label></td>
          <td>{{$reservation->in_charge}}</td>
        </tr>
        <tr>
          <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
          <td>{{$reservation->tel}}</td>
        </tr>
      </table>
    </div>

    <table class="table table-bordered mail-table">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-envelope icon-size"></i>
            利用後の送信メール
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="sendMail">送信メール</label></td>
        <td>{{$reservation->email_flag==1?'あり':'なし'}}</td>
      </tr>
    </table>

    <table class="table table-bordered sale-table">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-yen-sign icon-size"></i>
            売上原価
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="sale">原価率</label></td>
        <td>{{$reservation->cost==0?'':$reservation->cost}}</td>
      </tr>
    </table>

    <table class="table table-bordered note-table">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-file-alt icon-size"></i>
            備考
          </p>
        </td>
      </tr>
      <tr>
        <td>
          <p>
            割引条件
          </p>
          <p>{{isset($reservation->discount_condition)?$reservation->discount_condition:'なし'}}</p>
        </td>
      </tr>
      <tr class="caution">
        <td>
          <p>注意事項</p>
          <p>{{isset($reservation->attention)?$reservation->attention:'なし'}}</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>顧客(予約サイト経由)入力の備考</p>
          <p>{{isset($reservation->user_details)?$reservation->user_details:'なし'}}</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>管理者備考</p>
          <p>{{isset($reservation->admin_details)?$reservation->admin_details:'なし'}}</p>
        </td>
      </tr>
    </table>
  </div>
  <!-- 右側の項目 終わり-------------------------------------------------- -->


  <!-- 予約完了後も編集可能な備考欄-------------------------------------------------- -->
  <div class="col-12">
    <table class="table table-bordered note-table">
      <tr>
        <td>
          <p class="title-icon">
            <i class="fas fa-file-alt icon-size"></i>
            <label for="extraNote">予約内容変更履歴</label>
          </p>
        </td>
      </tr>
      <tr>
        <td>
          なし
        </td>
      </tr>
    </table>
  </div>


</div>



<!-- 請求セクション------------------------------------------------------------------- -->

<section class="bill-wrap section-wrap section-bg">
  <div class="bill-bg">

    <!-- 請求内容----------- -->

    <!-- 請求書情報-------- -->
    <div class="bill-ttl mb-5">
      <div class="section-ttl-box d-flex align-items-center">
        <div class="col-6">
          <h3 class="">請求情報</h3>
        </div>
        <div class="col-6 d-flex justify-content-end">
          <p class="text-right"><a class="more_btn" href="">※後ほど修正　請求書をみる</a></p>
          <!-- ステータスが入金確認後に表示------ -->
          <p class="text-right ml-3"><a class="more_btn" href="">※後ほど修正　領収書をみる</a></p>
        </div>
      </div>
      <!-- 請求書情報--予約完了後に表示------ -->
      {{-- <dl class="row bill-box_wrap">
                <div class="col-4 bill-box_cell">
                  <dt><label for="billCompany">※後ほど修正　請求No</label></dt>
                  <dd>※後ほど修正　2020092225</dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt><label for="billCustomer">請求日</label></dt>
                  <dd>{{ReservationHelper::formatDate($reservation->created_at)}}</dd>
    </div>
    <div class="col-4 bill-box_cell">
      <dt><label for="billDate">支払期日</label></dt>
      <dd>{{ReservationHelper::formatDate($reservation->payment_limit)}}</dd>
    </div>
    </dl> --}}

  </div>
  <!-- 請求書情報 終わり---------------------------- -->


  <!-- 会場料請求内容----------- -->
  <div class="bill-box">
    <h3 class="row">会場料</h3>
    <dl class="row bill-box_wrap">
      <div class="col-3 bill-box_cell">
        <dt>会場料金</dt>
        <dd>
          @foreach ($breakdowns as $breakdown)
          @if ($breakdown->unit_type==1)
          @if ($breakdown->unit_item=='会場料金')
          {{number_format($breakdown->unit_cost)}}
          @endif
          @endif
          @endforeach
        </dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>延長料金</dt>
        <dd>
          @foreach ($breakdowns as $breakdown)
          @if ($breakdown->unit_type==1)
          @if ($breakdown->unit_item=='延長料金')
          {{number_format($breakdown->unit_cost)}}
          @endif
          @endif
          @endforeach
        </dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt>会場料金合計</dt>
        <dd class="text-right">
          {{$reservation->bills()->first()->venue_total}}
        </dd>
      </div>

      {{-- <div class="col-6">
                <div class="row">
                  <div class="col-4 bill-box_cell cell-gray">
                    <p>割引率</p>
                  </div>
                  <div class="col-5 bill-box_cell">
                    <p class="text-right">※後ほど修正　1111</p>
                  </div>
                  <div class="col-3 bill-box_cell text-right">
                    <p>割引金額</p>
                    <p class="">※後ほど修正<span>円</span></p>
                  </div>
                </div>
              </div> --}}

      {{-- <div class="col-6">
                <div class="row">
                  <div class="col-4 bill-box_cell cell-gray">
                    <p>割引料金</p>
                  </div>
                  <div class="col-5 bill-box_cell">
                    <p class="text-right">※後ほど修正　111</p>
                  </div>
                  <div class="col-3 bill-box_cell text-right">
                    <p>割引率</p>
                    <p class="">※後ほど修正<span>%</span></p>
                  </div>
                </div>
              </div> --}}
      {{-- <div class="col-12 bill-box_cell text-right">
                <p class="font-weight-bold">割引後会場料金合計</p>
                <p class="">※後ほど修正</p>
              </div> --}}
    </dl>

    <!-- 料金内訳-------------------------------------------------------------- -->
    <div class="bill-list">
      <h3 class="row">料金内訳</h3>
      <div class="col-12 venue_price_details">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($breakdowns as $breakdown)
            @if ($breakdown->unit_type==1)
            <tr>
              <td>{{$breakdown->unit_item}}</td>
              <td>{{$breakdown->unit_cost}}</td>
              <td>{{$breakdown->unit_count}}</td>
              <td>{{$breakdown->unit_subtotal}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right">
          <span class="font-weight-bold">小計</span>
          {{$reservation->bills()->first()->discount_venue_total}}
        </p>
        <p class="text-right">
          <span>消費税</span>
          {{($reservation->bills()->first()->discount_venue_total)*0.1}}
        </p>
        <p class="text-right">
          <span class="font-weight-bold">合計金額</span>
          ※後ほど修正
        </p>
      </div>
    </div>
    <!-- 料金内訳 終わり---------------------------- -->


  </div>
  <!-- 請求内容 終わり---------------------------- -->

  <!-- 備品その他　請求内容----------- -->
  <div class="bill-box">
    <h3 class="row">備品その他</h3>
    <dl class="row bill-box_wrap">
      <div class="col-3 bill-box_cell">
        <dt>有料備品料金</dt>
        <dd>
          {{$reservation->bills()->first()->equipment_total}}
        </dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>有料サービス料金</dt>
        <dd>
          {{$reservation->bills()->first()->service_total}}
        </dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>荷物預かり/返送</dt>
        <dd class="d-flex align-items-center">
          {{$reservation->bills()->first()->luggage_total}}
          円
        </dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>備品その他合計</dt>
        <dd class="text-right">
          {{$reservation->bills()->first()->equipment_service_total}}
        </dd>
      </div>

      {{-- <div class="col-6">
                <div class="row">
                  <div class="col-4 bill-box_cell cell-gray">
                    <p>※後ほど修正　割引料金</p>
                  </div>
                  <div class="col-5 bill-box_cell">
                    <p class="text-right">※後ほど修正　</p>
                  </div>
                  <div class="col-3 bill-box_cell text-right">
                    <p>割引率</p>
                    <p class="">※後ほど修正　<span>%</span></p>
                  </div>
                </div>
              </div> --}}

      {{-- <div class="col-6 bill-box_cell text-right">
                <p class="font-weight-bold">割引後備品その他合計</p>
                <p class="">※後ほど修正　</p>
              </div> --}}
    </dl>


    <!-- 料金内訳-------------------------------------------------------------- -->
    <div class="bill-list">
      <h3 class="row">料金内訳</h3>
      <div class="col-12 items_equipments">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($breakdowns as $breakdown)
            @if ($breakdown->unit_type==2)
            <tr>
              <td>{{$breakdown->unit_item}}</td>
              <td>{{$breakdown->unit_cost}}</td>
              <td>{{$breakdown->unit_count}}</td>
              <td>{{$breakdown->unit_subtotal}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right"><span class="font-weight-bold">小計</span>※その他修正　7,200円</p>
        <p class="text-right"><span>消費税</span>※その他修正　720円</p>
        <p class="text-right"><span class="font-weight-bold">合計金額</span>※その他修正　7,200円</p>
      </div>



    </div>
    <!-- 料金内訳 終わり---------------------------- -->


  </div>
  <!-- 請求内容 終わり---------------------------- -->

  <!-- レイアウト変更 請求内容----------- -->
  <div class="bill-box layout_price_list">
    <h3 class="row">レイアウト変更</h3>
    <dl class="row bill-box_wrap">
      <div class="col-4 bill-box_cell">
        <dt>レイアウト準備料金</dt>
        <dd>
          <p class="layout_prepare_result">
            @foreach ($breakdowns as $breakdown)
            @if ($breakdown->unit_type==3)
            @if ($breakdown->unit_item=='レイアウト準備')
            {{number_format($breakdown->unit_cost)}}
            @endif
            @endif
            @endforeach
          </p>
        </dd>
      </div>
      <div class="col-4 bill-box_cell">
        <dt>レイアウト片付料金</dt>
        <dd>
          <p class="layout_clean_result">
            @foreach ($breakdowns as $breakdown)
            @if ($breakdown->unit_type==3)
            @if ($breakdown->unit_item=='レイアウト片付')
            {{number_format($breakdown->unit_cost)}}
            @endif
            @endif
            @endforeach
          </p>
        </dd>
      </div>
      <div class="col-4 bill-box_cell">
        <dt>レイアウト変更合計</dt>
        <dd class="text-right">
          <p class="layout_total">
            {{$reservation->bills()->first()->layout_total}}
          </p>
        </dd>
      </div>

      {{-- <div class="col-6">
                <div class="row">
                  <div class="col-4 bill-box_cell cell-gray">
                    <p>※後ほど修正　割引料金</p>
                  </div>
                  <div class="col-5 bill-box_cell">
                    <p class="text-right"></p>
                  </div>
                  <div class="col-3 bill-box_cell text-right">
                    <p>※後ほど修正　割引率</p>
                    <p class="layout_discount_percent"><span>%</span></p>
                  </div>
                </div>
              </div> --}}

      {{-- <div class="col-6 bill-box_cell text-right">
                <p class="font-weight-bold">割引後レイアウト変更合計</p>
                <p class="after_duscount_layouts"></p>
              </div> --}}
    </dl>


    <!-- 料金内訳-------------------------------------------------------------- -->
    <div class="bill-list">
      <h3 class="row">料金内訳</h3>
      <div class="col-12 items_equipments">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($breakdowns as $breakdown)
            @if ($breakdown->unit_type==3)
            <tr>
              <td>{{$breakdown->unit_item}}</td>
              <td>{{$breakdown->unit_cost}}</td>
              <td>{{$breakdown->unit_count}}</td>
              <td>{{$breakdown->unit_subtotal}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right"><span class="font-weight-bold">小計</span>※後ほど修正　7,200円</p>
        <p class="text-right"><span>消費税</span>※後ほど修正　720円</p>
        <p class="text-right"><span class="font-weight-bold">合計金額</span>※後ほど修正　7,200円</p>
      </div>



    </div>
    <!-- 料金内訳 終わり---------------------------- -->


  </div>
  <!-- 請求内容 終わり---------------------------- -->


  <!-- 請求書内容変更----------- -->
  <div class="bill-box">
    <h3 class="row">請求書内容</h3>
    <dl class="row bill-box_wrap">
      <div class="col-6 bill-box_cell">
        <dt><label for="billCompany">請求書の会社名</label></dt>
        <dd>{{$user->company}}</dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billCustomer">請求書の担当者名</label></dt>
        <dd>{{$user->first_name}}{{$user->last_name}}</dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billDate">請求日</label></dt>
        <dd>{{ReservationHelper::formatDate($reservation->created_at)}}</dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billDue">支払期日</label></dt>
        <dd>{{ReservationHelper::formatDate($reservation->payment_limit)}}</dd>
      </div>
      <div class="col-12 bill-box_cell">
        <dt><label for="billNote">備考</label></dt>
        <dd>{{$reservation->bill_remark}}</dd>
      </div>
    </dl>
  </div>
  <!-- 請求書内容変更 終わり---------------------------- -->


  <!-- 入金確認入力フィールド　予約完了後の表示----------- -->
  {{-- <div class="bill-box">
              <h3 class="row">入金確認</h3>
              <dl class="row bill-box_wrap">
                <div class="col-4 bill-box_cell">
                  <dt><label for="payDate">入金日</label></dt>
                  <dd>※後ほど修正　2020/12/21(月)</dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt><label for="payType">支払タイプ</label></dt>
                  <dd>※後ほど修正　振込</dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt><label for="payStatus">入金状況</label></dt>
                  <dd>{{$reservation->paid==0?'未入金':'入金済'}}</dd>
  </div>
  <div class="col-12 bill-box_cell">
    <dt><label for="billNote">※後ほど修正　振込名</label></dt>
    <dd>テキストテキストテキストテキストテキストテキスト</dd>
  </div>
  </dl>
  </div> --}}
  <!-- 入金確認入力フィールド 終わり---------------------------- -->

  </div>
</section>

　　　　　
<!-- 請求セクション　キャンセル料 キャンセルをしたときに、表示------------------------------------------------------------------ -->
{{-- <section class="bill-wrap section-wrap section-bg">
    <div class="bill-bg">

      <!-- 請求書情報-------- -->
      <div class="bill-ttl mb-5">
        <div class="section-ttl-box d-flex align-items-center">
          <div class="col-6">
            <h3 class="section-ttl">キャンセル料請求情報</h3>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
            <!-- ステータスが入金確認後に表示------ -->
            <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
          </div>


        </div>
        <!-- 請求書情報--予約完了後に表示------ -->
        <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt><label for="billCompany">請求No</label></dt>
            <dd>2020092225</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="billCustomer">請求日</label></dt>
            <dd>2020/09/02</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="billDate">支払期日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
        </dl>

      </div>
      <!-- 請求書情報 終わり---------------------------- -->


      <!-- 　キャンセル料金内容----------- -->
      <div class="bill-box">
        <h3 class="row">キャンセル料</h3>
        <dl class="row bill-box_wrap">
          <div class="col-12 bill-box_cell">
            <dt>キャンセル料金合計</dt>
            <dd class="text-right">57,700円</dd>
          </div>

          <div class="col-6">
            <div class="row">
              <div class="col-4 bill-box_cell cell-gray">
                <p>割引率</p>
              </div>
              <div class="col-5 bill-box_cell">
                <p class="text-right"></p>
              </div>
              <div class="col-3 bill-box_cell text-right">
                <p>割引金額</p>
                <p class=""><span>円</span></p>
              </div>
            </div>
          </div>


          <div class="col-6 bill-box_cell text-right">
            <p class="font-weight-bold">割引後キャンセル料合計</p>
            <p class=""></p>
          </div>
        </dl>


        <!-- 料金内訳-------------------------------------------------------------- -->
        <div class="bill-list">
          <h3 class="row">料金内訳</h3>
          <div class="col-12 venue_price_details">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
            <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
            <p class="text-right"><span>消費税</span>720円</p>
            <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
          </div>
        </div>
        <!-- 料金内訳 終わり---------------------------- -->


      </div>
      <!-- 請求内容 終わり---------------------------- -->


      <!-- 請求書内容変更----------- -->
      <div class="bill-box">
        <h3 class="row">請求書内容変更</h3>
        <dl class="row bill-box_wrap">
          <div class="col-6 bill-box_cell">
            <dt><label for="billCompany">請求書の会社名</label></dt>
            <dd>株式会社テスト</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billCustomer">請求書の担当者名</label></dt>
            <dd>山田太郎</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billDate">請求日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billDue">支払期日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
          <div class="col-12 bill-box_cell">
            <dt><label for="billNote">備考</label></dt>
            <dd>テキストテキストテキストテキストテキストテキスト</dd>
          </div>
        </dl>
      </div>
      <!-- 請求書内容変更 終わり---------------------------- -->


      <!-- 入金確認入力フィールド　予約完了後の表示----------- -->
      <div class="bill-box">
        <h3 class="row">入金確認</h3>
        <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt><label for="payDate">入金日</label></dt>
            <dd>2020/12/21(月)</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="payType">支払タイプ</label></dt>
            <dd>振込</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="payStatus">入金状況</label></dt>
            <dd>入金済</dd>
          </div>
          <div class="col-12 bill-box_cell">
            <dt><label for="billNote">振込名</label></dt>
            <dd>テキストテキストテキストテキストテキストテキスト</dd>
          </div>
        </dl>
      </div>
      <!-- 入金確認入力フィールド 終わり---------------------------- -->





    </div>
  </section> --}}




</section>
</div>

<!-- 予約詳細   終わり--------------------------------------------------　 -->






<!-- 追加請求のフィールド------------------------------------------------------------------->
{{-- <div class="section-wrap">
  <div class="ttl-box d-flex align-items-center">
    <div class="col-9 d-flex justify-content-between">
      <h2>その他の有料備品、サービス</h2>
    </div>
    <div class="col-3">
      <p class="text-right"><a class="more_btn" href="">編集</a></p>
    </div>

  </div>
  <section class="register-wrap">

    <div class="section-header">
      <div class="row">
        <div class="d-flex col-10 flex-wrap">
          <dl>
            <dt>予約状況</dt>
            <dd>予約確認中</dd>
          </dl>
          <dl>
            <dt>一人目チェック</dt>
            <dd>
              <p>山田太郎</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"><a class="more_btn" href="">チェックをする</a></p>
            </dd>
          </dl>
        </div>

        <div class="col-2">
          <p>
            申込日：2020/10/15(木)
          </p>
          <p>
            予約確定日：2020/10/15(木)
          </p>
        </div>
      </div> --}}


<!-- 承認確認ボタン-ダブルチェック後に表示------ -->
{{-- <div class="row justify-content-end mt-5">
        <div class="d-flex col-2 justify-content-around">
          <p class="text-right"><a class="more_btn" href="">承認</a></p>
          <p class="text-right"><a class="more_btn4" href="">確定</a></p>
        </div>
      </div> --}}

<!-- キャンセルボタン-ステータス：予約完了で表示------ -->
{{-- <div class="row justify-content-end mt-5">
        <div class="d-flex col-12 justify-content-end">
          <p class="text-right"><a class="more_btn4" href="">キャンセルする</a></p>
        </div>
      </div> --}}


{{-- </div> --}}

<!-- 請求セクション------------------------------------------------------------------- -->

{{-- <section class="section-wrap section-bg"> --}}

<!-- 請求内容----------- -->

<!-- 請求書情報-------- -->
{{-- <div class="bill-ttl mb-5">
        <div class="section-ttl-box d-flex align-items-center">
          <div class="col-6">
            <h3 class="">請求情報</h3>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
            <!-- ステータスが入金確認後に表示------ -->
            <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
          </div>
        </div> --}}
<!-- 請求書情報--予約完了後に表示------ -->
{{-- <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt><label for="billCompany">請求No</label></dt>
            <dd>2020092225</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="billCustomer">請求日</label></dt>
            <dd>2020/09/02</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="billDate">支払期日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
        </dl> --}}

{{-- </div> --}}

<!-- 　追加請求内容----------- -->
{{-- <div class="bill-box">
        <h3 class="row">その他の有料備品、サービス</h3>
        <dl class="row bill-box_wrap">
          <div class="col-12 bill-box_cell">
            <dt>その他の有料備品、サービス合計</dt>
            <dd class="text-right">57,700円</dd>
          </div>

          <div class="col-6">
            <div class="row">
              <div class="col-4 bill-box_cell cell-gray">
                <p>割引率</p>
              </div>
              <div class="col-5 bill-box_cell">
                <p class="text-right"></p>
              </div>
              <div class="col-3 bill-box_cell text-right">
                <p>割引金額</p>
                <p class=""><span>円</span></p>
              </div>
            </div>
          </div>


          <div class="col-6 bill-box_cell text-right">
            <p class="font-weight-bold">割引後その他の有料備品、サービス合計</p>
            <p class=""></p>
          </div>
        </dl> --}}


<!-- 料金内訳-------------------------------------------------------------- -->
{{-- <div class="bill-list">
          <h3 class="row">料金内訳</h3>
          <div class="col-12 venue_price_details">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
            <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
            <p class="text-right"><span>消費税</span>720円</p>
            <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
          </div>
        </div> --}}
<!-- 料金内訳 終わり---------------------------- -->


{{-- </div> --}}
<!-- 請求内容 終わり---------------------------- -->

<!-- 請求内容 終わり---------------------------- -->

<!-- 請求書内容変更----------- -->
<!-- 請求書内容変更 終わり---------------------------- -->


<!-- 入金確認入力フィールド　予約完了後の表示----------- -->
{{-- <div class="bill-box">
        <h3 class="row">入金確認</h3>
        <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt><label for="payDate">入金日</label></dt>
            <dd>2020/12/21(月)</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="payType">支払タイプ</label></dt>
            <dd>振込</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="payStatus">入金状況</label></dt>
            <dd>入金済</dd>
          </div>
          <div class="col-12 bill-box_cell">
            <dt><label for="billNote">振込名</label></dt>
            <dd>テキストテキストテキストテキストテキストテキスト</dd>
          </div>
        </dl>
      </div> --}}
<!-- 入金確認入力フィールド 終わり---------------------------- -->

</section>

　　　　　
<!-- 請求セクション　キャンセル料-　キャンセルをしたときに、表示------------------------------------------------------------------ -->
{{-- <section class="bill-wrap section-wrap section-bg">
      <div class="bill-bg">

        <!-- 請求書情報-------- -->
        <div class="bill-ttl mb-5">
          <div class="section-ttl-box d-flex align-items-center">
            <div class="col-6">
              <h3 class="section-ttl">キャンセル料請求情報</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
              <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
              <!-- ステータスが入金確認後に表示------ -->
              <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
            </div>
          </div>
          <!-- 請求書情報--予約完了後に表示------ -->
          <dl class="row bill-box_wrap">
            <div class="col-4 bill-box_cell">
              <dt><label for="billCompany">請求No</label></dt>
              <dd>2020092225</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="billCustomer">請求日</label></dt>
              <dd>2020/09/02</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="billDate">支払期日</label></dt>
              <dd>2020/12/10(木)</dd>
            </div>
          </dl>

        </div>
        <!-- 請求書情報 終わり---------------------------- -->


        <!-- 　キャンセル料金内容----------- -->
        <div class="bill-box">
          <h3 class="row">キャンセル料</h3>
          <dl class="row bill-box_wrap">
            <div class="col-12 bill-box_cell">
              <dt>キャンセル料金合計</dt>
              <dd class="text-right">57,700円</dd>
            </div>

            <div class="col-6">
              <div class="row">
                <div class="col-4 bill-box_cell cell-gray">
                  <p>割引率</p>
                </div>
                <div class="col-5 bill-box_cell">
                  <p class="text-right"></p>
                </div>
                <div class="col-3 bill-box_cell text-right">
                  <p>割引金額</p>
                  <p class=""><span>円</span></p>
                </div>
              </div>
            </div>


            <div class="col-6 bill-box_cell text-right">
              <p class="font-weight-bold">割引後キャンセル料合計</p>
              <p class=""></p>
            </div>
          </dl>


          <!-- 料金内訳-------------------------------------------------------------- -->
          <div class="bill-list">
            <h3 class="row">料金内訳</h3>
            <div class="col-12 venue_price_details">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td>内容</td>
                    <td>単価</td>
                    <td>数量</td>
                    <td>金額</td>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

            <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
              <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
              <p class="text-right"><span>消費税</span>720円</p>
              <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
            </div>
          </div>
          <!-- 料金内訳 終わり---------------------------- -->


        </div>
        <!-- 請求内容 終わり---------------------------- -->



        <!-- 請求書内容変更----------- -->
        <div class="bill-box">
          <h3 class="row">請求書内容変更</h3>
          <dl class="row bill-box_wrap">
            <div class="col-6 bill-box_cell">
              <dt><label for="billCompany">請求書の会社名</label></dt>
              <dd>株式会社テスト</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt><label for="billCustomer">請求書の担当者名</label></dt>
              <dd>山田太郎</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt><label for="billDate">請求日</label></dt>
              <dd>2020/12/10(木)</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt><label for="billDue">支払期日</label></dt>
              <dd>2020/12/10(木)</dd>
            </div>
            <div class="col-12 bill-box_cell">
              <dt><label for="billNote">備考</label></dt>
              <dd>テキストテキストテキストテキストテキストテキスト</dd>
            </div>
          </dl>
        </div>
        <!-- 請求書内容変更 終わり---------------------------- -->


        <!-- 入金確認入力フィールド　予約完了後の表示----------- -->
        <div class="bill-box">
          <h3 class="row">入金確認</h3>
          <dl class="row bill-box_wrap">
            <div class="col-4 bill-box_cell">
              <dt><label for="payDate">入金日</label></dt>
              <dd>2020/12/21(月)</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="payType">支払タイプ</label></dt>
              <dd>振込</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="payStatus">入金状況</label></dt>
              <dd>入金済</dd>
            </div>
            <div class="col-12 bill-box_cell">
              <dt><label for="billNote">振込名</label></dt>
              <dd>テキストテキストテキストテキストテキストテキスト</dd>
            </div>
          </dl>
        </div>
        <!-- 入金確認入力フィールド 終わり---------------------------- -->





      </div>
    </section> --}}




</section>
</div>


{{-- ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ --}}
{{-- ここから追加された請求書 --}}
<div class="section-wrap">
  <div class="ttl-box d-flex align-items-center">
    <div class="col-9 d-flex justify-content-between">
      <h2>その他の有料備品、サービス</h2>
      <!-- <p>予約ID:00001</p> -->
      <!-- <p>予約一括ID:00001</p> -->
    </div>
    <div class="col-3">
      <p class="text-right"><a class="more_btn" href="">編集</a></p>
    </div>

  </div>
  <section class="register-wrap">

    <div class="section-header">
      <div class="row">
        <div class="d-flex col-10 flex-wrap">
          <dl>
            <dt>予約状況</dt>
            <dd>予約確認中</dd>
          </dl>
          <dl>
            <dt>一人目チェック</dt>
            <dd>
              <p>山田太郎</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"><a class="more_btn" href="">チェックをする</a></p>
            </dd>
          </dl>
        </div>

        <div class="col-2">
          <p>
            申込日：2020/10/15(木)
          </p>
          <p>
            予約確定日：2020/10/15(木)
          </p>
        </div>
      </div>


      <!-- 承認確認ボタン-ダブルチェック後に表示------ -->
      <div class="row justify-content-end mt-5">
        <div class="d-flex col-2 justify-content-around">
          <p class="text-right"><a class="more_btn" href="">承認</a></p>
          <p class="text-right"><a class="more_btn4" href="">確定</a></p>
        </div>
      </div>

      <!-- キャンセルボタン-ステータス：予約完了で表示------ -->
      <div class="row justify-content-end mt-5">
        <div class="d-flex col-12 justify-content-end">
          <p class="text-right"><a class="more_btn4" href="">キャンセルする</a></p>
        </div>
      </div>


    </div>

    <!-- 請求セクション------------------------------------------------------------------- -->

    <section class="section-wrap section-bg">

      <!-- 請求内容----------- -->

      <!-- 請求書情報-------- -->
      <div class="bill-ttl mb-5">
        <div class="section-ttl-box d-flex align-items-center">
          <div class="col-6">
            <h3 class="">請求情報</h3>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
            <!-- ステータスが入金確認後に表示------ -->
            <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
          </div>
        </div>
        <!-- 請求書情報--予約完了後に表示------ -->
        <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt><label for="billCompany">請求No</label></dt>
            <dd>2020092225</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="billCustomer">請求日</label></dt>
            <dd>2020/09/02</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="billDate">支払期日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
        </dl>

      </div>

      <!-- 　追加請求内容----------- -->
      <div class="bill-box">
        <h3 class="row">その他の有料備品、サービス</h3>
        <dl class="row bill-box_wrap">
          <div class="col-12 bill-box_cell">
            <dt>その他の有料備品、サービス合計</dt>
            <dd class="text-right">57,700円</dd>
          </div>

          <div class="col-6">
            <div class="row">
              <div class="col-4 bill-box_cell cell-gray">
                <p>割引率</p>
              </div>
              <div class="col-5 bill-box_cell">
                <p class="text-right"></p>
              </div>
              <div class="col-3 bill-box_cell text-right">
                <p>割引金額</p>
                <p class=""><span>円</span></p>
              </div>
            </div>
          </div>


          <div class="col-6 bill-box_cell text-right">
            <p class="font-weight-bold">割引後その他の有料備品、サービス合計</p>
            <p class=""></p>
          </div>
        </dl>


        <!-- 料金内訳-------------------------------------------------------------- -->
        <div class="bill-list">
          <h3 class="row">料金内訳</h3>
          <div class="col-12 venue_price_details">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
            <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
            <p class="text-right"><span>消費税</span>720円</p>
            <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
          </div>
        </div>
        <!-- 料金内訳 終わり---------------------------- -->


      </div>
      <!-- 請求内容 終わり---------------------------- -->

      <!-- 請求内容 終わり---------------------------- -->

      <!-- 請求書内容----------- -->
      <div class="bill-box">
        <h3 class="row">請求書内容</h3>
        <dl class="row bill-box_wrap">
          <div class="col-6 bill-box_cell">
            <dt><label for="billCompany">請求書の会社名</label></dt>
            <dd>株式会社テスト</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billCustomer">請求書の担当者名</label></dt>
            <dd>山田太郎</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billDate">請求日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billDue">支払期日</label></dt>
            <dd>2020/12/10(木)</dd>
          </div>
          <div class="col-12 bill-box_cell">
            <dt><label for="billNote">備考</label></dt>
            <dd>テキストテキストテキストテキストテキストテキスト</dd>
          </div>
        </dl>
      </div>
      <!-- 請求書内容 終わり---------------------------- -->


      <!-- 入金確認入力フィールド　予約完了後の表示----------- -->
      <div class="bill-box">
        <h3 class="row">入金確認</h3>
        <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt><label for="payDate">入金日</label></dt>
            <dd>2020/12/21(月)</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="payType">支払タイプ</label></dt>
            <dd>振込</dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt><label for="payStatus">入金状況</label></dt>
            <dd>入金済</dd>
          </div>
          <div class="col-12 bill-box_cell">
            <dt><label for="billNote">振込名</label></dt>
            <dd>テキストテキストテキストテキストテキストテキスト</dd>
          </div>
        </dl>
      </div>
      <!-- 入金確認入力フィールド 終わり---------------------------- -->

    </section>

    　　　　　
    <!-- 請求セクション　キャンセル料-　キャンセルをしたときに、表示------------------------------------------------------------------ -->
    {{-- <section class="bill-wrap section-wrap section-bg">
      <div class="bill-bg">

        <!-- 請求書情報-------- -->
        <div class="bill-ttl mb-5">
          <div class="section-ttl-box d-flex align-items-center">
            <div class="col-6">
              <h3 class="section-ttl">キャンセル料請求情報</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
              <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
              <!-- ステータスが入金確認後に表示------ -->
              <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
            </div>
          </div>
          <!-- 請求書情報--予約完了後に表示------ -->
          <dl class="row bill-box_wrap">
            <div class="col-4 bill-box_cell">
              <dt><label for="billCompany">請求No</label></dt>
              <dd>2020092225</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="billCustomer">請求日</label></dt>
              <dd>2020/09/02</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="billDate">支払期日</label></dt>
              <dd>2020/12/10(木)</dd>
            </div>
          </dl>

        </div>
        <!-- 請求書情報 終わり---------------------------- -->

        <!-- 　キャンセル料金内容----------- -->
        <div class="bill-box">
          <h3 class="row">キャンセル料</h3>
          <dl class="row bill-box_wrap">
            <div class="col-12 bill-box_cell">
              <dt>キャンセル料金合計</dt>
              <dd class="text-right">57,700円</dd>
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col-4 bill-box_cell cell-gray">
                  <p>割引率</p>
                </div>
                <div class="col-5 bill-box_cell">
                  <p class="text-right"></p>
                </div>
                <div class="col-3 bill-box_cell text-right">
                  <p>割引金額</p>
                  <p class=""><span>円</span></p>
                </div>
              </div>
            </div>
            <div class="col-6 bill-box_cell text-right">
              <p class="font-weight-bold">割引後キャンセル料合計</p>
              <p class=""></p>
            </div>
          </dl>
          <!-- 料金内訳-------------------------------------------------------------- -->
          <div class="bill-list">
            <h3 class="row">料金内訳</h3>
            <div class="col-12 venue_price_details">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td>内容</td>
                    <td>単価</td>
                    <td>数量</td>
                    <td>金額</td>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
              <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
              <p class="text-right"><span>消費税</span>720円</p>
              <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
            </div>
          </div>
          <!-- 料金内訳 終わり---------------------------- -->
        </div>
        <!-- 請求内容 終わり---------------------------- -->
        <!-- 請求書内容----------- -->
        <div class="bill-box">
          <h3 class="row">請求書内容</h3>
          <dl class="row bill-box_wrap">
            <div class="col-6 bill-box_cell">
              <dt><label for="billCompany">請求書の会社名</label></dt>
              <dd>株式会社テスト</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt><label for="billCustomer">請求書の担当者名</label></dt>
              <dd>山田太郎</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt><label for="billDate">請求日</label></dt>
              <dd>2020/12/10(木)</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt><label for="billDue">支払期日</label></dt>
              <dd>2020/12/10(木)</dd>
            </div>
            <div class="col-12 bill-box_cell">
              <dt><label for="billNote">備考</label></dt>
              <dd>テキストテキストテキストテキストテキストテキスト</dd>
            </div>
          </dl>
        </div>
        <!-- 請求書内容 終わり---------------------------- -->
        <!-- 入金確認入力フィールド　予約完了後の表示----------- -->
        <div class="bill-box">
          <h3 class="row">入金確認</h3>
          <dl class="row bill-box_wrap">
            <div class="col-4 bill-box_cell">
              <dt><label for="payDate">入金日</label></dt>
              <dd>2020/12/21(月)</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="payType">支払タイプ</label></dt>
              <dd>振込</dd>
            </div>
            <div class="col-4 bill-box_cell">
              <dt><label for="payStatus">入金状況</label></dt>
              <dd>入金済</dd>
            </div>
            <div class="col-12 bill-box_cell">
              <dt><label for="billNote">振込名</label></dt>
              <dd>テキストテキストテキストテキストテキストテキスト</dd>
            </div>
          </dl>
        </div>
        <!-- 入金確認入力フィールド 終わり---------------------------- -->
      </div>
    </section> --}}
  </section>
</div>
{{-- ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ --}}










<!-- 合計請求額------------------------------------------------------------------- -->
<div class="total-sum section-wrap">
  <table class="table table-bordered">
    <thead>
      <tr class="bg-green">
        <td colspan="2">
          合計請求額
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active"><label for="venueFee">会場料</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="serviceFee">備品その他</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="layoutFee">キャンセル料</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-right">
          <p><span class="font-weight-bold">小計</span>7,200円</p>
          <p><span>消費税</span>720円</p>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>※後ほど修正　7,200円</td>
      </tr>
    </tbody>
  </table>
</div>


<!-- チェックボックス ----------------------------------------------------------------------------->
@if ($reservation->bills()->first()->double_check_status==0)
<div class="checkbox section-wrap">
  <dl class="d-flex col-12 justify-content-end align-items-center">
    <dt><label for="checkname">一人目チェック者</label></dt>
    <dd>
      {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
      @csrf
      {{Form::select('double_check1_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
      {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
    </dd>
    <dd>
      <p class="text-right">
        {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
      </p>
    </dd>
  </dl>
</div>
@elseif($reservation->bills()->first()->double_check_status==1)
<div class="checkbox section-wrap">
  <dl class="d-flex col-12 justify-content-end align-items-center">
    <dt><label for="checkname">二人目チェック者</label></dt>
    <dd>
      {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
      @csrf
      {{Form::select('double_check2_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
      {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
    </dd>
    <dd>
      <p class="text-right">
        {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check2_submit'])}}
      </p>
    </dd>
  </dl>
</div>

@endif






<div class="btn_wrapper">
  <p class="text-center"><a class="more_btn_lg" href="">予約一覧へもどる</a></p>
</div>



</div>
</div>








@endsection