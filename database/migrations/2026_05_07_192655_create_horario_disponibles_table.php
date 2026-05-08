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
    Schema::create('horario_disponibles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('centro_id')->constrained('centros')->onDelete('cascade');
        $table->tinyInteger('dia_semana');
        $table->time('hora_inicio');
        $table->time('hora_fin');
        $table->integer('intervalo_minutos')->default(30);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('horario_disponibles');
}
};
