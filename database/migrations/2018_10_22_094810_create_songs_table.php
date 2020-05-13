<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('cat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('duration')->nullable();
            $table->integer('is_fav')->nullable();
            $table->string('group_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('is_delete')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('songs');
    }
}
