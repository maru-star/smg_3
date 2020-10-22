<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    public static function searchs($freeword, $id, $name, $person_tel)
    {
        if (isset($freeword)) {
            return self::where('id', 'LIKE', "%$freeword%")
                ->orWhere('name', 'LIKE', "%$freeword%")
                ->orWhere('person_tel', 'LIKE', "%$freeword%")->paginate(10);
        } else if (isset($id)) {
            return self::where('id', 'LIKE', "%$id%")->paginate(10);
        } else if (isset($name)) {
            return self::where('name', 'LIKE', "%$name%")->paginate(10);
        } else if (isset($person_tel)) {
            return self::where('person_tel', 'LIKE', "%$person_tel%")->paginate(10);
        } else {
            return self::query()->paginate(10);
        }
    }
}
