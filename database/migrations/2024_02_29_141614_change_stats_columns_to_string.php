<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatsColumnsToString extends Migration
{
    public function up()
    {
        Schema::table('stats', function (Blueprint $table) {
            $table->string('blk')->change();
            $table->string('fga')->change();
            $table->string('DefReb')->change();
            $table->string('ast')->change();
            $table->string('ftp')->change();
            $table->string('tptfgp')->change();
            $table->string('tptfgm')->change();
            $table->string('trueShootingPercentage')->change();
            $table->string('stl')->change();
            $table->string('fgm')->change();
            $table->string('pts')->change();
            $table->string('reb')->change();
            $table->string('fgp')->change();
            $table->string('effectiveShootingPercentage')->change();
            $table->string('fta')->change();
            $table->string('mins')->change();
            $table->string('TOV')->change();
            $table->string('tptfga')->change();
            $table->string('OffReb')->change();
            $table->string('ftm')->change();
        });
    }

    public function down()
    {
        // No se puede revertir esta migración ya que estaría cambiando los tipos de datos de string a decimales.
    }
}
