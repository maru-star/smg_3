@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>


<style>
  #fullOverlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(100, 100, 100, .5);
    z-index: 2147483647;
    display: none;
  }

  .frame_spinner {
    max-width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hide {
    display: none;
  }
</style>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">予約　新規登録</h1>
  <hr>
</div>

<div class="container-field bg-white text-dark">
  {{-- <div class="border border border-success">
    <table class="table mb-0">
      <tr>
        <td class="">予約概要 ID : 00010</td>
        <td class="">編集</td>
      </tr>
    </table>
  </div> --}}

  {{-- <div class="mt-2">
    <div class="d-flex ml-2">
      <table class="table mr-2 border border-light col-10">
        <tr>
          <td class="bg-success text-white">予約状況</td>
          <td>予約確認中</td>
          <td class="bg-success text-white">チェック</td>
          <td>未</td>
          <td>
            <div class="btn btn-primary">チェックする</div>
          </td>
        </tr>
      </table>
    </div>
  </div> --}}
  <div class="">
    <table>
      <tr>
        <td>仲介会社</td>
        <td><input type="checkbox" class="cust_check"></td>
      </tr>
    </table>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active">利用日</td>
          <td><input id="datepicker1" type="text"></td>
        </tr>
        <tr>
          <td class="table-active">会場</td>
          <td>
            <select id="venues_selector" class="hide">
              <option value=""></option>
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}">{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
              @endforeach
            </select>
            <div class="price_selector">
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">入室時間</td>
          <td>
            <div>
              <select name="sales_start" id="sales_start">
                <option selected disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">退室時間</td>
          <td>
            <div>
              <select name="sales_finish" id="sales_finish">
                <option selected disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>要作成</td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              <select name="event_start" id="event_start">
                <option value="">選択してください</option>
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            <div>
              <select name="event_finish" id="event_finish">
                <option value="">選択してください</option>
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td><input type="text" name="event_name1"></td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td><input type="text" name="event_name2"></td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td><input type="text" name="event_owner"></td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料サービス
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class='layouts'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>レイアウト</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>





      <div class="price_details">
      </div>
      <button id='calculate' class="btn btn-primary">計算する！！！！</button>



    </div>









    {{-- 右側 --}}
    <div class="col">
      {{-- デフォルトでは、こちらが表示。顧客選択 --}}
      <div class="client_mater">　
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card fa-2x fa-fw"></i>顧客情報
                </p>
                <p><a class="more_btn bg-green" href="">顧客詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="company">会社名・団体名</label></td>
            <td>
              <select class="form-control" name="company" id="user_select">
                <option disabled selected>選択してください</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}">
                  {{$user->company}} | {{$user->first_name}}{{$user->last_name}} | {{$user->email}}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名</label></td>
            <td>
              <select class="form-control select2" name="name">
                <option>山田太郎</option>
                <option>山田太郎</option>
                <option>山田太郎</option>
              </select>
            </td>
          </tr>
        </table>

        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw"></i>当日の連絡できる担当者
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="ondayName">氏名</label></td>
            <td><input class="form-control" name="ondayName" type="text" id="ondayName"></td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
            <td><input class="form-control" name="mobilePhone" type="text" id="mobilePhone"></td>
          </tr>
        </table>

      </div>

      {{-- 仲介会社選択時、こちらが表示 --}}
      <div class="agent_master" style="border: solid 2px red;">
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card fa-2x fa-fw" aria-hidden="true"></i>仲介会社情報
                </p>
                <p><a class="more_btn" href="">仲介会社詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="agency">サービス名称</label></td>
            <td>
              <select class="form-control select2" name="agency">
                <option>スペースマーケット</option>
                <option>スペースマーケット</option>
                <option>スペースマーケット</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="agencyName">担当者氏名</label></td>
            <td>
              <select class="form-control select2" name="agencyName">
                <option>山田太郎</option>
                <option>山田太郎</option>
                <option>山田太郎</option>
              </select>
            </td>
          </tr>
        </table>

        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw" aria-hidden="true"></i>仲介会社の顧客
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="agencyCustermergroup">会社名・団体名</label></td>
            <td><input class="form-control" name="agencyCustermergroup" type="text" id="agencyCustermergroup"></td>
          </tr>
          <tr>
            <td class="table-active"><label for="agencyCustermerName">担当者氏名</label></td>
            <td><input class="form-control" name="agencyCustermerName" type="text" id="agencyCustermerName"></td>
          </tr>
          <tr>
            <td class="table-active"><label for="agencyCustermerAddress">住所</label></td>
            <td><input class="form-control" name="agencyCustermerAddress" type="text" id="agencyCustermerAddress"></td>
          </tr>
          <tr>
          <tr>
            <td class="table-active"><label for="agencyCustermerPhone">電話番号</label></td>
            <td><input class="form-control" name="agencyCustermerPhone" type="text" id="agencyCustermerPhone"></td>
          </tr>
          <tr>
            <td class="table-active"><label for="agencyCustermerMail">メールアドレス</label></td>
            <td><input class="form-control" name="agencyCustermerMail" type="text" id="agencyCustermerMail"></td>
          </tr>
          <tr>
            <td class="table-active"><label for="agencyCustermerType">利用者属性</label></td>
            <td>
              <select class="form-control select2" style="width: 100%;">
                <option>インターネット</option>
                <option>インターネット</option>
                <option>インターネット</option>
              </select>
            </td>
          </tr>
        </table>

        <table class="table table-bordered sale-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign fa-2x fa-fw" aria-hidden="true"></i>仲介会社顧客の支払い料
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="sale">支払い料</label><br>
              <small>※※あとで入力※※</small>
            </td>
            <td class="d-flex align-items-center"><input class="form-control" name="sale" type="text" id="sale">円</td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered mail-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>利用後の送信メール
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="sendMail">送信メール</label></td>
          <td>
            <div class="radio-box">
              <div class="icheck-primary">
                <input type="radio" id="sendMail" name="sendMail" checked>
                <label for="sendMail">あり</label>
              </div>
              <div class="icheck-primary">
                <input type="radio" id="sendMail" name="sendMail" checked>
                <label for="sendMail">なし</label>
              </div>
            </div>
          </td>
        </tr>
      </table>
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>売上原価
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="sale">原価率</label></td>
          <td class="d-flex align-items-center"><input class="form-control" name="sale" type="text" id="sale">%</td>
        </tr>
      </table>

      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>備考
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p>
              <input type="checkbox" id="discount" checked>
              <label for="discount">割引条件</label>
            </p>
            <textarea name="discount" rows="5"></textarea>
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            <textarea name="caution" rows="10"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            <textarea name="userNote" rows="10"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            <textarea name="adminNote" rows="10"></textarea>
          </td>
        </tr>
      </table>
    </div>
  </div>

