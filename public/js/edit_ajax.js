// reservation create　会場選択からの備品取得// 以下参考// https://niwacan.com/1619-laravel-ajax/
$(function () {
  // ロードトリガー
  var reserve_date = $('input[name="reserve_date"]').val();
  var venue_id = $('[name="venue_id"] option:selected').val();
  var price_system = $("input[name='price_system']:checked").val();
  var enter_time = $('[name="enter_time"] option:selected').val();
  var leave_time = $('[name="leave_time"] option:selected').val();
  var user = $('[name="user_id"] option:selected').val(); //userのidが返ってくる

  var equipemnts_array = [];
  var equipemnts_length = $('.equipemnts table tbody tr').length;
  for (let equipemnts_index = 0; equipemnts_index < equipemnts_length; equipemnts_index++) {
    var e_target = $('.equipemnts table tbody tr').eq(equipemnts_index).find('input').val();
    equipemnts_array.push(e_target);
  }

  var services_array = [];
  var services_length = $('.services table tbody tr').length;
  for (let services_index = 0; services_index < services_length; services_index++) {
    var s_target = $('.services table tbody tr').eq(services_index).find("input:radio[name='" + 'services' + (services_index) + "']:checked").val();
    services_array.push(s_target);
  }

  var layout_prepare = $("input[name='layout_prepare']:checked").val();
  var layout_clean = $("input[name='layout_clean']:checked").val();

  ajaxGetPriceDetails(venue_id, price_system, enter_time, leave_time);
  ajaxGetItemsDetails(venue_id, equipemnts_array, services_array);
  ajaxGetLayoutPrice(venue_id, layout_prepare, layout_clean);

  setTimeout(function () {
    var venue_subtotal = Number($('.venue_subtotal').val());
    var items_subtotal = Number($('.items_subtotal').val());
    var layout_subtotal = Number($('.layout_subtotal').val());
    var result = venue_subtotal + items_subtotal + layout_subtotal;
    console.log(result.toLocaleString());
    $('.all-total-without-tax').text(result.toLocaleString());
  }, 1000);

});




