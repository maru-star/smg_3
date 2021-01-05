<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
  protected $fillable = [
    'unit_item',
    'unit_cost',
    'unit_count',
    'unit_subtotal',
    'unit_type'
  ];

  /*
|--------------------------------------------------------------------------
| Billsとの一対多
|--------------------------------------------------------------------------|
*/
  public function bills()
  {
    return $this->belongsTo(Bill::class);
  }
}
