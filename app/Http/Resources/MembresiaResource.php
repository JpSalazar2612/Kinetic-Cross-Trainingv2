<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UserResource;
use App\Http\Resources\ServicioResource;
use App\Http\Resources\VentaResource;


class MembresiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'duracion_dias' => $this->duracion_dias, 
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,

            // 2. RELACIONES
            
            // Relación 'users' (Muchos a Muchos)
            // Usamos whenLoaded() para cargar solo si fue solicitada con 'with()'.
            'users' => UserResource::collection($this->whenLoaded('users')),
            
            // Relación 'servicios' (Uno a Muchos)
            'servicios' => ServicioResource::collection($this->whenLoaded('servicios')),
            
            // Relación 'ventas' (Uno a Muchos)
            'ventas' => VentaResource::collection($this->whenLoaded('ventas')),
        ];
    }
}
