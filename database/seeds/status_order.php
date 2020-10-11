<?php

use Illuminate\Database\Seeder;

class status_order extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_order')->insert([
            ['status'=>'Chưa liên lạc'],
            ['status'=>'Chưa liên hệ'],
            ['status'=>'Đã giao saler'],
            ['status'=>'Đã chốt'],
            ['status'=>'Hủy đơn hàng'],
            ['status'=>'Đang giao hàng'],
            ['status'=>'Đã giao hàng']
        ]);
    }
}
