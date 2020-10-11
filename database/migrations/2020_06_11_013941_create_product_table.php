<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name');
            $table->string('link_image');
            $table->string('link_image2');
            $table->string('link_image3');
            $table->bigInteger('price');
            $table->integer('sale_percent')->default(0);
            $table->text('description');
            $table->integer('id_category')->unsigned();
            $table->foreign('id_category')->references('id')->on('category_product')->onDelete('cascade');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('quantity')->default(100);
            $table->integer('sold')->default(0);
            $table->integer('status')->default(0);
            $table->integer('feeforsaler')->default(0);
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
        Schema::dropIfExists('product');
    }
}
