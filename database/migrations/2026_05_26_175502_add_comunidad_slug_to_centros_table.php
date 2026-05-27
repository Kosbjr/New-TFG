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
        Schema::table('centros', function (Blueprint $table) {
            // Añadimos la columna donde guardaremos el slug (ej: 'cataluna', 'madrid')
            $table->string('comunidad_autonoma')->nullable()->after('direccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centros', function (Blueprint $table) {
            $table->dropColumn('comunidad_autonoma');
        });
    }
};


