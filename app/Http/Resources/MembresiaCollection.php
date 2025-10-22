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
         return $this->collection->map(function ($categoria) {
            return [
                'id' => $categoria->id,
                'nombre' => $categoria->nombre,
                'descripcion' => $categoria->descripcion,
                'precio' => $categoria->precio,
                'duracion_meses' => $categoria->duracion_meses,
                //'created_at' => $categoria->created_at,
                //'updated_at' => $categoria->updated_at,
                ];  
        })->toArray(); // Convertir la colección mapeada a un array
    }
}