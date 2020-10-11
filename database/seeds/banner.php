<?php

use Illuminate\Database\Seeder;

class banner extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banner')->insert([
            ['link_image'=>'public/banner/image-slider-011.png','title'=>'Meet The Celebrities12','content'=>'Kitchenware, Table Lamp and Black Goji','link'=>'abc.com'],
            ['link_image'=>'public/banner/image-slider-021.png','title'=>'Bye The Celebrities12','content'=>'Software, Table Lamp and Black Goji','link'=>'xyz.com'],
        ]);
    }
}
