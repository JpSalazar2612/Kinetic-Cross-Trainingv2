<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMembresiasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // El campo 'nombre' es requerido y debe ser único
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('membresias', 'nombre'),
            ],
            
            'costo' => 'required|numeric|min:0',
            
            'duracion_dias' => 'required|integer|min:1',
        
            'detalles' => 'required|string|max:1000',

            'tipo' => 'nullable|string|max:50',
            'membresia_id' => 'sometimes|exists:membresias,id',
        ];
    }
}