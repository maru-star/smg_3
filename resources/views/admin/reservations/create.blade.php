@extends('layouts.admin.app')
@section('content')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
  <div class="border border border-success">
    <table class="table mb-0">
      <tr>
        <td class="">予約概要 ID : 00010</td>
        <td class="">編集</td>
      </tr>
    </table>
  </div>

  <div class="mt-2">
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
          <td>会社説明会</td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>2021年新卒採用</td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>株式会社BAC</td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">有料備品</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">有料サービス</th>
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





      <div class="price_details">
      </div>
      <button id='calculate' class="btn btn-primary">計算する！！！！</button>



    </div>









    {{-- 右側 --}}
    <div class="col">
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

  {{-- 請求情報 --}}
  {{-- <div class="container-field bg-white text-dark">
    <span>請求情報：会場量</span>
    <div class="row">
      <div class="col">
        <div><label for="total">請求総額</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
      <div class="col">
        <div><label for="sub_total">小計</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
      <div class="col">
        <div><label for="tax">消費税</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div><label for="venue_amount">会場料金</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
      <div class="col">
        <div><label for="extend">延長料金</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
      <div class="col">
        <div><label for="equipments">備品料金</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
      <div class="col">
        <div><label for="equipments">サービス料金</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div><label for="discount">割引料金</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
      <div class="col">
        <div><label for="change_total">変更後請求総額</label></div>
        <div><input type="text" name="total" value="0"></div>
      </div>
    </div>
  </div> --}}

</div>

