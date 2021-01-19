$(function () {
  var reservation = $("input[name='reservation']").val();

  $('input:radio[name="billcategory"]').on('click', function () {
    var target = $(this).val();
    if (target == 1) {
      $('.extra-bill-table tbody').html("");
      $('.extra-bill-table thead tr td').eq(3).remove();
      ajaxAddBillsEquipments(reservation);
    } else if (target == 2) {
      $('.extra-bill-table tbody').html("");
      $('.extra-bill-table thead tr td').eq(3).remove();
      ajaxAddBillsLayout(reservation);
    } else if (target == 3) {
      $('.extra-bill-table tbody').html("");
      $('.extra-bill-table thead tr td').eq(3).remove();
      $('.extra-bill-table thead tr').append("<td class='table-active'>追加／削除</td>");
      $('.extra-bill-table tbody').append("<tr><td>" + "<input type='text'>" + "</td><td>" + "<input type='text'>" + "</td><td><input type='text'" + "' ></td><td style='border: 0px solid none!important;'><input type='button' value='＋' class='add pluralBtn'><input type='button' value='ー' class='del pluralBtn'></td></tr>");
    }
  })

  $('.add_bill_calculate').on('click', function () {
    var judge = $('input:radio[name="billcategory"]:checked').val();

    var count = $('.extra-bill-table tbody tr').length;

    if (judge == 1) { //その他有料備品なら
      for (let index = 0; index < count; index++) {
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(0).text());
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(1).text());
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(2).find('input').val());
      }
    } else if (judge == 2) { //レイアウト変更なら
      for (let index = 0; index < count; index++) {
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(0).text());
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(1).text());
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(2).find('input').val());
      }
    } else if (judge == 3) {
      for (let index = 0; index < count; index++) {
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(0).find('input').val());
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(1).find('input').val());
        console.log($('.extra-bill-table tbody tr').eq(index).find('td').eq(2).find('input').val());
      }

    }
  })

});


function ajaxAddBillsEquipments($reservation_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/ajaxaddbillsequipments',
    type: 'POST',
    data: {
      'reservation_id': $reservation_id,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      // $result[0]　は備品が格納
      // $result[1]　はサービスが格納
      $('.extra-bill-table tbody').html(''); //初期化
      // console.log($result);
      for (let index = 0; index < $result[0].length; index++) {
        $('.extra-bill-table tbody').append("<tr><td>" + $result[0][index]['item'] + "</td><td>" + $result[0][index]['price'] + "</td><td><input type='text' class='equipments" + index + "' ></td></tr>");
      }
      for (let index2 = 0; index2 < $result[1].length; index2++) {
        $('.extra-bill-table tbody').append("<tr><td>" + $result[1][index2]['item'] + "</td><td>" + $result[1][index2]['price'] + "</td><td><input type='text' class='services" + index2 + "'></td></tr>");
      }
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log("しっぱい");
      console.log($result);

    });
};

function ajaxAddBillsLayout($reservation_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/ajaxaddbillslaytout',
    type: 'POST',
    data: {
      'reservation_id': $reservation_id,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($layouts) {
      $('#fullOverlay').css('display', 'none');
      $('.extra-bill-table tbody').html(''); //初期化
      $('.extra-bill-table tbody').append("<tr><td>" + "レイアウト準備" + "</td><td>" + $layouts[0] + "</td><td><input type='text' class='layout_prepare" + "' ></td></tr>");
      $('.extra-bill-table tbody').append("<tr><td>" + "レイアウト片付" + "</td><td>" + $layouts[1] + "</td><td><input type='text' class='layout_clean" + "'></td></tr>");
    })
    .fail(function ($layouts) {
      $('#fullOverlay').css('display', 'none');
      console.log("しっぱい");
      console.log($layouts);

    });
};