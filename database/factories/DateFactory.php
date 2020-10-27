<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Date;
use Faker\Generator as Faker;

$factory->define(Date::class, function (Faker $faker) {
    // for ($id = 1; $id <= 30; $id++) {
    //     for ($day = 1; $day <= 7; $day++) {
    //         return [
    //             'venue_id' => $id,
    //             'week_day' => $day,
    //             'start' => '08:00',
    //             'finish' => '22:00',
    //         ];
    //     };
    // };
});
