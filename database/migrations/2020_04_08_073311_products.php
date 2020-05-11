<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('product_name');
                $table->string('product_duration');
                $table->string('product_time');
                $table->double('product_price');
                $table->longText('product_discription');
                $table->longText('product_images');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                $table->unsignedBigInteger('subcategory_id');
                $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
                $table->unsignedBigInteger('bussinesse_id');
                $table->foreign('bussinesse_id')->references('id')->on('bussinesses')->onDelete('cascade');
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
        //
    }
}
