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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $membresiaId = $this->route('membresia'); // Obtener el ID de la membresía desde la ruta

        return [
            'nombre' => [
            'sometimes', // Solo valida si el campo 'nombre' está presente
            'string',
            // Aseguramos que el nuevo nombre sea único, excepto para el registro actual
            Rule::unique('membresias', 'nombre')->ignore($membresiaId),
        ],
        // Solo 'sometimes' y el tipo de dato.
        'precio' => 'sometimes|numeric|min:0', 
        'duracion_dias' => 'sometimes|integer|min:1',
        'descripcion' => 'sometimes|string',
    ];
    }
}
