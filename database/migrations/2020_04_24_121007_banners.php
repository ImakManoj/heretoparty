<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Banners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
             Schema::create('banners', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->longText('banner_title');
                    $table->longText('banner_subtitle');
                    $table->longText('banner_images');
                    $table->longText('banner_status');
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
