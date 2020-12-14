
// reservation create　会場選択からの備品取得
// 以下参考
// https://niwacan.com/1619-laravel-ajax/
$(function () {
  // 会場選択トリガー
  $('#venues_selector').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    ajaxGetItems(venue_id);
    // ajaxGetSalesHours(venue_id, dates);　管理者は24時間予約登録可能。そのため一旦、本機能停止
    ajaxGetPriceStstem(venue_id);
  });

  // 日付選択トリガー
  $('#datepicker1').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    ajaxGetItems(venue_id);
    // ajaxGetSalesHours(venue_id, dates);　管理者は24時間予約登録可能。そのため一旦、本機能停止
  });

  // 計算するボタン押下トリガー
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
          $('.equipemnts table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='number' value='0' min=0 name='equipemnt" + value['id'] + "' class='form-control'></td></tr>");
        });
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
        $('#fullOverlay').css('display', 'none');
        console.log($details);
        $('.carculete_result').text($details);
      })
      .fail(function ($details) {
        $('#fullOverlay').css('display', 'none');
        console.log('失敗したよ');
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
        console.log($each);
      })
      .fail(function ($each) {
        $('#fullOverlay').css('display', 'none');
        console.log('失敗した!!!!');
      });
  };
});
















