<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Venue;
use App\Models\Equipment;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;


class VenueTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */



    use RefreshDatabase;



    public function testVenueCreate()
    {
        $venue = new Venue();
        $venue->alliance_flag = 1;
        $venue->name_area = '心斎橋';
        $venue->name_bldg = 'サンワールド';
        $venue->name_venue = '１号館';
        $venue->size1 = 100.9;
        $venue->size2 = 78.1;
        $venue->capacity = 100;
        $venue->eat_in_flag = 1;
        $venue->post_code = 0740014;
        $venue->address1 = '大阪市';
        $venue->address2 = '東成区大今里';
        $venue->address3 = '6-3-12';
        $venue->remark = 'このお客様はやばい';
        $venue->first_name = '小笠';
        $venue->last_name = 'たかのり';
        $venue->first_name_kana = 'オガサ';
        $venue->last_name_kana = 'タカノリ';
        $venue->person_tel = '07010652028';
        $venue->person_email = 'testtesttest@test.com';
        $venue->luggage_flag = 1;
        $venue->luggage_info = '特になし';
        $venue->luggage_tel = '09075142028';
        $venue->cost = '9000';
        $savevenue = $venue->save();

        $this->assertTrue($savevenue);
    }

    public function testEquipments()
    {
        $eqipment = new Equipment;
        $eqipment->item = "黒板消し";
        $eqipment->price = "6000";
        $eqipment->stock = "50";
        $eqipment->remark = "在庫がない場合は買い足してください";
        $eqipmentsave = $eqipment->save();

        $this->assertTrue($eqipmentsave);

        $user = factory(User::class)->create(); // 変更(ファクトリでユーザーデータを作成)
        $this->assertTrue($user);
    }
}
