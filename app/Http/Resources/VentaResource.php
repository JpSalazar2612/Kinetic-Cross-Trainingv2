<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Asegúrate de que estos Resources existan y estén importados si estás cargando las relaciones
use App\Http\Resources\UserResource; 
use App\Http\Resources\MembresiaResource;
// Si tienes un ProductoResource, también inclúyelo:
// use App\Http\Resources\ProductoResource; 

class VentaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 1. CAMPOS SIMPLES (Mapeados a camelCase para la respuesta JSON)
            'id' => $this->id, 
            
            // Mapeo snake_case (DB) a camelCase (JSON esperado por el Test)
            'user_id' => $this->user_id,
            'membresia_id' => $this->membresia_id,
            'total' => $this->total,
            'fecha_venta' => $this->fecha_venta,
            'metodo_pago' => $this->metodo_pago,

            // 2. RELACIONES (Formateadas con sus Resources)
            
            // Relación belongsTo (Un solo objeto User)
            'user' => UserResource::make($this->whenLoaded('user')),
            
            // Relación belongsTo (Un solo objeto Membresia)
            'membresia' => MembresiaResource::make($this->whenLoaded('membresia')),
            
            // Relación Many-to-Many (Colección de Productos)
            // Asegúrate de que ProductoResource esté definido y la relación 'productos' exista en Venta.php
            // 'productos' => ProductoResource::collection($this->whenLoaded('productos')),
        ];
    }
}