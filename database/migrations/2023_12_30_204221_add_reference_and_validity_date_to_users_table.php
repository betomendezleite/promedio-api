<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceAndValidityDateToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar la columna 'reference' antes de 'deleted_at'
            $table->unsignedBigInteger('reference')->nullable()->after('password');

            // Agregar la columna 'validity_date' después de 'reference'
            $table->date('validity_date')->nullable()->after('reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir la migración eliminando las columnas
            $table->dropColumn('reference');
            $table->dropColumn('validity_date');
        });
    }
}
