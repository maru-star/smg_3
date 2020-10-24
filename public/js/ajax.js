
// reservation create　会場選択からの備品取得
// 以下参考
// https://niwacan.com/1619-laravel-ajax/
$(function () {
  $('#venues_selector').on('change', function () {
    var venue_id = $('#venues_selector').val();
    ajaxGetItems(venue_id);
    ajaxGetPrice(venue_id);
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

  function ajaxGetPrice($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getprices',
      type: 'POST',
      data: { 'venue_id': $venue_id, 'text': 'Ajax成功' },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function (prices) {
        $('#fullOverlay').css('display', 'none');
        $('.price_selector').html(''); //一旦初期化
        if (prices[0] != 0 && prices[1] != 0) {
          $('.price_selector').append("<div> <small>※料金体系を選択してください</small> </div> <div class='form-inline'> <small class='mr-4'><input type='radio' name='price_system' value='1' checked='checked'>通常(枠貸し)</small> <small><input type='radio' name='price_system' value=' 2'>アクセア(時間貸し)</small> </div>")
        } else {
          $('.price_selector').html('');
        }
      })
      .fail(function (prices) {
        $('#fullOverlay').css('display', 'none');
        $('.price_selector').html('');
        console.log('失敗したよ');
      });
  };
});
















