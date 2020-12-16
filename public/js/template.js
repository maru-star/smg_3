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


