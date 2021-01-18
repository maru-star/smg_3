@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<div class="content">
  <div class="container-fluid">

    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
              追加請求書作成
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">追加請求書作成</h1>
    </div>



    　　　　　　<div class="section-wrap">


      <!-- 追加請求書----------------------------------------------------------------- -->
      <table class="table table-bordered extra-bill-table">
        <thead>
          <tr class="">
            <td colspan="4">
              <p>請求情報</p>

              <div class="categorybox d-flex justify-content-around">
                <p class="radio">
                  <label>
                    <input type="radio" name="billcategory" id="optionsRadios1" value="1">その他の有料備品、サービス
                  </label>
                </p>
                <p class="radio">
                  <label>
                    <input type="radio" name="billcategory" id="billcategory2" value="2">レイアウト変更
                  </label>
                </p>
                <p class="radio d-flex">
                  <label style="width: 90px;">
                    <input type="radio" name="billcategory" id="billcategory5" value="3">その他
                  </label>
                  <label for="other"></label>
                  <input type="text" class="form-control" id="inputother" placeholder="入力してください" disabled="disabled">
                </p>
              </div>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="billcontent">内容</label></td>
            <td class="table-active"><label for="billfee">単価</label></td>
            <td class="table-active"><label for="billquantity">個数</label></td>
            <td class="table-active"><label for="billamount">金額</label></td>
          </tr>
          <tr>
            <td><input class="form-control" name="billcontent" type="text" id="billcontent"></td>
            <td><input class="form-control" name="billfee" type="text" id="billfee"></td>
            <td><input class="form-control" name="billquantity" type="text" id="billquantity"></td>
            <td style="width: 25%;" name="billamount">00000</td>
          </tr>
          <tr>
            <td class="extrabill-cell" colspan="4">
              <p class="text-center"><a class="more_btn3" href="">欄を追加する</a></p>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="row">
                <div class="col-4">
                  <p>割引料金</p>
                </div>
                <div class="col-5">
                  <p class="text-right"><input type="text" class=""></p>
                  <p></p>
                </div>
                <div class="col-3 text-right">
                  <p>割引率</p>
                  <p class=""><span>%</span></p>
                </div>
              </div>

            </td>
            <td colspan="2" class="text-right">
              <p class="font-weight-bold">割引後料金合計</p>
              <p class=""></p>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="text-right">
              <p><span class="font-weight-bold">小計</span>7,200円</p>
              <p><span>消費税</span>720円</p>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
          </tr>
        </tbody>
      </table>

      <div class="btn_wrapper">
        <p class="text-center"><a class="more_btn_lg" href="">作成する</a></p>
      </div>

      　　　　　　
      <!-- 予約詳細--------------------------------------------------------　 -->
      {{-- <div class="section-wrap">

        <div class="ttl-box d-flex align-items-center">
          <div class="col-9 d-flex justify-content-between">
            <h2>予約概要</h2>
            <p>予約ID: {{$reservation->id}}</p>
      <p>予約一括ID:00001</p>
    </div>

  </div>
  <section class="register-wrap">

    <div class="section-header">
      <div class="row">
        <div class="d-flex col-10 flex-wrap">
          <dl>
            <dt>予約状況</dt>
            <dd>{{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}</dd>
          </dl>
          <dl>
            <dt>一人目チェック</dt>
            <dd>
              <p>{{$reservation->bills()->first()->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check2_name}}</p>
            </dd>
          </dl>
        </div>

        <div class="col-2">
          <p>
            申込日：{{ReservationHelper::formatDate($reservation->created_at)}}
          </p>
          <p>
            予約確定日：{{ReservationHelper::formatDate($reservation->bills()->first()->approve_send_at)}}
          </p>
        </div>
      </div>
    </div>


    <div class="row">
      <!-- 左側の項目------------------------------------------------------------------------ -->
      <div class="col-6">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
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
          </tbody>
        </table>

        <table class="table table-bordered equipment-table">
          <thead class="accodion-ttl">
            <tr>
              <td colspan="2">
                <p class="title-icon active">有料備品</p>
              </td>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($equipments as $equipment)
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
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
          <thead class="accodion-ttl">
            <tr>
              <td colspan="2">
                <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
              </td>
            </tr>
          </thead>
          <tbody class="accordion-wrap" style="">
            <tr>
              <td colspan="2">
                <ul class="icheck-primary">
                  @foreach ($services as $service)
                  @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
                {{$breakdown->unit_item=='レイアウト準備'?'あり':''}}
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
              <td>
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
                {{$breakdown->unit_item=='レイアウト片付'?'あり':''}}
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
              <td>
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
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
                      {{isset($reservation->luggage_count)?$reservation->luggage_count:0}}個
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
                      {{isset($reservation->luggage_return)?$reservation->luggage_return:0}}個</p>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered eating-table">
          <tbody>
            <tr>
              <td>
                <p class="title-icon">室内飲食</p>
              </td>
            </tr>
            <tr>
              <td>
                なし
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- 左側の項目 終わり-------------------------------------------------- -->


      <!-- 右側の項目-------------------------------------------------- -->
      <div class="col-6">
        <div class="customer-table">
          <table class="table table-bordered name-table">
            <tbody>
              <tr>
                <td colspan="2">
                  <div class="d-flex align-items-center justify-content-between">
                    <p class="title-icon">
                      <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                      顧客情報
                    </p>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="company">会社名・団体名</label></td>
                <td>
                  {{$reservation->user->company}}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="name">担当者氏名</label></td>
                <td>
                  {{ReservationHelper::getPersonName($reservation->user_id)}}
                </td>
              </tr>
              <tr>
                <td class="table-active">担当者氏名(フリガナ)</td>
                <td>
                  {{ReservationHelper::getPersonNameKANA($reservation->user_id)}}
                </td>
              </tr>
              <tr>
                <td class="table-active">電話番号</td>
                <td>
                  <ul class="table-cell-box">
                    <li>
                      <p>携帯番号</p>
                      <p>
                        {{$reservation->user->mobile}}
                      </p>
                    </li>
                    <li>
                      <p>固定番号</p>
                      <p>
                        {{$reservation->user->tel}}
                      </p>
                    </li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td class="table-active">メールアドレス</td>
                <td>
                  {{$reservation->user->email}}
                </td>
              </tr>
              <tr>
                <td class="table-active">顧客属性</td>
                <td>
                  {{ReservationHelper::getAttr($reservation->user->id)}}
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered oneday-table">
            <tbody>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-user icon-size" aria-hidden="true"></i>
                    当日の連絡できる担当者
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="ondayName">氏名</label></td>
                <td>
                  {{$reservation->in_charge}}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                <td>
                  {{$reservation->tel}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <table class="table table-bordered mail-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-envelope icon-size" aria-hidden="true"></i>
                  利用後の送信メール
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="sendMail">送信メール</label></td>
              <td>
                {{$reservation->email_flag==0?"無し":"有り"}}
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered sale-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                  売上原価
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="sale">原価率</label></td>
              <td>
                (提携会場のときに表示)
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered note-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                  備考
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p>
                  割引条件
                </p>
                <p>
                  {{$reservation->discount_condition}}
                  {{$reservation->discount_condition?$reservation->discount_condition:"なし"}}

                </p>
              </td>
            </tr>
            <tr class="caution">
              <td>
                <p>注意事項</p>
                <p>
                  {{$reservation->attention}}
                  {{$reservation->attention?$reservation->attention:"なし"}}
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p>顧客情報の備考</p>
                <p>
                  {{$reservation->user_details?$reservation->user_details:"なし"}}
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p>管理者備考</p>
                <p>
                  {{$reservation->admin_details?$reservation->admin_details:"なし"}}
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- 右側の項目 終わり-------------------------------------------------- -->



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



        <div class="bill-box">


          <h3 class="row">会場料</h3>
          <dl class="row bill-box_wrap">
            <div class="col-3 bill-box_cell">
              <dt>会場料金</dt>
              <dd>{{$reservation->bills()->first()->sub_total}}</dd>
            </div>
            <div class="col-3 bill-box_cell">
              <dt>延長料金</dt>
              <dd>5,300円</dd>
            </div>
            <div class="col-6 bill-box_cell">
              <dt>会場料金合計</dt>
              <dd class="text-right">57,700円</dd>
            </div>

            <div class="col-6">
              <div class="row">
                <div class="col-4 bill-box_cell cell-gray">
                  <p>割引率</p>
                </div>
                <div class="col-5 bill-box_cell">
                  <dd class="text-right">0</dd>
                </div>
                <div class="col-3 bill-box_cell">
                  <p class="text-right">割引金額:0</p>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col-4 bill-box_cell cell-gray">
                  <p>割引料金</p>
                </div>
                <div class="col-5 bill-box_cell">
                  <p class="text-right">0</p>
                </div>
                <div class="col-3 bill-box_cell">
                  <p class="text-right">割引率:0%</p>
                </div>
              </div>
            </div>
            <div class="col-12 bill-box_cell">
              <p class="text-right"><span class="font-weight-bold mr-3">割引後 会場料金合計</span>51,930円</p>
            </div>
          </dl>


          <!-- 料金内訳-------------------------------------------------------------- -->
          <div class="bill-list">
            <h3 class="row">料金内訳</h3>
            <div class="row bill-box_wrap bill-list-subttl">
              <div class="col-6 bill-box_cell">
                <p>内容</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>単価</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>数量</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>金額</p>
              </div>
            </div>

            <div class="row bill-box_wrap">
              <div class="col-6 bill-box_cell">
                <p>会場料金</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>52,400円</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>1</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>52,400円</p>
              </div>
            </div>

            <div class="row bill-box_wrap">
              <div class="col-6 bill-box_cell">
                <p>会場料金</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>52,400円</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>1</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>52,400円</p>
              </div>
            </div>

            <div class="row bill-box_wrap">
              <div class="col-6 bill-box_cell">
                <p>会場料金</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>52,400円</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>1</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>52,400円</p>
              </div>
            </div>


            <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
              <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
              <p class="text-right"><span>消費税</span>720円</p>
              <p class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</p>
            </div>
          </div>
          <!-- 料金内訳 終わり---------------------------- -->


        </div>
        <!-- 請求内容 終わり---------------------------- -->

        <!-- 請求内容----------- -->
        <div class="bill-box">
          <h3 class="row">備品その他</h3>
          <dl class="row bill-box_wrap">
            <div class="col-3 bill-box_cell">
              <dt>会場料金</dt>
              <dd>52,400円</dd>
            </div>
            <div class="col-3 bill-box_cell">
              <dt>延長料金</dt>
              <dd>5,300円</dd>
            </div>
            <div class="col-3 bill-box_cell">
              <dt>荷物預かり/返送</dt>
              <dd class="d-flex align-items-center">500円
              </dd>
            </div>
            <div class="col-3 bill-box_cell">
              <dt>会場料金合計</dt>
              <dd class="text-right">57,700円</dd>
            </div>

            <div class="col-6">
              <div class="row">
                <div class="col-4 bill-box_cell cell-gray">
                  <p>割引料金</p>
                </div>
                <div class="col-5 bill-box_cell">
                  <p class="text-right">0</p>
                </div>
                <div class="col-3 bill-box_cell text-right">
                  <p>割引率:0%</p>
                </div>
              </div>
            </div>

            <div class="col-6 bill-box_cell text-right">
              <p><span class="font-weight-bold mr-3">割引後 会場料金合計</span>51,930円</p>
            </div>
          </dl>


          <!-- 料金内訳-------------------------------------------------------------- -->
          <div class="bill-list">
            <h3 class="row">料金内訳</h3>
            <div class="row bill-box_wrap bill-list-subttl">
              <div class="col-6 bill-box_cell">
                <p>内容</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>単価</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>数量</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>金額</p>
              </div>
            </div>

            <div class="row bill-box_wrap">
              <div class="col-6 bill-box_cell">
                <p>会場料金</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>52,400円</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>1</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>52,400円</p>
              </div>
            </div>

            <div class="row bill-box_wrap">
              <div class="col-6 bill-box_cell">
                <p>会場料金</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>52,400円</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>1</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>52,400円</p>
              </div>
            </div>

            <div class="row bill-box_wrap">
              <div class="col-6 bill-box_cell">
                <p>会場料金</p>
              </div>
              <div class="col-2 bill-box_cell">
                <p>52,400円</p>
              </div>
              <div class="col-1 bill-box_cell">
                <p>1</p>
              </div>
              <div class="col-3 bill-box_cell">
                <p>52,400円</p>
              </div>
            </div>


            <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
              <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
              <p class="text-right"><span>消費税</span>720円</p>
              <p class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</p>
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
    </section>


  </section>
</div> --}}

<!-- 予約詳細   終わり--------------------------------------------------　 -->




<!-- 合計請求額------------------------------------------------------------------- -->
{{-- <div class="total-sum section-wrap">
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
          5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="serviceFee">備品その他</label></td>
        <td class="text-right">
          5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
        <td class="text-right">
          5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="layoutFee">キャンセル料</label></td>
        <td class="text-right">
          5,300円
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-right">
          <p><span class="font-weight-bold">小計</span>7,200円</p>
          <p><span>消費税</span>720円</p>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
      </tr>
    </tbody>
  </table>
</div> --}}

<div class="btn_wrapper">
  <p class="text-center"><a class="more_btn_lg" href="">予約一覧へもどる</a></p>
</div>



</div>
</div>
</div>


@endsection