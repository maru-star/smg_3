<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon; //carbon利用


class Venue extends Model
{

  protected $fillable = [
    'alliance_flag',
    'name_area',
    'name_bldg',
    'name_venue',
    'size1',
    'size2',
    'capacity',
    'eat_in_flag',
    'post_code',
    'address1',
    'address2',
    'address3',
    'remark',
    'first_name',
    'last_name',
    'first_name_kana',
    'last_name_kana',
    'person_tel',
    'person_email',
    'luggage_flag',
    'luggage_tel',
    'cost',
    'mgmt_company',
    'mgmt_tel',
    'mgmt_emer_tel',
    'mgmt_first_name',
    'mgmt_last_name',
    'mgmt_person_tel',
    'mgmt_email',
    'mgmt_sec_company',
    'mgmt_sec_tel',
    'mgmt_remark',
    'entrance_open_time',
    'backyard_open_time',
    'layout'
  ];

  public function searchs(
    $freeword,
    $id,
    $alliance_flag,
    $name_area,
    $name_bldg,
    $name_venue,
    $capacity1,
    $capacity2
  ) {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('alliance_flag', 'LIKE', "%$freeword%")
        ->orWhere('name_area', 'LIKE', "%$freeword%")
        ->orWhere('alliance_flag', 'LIKE', "%$freeword%")
        ->orWhere('name_bldg', 'LIKE', "%$freeword%")
        ->orWhere('name_venue', 'LIKE', "%$freeword%")
        ->orWhere('capacity', 'LIKE', "%$freeword%")
        ->orWhere('capacity', 'LIKE', "%$freeword%")->paginate(10);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate(10);
    } else if (isset($alliance_flag)) {
      return $this->where('alliance_flag', 'LIKE', "%$alliance_flag%")->paginate(10);
    } else if (isset($name_area)) {
      return $this->where('name_area', 'LIKE', "%$name_area%")->paginate(10);
    } else if (isset($name_bldg)) {
      return $this->where('name_bldg', 'LIKE', "%$name_bldg%")->paginate(10);
    } else if (isset($name_venue)) {
      return $this->where('name_venue', 'LIKE', "%$name_venue%")->paginate(10);
    } else if (isset($capacity1) && isset($capacity2)) {
      return $this->whereBetween('capacity', $capacity1, $capacity2)->paginate(10);;
    } else if (isset($capacity1)) {
      return $this->where('capacity', '>=', $capacity1)->paginate(10);;
    } else if (isset($capacity2)) {
      return $this->where('capacity', '<=', $capacity2)->paginate(10);;
    } else {
      return $this->query()->paginate(10);
    }
  }

  /*
|--------------------------------------------------------------------------
| 会場と備品の中間テーブル
|--------------------------------------------------------------------------|
*/
  // 【備品】中間テーブル連携
  public function equipments()
  {
    return $this->belongsToMany('App\Models\Equipment')->withTimestamps();
  }

  // 中間テーブル追加
  public function save_equipments($equipment_id)
  {
    $this->equipments()->attach($equipment_id);
    return true;
  }

  // 中間テーブルUpdate
  public function sync_equipments($equipment_id)
  {
    $this->equipments()->sync($equipment_id);
    return true;
  }

  // 中間テーブル削除
  public function detach_equipments()
  {
    $this->equipments()->detach();
    return true;
  }

  /*
|--------------------------------------------------------------------------
| 会場とサービスの中間テーブル
|--------------------------------------------------------------------------|
*/

  // 【サービス】中間テーブル連携
  public function services()
  {
    return $this->belongsToMany('App\Models\Service')->withTimestamps();
  }

  // 【サービス】中間テーブル追加
  public function save_services($service_id)
  {
    $this->services()->attach($service_id);
    return true;
  }

  // 【サービス】中間テーブルsync
  public function sync_services($service_id)
  {
    $this->services()->sync($service_id);
    return true;
  }
  // 【サービス】中間テーブル削除
  public function detach_services()
  {
    $this->services()->detach();
    return true;
  }

  /*
|--------------------------------------------------------------------------
| 会場とDateの中間テーブル
|--------------------------------------------------------------------------|
*/
  // 【日付】一対多
  public function dates()
  {
    return $this->hasMany('App\Models\Date');
  }

  /*
|--------------------------------------------------------------------------
| 枠貸し料金と会場の一対多
|--------------------------------------------------------------------------|
*/
  public function frame_prices()
  {
    return $this->hasMany(Frame_price::class);
  }

  /*
|--------------------------------------------------------------------------
| 時間貸し料金と会場の一対多
|--------------------------------------------------------------------------|
*/
  public function time_prices()
  {
    return $this->hasMany(Time_price::class);
  }
}
