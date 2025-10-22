<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            // Asumo que tienes un 'id' aunque no está en $fillable
            'id' => $this->id, 
            'user_id' => $this->user_id,
            'membresia_id' => $this->membresia_id,
            'total' => $this->total,
            'fecha_venta' => $this->fecha_venta,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // 2. RELACIONES (Formateadas con sus Resources)
            
            // Relación belongsTo (Un solo objeto User)
            // Nota: Aquí se usa ::make() en lugar de ::collection()
            'user' => UserResource::make($this->whenLoaded('user')),
            
            // Relación belongsTo (Un solo objeto Membresia)
            'membresia' => MembresiaResource::make($this->whenLoaded('membresia')),
            
            // Relación Many-to-Many (Colección de Productos)
            'productos' => ProductoResource::collection($this->whenLoaded('productos')),
        ];
    }
}
