<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Modificar las columnas existentes
            $table->decimal('top_performers_blk_total', 8, 2)->change();
            $table->string('top_performers_blk_player_id')->change();
            $table->decimal('ast_total', 8, 2)->change();
            $table->string('ast_player_id')->change();
            $table->decimal('tptfgm_total', 8, 2)->change();
            $table->string('tptfgm_player_id')->change();
            $table->decimal('stl_total', 8, 2)->change();
            $table->string('stl_player_id')->change();
            $table->decimal('tov_total', 8, 2)->change();
            $table->string('tov_player_id')->change();
            $table->decimal('pts_total', 8, 2)->change();
            $table->string('pts_player_id')->change();
            $table->decimal('reb_total', 8, 2)->change();
            $table->string('reb_player_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No hay necesidad de revertir los cambios para modificar las columnas
    }
}