function ajaxGetPriceDetails($venue_id, $status, $start, $finish) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getpricedetails',
    type: 'POST',
    data: {
      'venue_id': $venue_id,
      'status': $status,
      'start': $start,
      'finish': $finish,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($details) {
      // 手入力部分は初期化
      $('#handinput_venue').val('');
      $('#handinput_extend').val('');
      $('#handinput_discount').val('');
      $('#handinput_subtotal').text('');
      $('#handinput_tax').text('');
      $('#handinput_total').text('');
      $('.hand_input').hasClass('hide') ? '' : $('.hand_input').addClass('hide');
      $('.bill-bg').hasClass('hide') ? $('.bill-bg').removeClass('hide') : '';
      //[0]は合計料金, [1]は延長料金, [2]は利用時間, [3]は延長時間
      var venue_extend_price = ($details[0][0]);
      var extend_price = ($details[0][1]);
      var usage = ($details[0][2]);
      var extend_time = ($details[0][3]);
      $('#fullOverlay').css('display', 'none');
      $('.venue_extend').text('');
      $('.extend').text('');
      $('.extend').val('');
      $('.venue_price').text('');
      $('.venue_price').val('');
      $('.after_discount_price').text('');
      $('.after_discount_price').val('');
      $('.venue_subtotal').text(''); //小計
      $('.venue_subtotal').val(''); //小計
      $('.venue_tax').text(''); //消費税
      $('.venue_tax').val(''); //消費税
      $('.venue_total').text(''); //会場合計料金
      $('.venue_total').val(''); //会場合計料金
      $('.venue_extend').text(venue_extend_price);
      $('.extend').text(extend_price);
      $('.extend').val(extend_price);
      $('.venue_price').text(venue_extend_price - extend_price);
      $('.venue_price').val(venue_extend_price - extend_price);
      $('.after_discount_price').text(venue_extend_price);
      $('.after_discount_price').val(venue_extend_price);
      if ((extend_price) == 0) {
        $('.venue_price_details table tbody').html('');
        $('.venue_price_details table tbody').append("<tr><td>" + '会場料金' + "</td><td>" + venue_extend_price + "</td><td>" + '1' + "</td><td>" + venue_extend_price + "</td></tr>");
        $('.after_discount_price').text(venue_extend_price);
        $('.after_discount_price').val(venue_extend_price);
        $('.venue_subtotal').text(venue_extend_price); //小計
        $('.venue_subtotal').val(venue_extend_price); //小計
        $('.venue_tax').text(Math.floor(Number((venue_extend_price)) * 0.1)); //消費税
        $('.venue_tax').val(Math.floor(Number((venue_extend_price)) * 0.1)); //消費税
        $('.venue_total').text(Number((venue_extend_price)) + (Math.floor(Number(venue_extend_price * 0.1)))); //会場合計料金
        $('.venue_total').val(Number((venue_extend_price)) + (Math.floor(Number(venue_extend_price * 0.1)))); //会場合計料金
      } else {
        $('.venue_price_details table tbody').html('');
        $('.venue_price_details table tbody').append("<tr><td>" + '会場料金' + "</td><td>" + ((venue_extend_price) - (extend_price)) + "</td><td>" + '1' + "</td><td>" + ((venue_extend_price) - (extend_price)) + "</td></tr>");
        $('.venue_price_details table tbody').append("<tr><td>" + '延長料金' + "</td><td>" + extend_price + "</td><td>" + extend_time + "H</td><td>" + extend_price + "</td></tr>");
        $('.after_discount_price').text(venue_extend_price);
        $('.after_discount_price').val(venue_extend_price);
        $('.venue_subtotal').text(venue_extend_price); //小計
        $('.venue_subtotal').val(venue_extend_price); //小計
        $('.venue_tax').text(Math.floor(Number(venue_extend_price) * 0.1)); //消費税
        $('.venue_tax').val(Math.floor(Number(venue_extend_price) * 0.1)); //消費税
        $('.venue_total').text(Number(venue_extend_price) + (Math.floor(Number(venue_extend_price * 0.1)))); //会場合計料金
        $('.venue_total').val(Number(venue_extend_price) + (Math.floor(Number(venue_extend_price * 0.1)))); //会場合計料金
      }
    })
    .fail(function ($details) {
      $('#fullOverlay').css('display', 'none');
      swal("料金の取得に失敗しました.", '枠料金にて入退室時間が08:00~23:00で入力した場合はページをリロードし再度条件を変え再計算してください。もし08:00~23:00以外で入力した場合は、そのまま進み会場料金を手入力してください')
        .then((value) => {
          swal(`アクセア料金を選択し利用時間が15時間を超過した場合、そのまま進み会場料金を手入力してください`);
        });
      $('.venue_extend').text('');
      $('.extend').text('');
      $('.extend').val('');
      $('.venue_price').text('');
      $('.venue_price').val('');
      $('.after_discount_price').text('');
      $('.after_discount_price').val('');
      $('.venue_subtotal').text(''); //小計
      $('.venue_subtotal').val(''); //小計
      $('.venue_tax').text(''); //消費税
      $('.venue_tax').val(''); //消費税
      $('.venue_total').text(''); //会場合計料金
      $('.venue_total').val(''); //会場合計料金
      $('.venue_price_details table tbody').html('');
      $('.bill-bg').addClass('hide');
      $('.hand_input').removeClass('hide');
      $('#handinput_venue').val('');
      $('#handinput_extend').val('');
      $('#handinput_discount').val('');
      $('#handinput_subtotal').text('');
      $('#handinput_tax').text('');
      $('#handinput_total').text('');
    });
};



