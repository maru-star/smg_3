<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Venue;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {
    return [
        'alliance_flag'=>1,
'name_area'=>$faker->city,
'name_bldg'=>$faker->company,
'name_venue'=>$faker->buildingNumber,
'size1'=>12,
'size2'=>12,
'capacity'=>150,
'eat_in_flag'=>1,
'post_code'=>$faker->postcode,
'address1'=>$faker->streetAddress,
'address2'=>$faker->address,
'address3'=>'なし',
'remark'=>'特になし',
'first_name'=>$faker->firstNameMale,
'last_name'=>$faker->lastName,
'first_name_kana'=>'名字カナ',
'last_name_kana'=>'名字ナマエ',
'person_tel'=>$faker->phoneNumber,
'person_email'=>$faker->email,
'luggage_flag'=>1,
'luggage_post_code'=>$faker->postcode,
'luggage_address1'=>$faker->streetAddress,
'luggage_address2'=>$faker->address,
'luggage_address3'=>'なし',
'luggage_name'=>'クロネコヤマト',
'luggage_tel'=>$faker->phoneNumber,
'cost'=>70,
'mgmt_company'=>$faker->company,
'mgmt_tel'=>$faker->phoneNumber,
'mgmt_emer_tel'=>$faker->phoneNumber,
'mgmt_first_name'=>$faker->firstNameMale,
'mgmt_last_name'=>$faker->lastName,
'mgmt_person_tel'=>$faker->phoneNumber,
'mgmt_email'=>$faker->email,
'mgmt_sec_company'=>'アルソック',
'mgmt_sec_tel'=>$faker->phoneNumber,
'mgmt_remark'=>'特になし',
'smg_url'=>'yahoo.com',
'entrance_open_time'=>'07:00~12:00',
'backyard_open_time'=>'07:00~12:00',
];
});
