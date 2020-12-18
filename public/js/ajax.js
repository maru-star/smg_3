// reservation create　会場選択からの備品取得
// 以下参考
// https://niwacan.com/1619-laravel-ajax/
$(function () {
  // 会場選択トリガー
  $('#venues_selector').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    $('#sales_start').val(0);
    $('#sales_finish').val(0);
    ajaxGetItems(venue_id);
    // ajaxGetSalesHours(venue_id, dates);　管理者は24時間予約登録可能。そのため一旦、本機能停止
    ajaxGetPriceStstem(venue_id);
    ajaxGetLayout(venue_id); //レイアウトが存在するかしないか、　"0"か"1"でreturn
    ajaxGetLuggage(venue_id); //会場に荷物預かりが存在するかしないか、　"0"か"1"でreturn
  });

  // 日付選択トリガー
  $('#datepicker1').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    // ajaxGetItems(venue_id);
    // ajaxGetSalesHours(venue_id, dates);　管理者は24時間予約登録可能。そのため一旦、本機能停止
  });

  /*--------------------------------------------------
  // 計算するボタン押下トリガー
  --------------------------------------------------*/
  $('#calculate').on('click', function () {
    var venue_id = $('#venues_selector').val();
    var radio_val = $('input:radio[name="price_system"]:checked').val();
    var start_time = $('#sales_start').val();
    var finish_time = $('#sales_finish').val();
    ajaxGetPriceDetails(venue_id, radio_val, start_time, finish_time); //料金計算

    // 備品の数取得
    var equipemnts_array = [];
    var equipemnts_length = $('.equipemnts table tbody tr').length;
    for (let equipemnts_index = 0; equipemnts_index < equipemnts_length; equipemnts_index++) {
      var e_target = $('.equipemnts table tbody tr').eq(equipemnts_index).find('input').val();
      equipemnts_array.push(e_target);
    }

    // サービスの数取得
    var services_array = [];
    var services_length = $('.services table tbody tr').length;
    for (let services_index = 0; services_index < services_length; services_index++) {
      var s_target = $('.services table tbody tr').eq(services_index).find("input:radio[name='" + 'service' + (services_index + 1) + "']:checked").val();
      services_array.push(s_target);
    }
    ajaxGetItemsDetails(venue_id, equipemnts_array, services_array);

    // レイアウト金額取得
    var layout_prepare = $('input:radio[name="layout_prepare"]:checked').val();
    var layout_clean = $('input:radio[name="layout_clean"]:checked').val();
    ajaxGetLayoutPrice(venue_id, layout_prepare, layout_clean);


    // 割引入力部分、全部初期化
    $('.venue_discount_percent').val('');
    $('.venue_dicsount_number').val('');
    $('.discount_item').val('');
    $('.layout_discount').val('');


    // 関数処理の順番にばらつきがあるので、１秒後に実行
    setTimeout(function () {
      // 総請求額反映用
      var all_total_venue = Number($('.venue_extend').text()); //会場料　税抜　料金　（割引反映前）
      var all_total_items = Number($('.selected_items_total').text()); //備品　その他　税抜　料金　（割引反映前）
      var all_total_layouts = Number($('.layout_total').text()); //備品　その他　税抜　料金　（割引反映前）
      var all_totals = all_total_venue + all_total_items + all_total_layouts;
      var only_tax = Number(all_totals) * 0.1;
      $('.all-total-without-tax').text(all_totals);
      $('.all-total-tax').text(only_tax);
      $('.all-total-amout').text(Number(all_totals) + Number(only_tax));
    }, 1000);
  });

  // 備品とサービス取得ajax
  function ajaxGetItems($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/geteitems',
      type: 'POST',
      data: { 'venue_id': $venue_id, 'text': 'Ajax成功' },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($items) {
        $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html(''); //一旦初期会
        $.each($items[0], function (index, value) {
          // ココで備品取得
          $('.equipemnts table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='text' value='0' min=0 name='equipemnt" + value['id'] + "' class='form-control'></td></tr>");
        });
        // ***********マイナス、全角制御用
        // $("input[name^='equipemnt']").numeric({ negative: false, });
        $("input[name^='equipemnt']").on('change', function () {
          charactersChange($(this));
        })
        charactersChange = function (ele) {
          var val = ele.val();
          var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });
          if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
            $(ele).val(han);
          }
        }
        // ***********マイナス、全角制御用

        $('.services table tbody').html('');
        $.each($items[1], function (index, value) {
          // ココでサービス取得
          // 有り・無しに変更するため以下コメントアウト
          // $('.services table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='number' value='0' max='1' min='0' name='" + value['id'] + "' class='form-control'></td></tr>");
          $('.services table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='radio' value='1' name='service" + value['id'] + "'>有り<input type='radio' value='0' name='service" + value['id'] + "' checked>無し</td></tr>");
        });
      })
      .fail(function (data) {
        $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html('');
        $('.services table tbody').html('');
        console.log("item失敗");
      });
  };


  // 営業時間取得
  // 管理者は24時間予約登録可能。そのため一旦、本機能停止
  // function ajaxGetSalesHours($venue_id, $dates) {
  //   $.ajax({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     },
  //     url: '/admin/reservations/getsaleshours',
  //     type: 'POST',
  //     data: { 'venue_id': $venue_id, 'dates': $dates },
  //     dataType: 'json',
  //     beforeSend: function () {
  //       $('#fullOverlay').css('display', 'block');
  //     },
  //   })
  //     .done(function ($times) {
  //       $('#fullOverlay').css('display', 'none');
  //       $('#sales_start').html('');//初期化
  //       $('#sales_finish').html('');//初期化
  //       $('#event_start').html('');//初期化
  //       $('#event_finish').html(''); //初期化

  //       var $time_start = new Date($times[0]);
  //       var $time_finish = new Date($times[1]);
  //       for (let index = $time_start.getHours(); index <= $time_finish.getHours(); index++) {
  //         $('#sales_start').append("<option value='" + ("0" + index).slice(-2) + ":00:00" + "'>" + ("0" + index).slice(-2) + ":00" + "</option>");
  //         $('#sales_finish').append("<option value='" + ("0" + index).slice(-2) + ":00:00" + "'>" + ("0" + index).slice(-2) + ":00" + "</option>");
  //         $('#event_start').append("<option value='" + ("0" + index).slice(-2) + ":00:00" + "'>" + ("0" + index).slice(-2) + ":00" + "</option>");
  //         $('#event_finish').append("<option value='" + ("0" + index).slice(-2) + ":00:00" + "'>" + ("0" + index).slice(-2) + ":00" + "</option>");
  //       }
  //     })
  //     .fail(function ($start, $$finish) {
  //       $('#fullOverlay').css('display', 'none');
  //       $('#sales_start').html('');//初期化
  //       $('#sales_finish').html('');//初期化
  //       $('#event_start').html('');//初期化
  //       $('#event_finish').html(''); //初期化
  //     });
  // };

  // 料金体系取得
  function ajaxGetPriceStstem($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getpricesystem',
      type: 'POST',
      data: { 'venue_id': $venue_id },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($prices) {
        $('#fullOverlay').css('display', 'none');
        $('.price_selector').html(''); //一旦初期化
        // if ($prices[0] != 0 && $prices[1] != 0) {
        //   $('.price_selector').append("<div> <small>※料金体系を選択してください</small> </div> <div class='form-inline'> <small class='mr-4'><input type='radio' name='price_system' value='1' checked='checked'>通常(枠貸し)</small> <small><input type='radio' name='price_system' value=' 2'>アクセア(時間貸し)</small> </div>")
        // } else if ($prices[0] == 0 && $prices[1] == 0) {
        //   swal('登録された料金体系がありません。会場管理/料金管理 にて作成してください');
        // }
        // else {
        //   $('.price_selector').html('');
        // }
        if ($prices[0].length > 0 && $prices[1].length > 0) { //配列の空チェック
          //どちらも配列ある
          $('.price_selector').append("<div> <small>※料金体系を選択してください</small> </div> <div class='form-inline'> <small class='mr-4'><input type='radio' name='price_system' value='1'>通常(枠貸し)</small> <small><input type='radio' name='price_system' value=' 2'>アクセア(時間貸し)</small> </div>")
        } else if ($prices[0].length > 0 && $prices[1].length == 0) {
          //時間枠がある・アクセアがない
          $('.price_selector').append("<div> <small>※料金体系</small> </div> <div class='form-inline'> <small class='mr-4'><input type='radio' name='price_system' value='1' checked='checked'>通常(枠貸し)</small></div>")
        } else if ($prices[0].length == 0 && $prices[1].length > 0) {
          //時間枠がない・アクセアがある
          $('.price_selector').append("<div> <small>※料金体系</small> </div> <div class='form-inline'> <small class='mr-4'><input type='radio' name='price_system' value='2' checked='checked'>アクセア(時間貸し)</small></div>")
        } else {
          // どちらも配列がない
          swal('選択した会場は登録された料金体系がありません。会場管理/料金管理 にて作成してください');
        }
      })
      .fail(function ($prices) {
        $('#fullOverlay').css('display', 'none');
        $('.price_selector').html('');
        console.log('失敗したよ');
      });
  };

  // 料金詳細　取得
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
        console.log($details);
        $('.venue_extend').text('');
        $('.extend').text('');
        $('.venue_price').text('');
        $('.after_discount_price').text('');
        $('.venue_subtotal').text(''); //小計
        $('.venue_tax').text(''); //消費税
        $('.venue_total').text(''); //会場合計料金
        $('.venue_extend').text(venue_extend_price);
        $('.extend').text(extend_price);
        $('.venue_price').text(venue_extend_price - extend_price);
        $('.after_discount_price').text(venue_extend_price);
        if ((extend_price) == 0) {
          $('.venue_price_details table tbody').html('');
          $('.venue_price_details table tbody').append("<tr><td>" + '会場料金' + "</td><td>" + venue_extend_price + "</td><td>" + '1' + "</td><td>" + venue_extend_price + "</td></tr>");
          $('.after_discount_price').text(venue_extend_price);
          $('.venue_subtotal').text(venue_extend_price); //小計
          $('.venue_tax').text(Number((venue_extend_price)) * 0.1); //消費税
          $('.venue_total').text(Number((venue_extend_price)) + (Number(venue_extend_price * 0.1))); //会場合計料金
        } else {
          $('.venue_price_details table tbody').html('');
          $('.venue_price_details table tbody').append("<tr><td>" + '会場料金' + "</td><td>" + ((venue_extend_price) - (extend_price)) + "</td><td>" + '1' + "</td><td>" + ((venue_extend_price) - (extend_price)) + "</td></tr>");
          $('.venue_price_details table tbody').append("<tr><td>" + '延長料金' + "</td><td>" + extend_price + "</td><td>" + extend_time + "H</td><td>" + extend_price + "</td></tr>");
          $('.after_discount_price').text(venue_extend_price);
          $('.venue_subtotal').text(venue_extend_price); //小計
          $('.venue_tax').text(Number(venue_extend_price) * 0.1); //消費税
          $('.venue_total').text(Number(venue_extend_price) + (Number(venue_extend_price * 0.1))); //会場合計料金
        }
      })
      .fail(function ($details) {
        $('#fullOverlay').css('display', 'none');
        swal('料金の取得に失敗しました', '入退室時間が08:00~23:00で入力した場合はページをリロードし再度条件を変え再計算してください。もし08:00~23:00以外で入力した場合は、そのまま進み会場料金を手入力してください');
        $('.venue_extend').text('');
        $('.extend').text('');
        $('.venue_price').text('');
        $('.after_discount_price').text('');
        $('.venue_subtotal').text(''); //小計
        $('.venue_tax').text(''); //消費税
        $('.venue_total').text(''); //会場合計料金
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

  // 備品＆サービス　料金取得
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
        $('.selected_services_price').text(''); //有料サービス料金初期化
        $('.selected_items_total').text(''); //有料備品＆有料サービス合計初期化
        $('.items_discount_price').text(''); //割引後 会場料金合計初期化
        $('.items_subtotal').text(''); //小計初期化
        $('.items_tax').text(''); //消費税初期化
        $('.all_items_total').text('');　//請求総額初期化
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
        $('.selected_services_price').text($each[0][4]);
        $('.selected_luggage_price').text(luggage_target);
        $('.selected_items_total').text(Number($each[0][0]) + Number(luggage_target));
        $('.items_discount_price').text(Number($each[0][0]) + Number(luggage_target));
        $('.items_subtotal').text(Number($each[0][0]) + Number(luggage_target));
        $('.items_tax').text((Number($each[0][0]) + Number(luggage_target)) * 0.1);
        $('.all_items_total').text((Number($each[0][0]) + Number(luggage_target)) + ((Number($each[0][0]) + Number(luggage_target)) * 0.1));
      })
      .fail(function ($each) {
        $('#fullOverlay').css('display', 'none');
        console.log('備品又はサービスの料金取得に失敗しました。ページをリロードし再度試して下さい');
      });
  };

  // レイアウト有りなし判別
  function ajaxGetLayout($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getlayout',
      type: 'POST',
      data: {
        'venue_id': $venue_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($result) {
        $('#fullOverlay').css('display', 'none');
        console.log($result);
        $('.layouts table tbody').html(''); //初期化
        $result == 1 ? $('.layouts table tbody').append("<tr><td>レイアウト準備</td><td><input type='radio' name='layout_prepare' value='1'>有り<input type='radio' name='layout_prepare' value='0' checked >無し</td></tr><tr><td>レイアウト片付</td><td><input type='radio' name='layout_clean' value='1'>有り<input type='radio' name='layout_clean' value='0'checked>無し</td></tr>") : $('.layouts table tbody').append('<tr><td>該当会場はレイアウト変更を受け付けていません</td></tr>');
      })
      .fail(function ($result) {
        $('#fullOverlay').css('display', 'none');
        swal('レイアウトの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };

  // レイアウト金額取得
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
        $('.layout_clean_result').text('');
        $('.layout_total').text('');
        $('.layout_subtotal').text('');
        $('.layout_tax').text('');
        $('.layout_total_amount').text('');
        $('.layout_prepare_result').text($result[0][0][0]); //レイアウト準備
        $('.layout_clean_result').text($result[0][1][0]); //レイアウト片付け
        $('.layout_total').text($result[1]);
        $('.layout_subtotal').text($result[1]);
        $('.layout_tax').text(Number($result[1]) * 0.1);
        $('.layout_total_amount').text((Number($result[1]) * 0.1) + (Number($result[1])));
        $('.after_duscount_layouts').text($result[1]);
      })
      .fail(function ($result) {
        $('#fullOverlay').css('display', 'none');
        swal('レイアウトの金額取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };


  // 荷物預かり　有りなし判別
  function ajaxGetLuggage($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getluggage',
      type: 'POST',
      data: {
        'venue_id': $venue_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($luggage) {
        if ($luggage == 1) {
          console.log('荷物', "ある");
          $('.luggage table tbody').html('');
          $('.luggage table tbody').append("<tr> <td>事前に預かる荷物<br>（個数）</td> <td class=''><input type='text' class='form-control luggage_count' placeholder='個数入力' name='luggage_count'></td> </tr> <tr> <td>事前荷物の到着日<br>午前指定のみ</td> <td class=''> <input id='datepicker3' type='text' class='form-control' placeholder='年-月-日' name='luggage_arrive'> </td> </tr> <tr> <td>事後返送する荷物</td> <td class=''><input type='text' class='form-control luggage_return' placeholder='個数入力' name='luggage_return'></td> </tr> <tr><td>荷物預かり/返送　料金</td><td class=''><input type='text' class='form-control luggage_price' placeholder='金額入力' name='luggage_price'></td></tr><script>$('#datepicker3').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, });</script>");
          // ***********マイナス、全角制御用
          // $(".luggage_count, .luggage_return").numeric({ negative: false, });
          $(".luggage_count, .luggage_return, .luggage_price").on('change', function () {
            charactersChange($(this));
          })
          charactersChange = function (ele) {
            var val = ele.val();
            var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });
            if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
              $(ele).val(han);
            }
          }
          // ***********マイナス、全角制御用

        } else {
          $('.luggage table tbody').html('');
          $('.luggage table tbody').append("<tr><td class='colspan='2''>該当会場は荷物預かりを受け付けていません</td></tr>");
        }
      })
      .fail(function ($luggage) {
        $('#fullOverlay').css('display', 'none');
        swal('荷物預かりの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };
















































});
















