<?php

Route::get('/', function () {
  return view('index');
});

/*
|--------------------------------------------------------------------------
| ユーザー用ルート
|--------------------------------------------------------------------------|
*/
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

  // ログイン認証後
  Route::middleware('verified')->group(function () {
    // TOPページ
    Route::resource('home', 'HomeController', ['only' => 'index']);
  });

  // メール入力フォーム
  Route::get('preusers', 'PreusersController@index')->name('preusers');
  // メール作成
  Route::post('preusers/create', 'PreusersController@create')->name('preusers.create');
  // メール送信
  Route::get('preusers/sendmail', 'PreusersController@sendmail')->name('preusers.sendmail');
  // メール認証
  Route::get('preusers/{id}/{token}', 'PreusersController@show');
  // メール送信完了画面
  Route::get('preusers/complete', 'PreusersController@complete')->name('preusers.complete');

  Auth::routes(['register' => false, 'confirm'  => true, 'reset'    => true,]);
  Route::get('preusers/register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('check_status');
  Route::post('preusers/register', 'Auth\RegisterController@register')->name('preusers.show');
  // Route::get('/home', 'HomeController@index')->name('home');
  Route::resource('home', 'HomeController');
  Route::put('home/{home}/update_status', 'HomeController@updateReservationStatus')->name('home.updatestatus');
});


/*
|--------------------------------------------------------------------------
| 管理者用ルート
|--------------------------------------------------------------------------|
*/
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
  // ログイン認証関連
  Auth::routes([
    'register' => true,
    'confirm'  => false,
    'reset'    => false
  ]);
  // ログイン認証後
  Route::middleware('auth:admin')->group(function () {
    // TOPページ
    Route::resource('home', 'HomeController', ['only' => 'index']);
    // 会場登録
    Route::resource('venues', 'VenuesController');
    // 備品登録
    Route::resource('equipments', 'EquipmentsController');
    // サービス登録
    Route::resource('services', 'ServicesController');
    // 営業日登録
    Route::resource('dates', 'DatesController');
    // 枠貸し料金登録
    Route::resource('frame_prices', 'Freme_pricesController')->except(['create']);
    Route::get('frame_prices/create/{frame_price}', 'Freme_pricesController@create')->name('frame_prices.create');
    // 時間貸し料金登録
    Route::resource('time_prices', 'Time_pricesController')->except(['create']);
    Route::get('time_prices/create/{time_price}', 'Time_pricesController@create')->name('time_prices.create');
    // 紹介会社
    Route::resource('agents', 'AgentsController');
    // 管理者側からUser登録
    Route::resource('clients', 'ClientsController');
    // 予約
    Route::resource('reservations', 'ReservationsController');
    // 予約　（確認）
    Route::post('reservations/create/check', 'ReservationsController@check')->name('reservations.check');
    // ajax アイテム
    Route::post('reservations/geteitems', 'ReservationsController@geteitems');
    // ajax 料金体系
    Route::post('reservations/getpricesystem', 'ReservationsController@getpricesystem');
    // ajax 営業時間
    Route::post('reservations/getsaleshours', 'ReservationsController@getsaleshours');
    // ajax 料金詳細所得
    Route::post('reservations/getpricedetails', 'ReservationsController@getpricedetails');
    // ajax 備品＆サービス　料金取得
    Route::post('reservations/geteitemsprices', 'ReservationsController@geteitemsprices');
    // ajax レイアウト取得
    Route::post('reservations/getlayout', 'ReservationsController@getlayout');
    // ajax レイアウト金額取得
    Route::post('reservations/getlayoutprice', 'ReservationsController@getlayoutprice');
    // ajax 荷物有り、無し　判別
    Route::post('reservations/getluggage', 'ReservationsController@getluggage');
    // ajax 会場　直営 or 提携　判別
    Route::post('reservations/getoperation', 'ReservationsController@getoperation');
    // ajax 会場　直営 or 提携　判別
    Route::post('clients/getclients', 'ClientsController@getclients');
    //予約に対するダブルチェック
    Route::post('reservations/{reservation}/double_check', 'ReservationsController@doublecheck')->name('reservations.double_check');
    Route::get('reservations/generate_pdf/{reservation}', 'ReservationsController@generate_pdf')->name('reservations.generate_pdf');
    // Bill　予約に紐づく
    Route::resource('bills', 'BillsController');
    // Breakdown　Billに紐づく
    Route::resource('breakdowns', 'BreakdownsController');
  });
});
