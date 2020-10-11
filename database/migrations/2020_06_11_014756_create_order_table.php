<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            //id don hang
            $table->increments('id');
            //thong tin khach hang
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            //tong tien thanh toan
            $table->bigInteger('totalpay');
            $table->string('payment_method');
            //phan tram duoc giam gia
            $table->float('sale_percent')->default(0);
            //id neu khach hang dang nhap
            $table->integer('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            //trang thai don hang
            $table->integer('id_status')->unsigned();
            $table->foreign('id_status')->references('id')->on('status_order')->onDelete('cascade');
            //id nguoi kiem duyet don hang
            $table->integer('id_censor')->unsigned()->nullable();
            $table->foreign('id_censor')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->bigInteger('feeforsaler')->default(0);
            $table->bigInteger('realrevenue')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
