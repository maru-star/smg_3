
// reservation create　会場選択からの備品取得
// 以下参考
// https://niwacan.com/1619-laravel-ajax/
$(function () {
  $('#venues_selector').on('change', function () {
    var venue_id = $('#venues_selector').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getequipments',
      type: 'POST',
      data: { 'venue_id': venue_id, 'text': 'Ajax成功' },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      }
    })
      .done(function (data) {
        $('#fullOverlay').css('display', 'none');
        $.each(data, function (index, value) {
          $('.equipemnts table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='number' value='0' name='" + value['id'] + "' class='form-control'></td></tr>");
        });

      })
      .fail(function (data) {
        $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html('');
      });
  });
});