function ajaxGetItemsDetails($venue_id, $equipemnts, $services) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/geteitemsprices',
    type: 'POST',
    data: {
      'venue_id': $venue_id,
      'equipemnts': $equipemnts,
      'services': $services,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($each) {
      $('#fullOverlay').css('display', 'none');
      // ※$eachの[0][0]には備品とサービスの合計料金
      // ※$eachの[0][1]には連想配列で選択された備品の個数、単価、備品名
      // ※$eachの[0][2]には連想配列で選択されたサービスの個数、単価、備品名
      // ※$eachの[0][3]には備品の合計金額
      // ※$eachの[0][4]にはサービスの合計金額
      var count_equipments = ($each[0][1]).length;
      $('.items_equipments table tbody').html(''); //テーブル初期化
      $('.selected_equipments_price').text(''); //有料備品料金初期化
      $('.selected_equipments_price').val(''); //有料備品料金初期化
      $('.selected_services_price').text(''); //有料サービス料金初期化
      $('.selected_services_price').val(''); //有料サービス料金初期化
      $('.selected_items_total').text(''); //有料備品＆有料サービス合計初期化
      $('.selected_items_total').val(''); //有料備品＆有料サービス合計初期化
      $('.items_discount_price').text(''); //割引後 会場料金合計初期化
      $('.items_discount_price').val(''); //割引後 会場料金合計初期化
      $('.items_subtotal').text(''); //小計初期化
      $('.items_subtotal').val(''); //小計初期化
      $('.items_tax').text(''); //消費税初期化
      $('.items_tax').val(''); //消費税初期化
      $('.all_items_total').text('');　//請求総額初期化
      $('.all_items_total').val('');　//請求総額初期化
      $('.selected_luggage_price').text('');　//請求総額初期化
      $('.selected_luggage_price').val('');　//請求総額初期化
      for (let counter = 0; counter < count_equipments; counter++) {
        $('.items_equipments table tbody').append("<tr><td>" + $each[0][1][counter][0] + "</td><td>" + $each[0][1][counter][1] + "</td><td>" + $each[0][1][counter][2] + "</td><td>" + (($each[0][1][counter][1]) * ($each[0][1][counter][2])) + "</td></tr>");
      }
      var count_services = ($each[0][2]).length;
      for (let counter_s = 0; counter_s < count_services; counter_s++) {
        $('.items_equipments table tbody').append("<tr><td>" + $each[0][2][counter_s][0] + "</td><td>" + $each[0][2][counter_s][1] + "</td><td>" + $each[0][2][counter_s][2] + "</td><td>" + (($each[0][2][counter_s][1]) * ($each[0][2][counter_s][2])) + "</td></tr>");
      }
      //荷物の金額が入力したら反映
      var luggage_target = $('.luggage_price').val();
      luggage_target == 0 || luggage_target == '' ? 0 : luggage_target;
      if (luggage_target != 0 || luggage_target != '') {
        if ($('.items_equipments table tbody').hasClass('luggage_input_price')) {
          $('.luggage_input_price').remove();
          $('.items_equipments table tbody').append("<tr class='luggage_input_price'><td>" + '荷物預かり/返送' + "</td><td>" + luggage_target + "</td><td>" + '1' + "</td><td>" + luggage_target + "</td></tr>");
        } else {
          $('.items_equipments table tbody').append("<tr class='luggage_input_price'><td>" + '荷物預かり/返送' + "</td><td>" + luggage_target + "</td><td>" + '1' + "</td><td>" + luggage_target + "</td></tr>");
        }
      } else {
        $('.luggage_input_price').remove();
      }
      $('.selected_equipments_price').text($each[0][3]);
      $('.selected_equipments_price').val($each[0][3]);
      $('.selected_services_price').text($each[0][4]);
      $('.selected_services_price').val($each[0][4]);
      $('.selected_luggage_price').text(luggage_target);
      $('.selected_luggage_price').val(luggage_target);
      $('.selected_items_total').text(Number($each[0][0]) + Number(luggage_target));
      $('.selected_items_total').val(Number($each[0][0]) + Number(luggage_target));
      $('.items_discount_price').text(Number($each[0][0]) + Number(luggage_target));
      $('.items_discount_price').val(Number($each[0][0]) + Number(luggage_target));
      $('.items_subtotal').text(Number($each[0][0]) + Number(luggage_target));
      $('.items_subtotal').val(Number($each[0][0]) + Number(luggage_target));
      $('.items_tax').text(Math.floor((Number($each[0][0]) + Number(luggage_target)) * 0.1));
      $('.items_tax').val(Math.floor((Number($each[0][0]) + Number(luggage_target)) * 0.1));
      $('.all_items_total').text((Math.floor((Number($each[0][0]) + Number(luggage_target)) * 0.1)) + (Number($each[0][0]) + Number(luggage_target)));
      $('.all_items_total').val((Math.floor((Number($each[0][0]) + Number(luggage_target)) * 0.1)) + (Number($each[0][0]) + Number(luggage_target)));
    })
    .fail(function ($each) {
      $('#fullOverlay').css('display', 'none');
      console.log('備品又はサービスの料金取得に失敗しました。ページをリロードし再度試して下さい');
      $('.items_equipments table tbody').html(''); //テーブル初期化
      $('.selected_equipments_price').text(''); //有料備品料金初期化
      $('.selected_equipments_price').val(''); //有料備品料金初期化
      $('.selected_services_price').text(''); //有料サービス料金初期化
      $('.selected_services_price').val(''); //有料サービス料金初期化
      $('.selected_items_total').text(''); //有料備品＆有料サービス合計初期化
      $('.selected_items_total').val(''); //有料備品＆有料サービス合計初期化
      $('.items_discount_price').text(''); //割引後 会場料金合計初期化
      $('.items_discount_price').val(''); //割引後 会場料金合計初期化
      $('.items_subtotal').text(''); //小計初期化
      $('.items_subtotal').val(''); //小計初期化
      $('.items_tax').text(''); //消費税初期化
      $('.items_tax').val(''); //消費税初期化
      $('.all_items_total').text('');　//請求総額初期化
      $('.selected_luggage_price').text('');　//荷物アヅカリ
      $('.selected_luggage_price').val('');　//荷物アヅカリ
    });
};


