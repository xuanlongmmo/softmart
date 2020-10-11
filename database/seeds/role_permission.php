<?php

use Illuminate\Database\Seeder;

class role_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permission')->insert([
            ['id_group'=>'2','id_permission'=>'1'],
            ['id_group'=>'2','id_permission'=>'2'],
            ['id_group'=>'2','id_permission'=>'3'],
            ['id_group'=>'2','id_permission'=>'4'],
            ['id_group'=>'2','id_permission'=>'8'],
            ['id_group'=>'2','id_permission'=>'9'],
            ['id_group'=>'2','id_permission'=>'10'],
            ['id_group'=>'2','id_permission'=>'11'],
            ['id_group'=>'2','id_permission'=>'12'],
            ['id_group'=>'2','id_permission'=>'13'],
            ['id_group'=>'2','id_permission'=>'17'],
            ['id_group'=>'2','id_permission'=>'18'],
            ['id_group'=>'3','id_permission'=>'1'],
            ['id_group'=>'3','id_permission'=>'2'],
            ['id_group'=>'3','id_permission'=>'3'],
            ['id_group'=>'4','id_permission'=>'8'],
            ['id_group'=>'4','id_permission'=>'9'],
            ['id_group'=>'4','id_permission'=>'10'],
            ['id_group'=>'5','id_permission'=>'16'],
            ['id_group'=>'6','id_permission'=>'1'],
            ['id_group'=>'6','id_permission'=>'2'],
            ['id_group'=>'6','id_permission'=>'3'],
            ['id_group'=>'6','id_permission'=>'4'],
            ['id_group'=>'6','id_permission'=>'5'],
            ['id_group'=>'6','id_permission'=>'6'],
            ['id_group'=>'6','id_permission'=>'7'],
            ['id_group'=>'6','id_permission'=>'8'],
            ['id_group'=>'6','id_permission'=>'9'],
            ['id_group'=>'6','id_permission'=>'10'],
            ['id_group'=>'6','id_permission'=>'11'],
            ['id_group'=>'6','id_permission'=>'12'],
            ['id_group'=>'6','id_permission'=>'13'],
            ['id_group'=>'6','id_permission'=>'14'],
            ['id_group'=>'6','id_permission'=>'15'],
            ['id_group'=>'6','id_permission'=>'16'],
            ['id_group'=>'6','id_permission'=>'17'],
            ['id_group'=>'6','id_permission'=>'18'],
            ['id_group'=>'6','id_permission'=>'19'],
            ['id_group'=>'6','id_permission'=>'20'],
            ['id_group'=>'7','id_permission'=>'15'],
            ['id_group'=>'7','id_permission'=>'19'],
            ['id_group'=>'7','id_permission'=>'20'],
            ['id_group'=>'6','id_permission'=>'21'],
            ['id_group'=>'6','id_permission'=>'22'],
            ['id_group'=>'6','id_permission'=>'23'],
            ['id_group'=>'6','id_permission'=>'24'],
            ['id_group'=>'6','id_permission'=>'25'],
            ['id_group'=>'6','id_permission'=>'26'],
        ]);
    }
}
