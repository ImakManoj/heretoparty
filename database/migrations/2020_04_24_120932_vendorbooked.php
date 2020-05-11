<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Vendorbooked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendorbooks', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->longText('vendorbook_title');
                    $table->longText('vendorbook_name');
                    $table->longText('vendorbook_rating');
                    $table->longText('vendorbook_country');
                    $table->longText('vendorbook_images');
                    $table->longText('iwanttoplan_status');
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
