<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Agrega las columnas necesarias
            $table->decimal('top_performers_blk_total', 8, 2)->nullable();
            $table->unsignedBigInteger('top_performers_blk_player_id')->nullable();
            $table->decimal('ast_total', 8, 2)->nullable();
            $table->unsignedBigInteger('ast_player_id')->nullable();
            $table->decimal('tptfgm_total', 8, 2)->nullable();
            $table->unsignedBigInteger('tptfgm_player_id')->nullable();
            $table->decimal('stl_total', 8, 2)->nullable();
            $table->unsignedBigInteger('stl_player_id')->nullable();
            $table->decimal('tov_total', 8, 2)->nullable();
            $table->unsignedBigInteger('tov_player_id')->nullable();
            $table->decimal('pts_total', 8, 2)->nullable();
            $table->unsignedBigInteger('pts_player_id')->nullable();
            $table->decimal('reb_total', 8, 2)->nullable();
            $table->unsignedBigInteger('reb_player_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Revertir las operaciones hechas en el método up()
            $table->dropColumn(['top_performers_blk_total', 'top_performers_blk_player_id', 'ast_total', 'ast_player_id', 'tptfgm_total', 'tptfgm_player_id', 'stl_total', 'stl_player_id', 'tov_total', 'tov_player_id', 'pts_total', 'pts_player_id', 'reb_total', 'reb_player_id']);
        });
    }
}
