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
  Route::get('/home', 'HomeController@index')->name('home');
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
  });
});