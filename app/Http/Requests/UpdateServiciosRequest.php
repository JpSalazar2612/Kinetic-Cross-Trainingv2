<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicioRequest extends FormRequest
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
            'nombre' => 'sometimes|required|exists:servicios,nombre',
            'precio' => 'sometimes|required|exists:servicios,precio',
            'descripcion' => 'sometimes|required|exists:servicios,descripcion',
            'duracion_minutos' => 'sometimes|required|exists:servicios,duracion_minutos',
            'membresia_id' => 'sometimes|required|exists:servicios,membresia_id',
            
        ];
    }
}
