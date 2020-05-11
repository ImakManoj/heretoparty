<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Vendorcategorylist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendorcategorylists', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->unsignedBigInteger('vendor_id');
                    $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
                    $table->unsignedBigInteger('category_id');
                    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                    $table->integer('status')->default(1);
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
