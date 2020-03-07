<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Teams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams',function (Blueprint $table){
            $table->increments('id');
            $table->string('team_name');
            $table->integer('matches_played')->default('0');
            $table->integer('matches_lost')->default('0');
            $table->integer('matches_won')->default('0');
            $table->integer('matches_drawn')->default('0');
            $table->integer('total_goals')->default('0');
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
        Schema::DropIfExists('teams');
    }
}
