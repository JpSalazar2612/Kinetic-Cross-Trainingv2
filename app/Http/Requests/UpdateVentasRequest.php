<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;  // Importar la interfaz Validator
use Illuminate\Http\Exceptions\HttpResponseException;  // Importar la excepción HttpResponseException
class UpdateVentasRequest extends FormRequest
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
            // Corregido: Validar los campos reales de la tabla 'ventas' y hacerlos opcionales
            'membresia_id' => 'sometimes|nullable|exists:membresias,id', 
            'total' => 'sometimes|required|numeric|min:0',
            'fecha_venta' => 'sometimes|required|date',
            'metodo_pago' => 'sometimes|required|string|max:50',
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
