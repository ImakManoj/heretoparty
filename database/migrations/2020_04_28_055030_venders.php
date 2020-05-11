<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Venders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('vendors', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('vendor_name');
                    $table->string('vendor_logo');
                    $table->string('vendor_coverphoto');
                    $table->longText('vendor_address');
                    $table->bigInteger('vendor_contact');
                    $table->string('vendor_twitter');
                    $table->string('vendor_instragram');
                    $table->string('vendor_website');
                    $table->string('vendor_video');
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    $table->decimal('latitude', 10, 8);
                    $table->decimal('longitude', 11, 8);
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
