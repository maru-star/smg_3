<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\User;

use Carbon\Carbon;


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
  public function create()
  {
    $venues = Venue::select('name_area', 'name_bldg', 'name_venue', 'id')->get();
    $users = User::all();
    return view('admin.reservations.create', [
      'venues' => $venues,
      'users' => $users,
    ]);
  }

  public function check(Request $request)
  {
    $reserve_date = $request->enter_time;
    $venue_id = $request->venue_id;
    $enter_time = $request->enter_time;
    $leave_time = $request->leave_time;
    $board_flag = $request->board_flag;
    $event_start = $request->event_start;
    $event_finish = $request->event_finish;
    $event_name1 = $request->event_name1;
    $event_name2 = $request->event_name2;
    $event_owner = $request->event_owner;
    $user_id = $request->user_id;
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
    return view('admin.reservations.check', [
      'reserve_date' => $reserve_date,
      'venue_id' => $venue_id,
      'enter_time' => $enter_time,
      'enter_time' => $enter_time,
      'leave_time' => $leave_time,
      'board_flag' => $board_flag,
      'event_start' => $event_start,
      'event_finish' => $event_finish,
      'event_name1' => $event_name1,
      'event_name2' => $event_name2,
      'event_owner' => $event_owner,
      'user_id' => $user_id,
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
    //
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
