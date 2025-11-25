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
            $table->foreignId('membresia_id')->constrained('membresias')->onDelete('cascade');
            $table->string('nombre')->unique(); // Añadido unique para coincidir con la validación en StoreRequest
            
            // COLUMNAS FALTANTES AÑADIDAS:
            $table->decimal('precio', 8, 2); 
            $table->integer('duracion_minutos'); 
            
            $table->string('tipo')->nullable();
            $table->text('detalles')->nullable(); // Hecho nullable por si el factory no lo pone siempre
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