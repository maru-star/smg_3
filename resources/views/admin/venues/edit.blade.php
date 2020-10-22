@extends('layouts.admin.app')

@section('content')

<script src="{{ asset('/js/template.js') }}"></script>
<style>
  .ms-container {
    display: flex;
  }

  .ms-selectable {
    width: 300px;
    height: 300px;
    overflow: scroll;
    border: solid 2px gray;
  }

  .ms-selection {
    width: 300px;
    height: 300px;
    overflow: scroll;
    border: solid 2px pink;
  }
</style>

<h1><span class="badge badge-secondary">会場管理 新規登録</span></h1>
<div class="border-bottom border-danger" style="padding:10px; margin-bottom:20px;">基本情報</div>
{{Form::model($venue, ['route' => ['admin.venues.update', $venue->id], 'method' => 'put'])}}
@csrf
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
        {{ Form::label('smg_url', '会場SMG Url') }}
        {{ Form::text('smg_url', old('smg_url'), ['class' => 'form-control']) }}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <h3>ビル情報</h3>
      <div class="form-group">
        {{ Form::label('alliance_flag', '直営') }}
        {{{Form::radio('alliance_flag', '0')}}}
        {{ Form::label('alliance_flag', '提携')}}
        {{{Form::radio('alliance_flag', '1')}}}
      </div>
      <div class="form-group">
        {{ Form::label('name_area', 'エリア名') }}
        {{ Form::text('name_area', old('name_area'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('name_bldg', 'ビル名') }}
        {{ Form::text('name_bldg', old('name_bldg'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('name_venue', '会場名') }}
        {{ Form::text('name_venue', old('name_venue'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('size1', '会場広さ（坪）') }}
        {{ Form::number('size1', old('size1'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('size2', '会場広さ（㎡）') }}
        {{ Form::number('size2', old('size2'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('capacity', '収容人数') }}
        {{ Form::number('capacity', old('capacity'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('post_code', '郵便番号') }}
        {{ Form::text('post_code', old('post_code'), [
          'class' => 'form-control',
          'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
          'autocomplete'=>'off',
          ]) }}
      </div>

      <div class="form-group">
        {{ Form::label('address1', '住所（都道府県）') }}
        {{ Form::text('address1', old('address1'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('address2', '住所（市町村番地）') }}
        {{ Form::text('address2', old('address2'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('address3', '住所（建物名）') }}
        {{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('entrance_open_time', '正面入口の開閉時間') }}
        {{ Form::text('entrance_open_time', old('entrance_open_time'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('backyard_open_time', '通用口の開閉時間') }}
        {{ Form::text('backyard_open_time', old('backyard_open_time'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('remark', '備考') }}
        {{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}
      </div>

      <h3>荷物預かり</h3>
      <div class="form-group">
        {{ Form::label('luggage_flag', '荷物預かり　有・無') }}
        {{Form::select('luggage_flag', ['有り', '無し'])}}
      </div>

      <div class="form-group">
        {{ Form::label('luggage_post_code', '送付先郵便番号') }}
        {{ Form::text('luggage_post_code', old('luggage_post_code'), [
          'class' => 'form-control',
          'onKeyUp'=>"AjaxZip3.zip2addr(this,'','luggage_address1','luggage_address2');",
          'autocomplete'=>'off',
          ]) }}
      </div>

      <div class="form-group">
        {{ Form::label('luggage_address1', '住所（都道府県）') }}
        {{ Form::text('luggage_address1', old('luggage_address1'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('luggage_address2', '住所（市町村番地）') }}
        {{ Form::text('luggage_address2', old('luggage_address2'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('luggage_address3', '住所（建物名）') }}
        {{ Form::text('luggage_address3', old('luggage_address3'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('luggage_tel', '送付先TEL') }}
        {{ Form::text('luggage_tel', old('luggage_tel'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('luggage_name', '送付先名') }}
        {{ Form::text('luggage_name', old('luggage_name'), ['class' => 'form-control']) }}
      </div>

      <h1><span class="badge badge-secondary">有料備品</span></h1>
      {{ Form::label('equipment_id', '備品') }}
      <select id='equipment_id' multiple='multiple' name="equipment_id[]">
        <!-- 要注意！かなり無理矢理作成した。後ほど別に関数としてまとめる必要あり -->
        @for ($i = 0; $i < $m_equipment->count(); $i++)
          <option value={{$m_equipment[$i]->id}} @foreach ($r_emptys as $r_empty)
            {{$m_equipment[$i]->id==$r_empty->id?"selected":""}} @endforeach>{{$m_equipment[$i]->item}}
          </option>
          @endfor
      </select>
      <h1><span class="badge badge-secondary">有料サービス</span></h1>
      {{ Form::label('service_id', '備品') }}
      <select id='service_id' multiple='multiple' name="service_id[]">
        @for ($s = 0; $s < $m_service->count(); $s++)
          <option value={{$m_service[$s]->id}} @foreach ($s_emptys as $s_empty)
            {{$m_service[$s]->id==$s_empty->id?"selected":""}} @endforeach>{{$m_service[$s]->item}}
          </option>
          @endfor
      </select>
    </div>
    <div class="col-sm">
      <h3>担当者情報</h3>
      <div class="form-group">
        {{ Form::label('first_name', '担当者氏名（姓）') }}
        {{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('last_name', '担当者氏名（名）') }}
        {{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('first_name_kana', '担当者氏名カナ（姓）') }}
        {{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('last_name_kana', '担当者氏名カナ（名）') }}
        {{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('person_tel', '担当者TEL') }}
        {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('person_email', 'EMAIL') }}
        {{ Form::text('person_email', old('person_email'), ['class' => 'form-control']) }}
      </div>

      <h3>ビル管理会社</h3>
      <div class="form-group">
        {{ Form::label('mgmt_company', '会社名') }}
        {{ Form::text('mgmt_company', old('mgmt_company'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_tel', '電話番号') }}
        {{ Form::text('mgmt_tel', old('mgmt_tel'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_emer_tel', '夜間緊急連絡先') }}
        {{ Form::text('mgmt_emer_tel', old('mgmt_emer_tel'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_first_name', '担当者氏名（姓）') }}
        {{ Form::text('mgmt_first_name', old('mgmt_first_name'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_last_name', '担当者氏名（名）') }}
        {{ Form::text('mgmt_last_name', old('mgmt_last_name'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_person_tel', '担当者電話番号') }}
        {{ Form::text('mgmt_person_tel', old('mgmt_person_tel'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_email', '担当者メール') }}
        {{ Form::text('mgmt_email', old('mgmt_email'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_sec_company', '軽微会社名') }}
        {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_sec_tel', '軽微会社電話番号') }}
        {{ Form::text('mgmt_sec_tel', old('mgmt_sec_tel'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('mgmt_remark', '備考') }}
        {{ Form::textarea('mgmt_remark', old('mgmt_remark'), ['class' => 'form-control']) }}
      </div>

      <h3>室内飲食</h3>
      <div class="form-group">
        {{ Form::label('eat_in_flag', '室内飲食') }}
        {{{Form::select('eat_in_flag', ['有り', '無し'],null,['placeholder' => '選択してください'])}}}
      </div>

      <h3>支払いデータ</h3>

      <div class="form-group">
        {{ Form::label('cost', '支払割合（原価）') }}
        {{ Form::text('cost', old('cost'),['class' => 'form-control']) }}
      </div>
    </div>
  </div>
</div>
<div class="mx-auto" style="width: 100px;">
  {{ Form::submit('変更を登録', ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
@endsection