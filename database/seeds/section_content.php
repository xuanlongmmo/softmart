<?php

use Illuminate\Database\Seeder;

class section_content extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('section_content')->insert([
            ['id_section'=>1,'id_product'=>3],
            ['id_section'=>1,'id_product'=>4],
            ['id_section'=>1,'id_product'=>5],
            ['id_section'=>1,'id_product'=>6],
            ['id_section'=>1,'id_product'=>7],
            ['id_section'=>2,'id_product'=>8],
            ['id_section'=>2,'id_product'=>9],
            ['id_section'=>2,'id_product'=>10],
            ['id_section'=>2,'id_product'=>11],
            ['id_section'=>2,'id_product'=>12]
        ]);
    }
}
