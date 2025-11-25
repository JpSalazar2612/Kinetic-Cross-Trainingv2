<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'membresia_id', 
        'total',
        'fecha_venta', 
        'metodo_pago',
    ];
// ... (resto del código del modelo)

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
