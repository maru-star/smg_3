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

// 会場管理　新規登録validation
$(function () {
  $("#VenuesCreateForm").validate({
    errorClass: "alert alert-danger", //エラー表示classをbootstrapのアラートに変える
    rules: {
      smg_url: {
        required: true,
        url: true
      },
      alliance_flag: {
        required: true,
      },
      name_area: {
        required: true,
      },
      name_bldg: {
        required: true,
      },
      name_venue: {
        required: true,
      },
      size1: {
        required: true,
        number: true,
        min: 0
      },
      size2: {
        required: true,
        number: true,
        min: 0
      },
      capacity: {
        required: true,
        number: true,
        min: 0
      },
      post_code: {
        required: true,
      },
      address1: {
        required: true,
      },
      address2: {
        required: true,
      },
      address3: {
        required: true,
      },
      luggage_flag: {
        required: true,
      },
      luggage_post_code: {
        required: true,
      },
      luggage_address1: {
        required: true,
      },
      luggage_address2: {
        required: true,
      },
      luggage_address3: {
        required: true,
      },
      luggage_name: {
        required: true,
      },
      luggage_tel: {
        required: true,
      },
      eat_in_flag: {
        required: true,
      },
      layout: {
        required: true,
      },
    },
    messages: {
      smg_url: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
      },
      alliance_flag: {
        required: "※必須項目です",
      },
      name_area: {
        required: "※必須項目です",
      },
      name_bldg: {
        required: "※必須項目です",
      },
      name_venue: {
        required: "※必須項目です",
      },
      size1: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      size2: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      capacity: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      post_code: {
        required: "※必須項目です",
      },
      address1: {
        required: "※必須項目です",
      },
      address2: {
        required: "※必須項目です",
      },
      address3: {
        required: "※必須項目です",
      },
      luggage_flag: {
        required: "※必須項目です",
      },
      luggage_post_code: {
        required: "※必須項目です",
      },
      luggage_address1: {
        required: "※必須項目です",
      },
      luggage_address2: {
        required: "※必須項目です",
      },
      luggage_address3: {
        required: "※必須項目です",
      },
      luggage_name: {
        required: "※必須項目です",
      },
      luggage_tel: {
        required: "※必須項目です",
      },
      eat_in_flag: {
        required: "※必須項目です",
      },
      layout: {
        required: "※必須項目です",
      },
    },
    // errorPlacement: function (err, element) {
    //   if (element.attr("alliance_flag")) {
    //     element.parent().before(err);
    //   } else {
    //     element.before(err);
    //   }
    // }
  });
});
