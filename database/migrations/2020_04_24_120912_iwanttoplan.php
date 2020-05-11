<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Iwanttoplan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iwanttoplans', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->longText('iwanttoplan_title');
                    $table->longText('iwanttoplan_icon');
                    $table->longText('iwanttoplan_message');
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
