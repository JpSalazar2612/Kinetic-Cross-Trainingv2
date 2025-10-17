<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Esta tabla es necesaria para la relación Muchos a Muchos entre Producto y Venta
        Schema::create('producto_venta', function (Blueprint $table) {
            
            // Claves foráneas que actúan como clave primaria compuesta
            $table->foreignId('producto_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('venta_id')->constrained()->onDelete('cascade'); 
            $table->primary(['producto_id', 'venta_id']);
            
            // Cantidad del producto comprado en esta venta
            $table->integer('cantidad')->default(1); 
            // Precio unitario registrado en el momento de la venta
            $table->decimal('precio_unitario', 8, 2); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_venta');
    }
};
