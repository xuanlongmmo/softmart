<?php

use Illuminate\Database\Seeder;

class category_policy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_policy')->insert([
            ['category_name'=>'Bảo hành','slug_name'=>'bao-hanh'],
            ['category_name'=>'Cài đặt','slug_name'=>'cai-dat'],
            ['category_name'=>'Nâng cấp','slug_name'=>'nang-cap'],
            ['category_name'=>'Gia hạn','slug_name'=>'gia-han'],
        ]);
    }
}
