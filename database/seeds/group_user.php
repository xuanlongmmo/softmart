<?php

use Illuminate\Database\Seeder;

class group_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_user')->insert([
            ['group_name'=>'normal'],
            ['group_name'=>'censor'],
            ['group_name'=>'collaboratorproduct'],
            ['group_name'=>'collaboratorblog'],
            ['group_name'=>'sale'],
            ['group_name'=>'admin'],
            ['group_name'=>'accountant']
        ]);
    }
}
