<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Message extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('messages', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    $table->unsignedBigInteger('vendor_id');
                    $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
                    $table->string('message');
                    $table->integer('type')->default(0)->comment('1 for Vendor 2 for  User');
                    $table->string('images');
                    $table->double('date');
                    $table->integer('status')->default(0);  
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
