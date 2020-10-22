<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Equipment;
use Faker\Generator as Faker;

$factory->define(Equipment::class, function (Faker $faker) {
  return [
    'item' => $faker->word,
    'price' => rand(2000, 5000),
    'stock' => rand(1, 50),
    'remark' => $faker->sentence
  ];
});
