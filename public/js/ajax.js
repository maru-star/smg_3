// reservation create　会場選択からの備品取得
$(function () {
  $('#venues_selector').on('change', function () {
    var venue_id = $('#venues_selector').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },//Headersを書き忘れるとエラーになる
      url: '/admin/reservations/getequipments',//ご自身のweb.phpのURLに合わせる
      type: 'POST',//リクエストタイプ
      data: { 'venue_id': venue_id, 'text': 'Ajax成功' },//Laravelに渡すデータ
      // contentType: false,//渡すデータによって必要(文字列だけなら不要)
      // processData: false,//渡すデータによって必要(文字列だけなら不要)
      dataType: 'json', //必須。json形式で返すように設定
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      }
    })
      // Ajaxリクエスト成功時の処理
      .done(function (data) {
        $('#fullOverlay').css('display', 'none');
        // Laravel内で処理された結果がdataに入って返ってくる
        // $('#message').text(data[0]['item']);
        // $('#message').text(data.length);
        // 以下で戻ってきた配列を個別に取得
        var selectors = [];
        $.each(data, function (index, value) {
          console.log(value['item']);
          console.log(value['id']);
          $('.equipemnts table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='number' value='0' name='" + value['id'] + "' class='form-control'></td></tr>");
        });

      })
      // Ajaxリクエスト失敗時の処理
      .fail(function (data) {
        $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html('');
      });
  });
});