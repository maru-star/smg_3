<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('dates')->truncate();
        for ($id = 1; $id <= 30; $id++) {
            for ($day = 1; $day <= 7; $day++) {
                DB::table('dates')->insert([
                    'venue_id'              => $id,
                    'week_day'             => $day,
                    'start'          => '08:00',
                    'finish'    => '22:00',
                ]);
            };
        };
    }
}