function ajaxGetLayoutPrice($venue_id, $layout_prepare, $layout_clean) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getlayoutprice',
    type: 'POST',
    data: {
      'venue_id': $venue_id,
      'layout_prepare': $layout_prepare,
      'layout_clean': $layout_clean,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log($result[0]);
      $('.selected_layouts table tbody').html('');
      for (let s_layout = 0; s_layout < $result[0].length; s_layout++) {
        if ($result[0][s_layout] != '') {
          $('.selected_layouts table tbody').append("<tr><td>" + $result[0][s_layout][1] + "</td><td>" + $result[0][s_layout][0] + "</td><td>1</td><td>" + $result[0][s_layout][0] + "</td></tr>")
        }
      }
      $('.layout_prepare_result').text('');
      $('.layout_prepare_result').val('');
      $('.layout_clean_result').text('');
      $('.layout_clean_result').val('');
      $('.layout_total').text('');
      $('.layout_total').val('');
      $('.layout_subtotal').text('');
      $('.layout_subtotal').val('');
      $('.layout_tax').text('');
      $('.layout_tax').val('');
      $('.layout_total_amount').text('');
      $('.layout_total_amount').val('');
      $('.layout_prepare_result').text($result[0][0][0]); //レイアウト準備
      $('.layout_prepare_result').val($result[0][0][0]); //レイアウト準備
      $('.layout_clean_result').text($result[0][1][0]); //レイアウト片付け
      $('.layout_clean_result').val($result[0][1][0]); //レイアウト片付け
      $('.layout_total').text($result[1]);
      $('.layout_total').val($result[1]);
      $('.layout_subtotal').text($result[1]);
      $('.layout_subtotal').val($result[1]);
      $('.layout_tax').text(Math.floor(Number($result[1]) * 0.1));
      $('.layout_tax').val(Math.floor(Number($result[1]) * 0.1));
      $('.layout_total_amount').text((Math.floor(Number($result[1]) * 0.1)) + (Number($result[1])));
      $('.layout_total_amount').val((Math.floor(Number($result[1]) * 0.1)) + (Number($result[1])));
      $('.after_duscount_layouts').text($result[1]);
      $('.after_duscount_layouts').val($result[1]);
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      swal('レイアウトの金額取得に失敗しました。ページをリロードし再度試して下さい!!!!');
    });
};




