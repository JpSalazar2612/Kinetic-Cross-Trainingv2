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
            // Clave foránea que conecta con el modelo Membresia (Relación Muchos a Uno)
            $table->foreignId('membresia_id')->constrained()->onDelete('cascade'); 
            $table->string('nombre', 150);
            // Tipo de servicio (ej: 'Clase', 'Entrenamiento Personal', 'Nutrición')
            $table->string('tipo', 100); 
            $table->text('detalles')->nullable();
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
