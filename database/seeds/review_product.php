<?php

use Illuminate\Database\Seeder;

class review_product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('review_product')->insert([
            ['id_product'=>1,'content'=>'Sản phẩm tốt','star'=>5,'id_user'=>1,'created_at'=>'2020-05-05 16:22:19']
        ]);
    }
}
