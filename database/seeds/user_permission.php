<?php

use Illuminate\Database\Seeder;

class user_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permission')->insert([
            ['id_user'=>'1','id_permission'=>'1'],
            ['id_user'=>'1','id_permission'=>'2'],
            ['id_user'=>'1','id_permission'=>'3'],
            ['id_user'=>'1','id_permission'=>'4'],
            ['id_user'=>'1','id_permission'=>'5'],
            ['id_user'=>'1','id_permission'=>'6'],
            ['id_user'=>'1','id_permission'=>'7'],
            ['id_user'=>'1','id_permission'=>'8'],
            ['id_user'=>'1','id_permission'=>'9'],
            ['id_user'=>'1','id_permission'=>'10'],
            ['id_user'=>'1','id_permission'=>'11'],
            ['id_user'=>'1','id_permission'=>'12'],
            ['id_user'=>'1','id_permission'=>'13'],
            ['id_user'=>'1','id_permission'=>'14'],
            ['id_user'=>'1','id_permission'=>'15'],
        ]);
    }
}
