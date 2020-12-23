<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

  protected $fillable = [
    'reservation_id',
    'sub_total',
    'tax',
    'total'
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
