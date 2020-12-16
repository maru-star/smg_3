$(function () {
  $('#equipment_id').multiSelect();
  $('#service_id').multiSelect();
});


$(function () {
  // 日付選択画面にてボックス内、検索機能
  $('#venue_id').select2({
    // placeholder: 'Select an option'
  });
});

$(function () {
  // 日付選択画面にてボックス内、検索機能
  $('#user_select').select2({
    // placeholder: 'Select an option'
  });
});

// datepicker
$(function () {
  $('#datepicker1').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0,
  });
  $('#datepicker2').datepicker({
    dateFormat: 'yy-mm-dd',
  });
});

// reservatiosn create の時間取得
// 一旦やめる。別の予約が入っていないか制御する必要あり
$(function () {
  $('#timepicker1').wickedpicker({
    now: "12:00", //hh：mm 24時間形式のみ、デフォルトは現在時刻
    twentyFour: true, //24時間形式を表示します。デフォルトはfalseです。
    title: '時間入力', //Wickedpickerのタイトル
    minutesInterval: 30, //分間隔を変更します。デフォルトは1です。  
  });
  $('#timepicker2').wickedpicker({
    now: "12:00", //hh：mm 24時間形式のみ、デフォルトは現在時刻
    twentyFour: true, //24時間形式を表示します。デフォルトはfalseです。
    title: '時間入力', //Wickedpickerのタイトル
    minutesInterval: 30, //分間隔を変更します。デフォルトは1です。  
  });
});


// reservation create 日付選択後、会場選択表示
$(function () {
  $('#datepicker1').on('change', function () {
    if ($(this).val() === "") {
      $('#venues_selector').addClass('hide');
    } else {
      $('#venues_selector').removeClass('hide');
    }
  })
});


// reservation create 会場の割引入力　制御
// 割引率
$(function () {
  $('.venue_discount_percent').on('change', function () {
    // 割引率が入力されたら割引額を初期化
    $('.venue_dicsount_number').val(''); //割引料金
    $('.number_result').text(''); //割引料金に紐づく割引率
    $('.after_discount_price').text(''); //割引後 会場料金合計
    $('.discount_input_number').remove(); //料金内訳に追記されたもの

    $('.venue_subtotal').text(''); //小計初期化
    $('.venue_tax').text(''); //消費税初期化
    $('.venue_total').text(''); //請求総額初期化


    var input_percent = ($(this).val() / 100);
    var calc_target = $('.venue_extend').text();
    var minus_result = calc_target * -input_percent;
    var after_discounts = (Number(calc_target) + Number(minus_result));
    if (input_percent != 0 || input_percent != '') {
      $('.percent_result').text(calc_target * input_percent);
      var input_target = "<tr class='discount_input'><td>割引料金</td><td style='color:red;'>" + (calc_target * -input_percent) + "</td><td>" + ($(this).val()) + "%</td><td style='color:red;'>" + (calc_target * -input_percent) + "</td></tr>"
      if ($('.venue_price_details table tbody tr').hasClass('discount_input')) {
        $('.discount_input').remove(); //初期化
        $('.venue_price_details table tbody').append(input_target);
        $('.after_discount_price').text('');
        $('.after_discount_price').text(after_discounts);
      } else {
        $('.venue_price_details table tbody').append(input_target);
        $('.after_discount_price').text(after_discounts);
      }
      // 小計、消費税、最終の請求総額に反映
      $('.venue_subtotal').text(after_discounts);
      $('.venue_tax').text((Number(after_discounts) * 0.1));
      $('.venue_total').text(Number(after_discounts) + (Number(after_discounts) * 0.1));
    } else {
      $('.percent_result').text('');
      if ($('.venue_price_details table tbody tr').hasClass('discount_input')) {
        $('.discount_input').remove();
        $('.after_discount_price').text('');
        $('.after_discount_price').text(after_discounts);
      } else {
        $('.venue_price_details table tbody').append(input_target);
        $('.after_discount_price').text('');
        $('.after_discount_price').text(after_discounts);
      }
      // 小計、消費税、最終の請求総額に反映
      $('.venue_subtotal').text($('.venue_extend').text());
      $('.venue_tax').text((Number($('.venue_extend').text())) * 0.1);
      $('.venue_total').text(Number($('.venue_extend').text()) + (Number($('.venue_extend').text())) * 0.1);
    }
  })
})

