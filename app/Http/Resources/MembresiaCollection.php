<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MembresiaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
         return $this->collection->map(function ($membresia) {
            return [
                'id' => $membresia->id,
                'nombre' => $membresia->nombre,
                'precio' => $membresia->precio,
                'duracion_dias' => $membresia->duracion_dias,
                'descripcion' => $membresia->descripcion,
                //'created_at' => $membresia->created_at,
                //'updated_at' => $membresia->updated_at,
                ];  
        })->toArray(); // Convertir la colección mapeada a un array
    }
}