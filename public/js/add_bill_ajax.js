$(function () {
  var reservation = $("input[name='reservation']").val();
  ajaxAddBillsEquipments(reservation);
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
      // $result[0]　は備品が格納
      // $result[1]　はサービスが格納
      $('.extra-bill-table tbody').html(''); //初期化
      $('#fullOverlay').css('display', 'none');
      console.log($result);
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