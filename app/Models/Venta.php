<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Aquí se incluyen todos los campos que el controlador 'store' puede llenar.
     * Esto corrige el error "NOT NULL constraint failed".
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',          // Se llena automáticamente en el controlador
        'membresia_id',     // Puede ser nulo
        'total',
        'fecha_venta',      // Este era el campo que faltaba y causaba el error 500
        'metodo_pago',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Asegura que fecha_venta se maneje como un objeto Carbon (date)
        'fecha_venta' => 'date', 
    ];

    // Relación con el usuario que realizó la venta (1:N inverso)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la membresía vendida (1:1 o 1:N, dependiendo del diseño)
    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }
    
    // Si tienes una relación N:M con productos/servicios, deberías definirla aquí
}
