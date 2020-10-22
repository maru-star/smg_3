@extends('layouts.admin.app')

@section('content')
<div class="container">
  <h2>顧客管理　編集</h2>
  <div class="row">
    <div class="col-sm">
      {{Form::model($user, ['route' => ['admin.clients.update', $user->id], 'method' => 'put'])}}
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-exclamation-circle fa-fw"></i></i>基本情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('company', '会社・団体名') }}</th>
            <td>{{ Form::text('company', $user->company, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{ Form::text('post_code', $user->post_code, [
                            'class' => 'form-control',
                            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                            'autocomplete'=>'off',
                            ]) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{ Form::text('address1', $user->address1, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{ Form::text('address2', $user->address2, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{ Form::text('address3', $user->address3, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{ Form::textarea('address_remark', $user->address_remark, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td>{{ Form::text('url', $user->url, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('attr', '顧客属性') }}</th>
            <td>{{Form::select('attr', [1=>'一般企業', 2=>'上場企業',3=>'近隣利用', 4=>'講師・セミナー', 5=>'その他'],$user->attr)}}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('condition', '割引条件') }}</th>
            <td>{{ Form::text('condition', old('condition'), ['class' => 'form-control']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-user fa-fw"></i>担当者情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('first_name', '担当者氏名') }}</th>
            <td>姓：{{ Form::text('first_name', $user->first_name, ['class' => 'form-control']) }}
            </td>
            <td>名：{{ Form::text('last_name', $user->last_name, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('first_name_kana', '担当者氏名（ふりがな）') }}</th>
            <td>セイ：{{ Form::text('first_name_kana', $user->first_name_kana, ['class' => 'form-control'])}}
            </td>
            <td>メイ：{{ Form::text('last_name_kana', $user->last_name_kana, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('tel', '電話番号') }}</th>
            <td>{{ Form::text('tel', $user->tel, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('mobile', '携帯番号') }}</th>
            <td>{{ Form::text('mobile', $user->mobile, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td>{{ Form::text('email', $user->email, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('fax', 'FAX') }}</th>
            <td>{{ Form::text('fax', $user->fax, ['class' => 'form-control']) }}</td>
          </tr>
          <thead>
            <tr>
              <th scope="col"><i class="fas fa-user fa-fw"></i>支払いデータ</th>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_method', '支払方法') }}</th>
              <td>{{Form::select('pay_method', [1=>'銀行振込', 2=>'現金',3=>'クレジットカード', 4=>'スマホ決済'],$user->pay_method)}}
              </td>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_limit', '支払期日') }}</th>
              <td>{{Form::select('pay_limit', [1=>'3営業日前', 2=>'当月末',3=>'翌月末'],$user->pay_limit)}}</td>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</th>
              <td>{{ Form::text('pay_post_code', $user->pay_post_code, [
                                'class' => 'form-control pay_post_code',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','pay_address1','pay_address2');",
                                'autocomplete'=>'off',
                                ]) }}
              </td>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_address1', '請求書送付先（都道府県）') }}</th>
              <td>{{ Form::text('pay_address1', $user->pay_address1, ['class' => 'form-control pay_address_1']) }}
              </td>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_address2', '請求書送付先（市町村番地）') }}</th>
              <td>{{ Form::text('pay_address2',$user->pay_address2, ['class' => 'form-control pay_address_2']) }}
              </td>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_address3', '建物名') }}</th>
              <td>{{ Form::text('pay_address3',$user->pay_address3, ['class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <th scope="row">{{ Form::label('pay_remark', '請求書備考') }}</th>
              <td>{{ Form::textarea('pay_remark', $user->pay_remark, ['class' => 'form-control']) }}</td>
            </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">注意事項</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('attention', '注意事項') }}</th>
            <td>{{ Form::textarea('attention', $user->attention, ['class' => 'form-control']) }}</td>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">備考</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('remark', '備考') }}</th>
            <td>{{ Form::textarea('remark', $user->remark, ['class' => 'form-control']) }}</td>
          </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>
  {{ Form::submit('更新', ['class' => 'btn btn-primary btn-block']) }}
  {{ Form::close() }}
</div>
@endsection