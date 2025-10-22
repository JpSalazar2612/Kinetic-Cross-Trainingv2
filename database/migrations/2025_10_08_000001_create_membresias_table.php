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
        Schema::create('membresias', function (Blueprint $table) {
            $table->id();
            // Asegúrate de que los campos usados en tu Factory existan aquí
            $table->string('nombre')->unique(); 
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2); 
            $table->integer('duracion_dias'); // Campo usado en el Seeder
            
            // Si tenías una llave foránea a `users` en esta tabla, ¡quítala! 
            // Las membresías existen solas, la relación con `users` está en la tabla pivote.
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};