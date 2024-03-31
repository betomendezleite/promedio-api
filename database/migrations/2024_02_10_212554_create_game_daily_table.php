<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameDailyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_daily', function (Blueprint $table) {
            $table->id();
            $table->string('gameID');
            $table->string('teamIDAway');
            $table->string('away');
            $table->string('gameDate');
            $table->string('teamIDHome');
            $table->string('home');
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
        Schema::dropIfExists('game_daily');
    }
}
