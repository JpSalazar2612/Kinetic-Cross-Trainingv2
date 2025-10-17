<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    public function ventas()
    {
        // Usamos 'producto_venta' como tabla pivote
        return $this->belongsToMany(Venta::class)->withTimestamps();
    }
}
