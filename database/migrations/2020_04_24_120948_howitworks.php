<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Howitworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('howitworks', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->longText('howitwork_title');
                    $table->longText('howitwork_name');
                    $table->longText('howitwork_statement');
                    $table->longText('howitwork_icon');
                    $table->longText('howitwork_status');
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
