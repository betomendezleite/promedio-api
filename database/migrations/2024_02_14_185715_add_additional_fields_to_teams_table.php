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

            $table->string('ppg');
            $table->string('oppg');
            $table->string('defensivePtsAway');
            $table->string('defensivePtsHome');
            $table->string('ofensivePtsAway');
            $table->string('ofensivePtsHome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            //
        });
    }
};
