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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membresia_id')->constrained('membresias')->onDelete('cascade'); // La dependencia
            $table->string('nombre');
            $table->string('tipo')->nullable(); // <-- CAMBIO AÑADIDO: Incluir la columna 'tipo'
            $table->text('detalles'); // <-- CAMBIO AÑADIDO: Usar 'detalles' en lugar de 'descripcion' para coincidir con el Seeder/Factory
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};