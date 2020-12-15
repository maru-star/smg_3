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
$(function () {
  $('.venue_discount_percent').on('change', function () {
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
    }
  })
})


$(function () {
  $('.venue_dicsount_number').on('change', function () {
    var input_number = $(this).val();
    var calc_target = $('.venue_extend').text();
    var minus_result = Number(calc_target) - Number(input_number);
    alert(minus_result);
    var result_percent = (Number(input_number) / Number(calc_target)) * 100;
    alert(result_percent);
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
    } else {
      $('.number_result').text('');
      $('.after_discount_price').text('');
      $('.after_discount_price').text(calc_target);
      if ($('.venue_price_details table tbody tr').hasClass('discount_input_number')) {
        $('.discount_input_number').remove(); //初期化
      } else {
        $('.discount_input_number').remove(); //初期化
      }

    }
  })
})

