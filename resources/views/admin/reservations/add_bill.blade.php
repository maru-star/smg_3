@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>

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

{{ Form::hidden('reservation', $reservation->id, ['class' => 'form-control', 'id'=>'reservation']) }}


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

    <!-- 追加請求書----------------------------------------------------------------- -->
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

    <table class="table table-bordered extra-bill-table">
      <thead>
        <tr>
          <td class="table-active"><label for="billcontent">内容</label></td>
          <td class="table-active"><label for="billfee">単価</label></td>
          <td class="table-active"><label for="billquantity">個数</label></td>
          {{-- <td class="table-active"><label for="billamount">金額</label></td> --}}
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <div class="btn_wrapper">
      <button class="text-center more_btn_lg add_bill_calculate">計算する</button>
    </div>

    <table class="result_table table table-bordered">
      <thead>
        <tr>
          <td colspan="4" style="background: gray">結果</td>
        </tr>
        <tr>
          <td>割引料金<input type="text"></td>
          <td>割引率　<span></span>%</td>
          <td colspan="2">割引後料金合計 </td>
        </tr>
        <tr>
          <td>内容</td>
          <td>単価</td>
          <td>個数</td>
          <td>合計</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>test</td>
          <td>test</td>
          <td>test</td>
          <td>test</td>
        </tr>
      </tbody>
    </table>




    <div class="btn_wrapper">
      <p class="text-center"><a class="more_btn_lg">作成する</a></p>
    </div>

    <div class="btn_wrapper">
      <p class="text-center"><a class="more_btn_lg">予約一覧へもどる</a></p>
    </div>

  </div>
</div>
</div>


<script>
  $(function(){
    $("input[name=billcategory]").on('click',function(){
      if ($(this).val()==3) {
        $('#inputother').prop('disabled',false);
      }else{
        $('#inputother').prop('disabled',true);
        $('#inputother').val('');
      }
    })
  })
</script>


@endsection