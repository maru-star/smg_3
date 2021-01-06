<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

  protected $fillable = [
    'reservation_id',

    'venue_total',
    'discount_venue_total',

    'equipment_total',
    'service_total',
    'luggage_total',
    'equipment_service_total',
    'discount_equipment_service_total',

    'layout_total',
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
}
