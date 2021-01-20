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

{{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/add_bill_check', 'method'=>'POST','id'=>'testid']) }}
@csrf

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
          <input type="radio" name="billcategory" id="optionsRadios" value="1">その他の有料備品、サービス
        </label>
      </p>
      <p class="radio">
        <label>
          <input type="radio" name="billcategory" id="optionsRadios" value="2">レイアウト変更
        </label>
      </p>
      <p class="radio d-flex">
        <label style="width: 90px;">
          <input type="radio" name="billcategory" id="optionsRadios" value="3">その他
        </label>
        <label for="other"></label>
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
      <p class=" btn text-center more_btn_lg add_bill_calculate">計算する</p>
    </div>

    <table class="result_table table table-bordered">
      <thead>
        <tr>
          <td colspan="4" style="background: gray">結果</td>
        </tr>
        <tr>
          <td>割引料金<input type="text" class="discount_input" name="discount_input"></td>
          <td>割引率　<input class="percentage" type="text" readonly disabled name="percentage">%</td>
          <td colspan="2"> </td>
        </tr>
        <tr>
          <td>内容</td>
          <td>単価</td>
          <td>個数</td>
          <td>合計</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <div>
      <p>小計</p>
      <input type="text" class="sub_total" readonly name="sub_total">
      <p>割引後　備品その他合計</p>
      <input class="after_dicsount" type="text" readonly name="after_dicsount">
      <p>消費税</p>
      <input class="tax" type="text" readonly name="tax">
      <p>請求総額</p>
      <input class="total" type="text" readonly name="total">
    </div>

    {{-- <div class="btn_wrapper">
      <p class="text-center">確認する</p>
    </div> --}}

    {{-- <div class="btn_wrapper">
      <p class="text-center"><a class="more_btn_lg">予約一覧へもどる</a></p>
    </div> --}}

  </div>
</div>
</div>

<input type="submit" value="確認する">
{{ Form::close() }}



<script>
  $(function(){
      // プラス・マイナス押下アクション
    $(document).on("click", ".add", function() {
      var target =$(this).parent().parent();
      target.clone(true).insertAfter(target);
      console.log(target.parent());
      target.parent().find('tr').last().find('td').eq(0).find('input').val('');
      target.parent().find('tr').last().find('td').eq(1).find('input').val('');
      target.parent().find('tr').last().find('td').eq(2).find('input').val('');
    })
    $(document).on("click", ".del", function() {
      var master =$(this).parent().parent().parent().find('tr').length;
      var target =$(this).parent().parent();
      if (master>1) {
        target.remove();
      }
    })

    $('.discount_input').on('change',function(){
      var discount=$(this).val();
      var sub_total=$('.sub_total').val();
      var after_discount=$('.after_dicsount').val();
      var percentage = Math.floor((discount/sub_total)*100);
      $('.selected_discount').remove();
      var data = "<tr class='selected_discount'><td>割引料金</td><td>"+(-discount)+"</td><td>1</td><td>"+(-discount)+"</td></tr>"

      if (discount>0) {
        $('.percentage').val(percentage);
        $('.result_table tbody').append(data);
        $('.after_dicsount').val(Math.floor(sub_total-discount));
        $('.tax').val(Math.floor((sub_total-discount)*0.1));
        $('.total').val(Math.floor(Number($('.tax').val())+Number($('.after_dicsount').val())));
      }else{
        $('.percentage').val('');
        $('.selected_discount').remove();
        $('.after_dicsount').val(Math.floor(sub_total));
        $('.tax').val(Math.floor((sub_total)*0.1));
        $('.total').val('');
        $('.total').val(Math.floor(Number(sub_total)+Number((sub_total)*0.1)));
      }
      

    })

  })
</script>



@endsection