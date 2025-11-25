<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;  // Importar la interfaz Validator
use Illuminate\Http\Exceptions\HttpResponseException;  // Importar la excepción HttpResponseException
class StoreProductosRequest extends FormRequest
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
           'id' => 'sometimes|numeric|exists:productos,id', // 'sometimes' para el update
        // Almacenamiento
        'nombre' => 'required|string|max:255|unique:productos,nombre', // Debe ser único y string
        'precio' => 'required|numeric|min:0', // Debe ser numérico y positivo
        'stock' => 'required|integer|min:0', // Debe ser un entero positivo
        'descripcion' => 'required|string',
        ];
    }
     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error de validación en la actualización',
            'errors' => $validator->errors()
        ], 422));
    }
}
