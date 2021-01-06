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
      <p class="text-left"><a class="more_btn4" href="">削除</a></p>
      <!-- 請求書の追加ボタン-ステータス：予約完了で表示----- -->
      <p class="text-right"><a class="more_btn3" href="">追加の請求書を作成する</a></p>
    </div>
    <div class="col-12 btn-wrapper2">
      <!-- 請求書の追加ボタン-ステータス：予約完了で表示----- -->
      <p class="text-right"><a class="more_btn4_lg" href="">一括キャンセルをする</a></p>
    </div>
    <!-- 予約詳細--------------------------------------------------------　 -->
    <div class="section-wrap">

      <div class="ttl-box d-flex align-items-center">
        <div class="col-9 d-flex justify-content-between">
          <h2>予約概要</h2>
          <p>予約ID: {{$reservation->id}}</p>
          <p>予約一括ID:</p>
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
                <dd>{{ReservationHelper::judgeStatus($reservation->reservation_status)}}</dd>
              </dl>
              <dl>
                <dt>一人目チェック</dt>
                <dd>
                  <p>※後ほど修正※　山田太郎</p>
                </dd>
              </dl>
              <dl>
                <dt>二人目チェック</dt>
                <dd class="d-flex">
                  <p>※後ほど修正※　未</p>
                  <p class="ml-2"><a class="more_btn" href="">チェックをする</a></p>
                </dd>
              </dl>
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
                <dd>{{ReservationHelper::formatDate($reservation->reserve_date)}}</dd>
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
                  <p><a class="more_btn" href="">※後ほど修正※案内板出力(PDF)</a></p>
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
                {{$equipment->item}}({{$equipment->price}}円)×
                @endforeach
                <tr>
                  <td class="justify-content-between d-flex">
                    ホワイトボード(3000円)×1
                  </td>
                </tr>
                <tr>
                  <td class="justify-content-between d-flex">
                    ホワイトボード(3000円)×1
                  </td>
                </tr>
                <tr>
                  <td class="justify-content-between d-flex">
                    ホワイトボード(3000円)×1
                  </td>
                </tr>
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
                      <li>
                        プロジェクター設置 2000円
                      </li>
                      <li>
                        プロジェクター設置 2000円
                      </li>
                      <li>
                        プロジェクター設置 2000円
                      </li>
                    </ul>
                  </td>
                </tr>

                <tr>
                  <td class="table-active"><label for="layout">レイアウト変更</label></td>
                  <td>
                    あり
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="prelayout">レイアウト準備</label></td>
                  <td>
                    あり
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
                  <td>
                    あり
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
                  <td>
                    あり
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>あり</p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>荷物個数</p>
                        <p>1個</p>
                      </li>

                      <li class="d-flex justify-content-between">
                        <p>事前荷物の到着日</p>
                        <p>2020/12/21(月)</p>
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="postDelivery">事後返送する荷物</label></td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>あり</p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>荷物個数</p>
                        <p>1個</p>
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
                  なし
                </td>
              </tr>
            </table>
          </div>
          <!-- 左側の項目 終わり-------------------------------------------------- -->


          <!-- 右側の項目-------------------------------------------------- -->
          <div class="col-6">

            <!-- <div class="agengy-table">
              <table class="table table-bordered name-table">
                <tr>
                  <td colspan="2">
                    <div class="d-flex align-items-center justify-content-between">
                      <p class="title-icon">
                        <i class="far fa-address-card icon-size"></i>
                        仲介会社情報
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
                      <i class="fas fa-user icon-size"></i>
                      仲介会社の顧客
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="agencyCustermergroup">会社名・団体名</label></td>
                  <td><input class="form-control" name="agencyCustermergroup" type="text"
                      id="agencyCustermergroup">
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="agencyCustermerName">担当者氏名</label></td>
                  <td><input class="form-control" name="agencyCustermerName" type="text" id="agencyCustermerName">
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="agencyCustermerAddress">住所</label></td>
                  <td><input class="form-control" name="agencyCustermerAddress" type="text"
                      id="agencyCustermerAddress"></td>
                </tr>
                <tr>
                <tr>
                  <td class="table-active"><label for="agencyCustermerPhone">電話番号</label></td>
                  <td><input class="form-control" name="agencyCustermerPhone" type="text"
                      id="agencyCustermerPhone">
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="agencyCustermerMail">メールアドレス</label></td>
                  <td><input class="form-control" name="agencyCustermerMail" type="text" id="agencyCustermerMail">
                  </td>
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
                      <i class="fas fa-yen-sign icon-size"></i>
                      仲介会社顧客の支払い料
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="sale">支払い料</label></td>
                  <td class="d-flex align-items-center"><input class="form-control" name="sale" type="text"
                      id="sale">円</td>
                </tr>
              </table>
            </div> -->

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
                    株式会社テスト
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="name">担当者氏名</label></td>
                  <td>
                    山田太郎
                  </td>
                </tr>
                <tr>
                  <td class="table-active">担当者氏名(フリガナ)</td>
                  <td>
                    ヤマダタロウ
                  </td>
                </tr>
                <tr>
                  <td class="table-active">電話番号</td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>携帯番号</p>
                        <p>08012345678</p>
                      </li>
                      <li>
                        <p>固定番号</p>
                        <p>0612345678</p>
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td class="table-active">メールアドレス</td>
                  <td>
                    yamada@gmail.com
                  </td>
                </tr>
                <tr>
                  <td class="table-active">顧客属性</td>
                  <td>
                    ネットワーク
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p>備考</p>
                    <p>なし</p>
                  </td>
                </tr>
                <tr class="caution">
                  <td colspan="2">
                    <p>注意事項</p>
                    <p>なし</p>
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
                  <td>山田花子</td>
                </tr>
                <tr>
                  <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                  <td>08012345678</td>
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
                <td>
                  あり
                </td>
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
                <td>
                  (提携会場のときに表示)
                </td>
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
                  <p>平日3%</p>
                </td>
              </tr>
              <tr class="caution">
                <td>
                  <p>注意事項</p>
                  <p>なし</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>顧客(予約サイト経由)入力の備考</p>
                  <p>なし</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>管理者備考</p>
                  <p>なし</p>
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


            <!-- 会場料請求内容----------- -->
            <div class="bill-box">
              <h3 class="row">会場料</h3>
              <dl class="row bill-box_wrap">
                <div class="col-3 bill-box_cell">
                  <dt>会場料金</dt>
                  <dd>52,400円</dd>
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
                      <p class="text-right">1111</p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引金額</p>
                      <p class=""><span>円</span></p>
                    </div>
                  </div>
                </div>

                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">111</p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class=""><span>%</span></p>
                    </div>
                  </div>
                </div>

                <div class="col-12 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後会場料金合計</p>
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

            <!-- 備品その他　請求内容----------- -->
            <div class="bill-box">
              <h3 class="row">備品その他</h3>
              <dl class="row bill-box_wrap">
                <div class="col-3 bill-box_cell">
                  <dt>有料備品料金</dt>
                  <dd>52,400円</dd>
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>有料サービス料金</dt>
                  <dd>5,300円</dd>
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>荷物預かり/返送</dt>
                  <dd class="d-flex align-items-center">円
                  </dd>
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>備品その他合計</dt>
                  <dd class="text-right">57,700円</dd>
                </div>

                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right"></p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class=""><span>%</span></p>
                    </div>
                  </div>
                </div>

                <div class="col-6 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後備品その他合計</p>
                  <p class=""></p>
                </div>
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
                    </tbody>
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

            <!-- レイアウト変更 請求内容----------- -->
            <div class="bill-box layout_price_list">
              <h3 class="row">レイアウト変更</h3>
              <dl class="row bill-box_wrap">
                <div class="col-4 bill-box_cell">
                  <dt>レイアウト準備料金</dt>
                  <dd>
                    <p class="layout_prepare_result"></p>
                  </dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt>レイアウト片付料金</dt>
                  <dd>
                    <p class="layout_clean_result"></p>
                  </dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt>レイアウト変更合計</dt>
                  <dd class="text-right">
                    <p class="layout_total"></p>
                  </dd>
                </div>

                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right"></p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class="layout_discount_percent"><span>%</span></p>
                    </div>
                  </div>
                </div>

                <div class="col-6 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後レイアウト変更合計</p>
                  <p class="after_duscount_layouts"></p>
                </div>
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
                    </tbody>
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
        </section>

        　　　　　
        <!-- 請求セクション　キャンセル料 キャンセルをしたときに、表示------------------------------------------------------------------ -->
        <section class="bill-wrap section-wrap section-bg">
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
        </section>




      </section>
    </div>

    <!-- 予約詳細   終わり--------------------------------------------------　 -->






    <!-- 追加請求のフィールド------------------------------------------------------------------->
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

        </section>

        　　　　　
        <!-- 請求セクション　キャンセル料-　キャンセルをしたときに、表示------------------------------------------------------------------ -->
        <section class="bill-wrap section-wrap section-bg">
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
        </section>




      </section>
    </div>






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
    </div>


    <!-- チェックボックス ----------------------------------------------------------------------------->
    <div class="checkbox section-wrap">
      <dl class="d-flex col-12 justify-content-end align-items-center">
        <dt><label for="checkname">チェック者</label></dt>
        <dd>
          <select class="form-control select2" name="checkname">
            <option>山田太郎</option>
            <option>山田太郎</option>
            <option>山田太郎</option>
          </select>
        </dd>
        <dd>
          <p class="text-right"><a class="more_btn" href="">チェック完了</a></p>
        </dd>
      </dl>
    </div>



    <div class="btn_wrapper">
      <p class="text-center"><a class="more_btn_lg" href="">予約一覧へもどる</a></p>
    </div>



  </div>
</div>








@endsection