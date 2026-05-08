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
        Schema::create('categoria_centro', function (Blueprint $table) {
    $table->foreignId('centro_id')->constrained('centros')->onDelete('cascade');
    $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
    $table->primary(['centro_id', 'categoria_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_centro');
    }
};
