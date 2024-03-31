<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBettingOddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bettingoddings', function (Blueprint $table) {
            $table->id();
            $table->string('teamIDHome');
            $table->string('teamIDAway');
            $table->string('totalUnder');
            $table->string('awayTeamSpread');
            $table->string('awayTeamSpreadOdds');
            $table->string('homeTeamSpread');
            $table->string('homeTeamSpreadOdds');
            $table->string('totalOverOdds');
            $table->string('totalUnderOdds');
            $table->string('awayTeamMLOdds');
            $table->string('homeTeamMLOdds');
            $table->string('totalOver');
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
        Schema::dropIfExists('bettingoddings');
    }
}
