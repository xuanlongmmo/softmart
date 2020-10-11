
<?php

use Illuminate\Database\Seeder;

class permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->insert([
            ['permission'=>'addproduct'],
            ['permission'=>'showlistproduct'],
            ['permission'=>'editproduct'],
            ['permission'=>'deleteproduct'],
            ['permission'=>'showlistuser'],
            ['permission'=>'edituser'],
            ['permission'=>'deleteuser'],
            ['permission'=>'addblog'],
            ['permission'=>'showlistblog'],
            ['permission'=>'editblog'],
            ['permission'=>'deleteblog'],
            ['permission'=>'showlistorder'],
            ['permission'=>'censororder'],
            ['permission'=>'addcategory'],
            ['permission'=>'showrevenue'],
            ['permission'=>'showlistmessage'],
            ['permission'=>'acceptproduct'],
            ['permission'=>'acceptblog'],
            ['permission'=>'showlistordercomplete'],
            ['permission'=>'showlistctv'],
            ['permission'=>'addsection'],
            ['permission'=>'editsection'],
            ['permission'=>'deletesection'],
            ['permission'=>'addcategory'],
            ['permission'=>'editcategory'],
            ['permission'=>'deletecategory'],
        ]);
    }
}
