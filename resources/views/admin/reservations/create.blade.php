@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

















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
  {{ Form::open(['url' => 'admin/reservations', 'method'=>'PSOT', 'id'=>'']) }}
  @csrf

  <div class="row">
    <div class="col">
      {{-- ビル情報 --}}
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-info-circle"></i>ビル情報</span>
        <div class="mt-2 mb-2">
          {{ Form::label('alliance_flag', '直営') }}
          {{Form::radio('alliance_flag', '0')}}
          {{ Form::label('alliance_flag', '提携')}}
          {{Form::radio('alliance_flag', '1')}}
        </div>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_area', 'エリア名') }}</div>
          <div class="col-sm-8">{{ Form::text('name_area', old('name_area'), ['class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_bldg', 'ビル名') }}</div>
          <div class="col-sm-8">{{ Form::text('name_bldg', old('name_bldg'), ['class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_venue', '会場名') }}</div>
          <div class="col-sm-8">{{ Form::text('name_venue', old('name_venue'), ['class' => 'form-control']) }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('size1', '会場広さ（坪）') }}</div>
          <div class="col-sm-8">{{ Form::number('size1', old('size1'), ['class' => 'form-control']) }}</div>
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

      {{-- 荷物預かり --}}
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
</div>



@endsection