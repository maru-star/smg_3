<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Bill;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用



class ReservationsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $reservations = Reservation::all();
    return view('admin.reservations.index', [
      'reservations' => $reservations,
    ]);
  }

  /***********************
   * ajax 備品orサービス取得
   **********************
   */
  public function geteitems(Request $request)
  {
    $id = $request->venue_id;
    $venue = Venue::find($id);
    $venue_equipments = $venue->equipments()->get();
    $venue_services = $venue->services()->get();
    return [$venue_equipments, $venue_services];
  }

  /***********************
   * ajax 
   ***********************
   */
  public function getpricesystem(Request $request)
  {
    $id = $request->venue_id; //会場ID
    $dates = Carbon::parse($request->dates); //日付取得
    $week_day = $dates->dayOfWeekIso; //曜日取得

    $venue = Venue::find($id);

    $date = $venue->dates()->where('week_day', $week_day)->get();

    $frame_price = $venue->frame_prices()->get();
    $time_price = $venue->time_prices()->get();

    return [$frame_price, $time_price, $date];
  }

  /***********************
   * ajax 営業時間取得
   ***********************
   */
  public function getsaleshours(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $dates = Carbon::parse($request->dates); //日付取得
    $week_day = $dates->dayOfWeekIso; //曜日取得
    $sales_start = Carbon::parse($venue->dates()->where('week_day', $week_day)->first()->start);
    $sales_finish = Carbon::parse($venue->dates()->where('week_day', $week_day)->first()->finish);

    return [$sales_start, $sales_finish];
  }

  /***********************
   * ajax 料金取得
   ***********************
   */
  public function getpricedetails(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $status = $request->status;
    $start = $request->start;
    $finish = $request->finish;

    // $statusは時間枠料金orアクセア料金か判別
    $result = $venue->calculate_price($status, $start, $finish);

    return [$result];
  }

  /***********************
   * ajax 備品＆サービス　料金取得
   ***********************
   */
  public function geteitemsprices(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $selected_equipments = $request->equipemnts;
    $selected_services = $request->services;

    $result = $venue->calculate_items_price($selected_equipments, $selected_services);

    // return [$result];
    if (is_null($selected_equipments) && is_null($selected_services)) {
      return fail;
    } else {
      return [$result];
    }
  }

  /***********************
   * ajax レイアウト有り無し判別取得
   ***********************
   */
  public function getlayout(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->layout;

    return [$result];
  }

  /***********************
   * ajax レイアウト金額
   ***********************
   */
  public function getlayoutprice(Request $request)
  {
    $venue = Venue::find($request->venue_id);

    $layout_prepare = $request->layout_prepare;
    $layout_clean = $request->layout_clean;

    $result = [];

    $layout_prepare == 1 ? $result[] = [$venue->layout_prepare, 'レイアウト準備'] : $result[] = '';
    $layout_clean == 1 ? $result[] = [$venue->layout_clean, 'レイアウト片付'] : $result[] = '';

    if ($layout_prepare == 1 && $layout_clean == 1) {
      $total = $venue->layout_prepare + $venue->layout_clean;
    } else if ($layout_prepare == 1 && $layout_clean == 0) {
      $total = $venue->layout_prepare;
    } else if ($layout_prepare == 0 && $layout_clean == 1) {
      $total = $venue->layout_clean;
    } else {
      $total = 0;
    }

    return [$result, $total];
  }

  /***********************
   * ajax 荷物預かり　有り無し　判別
   ***********************
   */
  public function getluggage(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $result = $venue->luggage_flag;

    return [$result];
  }

  /***********************
   * ajax 直営　or　提携　判別
   ***********************
   */
  public function getoperation(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $flag = $venue->alliance_flag;
    $percentage = $venue->cost;
    if ($flag == 0) {
      return 0;
    } else {
      return $percentage;
    }
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $venues = Venue::select('name_area', 'name_bldg', 'name_venue', 'id')->get();
    $users = User::all();

    $target = $request->all();

    if ($target != null) {
      return view('admin.reservations.create', [
        'venues' => $venues,
        'users' => $users,
        'request' => $request,
      ]);
    } else {
      return view('admin.reservations.create', [
        'venues' => $venues,
        'users' => $users,
      ]);
    }


    // return view('admin.reservations.create', [
    //   'venues' => $venues,
    //   'users' => $users,
    //   'reserve_date' => $reserve_date,
    //   'venue_id' => $venue_id,
    // ]);
  }

  public function check(Request $request)
  {

    var_dump($request->all());

    $reserve_date = $request->reserve_date;
    $venue_id = $request->venue_id;
    $venue = Venue::find($venue_id);
    $enter_time = $request->enter_time;
    $leave_time = $request->leave_time;
    $board_flag = $request->board_flag;
    $event_start = $request->event_start;
    $event_finish = $request->event_finish;
    $event_name1 = $request->event_name1;
    $event_name2 = $request->event_name2;
    $event_owner = $request->event_owner;
    $user_id = $request->user_id;
    $user = User::find($user_id);
    $in_charge = $request->in_charge;
    $tel = $request->tel;
    $email_flag = $request->email_flag;
    $cost = $request->cost;
    $discount_condition = $request->discount_condition;
    $attention = $request->attention;
    $user_details = $request->user_details;
    $admin_details = $request->admin_details;
    $payment_limit = $request->payment_limit;
    $paid = $request->paid;
    $reservation_status = $request->reservation_status;
    $double_check_status = $request->double_check_status;
    $bill_company = $request->bill_company;
    $bill_person = $request->bill_person;
    $bill_created_at = $request->bill_created_at;
    $bill_pay_limit = $request->bill_pay_limit;
    $layout_prepare = $request->layout_prepare;
    $layout_clean = $request->layout_clean;

    $luggage_count = $request->luggage_count;
    $luggage_arrive = $request->luggage_arrive;
    $luggage_return = $request->luggage_return;
    $luggage_price = $request->luggage_price;

    // $reservation_id = new Reservation;
    $sub_total = $request->sub_total;
    $tax = $request->tax;
    $total = $request->total;

    // 備品の個別入力input
    $simple_v_input = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipemnt/', $key)) {
        $simple_v_input[] = $value;
      }
    }

    // サービスの個別入力input
    $simple_s_input = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/service/', $key)) {
        $simple_s_input[] = $value;
      }
    }

    // 会場の内訳列×４カラム（内容、単価、数量、小計）
    $v_d_counts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/venue_breakdowns/', $key)) {
        $v_d_counts[] = $value;
      }
    }
    // 備品の内訳列×４カラム（内容、単価、数量、小計）
    $e_d_counts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdowns/', $key)) {
        $e_d_counts[] = $value;
      }
    }
    // レイアウトの内訳列×４カラム（内容、単価、数量、小計）
    $l_d_counts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/layout_breakdowns/', $key)) {
        $l_d_counts[] = $value;
      }
    }

    return view('admin.reservations.check', [
      'reserve_date' => $reserve_date,
      'venue_id' => $venue_id,
      'venue' => $venue,
      'enter_time' => $enter_time,
      'leave_time' => $leave_time,
      'board_flag' => $board_flag,
      'event_start' => $event_start,
      'event_finish' => $event_finish,
      'event_name1' => $event_name1,
      'event_name2' => $event_name2,
      'event_owner' => $event_owner,
      'user_id' => $user_id,
      'user' => $user,
      'in_charge' => $in_charge,
      'tel' => $tel,
      'email_flag' => $email_flag,
      'cost' => $cost,
      'discount_condition' => $discount_condition,
      'attention' => $attention,
      'user_details' => $user_details,
      'admin_details' => $admin_details,
      'payment_limit' => $payment_limit,
      'paid' => $paid,
      'reservation_status' => $reservation_status,
      'double_check_status' => $double_check_status,
      'bill_company' => $bill_company,
      'bill_person' => $bill_person,
      'bill_created_at' => $bill_created_at,
      'bill_pay_limit' => $bill_pay_limit,
      'sub_total' => $sub_total,
      'tax' => $tax,
      'total' => $total,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
      'luggage_count' => $luggage_count,
      'luggage_arrive' => $luggage_arrive,
      'luggage_return' => $luggage_return,
      'luggage_price' => $luggage_price,

      //↓　↓　  備品のinputされた値
      'simple_v_input' => $simple_v_input,
      'simple_s_input' => $simple_s_input,
      //↓　↓　 内訳に記載された会場や、備品、レイアウト等
      'v_d_counts' => $v_d_counts,
      'e_d_counts' => $e_d_counts,
      'l_d_counts' => $l_d_counts,
      'request' => $request
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // $this->validate($request, [
    //   'reserve_date' => ['required', 'max:191'],
    //   'venue_id' => ['required', 'max:191'],
    //   'enter_time' => ['required', 'max:191'],
    //   'leave_time' => ['required', 'max:191'],
    //   'board_flag' => ['required', 'max:191'],
    //   'event_start' => ['required', 'max:191'],
    //   'event_finish' => ['required', 'max:191'],
    //   'event_name1' => ['required', 'max:191'],
    //   'event_name2' => ['required', 'max:191'],
    //   'event_owner' => 'required',
    //   'user_id' => 'required',
    //   'in_charge' => 'required',
    //   'tel' => ['required', 'max:191'],
    //   'email_flag' => ['required', 'max:191'],
    //   'cost' => 'required',
    //   'payment_limit' => 'required',
    //   'paid' => 'required',
    //   'reservation_status' => 'required',
    //   'double_check_status' => ['required', 'max:191'],
    //   'bill_company' => 'required',
    //   'bill_person' => 'required',
    //   'bill_created_at' => 'required',
    //   'bill_pay_limit' => 'required',
    // ]);
    return DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation = new Reservation;
      $reservation->reserve_date = $request->reserve_date;
      $reservation->venue_id = $request->venue_id;
      $reservation->enter_time = $request->enter_time;
      $reservation->leave_time = $request->leave_time;
      $reservation->board_flag = $request->board_flag;
      $reservation->event_start = $request->event_start;
      $reservation->event_start = $request->event_start;
      $reservation->event_finish = $request->event_finish;
      $reservation->event_name1 = $request->event_name1;
      $reservation->event_name2 = $request->event_name2;
      $reservation->event_owner = $request->event_owner;
      $reservation->user_id = $request->user_id;
      $reservation->in_charge = $request->in_charge;
      $reservation->tel = $request->tel;
      $reservation->email_flag = $request->email_flag;
      $reservation->cost = $request->cost;
      $reservation->payment_limit = $request->payment_limit;
      $reservation->paid = $request->paid;
      $reservation->reservation_status = $request->reservation_status;
      $reservation->double_check_status = $request->double_check_status;
      $reservation->bill_company = $request->bill_company;
      $reservation->bill_person = $request->bill_person;
      $reservation->bill_created_at = $request->bill_created_at;
      $reservation->bill_pay_limit = $request->bill_pay_limit;

      $reservation->save();

      $reservation->bills()->create([
        'reservation_id' => $reservation->id,
        'sub_total' => $request->sub_total,
        'tax' => $request->tax,
        'total' => $request->total,
      ]);
    });
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
