<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VentaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($venta) {
            return [
                'id' => $venta->id,
                'fecha' => $venta->fecha,
                'total' => $venta->total,
                'cliente_id' => $venta->cliente_id,
                'membresia_id' => $venta->membresia_id,
                'user_id' => $venta->user_id,
                'metodo_pago' => $venta->metodo_pago,
                'productos' => ProductoResource::collection($venta->whenLoaded('productos')),
                
                
                //'created_at' => $venta->created_at,
                //'updated_at' => $venta->updated_at,
                ];  
        })->toArray(); // Convertir la colección mapeada a un array
    }
}
