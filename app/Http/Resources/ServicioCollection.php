<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServicioCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($servicio) {
            return [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'precio' => $servicio->precio,
                'tipo' => $servicio->tipo,
                'detalles' => $servicio->detalles,
                
                //'created_at' => $servicio->created_at,
                //'updated_at' => $servicio->updated_at,
                ];  
        })->toArray(); // Convertir la colección mapeada a un array
    }
}
