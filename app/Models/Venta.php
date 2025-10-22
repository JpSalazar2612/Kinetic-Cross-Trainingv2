<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    
        protected $fillable = [  // Campos que se pueden asignar masivamente 
            'user_id',
            'membresia_id',
            'total',
            'fecha_venta',
        ];
    /**
     * Una venta pertenece a un usuario.
     */
     public function user()
     {
         return $this->belongsTo(User::class);
     }

     /**
      * Una Venta puede incluir una Membresía.
      */
     public function membresia()
     {
         return $this->belongsTo(Membresia::class);
     }

     /**
      * Una Venta puede tener muchos Productos (Muchos a Muchos).
      */
     public function productos()
     {
         // Usamos 'producto_venta' como tabla pivote
         return $this->belongsToMany(Producto::class)
                     ->withPivot('cantidad', 'precio_unitario') // Incluye campos pivote
                     ->withTimestamps();
     }
}
