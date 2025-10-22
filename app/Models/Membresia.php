<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    /** @use HasFactory<\Database\Factories\MembresiaFactory> */
    use HasFactory;

     protected $fillable = [  // Campos que se pueden asignar masivamente 
        'nombre',
        'descripcion',
        'precio',
        'duracion_dias',
    ];

      public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Una Membresia puede otorgar muchos Servicios (Uno a Muchos).
     * Laravel buscará la columna 'membresia_id' en la tabla 'servicios'.
     */
    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    /**
     * Una Membresia puede estar incluida en muchas Ventas (Uno a Muchos).
     * Laravel buscará la columna 'membresia_id' en la tabla 'ventas'.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
