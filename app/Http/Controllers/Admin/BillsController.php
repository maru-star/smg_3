<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Bill;

use App\Models\Reservation;



class BillsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $reservation = Reservation::find($request->reservation_id);
    return view('admin/bills/create', [
      'reservation' => $reservation
    ]);
  }

  /***********************
   * ajax 請求書追加 備品サービス取得
   ***********************
   */
  public function ajaxaddbillsequipments(Request $request)
  {
    $reservation = Reservation::find($request->reservation_id);
    $equipments = $reservation->venue->equipments()->get();
    $services = $reservation->venue->services()->get();

    return [$equipments, $services];
  }

  /***********************
   * ajax 請求書追加 レイアウト取得
   ***********************
   */

  public function ajaxaddbillslaytout(Request $request)
  {
    $reservation = Reservation::find($request->reservation_id);
    $layout_prepare = $reservation->venue->layout_prepare;
    $layout_clean = $reservation->venue->layout_clean;
    return [$layout_prepare, $layout_clean];
  }

  public function check(Request $request)
  {
    var_dump($request->all());
    $master_arrays = [];

    if ($request->billcategory == 1) {
      foreach ($request->all() as $key => $value) {
        if (preg_match('/equipment_service/', $key)) {
          $master_arrays[] = $value;
        }
      }
      $counter = count($master_arrays) / 4; //固定で4つ
    } else if ($request->billcategory == 2) {
      foreach ($request->all() as $key => $value) {
        if (preg_match('/layout_/', $key)) {
          $master_arrays[] = $value;
        }
      }
      $counter = count($master_arrays) / 4; //固定で4つ
    } else if ($request->billcategory == 3) {
      foreach ($request->all() as $key => $value) {
        if (preg_match('/others_/', $key)) {
          $master_arrays[] = $value;
        }
      }
      $counter = count($master_arrays) / 4; //固定で4つ
    }

    return view('admin.bills.check', [
      'request' => $request,
      'master_arrays' => $master_arrays,
      'counter' => $counter
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
    var_dump($request->all());
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
