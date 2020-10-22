<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Agent;
use Faker\Generator as Faker;

$factory->define(Agent::class, function (Faker $faker) {
  return [
    'name' => $faker->company,
    'post_code' => $faker->postcode,
    'address1' => $faker->city,
    'address2' => $faker->streetName,
    'address3' => $faker->streetAddress,
    'address_remark' => $faker->sentence,
    'url' => $faker->url,
    'attr' => 1,
    'remark' => $faker->text,
    'person_firstname'  => $faker->firstName,
    'person_lastname'  => $faker->lastName,
    'firstname_kana'   => $faker->firstName,
    'lastname_kana' => $faker->lastName,
    'person_mobile' => $faker->phoneNumber,
    'person_tel' => $faker->phoneNumber,
    'fax' => $faker->phoneNumber,
    'email' => $faker->email,
    'cost' => 80,
  ];
});
