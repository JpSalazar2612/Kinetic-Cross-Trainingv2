<?php

namespace App\Http\Requests;

use App\Models\Membresia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 

class UpdateMembresiasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Asegura que solo los usuarios autenticados puedan realizar esta solicitud
        return auth()->check(); 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Obtiene el ID de la membresía de la ruta para ignorarla en la regla unique
        $membresiaId = $this->route('membresia'); 

        return [
            'nombre' => [
                'sometimes', // Solo valida si el campo está presente en el request
                'string',
                'max:255',
                // Asegura que el nombre sea único, excepto para el registro actual.
                Rule::unique('membresias', 'nombre')->ignore($membresiaId),
            ],
            
            // CORREGIDO: Usamos 'costo' para alinearlo con la migración
            'costo' => 'sometimes|numeric|min:0', 
            
            // Se usa 'duracion_dias'
            'duracion_dias' => 'sometimes|integer|min:1',
            
            // CORREGIDO: Usamos 'detalles' para alinearlo con la migración
            'detalles' => 'sometimes|string|max:1000',
            
            'tipo' => 'nullable|string|max:50',
        ];
    }
}