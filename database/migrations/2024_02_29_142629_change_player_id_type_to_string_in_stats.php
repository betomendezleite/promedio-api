<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePlayerIdTypeToStringInStats extends Migration
{
    public function up()
    {
        Schema::table('stats', function (Blueprint $table) {
            $table->string('player_id')->change();
        });
    }

    public function down()
    {
        // No se puede revertir esta migración ya que estaría cambiando el tipo de datos de string a decimal.
    }
}
