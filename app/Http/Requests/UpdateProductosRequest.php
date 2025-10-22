<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
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
            'nombre' => 'sometimes|required|exists:productos,nombre',
            'precio' => 'sometimes|required|exists:productos,precio',
            'stock' => 'sometimes|required|exists:productos,stock',
            'descripcion' => 'sometimes|required|string',
        ];
    }
}
