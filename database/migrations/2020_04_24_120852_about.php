<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class About extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('abouts', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->longText('about_title');
                    $table->longText('about_statement');
                    $table->longText('about_image');
                    $table->integer('about_list_id');
                    $table->longText('about_status');
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
