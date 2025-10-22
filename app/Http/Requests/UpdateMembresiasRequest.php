<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMembresiaRequest extends FormRequest
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
            'nombre' => 'sometimes|required|exists:membresias,nombre',
            'precio' => 'sometimes|required|exists:membresias,precio',
            'duracion' => 'sometimes|required|exists:membresias,duracion',
            'descripcion' => 'sometimes|required|exists:membresias,descripcion',
        ];
    }
}
