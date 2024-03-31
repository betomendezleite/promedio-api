<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTable extends Migration
{
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->foreign('player_id')->references('id')->on('players');
            $table->decimal('blk', 4, 1);
            $table->decimal('fga', 4, 1);
            $table->decimal('DefReb', 4, 1);
            $table->decimal('ast', 4, 1);
            $table->decimal('ftp', 5, 1);
            $table->decimal('tptfgp', 5, 1);
            $table->decimal('tptfgm', 4, 1);
            $table->decimal('trueShootingPercentage', 5, 1);
            $table->decimal('stl', 4, 1);
            $table->decimal('fgm', 4, 1);
            $table->decimal('pts', 4, 1);
            $table->decimal('reb', 4, 1);
            $table->decimal('fgp', 5, 1);
            $table->decimal('effectiveShootingPercentage', 5, 1);
            $table->decimal('fta', 3, 1);
            $table->decimal('mins', 4, 1);
            $table->integer('gamesPlayed');
            $table->decimal('TOV', 3, 1);
            $table->decimal('tptfga', 4, 1);
            $table->decimal('OffReb', 3, 1);
            $table->decimal('ftm', 3, 1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
