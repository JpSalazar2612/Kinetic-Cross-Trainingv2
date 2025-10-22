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
        // Tabla pivote para la relación muchos a muchos entre Membresia y User
        Schema::create('membresia_user', function (Blueprint $table) {
            $table->id();
            
            // Llave foránea a la tabla 'membresias' (debe existir antes)
            $table->foreignId('membresia_id')->constrained('membresias')->onDelete('cascade');
            
            // Llave foránea a la tabla 'users' (debe existir antes)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Campos pivote adicionales
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            
            $table->timestamps();
            
            // Evita que un mismo usuario tenga la misma membresía duplicada
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