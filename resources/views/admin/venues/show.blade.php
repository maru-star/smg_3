@extends('layouts.admin.app')

@section('content')
{{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
<h1><span class="badge badge-secondary">会場管理 詳細</span></h1>
<div class="d-inline-flex p-2 bd-highlight">
  {{ link_to_route('admin.venues.edit', '編集する', $parameters = $venue->id, ['class' => 'btn btn-primary']) }}
  {{ Form::model($venue, ['route' => ['admin.venues.destroy', $venue->id], 'method' => 'delete']) }}
  @csrf
  {{ Form::submit('削除', ['class' => 'btn btn-danger']) }}
  {{ Form::close() }}
</div>
<div class="border-bottom border-danger" style="padding:10px; margin-bottom:20px;">基本情報</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
        <h4>SMG Url</h4>
        {{ $venue->smg_url}}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <h3> <span class="badge badge-info">ビル情報</span></h3>
      <div class="form-group">
        <h4>直営・提携</h4>
        {{ $venue->alliance_flag==0?"直営":"提携"}}
      </div>
      <div class="form-group">
        <h4>エリア名</h4>
        {{ $venue->name_area}}
      </div>

      <div class="form-group">
        <h4>ビル名</h4>
        {{ $venue->name_bldg}}
      </div>

      <div class="form-group">
        <h4>会場名</h4>
        {{ $venue->name_venue}}
      </div>

      <div class="form-group">
        <h4>会場広さ（坪）</h4>
        {{ $venue->size1}}

      </div>

      <div class="form-group">
        <h4>会場広さ（㎡）</h4>
        {{ $venue->size2}}
      </div>

      <div class="form-group">
        <h4>収容人数</h4>
        {{ $venue->capacity}}
      </div>

      <div class="form-group">
        <h4>郵便番号</h4>
        {{ $venue->post_code}}

      </div>

      <div class="form-group">
        <h4>住所（都道府県）</h4>
        {{ $venue->address1}}
      </div>

      <div class="form-group">
        <h4>住所（市町村番地）</h4>
        {{ $venue->address2}}

      </div>

      <div class="form-group">
        <h4>住所（建物名）</h4>
        {{ $venue->address3}}
      </div>

      <div class="form-group">
        <h4>正面入口の開閉時間</h4>
        {{ $venue->entrance_open_time}}
      </div>

      <div class="form-group">
        <h4>通用口の開閉時間</h4>
        {{ $venue->backyard_open_time}}
      </div>

      <div class="form-group">
        <h4>備考</h4>
        {{ $venue->remark}}
      </div>

      <h3> <span class="badge badge-info">荷物預かり</span></h3>
      <div class="form-group">
        <h4>荷物預かり　有・無</h4>
        {{ $venue->luggage_flag}}
      </div>

      <div class="form-group">
        <h4>送付先郵便番号</h4>
        {{ $venue->luggage_post_code}}
      </div>

      <div class="form-group">
        <h4>住所（都道府県）</h4>
        {{ $venue->luggage_address1}}
      </div>

      <div class="form-group">
        <h4>住所（市町村番地）</h4>
        {{ $venue->luggage_address2}}
      </div>

      <div class="form-group">
        <h4>住所（建物名）</h4>
        {{ $venue->luggage_address3}}
      </div>

      <div class="form-group">
        <h4>送付先TEL</h4>
        {{ $venue->luggage_tel}}
      </div>

      <div class="form-group">
        <h4>送付先名</h4>
        {{ $venue->luggage_name}}
      </div>

      <h3> <span class="badge badge-info">有料備品</span></h3>
      @foreach ($r_emptys as $r_empty)
      <p> {{ $r_empty->item }} </p>
      @endforeach

      <!-- サービス -->
      <h3> <span class="badge badge-info">有料サービス</span></h3>
      @foreach ($s_emptys as $s_empty)
      <p> {{ $s_empty->item }} </p>
      @endforeach

      {{-- 営業時間 --}}
      <h3> <span class="badge badge-info">営業時間</span></h3>
      <table class="table">
        <tbody>
          <tr>
            <td>曜日</td>
            <td>営業時間</td>
          </tr>
          @for ($i = 1; $i <= 7; $i++) <tr>
            <td>
              {{$i==1?'月':''}}{{$i==2?'火':''}}{{$i==3?'水':''}}{{$i==4?'木':''}}{{$i==5?'金':''}}{{$i==6?'土':''}}{{$i==7?'日':''}}
            </td>
            <td>
              {{$date_venues->where('week_day',$i)->first()->start}}
              ~
              {{$date_venues->where('week_day',$i)->first()->finish}}
            </td>
            <td>
            </td>
            </tr>
            @endfor
        </tbody>
      </table>

      {{-- 料金体系 --}}
      <h3> <span class="badge badge-info">料金体系</span></h3>
      <div>
        <h4>料金体系：枠貸し</h4>
        <p></p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">枠</th>
              <th scope="col">時間（開始）</th>
              <th scope="col">時間（終了）</th>
              <th scope="col">料金</th>
              <th scope="col">登録日</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($frame_prices as $frame_price)
            <tr>
              <th>{{ $frame_price->frame}}</th>
              <td>{{ $frame_price->start}}</td>
              <td>{{ $frame_price->finish}}</td>
              <td>{{ $frame_price->price}}</td>
              <td>{{ $frame_price->created_at}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div>
        <h4>料金体系：時間貸</h4>
        <p></p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">時間</th>
              <th scope="col">料金</th>
              <th scope="col">延長料金</th>
              <th scope="col">登録日</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($time_prices as $time_price)
            <tr>
              <th>{{ $time_price->time}}</th>
              <td>{{ $time_price->price}}</td>
              <td>{{ $time_price->extend}}</td>
              <td>{{ $time_price->created_at}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-sm">
      <h3> <span class="badge badge-info">担当者情報</span></h3>
      <div class="form-group">
        <h4>担当者氏名（姓）</h4>
        {{ $venue->first_name}}
      </div>

      <div class="form-group">
        <h4>担当者氏名（名）</h4>
        {{ $venue->last_name}}
      </div>

      <div class="form-group">
        <h4>担当者氏名カナ（姓）</h4>
        {{ $venue->first_name_kana}}
      </div>

      <div class="form-group">
        <h4>担当者氏名カナ（名）</h4>
        {{ $venue->last_name_kana}}
      </div>

      <div class="form-group">
        <h4>担当者TEL</h4>
        {{ $venue->person_tel}}
      </div>

      <div class="form-group">
        <h4>EMAIL</h4>
        {{ $venue->person_email}}
      </div>

      <h3> <span class="badge badge-info">ビル管理会社</span></h3>
      <div class="form-group">
        <h4>会社名</h4>
        {{ $venue->mgmt_company}}
      </div>

      <div class="form-group">
        <h4>電話番号</h4>
        {{ $venue->mgmt_tel}}
      </div>

      <div class="form-group">
        <h4>夜間緊急連絡先</h4>
        {{ $venue->mgmt_emer_tel}}
      </div>

      <div class="form-group">
        <h4>担当者氏名（姓）</h4>
        {{ $venue->mgmt_first_name}}
      </div>

      <div class="form-group">
        <h4>担当者氏名（名）</h4>
        {{ $venue->mgmt_last_name}}
      </div>

      <div class="form-group">
        <h4>担当者電話番号</h4>
        {{ $venue->mgmt_person_tel}}
      </div>

      <div class="form-group">
        <h4>担当者メール</h4>
        {{ $venue->mgmt_email}}
      </div>

      <div class="form-group">
        <h4>警備会社名</h4>
        {{ $venue->mgmt_sec_company}}
      </div>

      <div class="form-group">
        <h4>警備会社電話番号</h4>
        {{ $venue->mgmt_sec_tel}}
      </div>

      <div class="form-group">
        <h4>備考</h4>
        {{ $venue->mgmt_remark}}
      </div>

      <h3> <span class="badge badge-info">室内飲食</span></h3>
      <div class="form-group">
        <h4>室内飲食</h4>
        {{ $venue->eat_in_flag}}
      </div>

      <h3> <span class="badge badge-info">支払データ</span></h3>
      <div class="form-group">
        <h4>支払割合（原価）</h4>
        {{ $venue->cost}}
      </div>
    </div>
  </div>
</div>
@endsection