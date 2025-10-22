<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ¡IMPORTANTE!
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory; // ¡IMPORTANTE! Esto habilita el método ::factory()

    protected $fillable = [  // Campos que se pueden asignar masivamente 
        'nombre',
        'descripcion',
        'precio',
        'membresia_id',
    ];
    /**
     * Un Servicio pertenece a una sola Membresía (Muchos a Uno Inversa).
     * Laravel buscará la columna 'membresia_id' en la tabla 'servicios'.
     */
    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }
}