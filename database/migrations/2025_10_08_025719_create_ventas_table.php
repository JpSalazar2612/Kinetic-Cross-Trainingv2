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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            // Clave foránea del Usuario que realiza la venta (Relación Muchos a Uno)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Clave foránea opcional si la venta incluye una Membresía (Relación Muchos a Uno)
            $table->foreignId('membresia_id')->nullable()->constrained()->onDelete('set null'); 
            
            // Monto total de la transacción
            $table->decimal('total', 10, 2); 
            // Método de pago (ej: 'Tarjeta', 'Efectivo', 'Transferencia')
            $table->string('metodo_pago', 50); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
