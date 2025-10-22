<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'nombre' => 'required|exists:membresias,nombre',
            'precio' => 'required|exists:membresias,precio',
            'duracion' => 'required|exists:membresias,duracion',
            'descripcion' => 'required|exists:membresias,descripcion',
            
        ];
    }
}
