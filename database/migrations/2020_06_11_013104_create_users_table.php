<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->nullable();
            $table->string('google_id')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('fullname');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('wishlist')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('id_group')->unsigned()->default(1);
            $table->foreign('id_group')->references('id')->on('group_user')->onDelete('cascade');
            $table->string('code_change_password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
