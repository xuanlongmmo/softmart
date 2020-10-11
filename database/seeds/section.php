<?php

use Illuminate\Database\Seeder;

class section extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('section')->insert([
            ['title'=>'Bán chạy nhất'],
            ['title'=>'Mới nhất']
        ]);
    }
}
