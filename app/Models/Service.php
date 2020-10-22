<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['item', 'price', 'remark'];

    // 中間テーブル連携
    public function venues()
    {
        return $this->belongsToMany('App\Models\Venue');
    }

    public static function searchs($freeword, $id, $item)
    {
        if (isset($freeword)) {
            return self::where('id', 'LIKE', "%$freeword%")
                ->orWhere('item', 'LIKE', "%$freeword%")->paginate(10);
        } else if (isset($id)) {
            return self::where('id', 'LIKE', "%$id%")->paginate(10);
        } else if (isset($item)) {
            return self::where('item', 'LIKE', "%$item%")->paginate(10);
        } else {
            return self::query()->paginate(10);
        }
    }
}
