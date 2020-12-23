<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
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
