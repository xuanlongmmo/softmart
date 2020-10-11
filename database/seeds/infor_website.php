<?php

use Illuminate\Database\Seeder;

class infor_website extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('infor_website')->insert([
            ['name_properties'=>'hotline','value'=>'0927151535'],
            ['name_properties'=>'email','value'=>'Contact@web88.vn'],
            ['name_properties'=>'facebook','value'=>'https://www.facebook.com/'],
            ['name_properties'=>'twitter','value'=>'https://twitter.com/'],
            ['name_properties'=>'instagarm','value'=>'https://www.instagram.com/'],
            ['name_properties'=>'address','value'=>'CT2 Constrexim Thái Hà, Phạm Văn Đồng, Bắc Từ Liêm, Hà Nội'],
            ['name_properties'=>'iframe','value'=>'']
        ]);
    }
}
