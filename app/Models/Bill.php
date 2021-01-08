<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bill extends Model
{

  use SoftDeletes;

  protected $fillable = [
    'reservation_id',

    'venue_total',
    'venue_discount_percent',
    'venue_dicsount_number',
    'discount_venue_total',

    'equipment_total',
    'service_total',
    'luggage_total',
    'equipment_service_total',
    'discount_item',
    'discount_equipment_service_total',

    'layout_total',
    'layout_discount',
    'after_duscount_layouts',

    'sub_total',
    'tax',
    'total',
  ];

  /*
|--------------------------------------------------------------------------
| Reservationとの一対多
|--------------------------------------------------------------------------|
*/
  public function reservation()
  {
    return $this->belongsTo(Reservation::class);
  }
  /*
|--------------------------------------------------------------------------
| breakdownsとの一対多
|--------------------------------------------------------------------------|
*/
  public function breakdowns()
  {
    return $this->hasMany(Breakdown::class);
  }

  // breakdowns 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->breakdowns()->get() as $child) {
        $child->delete();
      }
    });
  }
}