{{-- <div class="container-field">
  {{ Form::open(['url' => 'admin/reservations', 'method'=>'POST', 'id'=>'']) }}
@csrf

<div class="row">
  <div class="col">
    <div class="p-3 mb-2 bg-white text-dark">

      <table class="table table-bordered">
        <tr>
          <td>予約情報</td>
        </tr>
        <tr>
          <td>利用日</td>
          <td>2020/10/20(火)</td>
        </tr>
      </table>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('remark', '備考') }}</div>
        <div class="col-sm-8">
          {{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</div>
      </div>
    </div>

    <div class="p-3 mb-2 bg-white text-dark">
      <span><i class="fas fa-suitcase-rolling"></i>荷物預かり</span>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_flag', '荷物預かり　有・無') }}</div>
        <div class="col-sm-8">
          {{Form::select('luggage_flag', ['有り', '無し'],null,['placeholder' => '選択してください','class'=>'custom-select mr-sm-2'])}}
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_post_code', '送付先郵便番号') }}</div>
        <div class="col-sm-8"> {{ Form::text('luggage_post_code', old('luggage_post_code'), [
            'class' => 'form-control',
            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','luggage_address1','luggage_address2');",
            'autocomplete'=>'off',
            ]) }}
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_address1', '住所（都道府県）') }}</div>
        <div class="col-sm-8">
          {{ Form::text('luggage_address1', old('luggage_address1'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_address2', '住所（市町村番地）') }}</div>
        <div class="col-sm-8">
          {{ Form::text('luggage_address2', old('luggage_address2'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_address3', '住所（建物名）') }}</div>
        <div class="col-sm-8">
          {{ Form::text('luggage_address3', old('luggage_address3'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_name', '送付先名') }}</div>
        <div class="col-sm-8">
          {{ Form::text('luggage_name', old('luggage_name'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('luggage_tel', '電話番号') }}</div>
        <div class="col-sm-8">
          {{ Form::text('luggage_tel', old('luggage_tel'), ['class' => 'form-control']) }}</div>
      </div>

    </div>

  </div>
  <div class="col">
    <div class="p-3 mb-2 bg-white text-dark">
      <span><i class="fas fa-user-check"></i>担当者情報</span>

      <div class="row">
        <div class="col-sm-2">{{ Form::label('first_name', '氏名(姓)') }}</div>
        <div class="col-sm-4">
          {{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}</div>
        <div class="col-sm-2">{{ Form::label('last_name', '氏名(名)') }}</div>
        <div class="col-sm-4">
          {{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-2">{{ Form::label('first_name', '氏名(セイ)') }}</div>
        <div class="col-sm-4">
          {{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control']) }}</div>
        <div class="col-sm-2">{{ Form::label('last_name', '氏名(メイ)') }}</div>
        <div class="col-sm-4">
          {{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('person_tel', '担当者電話番号') }}</div>
        <div class="col-sm-8">
          {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('person_email', '担当者メール') }}</div>
        <div class="col-sm-8">
          {{ Form::text('person_email', old('person_email'), ['class' => 'form-control']) }}</div>
      </div>
    </div>

    <div class="p-3 mb-2 bg-white text-dark">
      <span><i class="fas fa-building"></i>ビル管理会社</span>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_company', '会社名') }}</div>
        <div class="col-sm-8">
          {{ Form::text('mgmt_company', old('mgmt_company'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_tel', '電話番号') }}</div>
        <div class="col-sm-8">
          {{ Form::text('mgmt_tel', old('mgmt_tel'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_emer_tel', '夜間緊急連絡先') }}</div>
        <div class="col-sm-8">
          {{ Form::text('mgmt_emer_tel', old('mgmt_emer_tel'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-2">{{ Form::label('mgmt_first_name', '氏名(姓)') }}</div>
        <div class="col-sm-4">
          {{ Form::text('mgmt_first_name', old('mgmt_first_name'), ['class' => 'form-control']) }}</div>
        <div class="col-sm-2">{{ Form::label('mgmt_last_name', '氏名(名)') }}</div>
        <div class="col-sm-4">
          {{ Form::text('mgmt_last_name', old('mgmt_last_name'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_email', '担当者メール') }}</div>
        <div class="col-sm-8">
          {{ Form::text('mgmt_email', old('mgmt_email'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_sec_company', '警備会社名') }}</div>
        <div class="col-sm-8">
          {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_sec_tel', '警備会社電話番号') }}</div>
        <div class="col-sm-8">
          {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('mgmt_remark', '備考') }}</div>
        <div class="col-sm-8">
          {{ Form::textarea('mgmt_remark', old('mgmt_remark'), ['class' => 'form-control']) }}</div>
      </div>
      <hr>
    </div>




    <div class="p-3 mb-2 bg-white text-dark">
      <span><i class="fas fa-utensils"></i>室内飲食</span>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('eat_in_flag', '室内飲食') }}</div>
        <div class="col-sm-8">
          {{{Form::select('eat_in_flag', ['有り', '無し'],null,['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
        </div>
      </div>
      <hr>
    </div>

    <div class="p-3 mb-2 bg-white text-dark">
      <span><i class="fas fa-utensils"></i>支払データ</span>

      <div class="row">
        <div class="col-sm-4">{{ Form::label('cost', '支払割合（原価）') }}</div>
        <div class="col-sm-8">
          {{ Form::number('cost', old('cost'), ['class' => 'form-control']) }}</div>
      </div>
    </div>
    <hr>
  </div>
</div>
</div>



<div class="p-3 mb-2 bg-white text-dark">
  <span>有料備品</span>
  <div>
    <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
  </div>
  <select id='equipment_id' multiple='multiple' name="equipment_id[]">
  </select>
</div>

<div class="p-3 mb-2 bg-white text-dark">
  <span>有料サービス</span>
  <div>
    <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
  </div>
  <select id='service_id' multiple='multiple' name="service_id[]">
  </select>
</div>

<div class="mx-auto" style="width: 100px;">
  {{ Form::submit('登録', ['class' => 'btn btn-primary']) }}
</div>


{{ Form::close() }}
</div>
--}}






{{--

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

<div class="container-field">
  {{ Form::open(['url' => 'admin/reservations', 'method'=>'POST', 'id'=>'']) }}
  @csrf

  <div class="row">
    <div class="col">
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-info-circle"></i>ビル情報</span>

        <div class="row">
          {{ Form::label('reserve_date', '利用日') }}
          {{ Form::text('reserve_date', old('reserve_date'), ['class' => 'form-control', 'id'=>'datepicker1']) }}
        </div>

        <hr>

        <div class="row">
          {{ Form::label('reserve_date', '会場') }}
          ここはselect 必要
        </div>

        <hr>
        <div class="row">
          {{ Form::label('start', '入室時間') }}
          {{ Form::text('start', old('start'), ['class' => 'form-control']) }}
        </div>
        <hr>

        <div class="row">
          {{ Form::label('status', '退室時間') }}
          {{ Form::number('status', old('status'), ['class' => 'form-control']) }}
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('size2', '会場広さ（㎡）') }}</div>
          <div class="col-sm-8">{{ Form::number('size2', old('size2'), ['class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('capacity', '収容人数') }}</div>
          <div class="col-sm-8">
            {{ Form::number('capacity', old('capacity'), ['placeholder' => '15','class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('post_code', '郵便番号') }}</div>
          <div class="col-sm-8"> {{ Form::text('post_code', old('post_code'), [
            'class' => 'form-control',
            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
            'autocomplete'=>'off',
            ]) }}
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('address1', '住所（都道府県）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('address1', old('address1'), ['placeholder' => '大阪府','class' => 'form-control search_address2']) }}
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('address2', '住所（市町村番地）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('address2', old('address2'), ['placeholder' => '大阪市北堀江1-23-1','class' => 'form-control search_address3']) }}
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('address3', '住所（建物名）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('address3', old('address3'), ['placeholder' => 'プレサンスビル703号室','class' => 'form-control']) }}
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('entrance_open_time', '正面入口の開閉時間') }}</div>
          <div class="col-sm-8">
            {{ Form::text('entrance_open_time', old('entrance_open_time'), ['class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('backyard_open_time', '通用口の開閉時間') }}</div>
          <div class="col-sm-8">
            {{ Form::text('backyard_open_time', old('backyard_open_time'), ['class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('remark', '備考') }}</div>
          <div class="col-sm-8">
            {{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</div>
        </div>
      </div>

      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-suitcase-rolling"></i>荷物預かり</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_flag', '荷物預かり　有・無') }}</div>
          <div class="col-sm-8">
            {{Form::select('luggage_flag', ['有り', '無し'],null,['placeholder' => '選択してください','class'=>'custom-select mr-sm-2'])}}
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_post_code', '送付先郵便番号') }}</div>
          <div class="col-sm-8"> {{ Form::text('luggage_post_code', old('luggage_post_code'), [
            'class' => 'form-control',
            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','luggage_address1','luggage_address2');",
            'autocomplete'=>'off',
            ]) }}
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address1', '住所（都道府県）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_address1', old('luggage_address1'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address2', '住所（市町村番地）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_address2', old('luggage_address2'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address3', '住所（建物名）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_address3', old('luggage_address3'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_name', '送付先名') }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_name', old('luggage_name'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_tel', '電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_tel', old('luggage_tel'), ['class' => 'form-control']) }}</div>
        </div>

      </div>

    </div>
    <div class="col">
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-user-check"></i>担当者情報</span>

        <div class="row">
          <div class="col-sm-2">{{ Form::label('first_name', '氏名(姓)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}</div>
          <div class="col-sm-2">{{ Form::label('last_name', '氏名(名)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-2">{{ Form::label('first_name', '氏名(セイ)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control']) }}</div>
          <div class="col-sm-2">{{ Form::label('last_name', '氏名(メイ)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('person_tel', '担当者電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('person_email', '担当者メール') }}</div>
          <div class="col-sm-8">
            {{ Form::text('person_email', old('person_email'), ['class' => 'form-control']) }}</div>
        </div>
      </div>

      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-building"></i>ビル管理会社</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_company', '会社名') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_company', old('mgmt_company'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_tel', '電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_tel', old('mgmt_tel'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_emer_tel', '夜間緊急連絡先') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_emer_tel', old('mgmt_emer_tel'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-2">{{ Form::label('mgmt_first_name', '氏名(姓)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('mgmt_first_name', old('mgmt_first_name'), ['class' => 'form-control']) }}</div>
          <div class="col-sm-2">{{ Form::label('mgmt_last_name', '氏名(名)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('mgmt_last_name', old('mgmt_last_name'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_email', '担当者メール') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_email', old('mgmt_email'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_sec_company', '警備会社名') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_sec_tel', '警備会社電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_remark', '備考') }}</div>
          <div class="col-sm-8">
            {{ Form::textarea('mgmt_remark', old('mgmt_remark'), ['class' => 'form-control']) }}</div>
        </div>
        <hr>
      </div>




      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>室内飲食</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('eat_in_flag', '室内飲食') }}</div>
          <div class="col-sm-8">
            {{{Form::select('eat_in_flag', ['有り', '無し'],null,['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
          </div>
        </div>
        <hr>
      </div>

      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>支払データ</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('cost', '支払割合（原価）') }}</div>
          <div class="col-sm-8">
            {{ Form::number('cost', old('cost'), ['class' => 'form-control']) }}</div>
        </div>
      </div>
      <hr>
    </div>
  </div>
</div>



<div class="p-3 mb-2 bg-white text-dark">
  <span>有料備品</span>
  <div>
    <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
  </div>
  <select id='equipment_id' multiple='multiple' name="equipment_id[]">
  </select>
</div>

<div class="p-3 mb-2 bg-white text-dark">
  <span>有料サービス</span>
  <div>
    <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
  </div>
  <select id='service_id' multiple='multiple' name="service_id[]">
  </select>
</div>

<div class="mx-auto" style="width: 100px;">
  {{ Form::submit('登録', ['class' => 'btn btn-primary']) }}
</div>


{{ Form::close() }}
</div>


















































<div class="container-filed">
  <div><input type="checkbox" class="agents">仲介会社</div>
  <div>
    <form>
      <h1>予約概要</h1>
      <div class="row">
        <div class="col">
          {{ Form::label('reserve_date', '利用日') }}
          {{ Form::text('reserve_date', old('reserve_date'), ['class' => 'form-control', 'id'=>'datepicker1']) }}
        </div>
        <div class="col">
          {{ Form::label('reserve_date', '申込日') }}
          {{ Form::text('reserve_date', old('reserve_date'), ['class' => 'form-control', 'id'=>'datepicker2']) }}
        </div>
        <div class="col">
          {{ Form::label('status', '予約状況') }}
          {{ Form::number('status', old('status'), ['class' => 'form-control']) }}
        </div>
      </div>
      <div class="row">
        <div class="col">
          {{ Form::label('venues', '利用会場') }}
          {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
        </div>
        <div class="col">
          {{ Form::label('start', '開始時間') }}
          {{ Form::text('start', old('start'), ['class' => 'form-control']) }}
        </div>
        <div class="col">
          {{ Form::label('status', '終了時間') }}
          {{ Form::number('status', old('status'), ['class' => 'form-control']) }}
        </div>
      </div>
      <div class="row">
        <div class="col">
          {{ Form::label('venues', '顧客') }}
          {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
        </div>
        <div class="col">
          {{ Form::label('venues', '仲介会社') }}
          {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
        </div>
        <div class="col">
          {{ Form::label('start', '当日の担当者') }}
          {{ Form::text('start', old('start'), ['class' => 'form-control']) }}
        </div>
        <div class="col">
          {{ Form::label('status', '連絡先') }}
          {{ Form::number('status', old('status'), ['class' => 'form-control']) }}
        </div>
      </div>
      <div class="row">
        <div class="col">
          {{ Form::label('status', '案内板') }}
          {{ Form::number('status', old('status'), ['class' => 'form-control']) }}
          <div class="board_details">
            <div class="row">
              <div class="col">
                {{ Form::label('venues', '顧客') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
              <div class="col">
                {{ Form::label('venues', '仲介会社') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="row">
              <div class="col">
                {{ Form::label('venues', 'イベント名称1行目') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
              <div class="col">
                {{ Form::label('venues', 'イベント名称2行目') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="row">
              <div class="col">
                {{ Form::label('venues', '主催者名') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="row">
              <div class="col">
                <input type="radio" name="event_time" checked="checked">イベント時間を記載
                <input type="radio" name="event_time">イベント時間記載はなし
              </div>
            </div>
            <div class="row">
              <div class="col">
                {{ Form::label('venues', 'イベント開始時間') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
              <div class="col">
                {{ Form::label('venues', 'イベント終了時間') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="row">
              <div class="col">
                {{ Form::label('venues', '利用後の送信メールの有無') }}
                {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <h1>有料備品</h1>
      <div class="row">
        <div class="col">
          <div>
            有料備品一覧...
          </div>
        </div>
      </div>
      <h1>有料サービス</h1>
      <div class="row">
        <div class="col">
          <div>
            有料サービス一覧...
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          {{ Form::label('venues', '備考') }}
          {{ Form::textarea('venues', old('venues'), ['class' => 'form-control']) }}
        </div>
      </div>
      <h1>請求情報</h1>
      <div>
        <div class="row">
          <div class="col">
            {{ Form::label('venues', '請求総額') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
          <div class="col">
            {{ Form::label('venues', '消費税') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
          <div class="col">
            {{ Form::label('venues', '支払状態') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
        </div>
        <div class="row">
          <div class="col">
            {{ Form::label('venues', '会場料金') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
          <div class="col">
            {{ Form::label('venues', '延長料金') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
          <div class="col">
            {{ Form::label('venues', '備品料金') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
        </div>
        <div class="row">
          <div class="col">
            {{ Form::label('venues', '割引料金') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
          <div class="col">
            {{ Form::label('venues', '変更後請求総額') }}
            {{ Form::text('venues', old('venues'), ['class' => 'form-control']) }}
          </div>
        </div>
        <div>
          <h1>内訳</h1>
          <table class="table">
            <thead>
              <tr>
                <th>内容</th>
                <th>単価</th>
                <th>数量</th>
                <th>金額</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>会場料金</td>
                <td>5,000円</td>
                <td>4H</td>
                <td>20,000円</td>
              </tr>
              <tr>
                <td>会場料金</td>
                <td>5,000円</td>
                <td>4H</td>
                <td>20,000円</td>
              </tr>
              <tr>
                <td>会場料金</td>
                <td>5,000円</td>
                <td>4H</td>
                <td>20,000円</td>
              </tr>
              <tr>
                <td>会場料金</td>
                <td>5,000円</td>
                <td>4H</td>
                <td>20,000円</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>
          <div>提携先支払い情報</div>
          <div>
            <table class="table">
              <tr>
                <td>原価率<br>70%</td>
                <td>金額<br>9,900円</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </form>
  </div>
</div> --}}







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
                <input type="number" name="price" class="form-control venue_discount_percent" id="price"
                  value="0"><span>%</span>
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
              <p class="text-right"><input type="text" name="price" class="form-control" id="price"></p>
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

      {{-- <div class="row bill-box_wrap bill-list-subttl">
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
        </div> --}}
      {{-- <div class="row bill-box_wrap">
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
        </div> --}}

      {{-- <div class="row bill-box_wrap">
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
        </div> --}}

      {{-- <div class="row bill-box_wrap">
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
      </div> --}}


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
        <dd class="d-flex align-items-center"><input class="form-control mr-3" name="package" type="text">円
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
            <p class="text-right"><input type="text" name="price" class="form-control" id="price"></p>
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


  <dl class="row bill-box_wrap total-sum">
    <div class="col-3 bill-box_cell">
      <dt>合計請求総額</dt>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>会場料</dt>
      <dd>5,300円</dd>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>追加請求料</dt>
      <dd>5,300円</dd>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>請求総額</dt>
      <dd class="text-right">57,700円</dd>
    </div>
  </dl>
  </div>
</section>

<div class="btn_wrapper">
  <p class="text-center"><a class="more_btn_lg" href="">予約登録する</a></p>
</div>


@endsection