// reservation create 会場の割引入力　制御
// 割引料金
$(function () {
  $('.venue_dicsount_number').on('change', function () {

    // 割引料金が入力されたら割引率を初期化
    $('.venue_discount_percent').val(''); //割引料金
    $('.percent_result').text(''); //割引料金に紐づく割引率
    $('.after_discount_price').text(''); //割引後 会場料金合計
    $('.discount_input').remove(); //料金内訳に追記されたもの
    $('.venue_subtotal').text(''); //小計初期化
    $('.venue_tax').text(''); //消費税初期化
    $('.venue_total').text(''); //請求総額初期化

    var input_number = $(this).val();
    var calc_target = $('.venue_extend').text();
    var minus_result = Number(calc_target) - Number(input_number);
    var result_percent = (Number(input_number) / Number(calc_target)) * 100;
    if (input_number != 0 || input_number != '') {
      var input_target = "<tr class='discount_input_number'><td>割引料金</td><td style='color:red;'>" + (-input_number) + "</td><td>" + '1' + "</td><td style='color:red;'>" + (-input_number) + "</td></tr>"
      $('.number_result').text('');
      $('.number_result').text(Math.round(result_percent));
      $('.after_discount_price').text('');
      $('.after_discount_price').text(minus_result);
      if ($('.venue_price_details table tbody tr').hasClass('discount_input_number')) {
        $('.discount_input_number').remove(); //初期化
        $('.venue_price_details table tbody').append(input_target);
      } else {
        $('.venue_price_details table tbody').append(input_target);
      }
      // 小計、消費税、最終の請求総額に反映
      $('.venue_subtotal').text(minus_result);
      $('.venue_tax').text((Number(minus_result) * 0.1));
      $('.venue_total').text(Number(minus_result) + (Number(minus_result) * 0.1));
    } else {
      $('.number_result').text('');
      $('.after_discount_price').text('');
      $('.after_discount_price').text(calc_target);
      if ($('.venue_price_details table tbody tr').hasClass('discount_input_number')) {
        $('.discount_input_number').remove(); //初期化
      } else {
        $('.discount_input_number').remove(); //初期化
      }
      // 小計、消費税、最終の請求総額に反映
      $('.venue_subtotal').text($('.venue_extend').text());
      $('.venue_tax').text((Number($('.venue_extend').text())) * 0.1);
      $('.venue_total').text(Number($('.venue_extend').text()) + (Number($('.venue_extend').text())) * 0.1);
    }
  })
})


// reservation create 備品&サービス
// 割引料金
$(function () {
  $('.discount_item').on('change', function () {

    var input_number = $(this).val();
    var calc_target = $('.selected_items_total').text();
    var minus_result = Number(calc_target) - Number(input_number); //割引後の料金
    var result_percent = (Number(input_number) / Number(calc_target)) * 100;　//割引した割合を算出
    if (input_number != 0 || input_number != '') {
      var input_target = "<tr class='discount_input_number_items'><td>割引料金</td><td style='color:red;'>" + (-input_number) + "</td><td>" + '1' + "</td><td style='color:red;'>" + (-input_number) + "</td></tr>"
      $('.item_discount_percent').text('');
      $('.item_discount_percent').text(Math.round(result_percent));
      $('.items_discount_price').text('');
      $('.items_discount_price').text(minus_result);
      if ($('.items_equipments table tbody tr').hasClass('discount_input_number_items')) {
        $('.discount_input_number_items').remove(); //初期化
        $('.items_equipments table tbody').append(input_target);
      } else {
        $('.items_equipments table tbody').append(input_target);
      }
      // 小計、消費税、最終の請求総額に反映
      $('.items_subtotal').text(minus_result);
      $('.items_tax').text((Number(minus_result) * 0.1));
      $('.all_items_total').text(Number(minus_result) + (Number(minus_result) * 0.1));
    } else {
      $('.item_discount_percent').text('');
      $('.after_discount_price').text('');
      $('.items_discount_price').text(calc_target);
      if ($('.items_equipments table tbody tr').hasClass('discount_input_number_items')) {
        $('.discount_input_number_items').remove(); //初期化
      } else {
        $('.discount_input_number_items').remove(); //初期化
      }
      // 小計、消費税、最終の請求総額に反映
      $('.items_subtotal').text($('.items_discount_price').text());
      $('.items_tax').text((Number($('.items_discount_price').text())) * 0.1);
      $('.all_items_total').text(Number($('.items_discount_price').text()) + (Number($('.items_discount_price').text())) * 0.1);
    }
  })
})





// numeric マイナス制御
// フォーカスアウトしたら全角を半角に
$(function () {
  $(".venue_discount_percent, .venue_dicsount_number, .discount_item").numeric({ negative: false, });
  $(".venue_discount_percent, .venue_dicsount_number, .discount_item").on('change', function () {
    charactersChange($(this));
  })

  charactersChange = function (ele) {
    var val = ele.val();
    var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });

    if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
      $(ele).val(han);
    }
  }
});

// プラスマイナスボタン
$(function () {
  $('.equipemnts .icon_minus').on('click', function () {
    $('.equipemnts table tbody').slideUp();
    $('.equipemnts .icon_minus').addClass('hide');
    $('.equipemnts .icon_plus').removeClass('hide');
  })
  $('.equipemnts .icon_plus').on('click', function () {
    $('.equipemnts table tbody').slideDown();
    $('.equipemnts .icon_plus').addClass('hide');
    $('.equipemnts .icon_minus').removeClass('hide');
  })
  $('.services .icon_minus').on('click', function () {
    $('.services table tbody').slideUp();
    $('.services .icon_minus').addClass('hide');
    $('.services .icon_plus').removeClass('hide');
  })
  $('.services .icon_plus').on('click', function () {
    $('.services table tbody').slideDown();
    $('.services .icon_plus').addClass('hide');
    $('.services .icon_minus').removeClass('hide');
  })

})