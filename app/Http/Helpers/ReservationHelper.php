<?php

namespace App\Http\Helpers;

use App\Models\Venue;


class ReservationHelper
{
  // Laravelの標準ヘルパの実装に習い staticにする
  public static function judgeStatus($num)
  {
    switch ($num) {
      case 0:
        return "仮抑え";
        break;
      case 1:
        return "予約確認中";
        break;
      case 2:
        return "予約完了";
        break;
      case 3:
        return "キャンセル申請中";
        break;
      case 4:
        return "キャンセル承認待ち";
        break;
      case 5:
        return "キャンセル";
        break;
    }
  }

  public static function formatDate($num)
  {
    return date('Y/m/d',  strtotime($num));
  }

  public static function getVenue($venue_id)
  {
    $venue = Venue::find($venue_id);
    return [$venue->name_area, $venue->name_bldg, $venue->name_venue];
  }
}