</div>


{{-- 丸岡さんカスタム --}}
<section class="bill-wrap section-wrap">
  <div class="bill-bg">

    <!-- 請求内容----------- -->
    <div class="bill-box">
      <h3 class="row">会場料</h3>
      <dl class="row bill-box_wrap">
        <div class="col-3 bill-box_cell">
          <dt>会場料金</dt>
          <dd class="venue_price"></dd>
        </div>
        <div class="col-3 bill-box_cell">
          <dt>延長料金</dt>
          <dd class="extend"></dd>
        </div>
        <div class="col-6 bill-box_cell">
          <dt>会場料金合計</dt>
          <dd class="text-right venue_extend" style="font-size: 20px"></dd>
        </div>
        <div class="col-6">
          <div class="row">
            <div class="col-4 bill-box_cell cell-gray">
              <p>割引率</p>
            </div>
            <div class="col-5 bill-box_cell">
              <dd class="text-right d-flex">
                <input type="text" name="price" class="form-control venue_discount_percent" id="price" value="0"
                  min=0><span>%</span>
              </dd>
            </div>
            <div class="col-3 bill-box_cell">
              <p class="text-right">割引金額: <span class="percent_result"></span></p>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="row">
            <div class="col-4 bill-box_cell cell-gray">
              <p>割引料金</p>
            </div>
            <div class="col-5 bill-box_cell">
              <p class="text-right">
                <input type="text" name="price" class="form-control venue_dicsount_number" id="price" min=0>
              </p>
            </div>
            <div class="col-3 bill-box_cell">
              <p class="text-right">割引率: <span class="number_result"></span>%</p>
            </div>
          </div>
        </div>
        <div class="col-12 bill-box_cell d-flex justify-content-end">
          <span class="font-weight-bold mr-3">割引後 会場料金合計</span>
          <p class="text-right after_discount_price"></p>円
        </div>
      </dl>

      <!-- 料金内訳-------------------------------------------------------------- -->
      <h3 class="row" style="background: #F3F3F3;color:black">料金内訳</h3>
      <div class="row venue_price_details">
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
        <p class="text-right"><span class="font-weight-bold">小計</span> <span class="venue_subtotal"></span>円</p>
        <p class="text-right"><span>消費税</span> <span class="venue_tax"></span> 円</p>
        <p class="text-right"><span class="font-weight-bold">請求総額</span> <span class="venue_total"></span> 円</p>
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
        <dt>有料備品料金</dt>
        <dd><span class="selected_equipments_price"></span>円</dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>有料サービス料金</dt>
        <dd><span class="selected_services_price"></span>円</dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>荷物預かり/返送</dt>
        <dd class="d-flex align-items-center">
        <dd><span class="selected_luggage_price"></span>円</dd>
        </dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>有料備品＆有料サービス合計</dt>
        <dd class="text-right"><span class="selected_items_total"></span>円</dd>
      </div>
      <div class="col-6">
        <div class="row">
          <div class="col-4 bill-box_cell cell-gray">
            <p>割引料金</p>
          </div>
          <div class="col-5 bill-box_cell">
            <p class="text-right"><input type="text" name="price" class="form-control discount_item" id="price"></p>
          </div>
          <div class="col-3 bill-box_cell text-right">
            <p>割引率:<span class="item_discount_percent"></span>%</p>
          </div>
        </div>
      </div>
      <div class="col-6 bill-box_cell text-right">
        <p><span class="font-weight-bold mr-3">割引後 会場料金合計</span> <span class="items_discount_price"></span> 円</p>
      </div>
    </dl>

    <!-- 料金内訳-------------------------------------------------------------- -->
    <div class="bill-list">
      <h3 class="row">料金内訳</h3>
      <div class="row items_equipments">
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
          </tbody>
        </table>
      </div>
      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right"><span class="font-weight-bold">小計</span><span class="items_subtotal"></span>円</p>
        <p class="text-right"><span>消費税</span> <span class="items_tax"></span> 円</p>
        <p class="text-right"><span class="font-weight-bold">請求総額</span> <span class="all_items_total"></span> 円</p>
      </div>



    </div>
    <!-- 料金内訳 終わり---------------------------- -->


  </div>
  <!-- 請求内容 終わり---------------------------- -->



  {{-- レイアウト --}}
  <div class="layout_price_list" style="margin-bottom: 100px">
    <div>
      レイアウト準備料金： <p class="layout_prepare_result"></p>
      レイアウト片付料金： <p class="layout_clean_result"></p>
      レイアウト変更合計： <p class="layout_total"></p>
      割引料金 <input type="text" class="layout_discount d-block">
      割引率：<p class="layout_discount_percent"><span>%</span></p>
      割引後レイアウト変更合計：<p class="after_duscount_layouts"></p>
    </div>
    <div class="selected_layouts">
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
    <div style="margin-top: 50px;">
      小計：<p class="layout_subtotal"></p>
      消費税：<p class="layout_tax"></p>
      合計金額：<p class="layout_total_amount"></p>
    </div>
  </div>
  {{-- レイアウト --}}

  <dl class="row bill-box_wrap total-sum">
    <div class="col-3 bill-box_cell">
      <dt>合計請求総額</dt>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>合計額</dt>
      <dd> <span class="all-total-without-tax"></span> 円</dd>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>消費税</dt>
      <dd> <span class="all-total-tax"></span> 円</dd>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>税込総請求額</dt>
      <dd class="text-right"> <span class="all-total-amout"></span> 円</dd>
    </div>
  </dl>
  </div>
</section>


<div class="btn_wrapper text-center">
  {{-- <p class="text-center"><a class="more_btn_lg" href="">予約登録する</a></p> --}}
  <button class="btn btn-primary more_btn_lg">予約登録する</button>
</div>



@endsection