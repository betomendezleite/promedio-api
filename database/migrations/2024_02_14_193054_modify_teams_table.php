<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->decimal('ppg', 8, 2)->change();
            $table->decimal('oppg', 8, 2)->change();
            $table->decimal('defensivePtsAway', 8, 2)->change();
            $table->decimal('defensivePtsHome', 8, 2)->change();
            $table->decimal('ofensivePtsAway', 8, 2)->change();
            $table->decimal('ofensivePtsHome', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // No se necesita revertir los cambios
        });
    }
};
