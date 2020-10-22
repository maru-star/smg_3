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


<h1><span class="badge badge-secondary">予約 新規作成</span></h1>

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