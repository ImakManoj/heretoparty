<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserQuotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Userquotes', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    $table->unsignedBigInteger('vendor_id');
                    $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
                    $table->unsignedBigInteger('userinvoice_id');
                    $table->foreign('userinvoice_id')->references('id')->on('userinvoices')->onDelete('cascade');
                    $table->string('servces_id')->nullable();
                    $table->string('event_name');
                    $table->string('name');
                    $table->string('event_time');
                    $table->date('event_date');
                    $table->string('event_type');
                    $table->string('events');
                    $table->integer('gaddring');
                    $table->bigInteger('contact');
                    $table->string('email');
                    $table->longText('comment');
                    $table->longText('images');
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
