<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
  /*
|--------------------------------------------------------------------------
| 会場と仲介の多対多
|--------------------------------------------------------------------------|
*/
  // public function venues()
  // {
  //   return $this->belongsToMany('App\Models\Venue')->withTimestamps();
  // }

  // public function users()
  // {
  //   return $this->belongsToMany('App\Models\User')->withTimestamps();
  // }

  public function searchs($freeword, $id, $name, $person_tel)
  {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('name', 'LIKE', "%$freeword%")
        ->orWhere('person_tel', 'LIKE', "%$freeword%")->paginate(10);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate(10);
    } else if (isset($name)) {
      return $this->where('name', 'LIKE', "%$name%")->paginate(10);
    } else if (isset($person_tel)) {
      return $this->where('person_tel', 'LIKE', "%$person_tel%")->paginate(10);
    } else {
      return $this->query()->paginate(10);
    }
  }
}
