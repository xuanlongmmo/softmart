<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInforWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infor_website', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_branch');
            $table->string('hotline');
            $table->string('email');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('twitter');
            $table->string('address');
            $table->string('phone');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('company_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infor_website');
    }
}
