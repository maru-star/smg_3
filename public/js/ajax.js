
// reservation create　会場選択からの備品取得
// 以下参考
// https://niwacan.com/1619-laravel-ajax/
$(function () {
  $('#venues_selector').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    ajaxGetItems(venue_id);
    ajaxGetSalesHours(venue_id, dates);
    // ajaxGetPrice(venue_id, dates);
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
          $('.equipemnts table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='number' value='0' name='" + value['id'] + "' class='form-control'></td></tr>");
        });
        $('.services table tbody').html('');
        $.each($items[1], function (index, value) {
          // ココでサービス取得
          $('.services table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='number' value='0' name='" + value['id'] + "' class='form-control'></td></tr>");
        });
      })
      .fail(function (data) {
        $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html('');
        $('.services table tbody').html('');
      });
  };

  // function ajaxGetPrice($venue_id, $dates) {
  //   $.ajax({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     },
  //     url: '/admin/reservations/getprices',
  //     type: 'POST',
  //     data: { 'venue_id': $venue_id, 'dates': $dates },
  //     dataType: 'json',
  //     beforeSend: function () {
  //       $('#fullOverlay').css('display', 'block');
  //     },
  //   })
  //     .done(function ($prices) {
  //       $('#fullOverlay').css('display', 'none');
  //       $('.price_selector').html(''); //一旦初期化
  //       if ($prices[0] != 0 && $prices[1] != 0) {
  //         $('.price_selector').append("<div> <small>※料金体系を選択してください</small> </div> <div class='form-inline'> <small class='mr-4'><input type='radio' name='price_system' value='1' checked='checked'>通常(枠貸し)</small> <small><input type='radio' name='price_system' value=' 2'>アクセア(時間貸し)</small> </div>")
  //       } else {
  //         $('.price_selector').html('');
  //         console.log($prices);
  //       }
  //     })
  //     .fail(function ($prices) {
  //       $('#fullOverlay').css('display', 'none');
  //       $('.price_selector').html('');
  //       console.log('失敗したよ');
  //     });
  // };

  function ajaxGetSalesHours($venue_id, $dates) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getsaleshours',
      type: 'POST',
      data: { 'venue_id': $venue_id, 'dates': $dates },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($times) {
        $('#fullOverlay').css('display', 'none');
        var $time_start = new Date($times[0]);
        var $time_finish = new Date($times[1]);
        // var $f_start = ("0" + $time_start.getHours()).slice(-2) + ':00';
        // var $f_finish = ("0" + $time_finish.getHours()).slice(-2) + ':00';
        for (let index = $time_start.getHours(); index <= $time_finish.getHours(); index++) {
          $('#sales_start').append("<option value='" + ("0" + index).slice(-2) + ":00:00" + "'>" + ("0" + index).slice(-2) + ":00" + "</option>");
          $('#sales_finish').append("<option value='" + ("0" + index).slice(-2) + ":00:00" + "'>" + ("0" + index).slice(-2) + ":00" + "</option>");
          // console.log(("0" + index).slice(-2));
        }


      })
      .fail(function ($start, $$finish) {
        $('#fullOverlay').css('display', 'none');
        alert('失敗');
        console.log($start);
      });
  };
});
















