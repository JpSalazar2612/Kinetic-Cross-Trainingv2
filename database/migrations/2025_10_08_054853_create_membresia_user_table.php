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
        // Esta es la tabla pivote para la relación muchos a muchos entre Membresia y User
        Schema::create('membresia_user', function (Blueprint $table) {
            $table->id();
            
            // Llave foránea a la tabla 'membresias'
            // NOTA: 'membresias' debe ser creada en una migración con TIMESTAMP ANTERIOR
            $table->foreignId('membresia_id')->constrained('membresias')->onDelete('cascade');
            
            // Llave foránea a la tabla 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Campos pivote adicionales
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            
            $table->timestamps();
            
            // Opcional: Única combinación de membresia y usuario para evitar duplicados
            $table->unique(['membresia_id', 'user_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresia_user');
    }
};