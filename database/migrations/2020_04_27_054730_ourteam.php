<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ourteam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ourteams', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('team_name');
                    $table->unsignedBigInteger('degination_id');
                    $table->foreign('degination_id')->references('id')->on('deginations')->onDelete('cascade');
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
