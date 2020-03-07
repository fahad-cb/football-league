<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TeamMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_matches',function(Blueprint $table){
            $table->increments('id');
            $table->integer('team_id')->unsigned();
            $table->integer('match_id')->unsigned();
            $table->integer('goals');
            $table->enum('result',['won','lost','drawn','no_result'])->default('no_result');
            $table->foreign('team_id')->on('teams')->references('id');
            $table->foreign('match_id')->on('matches')->references('id');
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
        Schema::DropIfExists('matches');
    }
}
