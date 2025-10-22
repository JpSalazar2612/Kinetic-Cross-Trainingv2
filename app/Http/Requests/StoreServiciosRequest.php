<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiciosRequest extends FormRequest
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
            'membresia_id' => 'required|exists:servicios,membresia_id',
            'nombre' => 'required|exists:servicios,nombre',
            'descripcion' => 'required|exists:servicios,descripcion',
            'precio' => 'required|exists:servicios,precio',
            'duracion_minutos' => 'required|exists:servicios,duracion_minutos',
        ];
    }
}
