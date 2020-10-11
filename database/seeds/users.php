<?php

use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['email'=>'admin@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn A','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>6,'username'=>'admin','created_at'=>'2020-06-09 09:27:01.000000'],
            ['email'=>'censor@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn B','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>2,'username'=>'censor','created_at'=>'2020-06-09 09:27:01.000000'],
            ['email'=>'normalr@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn B','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>1,'username'=>'normal','created_at'=>'2020-06-09 09:27:01.000000'],
            ['email'=>'sale@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn A','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>5,'username'=>'sale','created_at'=>'2020-06-09 09:27:01.000000'],
            ['email'=>'ctvproduct@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn B','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>3,'username'=>'product','created_at'=>'2020-06-09 09:27:01.000000'],
            ['email'=>'ctvblog@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn B','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>4,'username'=>'blog','created_at'=>'2020-06-09 09:27:01.000000'],
            ['email'=>'accountantg@gmail.com','password'=>bcrypt('123456'),'fullname'=>'Nguyễn B','phone'=>'0989999999','address'=>'Việt Nam','id_group'=>7,'username'=>'accountant','created_at'=>'2020-06-09 09:27:01.000000']

        ]);
    }
}
